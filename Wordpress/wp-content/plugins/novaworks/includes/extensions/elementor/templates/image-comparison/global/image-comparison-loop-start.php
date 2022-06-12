<?php
/**
 * Image Comparison start template
 */
$settings = $this->get_settings();
$data_settings = $this->generate_setting_json();


$class_array[] = 'novaworks-image-comparison__instance';

$classes = implode( ' ', $class_array );

$dir = is_rtl() ? 'rtl' : 'ltr';

?>
<div class="<?php echo $classes; ?>" <?php echo $data_settings; ?> dir="<?php echo $dir; ?>">
