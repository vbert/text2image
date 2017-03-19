<?php

if (!defined('BASEPATH')) {
	exit('Bezpośredni dostęp do skryptu jest niedozwolony!');
}

/**
 * Helper Tools
 *
 * @author Wojciech Sobczak, wsobczak@gmail.com
 * @copyright (c) 2016
 */
function validate_IP_address($addreses) {
	$ip_debug = '';
	foreach (explode(',', $addreses) as $IPaddress) {
		$IPaddress = trim($IPaddress);
		if (filter_var($IPaddress, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE) !== FALSE) {
			$ip_debug .= $IPaddress . '|';
			$ret = $IPaddress;
		} else {
			$ret = FALSE;
		}
	}
	return $ret;
}

function get_IP_address() {
	$ip_src = array('HTTP_CLIENT_IP',
		'HTTP_X_FORWARDED_FOR',
		'HTTP_X_FORWARDED',
		'HTTP_X_CLUSTER_CLIENT_IP',
		'HTTP_FORWARDED_FOR',
		'HTTP_FORWARDED',
		'REMOTE_ADDR');

	foreach ($ip_src as $key) {
		if (array_key_exists($key, $_SERVER) === TRUE) {
			return validate_IP_address($_SERVER[$key]);
		}
	}
}

function add_prefix($string, $prefix) {
	return $prefix . $string;
}

function colon($string) {
	return add_prefix($string, ':');
}

function source_file($file_name) {
	if (strlen($file_name) > 0) {
		$result = $file_name;
	} else {
		$result = BASENAME . '.php';
	}
	return $result;
}

function head_page_title($title = '') {
	if (strlen($title) > 0) {
		$result = $title;
	} else {
		$result = DEFAULT_HEAD_TITLE;
	}
	return $result;
}

function head_description($description = '') {
	if (strlen($description) > 0) {
		$result = $description;
	} else {
		$result = DEFAULT_HEAD_DESCRIPTION;
	}
	return $result;
}

function head_keywords($keywords = '') {
	if (strlen($keywords) > 0) {
		$result = $keywords;
	} else {
		$result = DEFAULT_HEAD_KEYWORDS;
	}
	return $result;
}

function html_body_class($css_class = '') {
	$format = ' class="%s"';
	if (strlen($css_class) > 0) {
		$result = sprintf($format, $css_class);
	} else {
		$result = '';
	}
	return $result;
}

function html_page_title($title = '', $text = '', $html_tag = 'h1') {
	$format = '<section class="page-title-box" data-aos="fade-up"><%s class="page-title">%s</%s>%s</section>';
	if (strlen($title) > 0) {
		if (strlen($text) > 0) {
			$lead = sprintf('<p class="lead">%s</p>', $text);
		} else {
			$lead = '';
		}
		$result = sprintf($format, $html_tag, $title, $html_tag, $lead);
	} else {
		$result = '';
	}
	return $result;
}

function html_section_title($title = '', $text = '', $html_tag = 'h2') {
	$format = '<section class="section-title-box" data-aos="fade-up"><%s class="section-title">%s</%s>%s</section>';
	if (strlen($title) > 0) {
		if (strlen($text) > 0) {
			$lead = sprintf('<p class="lead">%s</p>', $text);
		} else {
			$lead = '';
		}
		$result = sprintf($format, $html_tag, $title, $html_tag, $lead);
	} else {
		$result = '';
	}
	return $result;
}

/**
 * CAROUSEL
 * ************************************************************************** */

/**
 *
 * @param array $Carousel
 * @param string $file_name
 * @param string $img_alt
 * @param string $caption String or Html
 * @return array
 */
function add_item_carousel($Carousel, $file_name, $img_alt = '', $caption = '') {
	$alt = (strlen($img_alt) > 0) ? $img_alt : DEFAULT_IMG_ALT;
	$item = [
		'file_name' => $file_name,
		'img_alt' => $alt,
		'caption' => $caption
	];
	array_push($Carousel, $item);
	return $Carousel;
}

/**
 * Carousel On Home
 * ************************************************************************** */
function controls_dekorator($carousel_id) {
	$format = '';
	$format .= '<a class="left carousel-control" href="#%s" role="button" data-slide="prev">';
	$format .= '<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>';
	$format .= '<span class="sr-only">Poprzedni</span></a>';
	$format .= '<a class="right carousel-control" href="#%s" role="button" data-slide="next">';
	$format .= '<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>';
	$format .= '<span class="sr-only">Następny</span></a>';
	return sprintf($format, $carousel_id, $carousel_id);
}

function indicators_decorator($carousel_id, $num_slides) {
	$format = '<ol class="carousel-indicators">%s</ol>';
	$item_format = '<li data-target="#%s" data-slide-to="%d"%s></li>';
	$items = '';
	for ($i = 0; $i < $num_slides; $i++) {
		$active = ($i === 0) ? ' class="active"' : '';
		$items .= sprintf($item_format, $carousel_id, $i, $active);
	}
	return sprintf($format, $items);
}

function slides_dekorator($items) {
	$format = '<div class="carousel-inner" role="listbox">%s</div>';
	$slides = implode('', $items);
	return sprintf($format, $slides);
}

function slide_carousel_decorator($key, $data) {
	$active = ($key === 0) ? ' active' : '';
	$src = BASEURI . 'assets/img/banners/' . $data['file_name'];
	$alt = $data['img_alt'];
	if (strlen($data['caption']) > 0) {
		$caption = sprintf('<div class="carousel-caption">%s</div>', $data['caption']);
	} else {
		$caption = '';
	}

	$format = '<div class="item%s"><img src="%s" class="img-responsive" alt="%s">%s</div>';
	return sprintf($format, $active, $src, $alt, $caption);
}

function slide_carousel($key, $data) {
	$result = slide_carousel_decorator($key, $data);
	return $result;
}

function carousel_decorator($carousel_id, $indicators, $slides, $controls) {
	$format = '';
	$format .= '<section class="carousel-box">';
	$format .= '<div id="%s" class="carousel slide" data-ride="carousel">';
	$format .= '%s %s %s</div></section>';
	return sprintf($format, $carousel_id, $indicators, $slides, $controls);
}

function build_carousel($data = CAROUSEL, $carousel_id = 'carousel-home') {
	$items = [];
	$carousel = json_decode($data, TRUE);
	foreach ($carousel as $key => $value) {
		$slide = slide_carousel($key, $value);
		array_push($items, $slide);
	}

	$indicators = indicators_decorator($carousel_id, count($items));
	$slides = slides_dekorator($items);
	$controls = controls_dekorator($carousel_id);

	$result = carousel_decorator($carousel_id, $indicators, $slides, $controls);
	return $result;
}

/**
 * MENU
 * ************************************************************************** */

/**
 *
 * @param array $Menu
 * @param string $title
 * @param string $side
 * @param string $url
 * @param integer $has_child
 * @param integer $is_child
 * @param string $parent
 * @return array
 */
function add_item_menu($Menu, $title, $side, $url = FALSE, $has_child = NO_CHILD, $is_child = NOT_CHILD, $parent = NULL) {
	$slug = slug($title);

	if ($is_child === IS_CHILD) {
		$parent_slug = slug($parent);
		$_url = (!$url) ? $parent_slug . '_' . $slug . '.html' : $url;
		$menu_id = $parent_slug;
	} else {
		$_url = (!$url) ? $slug . '.html' : $url;
		$menu_id = $slug;
	}

	$item = [
		'title' => $title,
		'menu_id' => $menu_id,
		'side' => $side,
		'url' => $_url,
		'has_child' => $has_child,
		'is_child' => $is_child
	];

	if ($has_child === HAS_CHILD) {
		$item['children'] = [];
	}

	if ($is_child === IS_CHILD) {
		$Menu[$parent_slug]['children'][$slug] = $item;
	} else {
		$Menu[$slug] = $item;
	}
	return $Menu;
}

function get_menu_title($string = BASENAME) {
	$menu = json_decode(MENU, TRUE);
	$key = explode('_', $string);
	if (array_key_exists($key[0], $menu)) {
		$num_key = count($key);
		switch ($num_key) {
			case 1:
				$title = $menu[$key[0]]['title'];
				break;
			case 2:
				$title = $menu[$key[0]]['children'][$key[1]]['title'];
				break;
		}
	} else {
		$title = '';
	}
	return $title;
}

function get_active_menu_id($string = BASENAME) {
	$key = explode('_', $string);
	return $key[0];
}

/**
 * Top Menu
 * ************************************************************************** */

/**
 *
 * @param array $data
 * @return string html item submenu
 */
function item_dropdown_top_menu_decorator($data) {
	$uri = BASEURI . $data['url'];
	$title = $data['title'];

	$format = '<li><a href="%s" title="%s">%s</a></li>';
	return sprintf($format, $uri, $title, $title);
}

/**
 *
 * @param array $data
 * @return string html item submenu
 */
function item_dropdown_top_menu($data) {
	$result = item_dropdown_top_menu_decorator($data);
	return $result;
}

/**
 *
 * @param array $data
 * @return string html submenu
 */
function dropdown_top_menu_decorator($data) {
	$active = ($data['menu_id'] === get_active_menu_id()) ? ' class="active"' : '';
	$uri = '#'; //BASEURI . $data['url'];
	$title = $data['title'];
	$items = $data['items'];

	$format = '';
	$format .= '<li%s><a class="dropdown-toggle" data-toggle="dropdown" ';
	$format .= 'role="button" aria-expanded="false" href="%s" title="%s">%s';
	$format .= ' <span class="caret"></span></a><ul class="dropdown-menu">';
	$format .= '%s</ul></li>';
	return sprintf($format, $active, $uri, $title, $title, $items);
}

/**
 *
 * @param array $data
 * @return string html submenu
 */
function dropdown_top_menu($data) {
	$submenu = $data['children'];
	$items = '';
	foreach ($submenu as $value) {
		$items .= item_dropdown_top_menu($value);
	}
	$dropdown_data = [
		'title' => $data['title'],
		'menu_id' => $data['menu_id'],
		'url' => $data['url'],
		'items' => $items
	];
	$result = dropdown_top_menu_decorator($dropdown_data);
	return $result;
}

/**
 *
 * @param array $data
 * @return string html item menu
 */
function item_top_menu_decorator($data) {
	$active = ($data['menu_id'] === BASENAME) ? ' class="active"' : '';
	$uri = BASEURI . $data['url'];
	$title = $data['title'];

	$format = '<li%s><a href="%s" title="%s">%s</a></li>';
	return sprintf($format, $active, $uri, $title, $title);
}

/**
 *
 * @param array $data
 * @return string html item menu
 */
function item_top_menu($data) {
	if (!$data['has_child']) {
		$result = item_top_menu_decorator($data);
	} else {
		$result = dropdown_top_menu($data);
	}
	return $result;
}

/**
 *
 * @param array $data
 * @return string html menu
 */
function top_menu_decorator($data, $menubar_id) {
	$navbar_left = '<ul class="nav navbar-nav">%s</ul>';
	$navbar_right = '<ul class="nav navbar-nav navbar-right">%s</ul>';
	$num_left = count($data['left']);
	$num_right = count($data['right']);
	$left = ($num_left > 0) ? sprintf($navbar_left, implode('', $data['left'])) : '';
	$right = ($num_right > 0) ? sprintf($navbar_right, implode('', $data['right'])) : '';

	$format = '';
	$format .= '<div class="container navbar-menu-panel">';
	$format .= '<div id="%s" class="navbar-collapse collapse">';
	$format .= '%s%s</div></div>';
	return sprintf($format, $menubar_id, $left, $right);
}

/**
 *
 * @param array $data
 * @return string html menu
 */
function build_top_menu($data = MENU, $menubar_id = 'menubar-collapse') {
	$navbar = [
		'left' => [],
		'right' => []
	];

	$menu = json_decode($data, TRUE);
	foreach ($menu as $value) {
		$item = item_top_menu($value);
		array_push($navbar[$value['side']], $item);
	}

	$result = top_menu_decorator($navbar, $menubar_id);
	return $result;
}

/**
 * Bottom Menu
 * ************************************************************************** */

/**
 *
 * @param array $data
 * @return string html item submenu
 */
function item_dropup_bottom_menu_decorator($data) {
	$uri = BASEURI . $data['url'];
	$title = $data['title'];

	$format = '<li><a href="%s" title="%s">%s</a></li>';
	return sprintf($format, $uri, $title, $title);
}

/**
 *
 * @param array $data
 * @return string html item submenu
 */
function item_dropup_bottom_menu($data) {
	$result = item_dropup_bottom_menu_decorator($data);
	return $result;
}

/**
 *
 * @param array $data
 * @return string html submenu
 */
function dropup_bottom_menu_decorator($data) {
	$active = ($data['menu_id'] === get_active_menu_id()) ? ' class="active"' : '';
	$uri = '#'; //BASEURI . $data['url'];
	$title = $data['title'];
	$items = $data['items'];
	$dropdown_id = 'dropdown-' . slug($title);

	$format = '<li%s><div class="dropup"><a id="%s" class="dropdown-toggle" '
		. 'data-toggle="dropdown" role="button" aria-haspopup="true" '
		. 'aria-expanded="false" href="%s" title="%s">%s '
		. '<span class="caret"></span></a><ul class="dropdown-menu" '
		. 'aria-labelledby="%s">%s</ul></div></li>';
	return sprintf($format, $active, $dropdown_id, $uri, $title, $title, $dropdown_id, $items);
}

/**
 *
 * @param array $data
 * @return string html submenu
 */
function dropup_bottom_menu($data) {
	$submenu = $data['children'];
	$items = '';
	foreach ($submenu as $value) {
		$items .= item_dropup_bottom_menu($value);
	}
	$dropup_data = [
		'title' => $data['title'],
		'menu_id' => $data['menu_id'],
		'url' => $data['url'],
		'items' => $items
	];
	$result = dropup_bottom_menu_decorator($dropup_data);
	return $result;
}

/**
 *
 * @param array $data
 * @return string html item menu
 */
function item_bottom_menu_decorator($data) {
	$active = ($data['menu_id'] === get_active_menu_id()) ? ' class="active"' : '';
	$uri = BASEURI . $data['url'];
	$title = $data['title'];

	$format = '<li%s><a href="%s" title="%s">%s</a></li>';
	return sprintf($format, $active, $uri, $title, $title);
}

/**
 *
 * @param array $data
 * @return string html item menu
 */
function item_bottom_menu($data) {
	if (!$data['has_child']) {
		$result = item_bottom_menu_decorator($data);
	} else {
		$result = dropup_bottom_menu($data);
	}
	return $result;
}

/**
 *
 * @param array $data
 * @return string html menu
 */
function bottom_menu_decorator($data, $menubar_id) {
	$num_items = count($data);
	$items = ($num_items > 0) ? implode('', $data) : '';

	$format = '<ul id="%s" class="list-unstyled">%s</ul>';
	return sprintf($format, $menubar_id, $items);
}

/**
 *
 * @param array $data
 * @return string html menu
 */
function build_bottom_menu($data = MENU, $menubar_id = 'bottomMenu') {
	$items = [];
	$menu = json_decode($data, TRUE);
	foreach ($menu as $value) {
		$item = item_bottom_menu($value);
		array_push($items, $item);
	}

	$result = bottom_menu_decorator($items, $menubar_id);
	return $result;
}
