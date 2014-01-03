<?php

//fuly decode a particular string
function full_decode($string)
{
	return html_entity_decode($string, ENT_QUOTES);
}

//decode anything we throw at it
function form_decode(&$x)
{
	//loop through objects or arrays
	if(is_array($x) || is_object($x))
	{
		foreach($x as &$y)
		{
			$y = form_decode($y);
		}
	}
	
	if(is_string($x))
	{
		$x	= full_decode($x);
	}
	
	return $x;
}

function my_character_limiter($str, $n = 500, $end_char = '&#8230;')
{
	$output = substr($str, 0, $n);
	if(strlen($str)>$n){
		$output.=$end_char;
	}

	return $output;
}


//used by the giftcard feature
function generate_code($length=16)
{
	$vowels = '0123';
	$consonants = '456789ABCDEF';
 
	$password = '';
	$alt = time() % 2;
	for ($i = 0; $i < $length; $i++) {
		if ($alt == 1) {
			$password .= $consonants[(rand() % strlen($consonants))];
			$alt = 0;
		} else {
			$password .= $vowels[(rand() % strlen($vowels))];
			$alt = 1;
		}
	}
	return $password;
}

//替换商品描述下www.eelly.com的图片到img.eelly.com
function correction($out)
{
    $out = preg_replace('/http:\/\/(\w+)\.eelly\.com\/data\/files\//','http://img.eelly.com/data/files/',$out);
    $out = str_replace('http://img.eelly.com/http', 'http', $out);
    $out = str_replace('http://www.eelly.com/http', 'http', $out);
    return $out;
}