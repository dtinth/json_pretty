<?php


class JSONPrettyDefaultStyle {

	static function indent($x)            { return str_replace("\n", "\n  ", $x); }
	static function format_object($k, $v) { return "$k: $v"; }
	static function format_empty($open, $close)  { return "$open $close"; }
	
	static function open_inline($open)    { return "$open "; }
	static function join_inline()         { return ", "; }
	static function close_inline($close)  { return " $close"; }
	
	static function open_compact($open)   { return "$open "; }
	static function join_compact($open)   { return ",\n  "; }
	static function close_compact($close) { return " $close"; }
	
	static function open_block($open)     { return "$open\n  "; }
	static function join_block($open)     { return ",\n  "; }
	static function close_block($close)   { return " $close"; }

}

class JSONPrettyExpandedStyle {

	static function indent($x)            { return str_replace("\n", "\n   ", $x); }
	static function format_object($k, $v) { return "$k: $v"; }
	static function format_empty($open, $close)  { return "$open $close"; }
	
	static function open_inline($open)    { return "$open"; }
	static function join_inline()         { return ", "; }
	static function close_inline($close)  { return "$close"; }
	
	static function open_compact($open)   { return "$open\n   "; }
	static function join_compact($open)   { return ",\n   "; }
	static function close_compact($close) { return "\n$close"; }
	
	static function open_block($open)     { return "$open\n   "; }
	static function join_block($open)     { return ",\n   "; }
	static function close_block($close)   { return "\n$close"; }

}

function json_pretty__array(&$x, &$children, &$block, $style) {
	foreach ($x as $v) {
		$children[] = json_pretty__format($v, false, $childBlock, $style);
		if ($childBlock) {
			$block = true;
		}
	}
}

function json_pretty__object(&$x, &$children, &$block, $style) {
	foreach ($x as $k => $v) {
		$children[] = $style::format_object(json_encode($k), json_pretty__format($v, true, $childBlock, $style));
		if ($childBlock) {
			$block = true;
		}
	}
}

function json_pretty__collection(&$x, $open, $close, $collector, $drop, &$block, $style) {
	$block = false;
	$children = array();
	$collector($x, $children, $block, $style);
	if (empty($children)) {
		return $style::format_empty($open, $close);
	}
	if (!$block) {
		if (strlen(implode(', ', $children)) > 50) {
			$block = true;
		}
	}
	if ($block) {
		if ($drop) {
			$mode = 'block';
		} else {
			$mode = 'compact';
		}
	} else {
		$mode = 'inline';
	}
	$opener = "open_$mode";
	$joiner = "join_$mode";
	$closer = "close_$mode";
	return $style::$opener($open) . implode($style::$joiner(','), $style::indent($children)) . $style::$closer($close);
}

function json_pretty__format(&$x, $drop, &$block, $style) {
	if (is_array($x)) {
		return json_pretty__collection($x, '[', ']', 'json_pretty__array', $drop, $block, $style);
	} else if (is_object($x)) {
		return json_pretty__collection($x, '{', '}', 'json_pretty__object', $drop, $block, $style);
	} else {
		$block = false;
		return json_encode($x);
	}
}

function json_pretty($json, $drop = false, $style = 'JSONPrettyDefaultStyle') {
	$data = json_decode($json);
	return json_pretty__format($data, $drop, $block, $style);
}

