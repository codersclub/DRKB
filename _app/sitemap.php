<?php

session_start();

set_time_limit(0);

require_once('lib/functions.php');

init(__FILE__);

$outdir = DATA_DIR; //'./data';
$indir = CONTENT; //'../content';

//dump(DIR, 'DIR');
//dump(CONTENT, 'CONTENT');
//dump(URL, 'URL');
//dump(APP, 'APP');
//dump($indir, '$indir');
//dump($outdir, '$outdir');
//exit;

// Resulting sitemap array
//$array = array();

//MULTIPLE_EXTENSIONS
//glob("$dirname*.{png,jpeg,jpg,gif}", GLOB_BRACE);
$mask = '/*.{' . EXT . ',' . EXT2 . '}';

//dump($indir . $mask, '$indir . $mask');

//$files = glob($indir . $mask, GLOB_NOSORT | GLOB_BRACE);

$files = glob_recursive($indir . $mask, GLOB_BRACE | GLOB_NOSORT);
////$files = glob_recursive($indir . $mask, GLOB_BRACE);

exclude($files);

//usort($files, "reindex");

//dump($files, '$files');
//exit;

// Use after check if from web!
//header('Content-Type: text/plain');

//dump(DIR, 'DIR');
//dump(APP_DIR, 'APP_DIR');
//dump(URL, 'URL');
//dump($GLOBALS['exclude_dir'], '$GLOBALS[exclude_dir]');
//dump($GLOBALS['exclude_file'], '$GLOBALS[exclude_file]');
//dump($GLOBALS['exclude_url'], '$GLOBALS[exclude_url]');
//dump($GLOBALS['menu_items'], '$GLOBALS[menu_items]');
//exit;


// File counter
$fc = count($files);
$fn = 1;

$json = "[\n";

foreach ($files as $file) {
//dump($file, '$file');

    $body = file_get_contents($file);
//echo "\tLength = ", mb_strlen($body);

    $ext = extension($file);
//dump($ext, '$ext');

    $meta = meta($body, $ext);

    $url = file_url($file);
    $meta['url'] = $url;

    $filemtime = filemtime($file);
    $file_time = date('Y-m-d H:i:s', $filemtime);

    $meta['filemtime'] = $filemtime;
    $meta['file_time'] = $file_time;
    $meta['order']     = $fn;

    // Mark Menu Items
    if(($url <> '/') && in_array($url, $GLOBALS['menu_items'])) {
//dump('Mark menu_items: "'.$url.'" !!!!!!!!!!!!!!');
        $meta['in_menu'] = 1;
    }

    meta_fix($body, $meta);

    if($url == URL . '/') {
        $meta['title'] = HOME_TITLE;
    }

//dump($meta, 'SITEMAP $meta');

    $json .= "\t{\n";

    $c = count($meta);
    $n = 1;

    foreach ($meta as $k => $v) {
//        $v = stripslashes(trim($v));
        $meta[$k] = $v;

//    	$json .= "\t\"" . $k . "\":\t\"" . htmlspecialchars($v) . "\"";
    	$v = addslashes($v);
    	$v = str_replace('\\\'', "'", $v);
    	$json .= "\t\"" . $k . "\":\t\"" . $v . '"';
//    	$json .= "\t\"" . $k . "\":\t\"" . $v . '"';

    	if($n < $c) {
    	    $json .= ',';
        }
        $json .= "\n";
        $n++;
    }
    $json .= "\t}";

//dump($meta, '$meta');

    if($fn < $fc) {
        $json .= ',';
    }
    $json .= "\n";

    $fn++;
}

$json .= "]\n";

$file = $outdir . '/sitemap.json';
$res = file_put_contents($file, $json, LOCK_EX);

if($res === false) {
    die ("Error writing the file: $file");
} else {
    die ("Sitemap is created ok.");
}


//---------------------------------------------------------------
function glob_recursive($pattern, $flags = 0)
{
    $files = glob($pattern, $flags);
//dump($files, '$files');
    foreach (glob(dirname($pattern) . '/*', GLOB_ONLYDIR | GLOB_NOSORT) as $dir) {
        $in_files = glob_recursive($dir . '/' . basename($pattern), $flags);
//dump($in_files, '$in_files');
        $files = array_merge($files, $in_files);
    }
    return $files;
}

//---------------------------------------------------------------
function reindex($a, $b) {
//dump($a, '$a');
//dump($b, '$b');
  $res = 0;

  $d1 = dirname($a);
  $d2 = dirname($b);

//dump($d1, '$d1');
//dump($d2, '$d2');

  if($d1 > $d2) {
    $res = 1;
  } else if($d1 < $d2) {
    $res = -1;
  } else {
    $mask = '\.('.EXT.'|'.EXT2.'$)';
    $f1 = preg_replace("/$mask/", '', basename($a));
    $f2 = preg_replace("/$mask/", '', basename($b));
//dump($f1, '$f1');
//dump($f2, '$f2');
    if($f1 == INDEX) {
      $res = -1;
    } else if($f2 == INDEX) {
      $res = 1;
    } else {
      $res = $a > $b ? 1 : ($a < $b ? -1 : 0);
    }
//dump($res, '$res');
  }

  return $res;
}
