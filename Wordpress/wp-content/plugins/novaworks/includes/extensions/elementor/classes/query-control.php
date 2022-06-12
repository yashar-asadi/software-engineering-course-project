<?php
namespace Novaworks_Element\Classes;

if (!defined('WPINC')) {
    die;
}

use Elementor\Core\Common\Modules\Ajax\Module as Ajax;

use Novaworks_Element\Controls\Query;
use Novaworks_Element\Controls\Group_Control_Related;
use Novaworks_Element\Controls\Group_Control_Query;

class Query_Control {

    const QUERY_CONTROL_ID = 'novaworks_query';

    public static $displayed_ids = [];

    protected static $_instances = [];

    public $sys_messages = [];

    /**
     * @return static
     */
    public static function instance() {
        if ( empty( self::$_instances ) ) {
            self::$_instances = new self();
        }
        return self::$_instances;
    }

    public function __construct() {
        $this->add_actions();
    }

    public static function add_to_avoid_list( $ids ) {
        self::$displayed_ids = array_merge( self::$displayed_ids, $ids );
    }

    public static function get_avoid_list_ids() {
        return self::$displayed_ids;
    }

    public function get_name() {
        return 'query-control';
    }

    /**
     * @param array $data
     *
     * @return array
     * @throws \Exception
     */
    public function ajax_posts_filter_autocomplete( array $data ) {
        if ( empty( $data['filter_type'] ) || empty( $data['q'] ) ) {
            throw new \Exception( 'Bad Request' );
        }

        $results = [];

        switch ( $data['filter_type'] ) {
            case 'taxonomy':
                $query_params = [
                    'taxonomy' => $this->extract_post_type( $data ),
                    'search' => $data['q'],
                    'hide_empty' => false,
                ];

                $terms = get_terms( $query_params );

                global $wp_taxonomies;

                foreach ( $terms as $term ) {
                    $term_name = $this->get_term_name_with_parents( $term );
                    if ( ! empty( $data['include_type'] ) && isset( $wp_taxonomies[ $term->taxonomy ] ) ) {

                        $text = $wp_taxonomies[ $term->taxonomy ]->labels->name . ': ' . $term_name;
                    }
                    else {
                        $text = $term_name;
                    }

                    $results[] = [
                        'id' => $term->term_taxonomy_id,
                        'text' => $text,
                    ];
                }

                break;

            case 'by_id':
            case 'post':
                $query_params = [
                    'post_type' => $this->extract_post_type( $data ),
                    's' => $data['q'],
                    'posts_per_page' => -1,
                ];

                if ( 'attachment' === $query_params['post_type'] ) {
                    $query_params['post_status'] = 'inherit';
                }

                if(absint($data['q']) > 0){
                    unset($query_params['s']);
                    $query_params['p'] = absint($data['q']);
                }

                $query = new \WP_Query( $query_params );

                foreach ( $query->posts as $post ) {
                    $post_type_obj = get_post_type_object( $post->post_type );
                    if ( ! empty( $data['include_type'] ) ) {
                        $text = $post_type_obj->labels->name . ': ' . $post->post_title;
                    } else {
                        $text = ( $post_type_obj->hierarchical ) ? $this->get_post_name_with_parents( $post ) : $post->post_title;
                    }

                    $results[] = [
                        'id' => $post->ID,
                        'text' => $text,
                    ];
                }
                break;

            case 'author':
                $query_params = [
                    'who' => 'authors',
                    'has_published_posts' => true,
                    'fields' => [
                        'ID',
                        'display_name',
                    ],
                    'search' => '*' . $data['q'] . '*',
                    'search_columns' => [
                        'user_login',
                        'user_nicename',
                    ],
                ];

                $user_query = new \WP_User_Query( $query_params );

                foreach ( $user_query->get_results() as $author ) {
                    $results[] = [
                        'id' => $author->ID,
                        'text' => $author->display_name,
                    ];
                }
                break;
            default:
                $results = apply_filters( 'novaworks_elements/query_control/get_autocomplete/' . $data['filter_type'], [], $data );
        }

        return [
            'results' => $results,
        ];
    }

    public function ajax_posts_control_value_titles( $request ) {
        $ids = (array) $request['id'];

        $results = [];

        switch ( $request['filter_type'] ) {
            case 'taxonomy':
                $terms = get_terms(
                    [
                        'term_taxonomy_id' => $ids,
                        'hide_empty' => false,
                    ]
                );

                global $wp_taxonomies;
                foreach ( $terms as $term ) {
                    $term_name = $this->get_term_name_with_parents( $term );
                    if ( ! empty( $request['include_type'] ) ) {
                        $text = $wp_taxonomies[ $term->taxonomy ]->labels->name . ': ' . $term_name;
                    } else {
                        $text = $term_name;
                    }
                    $results[ $term->term_taxonomy_id ] = $text;
                }
                break;

            case 'by_id':
            case 'post':
                $query = new \WP_Query(
                    [
                        'post_type' => 'any',
                        'post__in' => $ids,
                        'posts_per_page' => -1,
                    ]
                );

                foreach ( $query->posts as $post ) {
                    $results[ $post->ID ] = $post->post_title;
                }
                break;

            case 'author':
                $query_params = [
                    'who' => 'authors',
                    'has_published_posts' => true,
                    'fields' => [
                        'ID',
                        'display_name',
                    ],
                    'include' => $ids,
                ];

                $user_query = new \WP_User_Query( $query_params );

                foreach ( $user_query->get_results() as $author ) {
                    $results[ $author->ID ] = $author->display_name;
                }
                break;
            default:
                $results = apply_filters( 'novaworks_elements/query_control/get_value_titles/' . $request['filter_type'], [], $request );
        }

        return $results;
    }

    public function register_controls() {
        $controls_manager = \Elementor\Plugin::instance()->controls_manager;

        $controls_manager->add_group_control( Group_Control_Query::get_type(), new Group_Control_Query() );

        $controls_manager->add_group_control( Group_Control_Related::get_type(), new Group_Control_Related() );

        $controls_manager->register_control( self::QUERY_CONTROL_ID, new Query() );
    }

    private function extract_post_type( $data ) {

        if ( ! empty( $data['query'] ) && ! empty( $data['query']['post_type'] ) ) {
            return $data['query']['post_type'];
        }

        return isset($data['object_type']) ? $data['object_type'] : array();
    }

    /**
     * get_term_name_with_parents
     * @param \WP_Term $term
     * @param int $max
     *
     * @return string
     */
    private function get_term_name_with_parents( \WP_Term $term, $max = 3 ) {
        if ( 0 === $term->parent ) {
            return $term->name;
        }
        $separator = is_rtl() ? ' < ' : ' > ';
        $test_term = $term;
        $names = [];
        while ( $test_term->parent > 0 ) {
            $test_term = get_term_by( 'term_taxonomy_id', $test_term->parent );
            if ( is_wp_error($test_term) || !$test_term ) {
                break;
            }
            $names[] = $test_term->name;
        }

        $names = array_reverse( $names );
        if ( count( $names ) < ( $max ) ) {
            return implode( $separator, $names ) . $separator . $term->name;
        }

        $name_string = '';
        for ( $i = 0; $i < ( $max - 1 ); $i++ ) {
            $name_string .= $names[ $i ] . $separator;
        }
        return $name_string . '...' . $separator . $term->name;
    }

    /**
     * get post name with parents
     * @param \WP_Post $post
     * @param int $max
     *
     * @return string
     */
    private function get_post_name_with_parents( $post, $max = 3 ) {
        if ( 0 === $post->post_parent ) {
            return $post->post_title;
        }
        $separator = is_rtl() ? ' < ' : ' > ';
        $test_post = $post;
        $names = [];
        while ( $test_post->post_parent > 0 ) {
            $test_post = get_post( $test_post->post_parent );
            if ( ! $test_post ) {
                break;
            }
            $names[] = $test_post->post_title;
        }

        $names = array_reverse( $names );
        if ( count( $names ) < ( $max ) ) {
            return implode( $separator, $names ) . $separator . $post->post_title;
        }

        $name_string = '';
        for ( $i = 0; $i < ( $max - 1 ); $i++ ) {
            $name_string .= $names[ $i ] . $separator;
        }
        return $name_string . '...' . $separator . $post->post_title;
    }

    /**
     * @param string $name
     * @param array $query_args
     * @param array $fallback_args
     *
     * @return \WP_Query
     */
    public function get_query( $widget, $name, $query_args = [], $fallback_args = [] ) {
        $prefix = $name . '_';
        $post_type = $widget->get_settings( $prefix . 'post_type' );
        if ( 'related' === $post_type ) {
            $the_query = new Related_Query( $widget, $name, $query_args, $fallback_args );
        }
        else {
            $the_query = new Post_Query( $widget, $name, $query_args );
        }
        return $the_query->get_query();
    }

    /**
     * @param Ajax $ajax_manager
     */
    public function register_ajax_actions( $ajax_manager ) {
        $ajax_manager->register_ajax_action( 'novaworks_query_control_value_titles', [ $this, 'ajax_posts_control_value_titles' ] );
        $ajax_manager->register_ajax_action( 'novaworks_panel_posts_control_filter_autocomplete', [ $this, 'ajax_posts_filter_autocomplete' ] );
    }

    public function localize_settings( $settings ) {
        $settings = array_replace_recursive( $settings, [
            'i18n' => [
                'all' => __( 'All', 'novaworks-elements' ),
            ],
        ] );

        return $settings;
    }

    protected function add_actions() {
        add_action( 'elementor/ajax/register_actions', [ $this, 'register_ajax_actions' ] );
        add_action( 'elementor/controls/controls_registered', [ $this, 'register_controls' ] );

        add_filter( 'novaworks_elements/editor/localize_settings', [ $this, 'localize_settings' ] );


        $this->sys_messages = apply_filters( 'NovaworksElement/popups_sys_messages', array(
            'invalid_mail'                => esc_html__( 'Please, provide valid mail', 'novaworks' ),
            'mailchimp'                   => esc_html__( 'Please, set up MailChimp API key and List ID', 'novaworks' ),
            'internal'                    => esc_html__( 'Internal error. Please, try again later', 'novaworks' ),
            'server_error'                => esc_html__( 'Server error. Please, try again later', 'novaworks' ),
            'subscribe_success'           => esc_html__( 'Success', 'novaworks' ),
        ) );

        add_action( 'wp_ajax_novaworks_elementor_subscribe_form_ajax', [ $this, 'subscribe_form_ajax' ] );
        add_action( 'wp_ajax_nopriv_novaworks_elementor_subscribe_form_ajax', [ $this, 'subscribe_form_ajax' ] );
        add_action( 'elementor/frontend/after_enqueue_scripts', [ $this, 'enqueue_frontend_localize_script' ] );
    }


    public function enqueue_frontend_localize_script(){
        wp_localize_script(
            'novaworks-subscribe-form-elm',
            'novaworks_elementor_subscribe_form_ajax',
            array(
                'action' => 'novaworks_elementor_subscribe_form_ajax',
                'nonce' => wp_create_nonce('novaworks_elementor_subscribe_form_ajax'),
                'type' => 'POST',
                'data_type' => 'json',
                'is_public' => 'true',
                'sys_messages' => $this->sys_messages
            )
        );
    }

    public function subscribe_form_ajax() {

        if ( ! wp_verify_nonce( isset($_POST['nonce']) ? $_POST['nonce'] : false, 'novaworks_elementor_subscribe_form_ajax' ) ) {
            $response = array(
                'message' => $this->sys_messages['invalid_nonce'],
                'type'    => 'error-notice',
            ) ;

            wp_send_json( $response );
        }

        $data = ( ! empty( $_POST['data'] ) ) ? $_POST['data'] : false;

        if ( ! $data ) {
            wp_send_json_error( array( 'type' => 'error', 'message' => $this->sys_messages['server_error'] ) );
        }

        $api_key = apply_filters('NovaworksElement/mailchimp/api', '');
        $list_id = apply_filters('NovaworksElement/mailchimp/list_id', '');
        $double_opt = apply_filters('NovaworksElement/mailchimp/double_opt_in', '');

        $double_opt_in = filter_var( $double_opt, FILTER_VALIDATE_BOOLEAN );

        if ( ! $api_key ) {
            wp_send_json( array( 'type' => 'error', 'message' => $this->sys_messages['mailchimp'] ) );
        }

        if ( isset( $data['use_target_list_id'] ) &&
            filter_var( $data['use_target_list_id'], FILTER_VALIDATE_BOOLEAN ) &&
            ! empty( $data['target_list_id'] )
        ) {
            $list_id = $data['target_list_id'];
        }

        if ( ! $list_id ) {
            wp_send_json( array( 'type' => 'error', 'message' => $this->sys_messages['mailchimp'] ) );
        }

        $mail = $data['email'];

        if ( empty( $mail ) || ! is_email( $mail ) ) {
            wp_send_json( array( 'type' => 'error', 'message' => $this->sys_messages['invalid_mail'] ) );
        }

        $args = [
            'email_address' => $mail,
            'status'        => $double_opt_in ? 'pending' : 'subscribed',
        ];

        if ( ! empty( $data['additional'] ) ) {

            $additional = $data['additional'];

            foreach ( $additional as $key => $value ) {
                $merge_fields[ strtoupper( $key ) ] = $value;
            }

            $args['merge_fields'] = $merge_fields;

        }

        $response = $this->api_call( $api_key, $list_id, $args );

        if ( false === $response ) {
            wp_send_json( array( 'type' => 'error', 'message' => $this->sys_messages['mailchimp'] ) );
        }

        $response = json_decode( $response, true );

        if ( empty( $response ) ) {
            wp_send_json( array( 'type' => 'error', 'message' => $this->sys_messages['internal'] ) );
        }

        if ( isset( $response['status'] ) && 'error' == $response['status'] ) {
            wp_send_json( array( 'type' => 'error', 'message' => esc_html( $response['error'] ) ) );
        }

        wp_send_json( array( 'type' => 'success', 'message' => $this->sys_messages['subscribe_success'] ) );
    }

    /**
     * Make remote request to mailchimp API
     *
     * @param  string $method API method to call.
     * @param  array  $args   API call arguments.
     * @return array|bool
     */
    private function api_call( $api_key, $list_id, $args = [] ) {

        $key_data = explode( '-', $api_key );

        if ( empty( $key_data ) || ! isset( $key_data[1] ) ) {
            return false;
        }

        $api_server = sprintf( 'https://%s.api.mailchimp.com/3.0/', $key_data[1] );

        $url = esc_url( trailingslashit( $api_server . 'lists/' . $list_id . '/members/' ) );

        $data = json_encode( $args );

        $request_args = [
            'method'      => 'POST',
            'timeout'     => 20,
            'headers'     => [
                'Content-Type'  => 'application/json',
                'Authorization' => 'apikey ' . $api_key
            ],
            'body'        => $data,
        ];

        $request = wp_remote_post( $url, $request_args );

        return wp_remote_retrieve_body( $request );
    }

}
