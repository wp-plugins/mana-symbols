<?php
/*
Plugin Name: Mana Symbols
Plugin URI: 
Description: Replace shortcodes with Magic: The Gathering mana symbols.
Author: beatrepeat
Version: 0.1
Author URI: mailto:Tim.Glushkov@gmail.com
*/

class ManaReplacer
{
	var $text;

	var $pairs = array(
		'wp'  => 'wp',
		'up'  => 'up',
		'bp'  => 'bp',
		'rp'  => 'rp',
		'gp'  => 'gp',

		'2/w' => '2w',
		'2/u' => '2u',
		'2/b' => '2b',
		'2/r' => '2r',
		'2/g' => '2g',

		'w/u' => 'wu',
		'u/b' => 'ub',
		'b/r' => 'br',
		'r/g' => 'rg',
		'g/w' => 'gw',

		'u/w' => 'wu',
		'b/u' => 'ub',
		'r/b' => 'br',
		'g/r' => 'rg',
		'w/g' => 'gw',

		'w/b' => 'wb',
		'b/g' => 'bg',
		'g/u' => 'gu',
		'u/r' => 'ur',
		'r/w' => 'rw',

		'b/w' => 'wb',
		'g/b' => 'bg',
		'u/g' => 'gu',
		'r/u' => 'ur',
		'w/r' => 'rw',

		'20'  => '20',
		'19'  => '19',
		'18'  => '18',
		'17'  => '17',
		'16'  => '16',
		'15'  => '15',
		'14'  => '14',
		'13'  => '13',
		'12'  => '12',
		'11'  => '11',
		'10'  => '10',
		'9'   => '9',
		'8'   => '8',
		'7'   => '7',
		'6'   => '6',
		'5'   => '5',
		'4'   => '4',
		'3'   => '3',
		'2'   => '2',
		'1'   => '1',
		'0'   => '0',
		'x'   => 'x',
		'y'   => 'y',

		'w'   => 'w',
		'u'   => 'u',
		'b'   => 'b',
		'r'   => 'r',
		'g'   => 'g',

		'q'   => 'q',
		't'   => 't',
		's'   => 's',
	);

	function __construct($text)
	{
		$this->text = $text;
		foreach($this->pairs as $key => $value) {
			$this->pairs[$key] = '<i class="mana-'.$value.'"></i>';
		}
	}

	function to_symbols($input) {
		return strtr(strtolower($input[1]), $this->pairs);
	}

	function replace() {
		return preg_replace_callback(
			'/\{([^\}]+)\}/',
			array($this, 'to_symbols'),
			$this->text
		);
	}
}

function mana_symbols_css()  
{  
	wp_register_style('mana-symbols', plugins_url('mana-symbols.css', __FILE__));
	wp_enqueue_style('mana-symbols');
}

add_action('wp_enqueue_scripts', 'mana_symbols_css');

function mana_replace($text = '')
{
	$replacer = new ManaReplacer($text);
	return $replacer->replace();
}

add_filter('the_content',  'mana_replace');
add_filter('the_excerpt',  'mana_replace');
add_filter('comment_text', 'mana_replace');