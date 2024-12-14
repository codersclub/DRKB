<?php

//-------------------------------------------------------------------------
function parse_div_5_3plus($content='') {
    str_replace("\r", '', $content);

    $pattern = "/^(<p>)*:::\s*({([^}]+)})*\s*(<\/p>)*$/m";

    $content = preg_replace_callback($pattern, function($matches) { 
//dump($matches, '$matches');
        $line = @$matches[3];
//dump($line, '$line');
        if($line) {
            $line = preg_replace("/#([^\s]+)/", "id=\"\\1\"", $line);
            $line = preg_replace("/\.([^\s]+)/", "class=\"\\1\"", $line);
            $line = '<div ' . $line . ">";
//dump($line, '$line');
        } else {
            $line = "</div>";
        }
        return $line;
    }, $content);

return $content;

}

//---------------------------------------------------
function load_tree() {
	$file = _D_ . '/site_map.json';

	$json = file_get_contents($file);

	$array = json_decode($json, 1);

//dump($array, '$array');
//exit;

	return $array;
}

//-------------------------------------------------------------------------
function download($path='') {
	$filename = basename($file);
	header('Content-Type: ' . mime_content_type($file));
	header('Content-Length: '. filesize($file));
	header(sprintf('Content-Disposition: attachment; filename=%s',
		strpos('MSIE',$_SERVER['HTTP_REFERER']) ? rawurlencode($filename) : "\"$filename\"" ));
	ob_flush();
	readfile($file);
	exit;
}

