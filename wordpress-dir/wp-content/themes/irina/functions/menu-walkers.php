<?php

// =============================================================================
// Foundation Dropdown Menu
// =============================================================================

class Foundation_Dropdown_Menu_Walker extends Walker_Nav_Menu
{
	private $noIDS = array();
	private $curItem;

    function start_lvl( &$output, $depth = 0, $args = array() ) {
    	if (!in_array($this->curItem->ID, $this->noIDS)) {
			$indent = str_repeat("\t", $depth);
			$output .= "\n$indent<ul class=\"vertical menu\" data-submenu>\n";
		}
    }

    function end_lvl ( &$output, $depth = 0, $args = array() ) {
    	if (!in_array($this->curItem->ID, $this->noIDS))
	    	parent::end_lvl($output, $depth, $args);
    }

    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
    	$this->curItem = $item;
    	if ( Nova_OP::getOption('enable_megamenu_' . $item->ID, 0) == true) {
			$this->noIDS[] = $item->ID;
		}
	    if ( (Nova_OP::getOption('enable_megamenu_' . $item->menu_item_parent, 0) == true) || ( in_array($item->menu_item_parent, $this->noIDS))) {
	    	$this->noIDS[] = $item->ID;
	    	return;
  		}
		parent::start_el($output, $item, $depth, $args, $id);
	}
}


// =============================================================================
// Foundation Dropdown Menu Fallback
// =============================================================================

function Foundation_Dropdown_Menu_Fallback($args)
{
    echo '<div class="no_menu"></div>';
}


// =============================================================================
// Foundation Drilldown Menu
// =============================================================================

class Foundation_Drilldown_Menu_Walker extends Walker_Nav_Menu
{
	private $noIDS = array();
	private $curItem;

    function start_lvl( &$output, $depth = 0, $args = array() ) {
	    if (!in_array($this->curItem->ID, $this->noIDS)) {
	        $indent = str_repeat("\t", $depth);
	        $output .= "\n$indent<ul class=\"menu vertical nested\">\n";
	    }
    }

    function end_lvl ( &$output, $depth = 0, $args = array() ) {
    	if (!in_array($this->curItem->ID, $this->noIDS))
	    	parent::end_lvl($output, $depth, $args);
    }

    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
    	$this->curItem = $item;
    	if ( Nova_OP::getOption('enable_megamenu_' . $item->ID, 0) == true) {
			$this->noIDS[] = $item->ID;
		}
	    if ( (Nova_OP::getOption('enable_megamenu_' . $item->menu_item_parent, 0) == true) || ( in_array($item->menu_item_parent, $this->noIDS))) {
	    	$this->noIDS[] = $item->ID;
	    	return;
  		}
		parent::start_el($output, $item, $depth, $args, $id);
	}
}
