<?php

global $sitemap;

function init($parent) {

	// PHP error settings
	ini_set('display_errors', 'On'); // Report PHP errors ON
	error_reporting(E_ALL); // Report all PHP errors

	// Multibyte encoding
	mb_internal_encoding('UTF-8');

	// Set Time Zone
	date_default_timezone_set(@date_default_timezone_get());

	// Define the Application Constants
//dump($_SERVER, '$_SERVER');
//dump($_SERVER['SCRIPT_FILENAME'], '$_SERVER[SCRIPT_FILENAME]');
//dump(__FILE__, '__FILE__');

//	$dir = str_replace('\\', '/', realpath(dirname($_SERVER['SCRIPT_FILENAME'])));
	$dir = str_replace('\\', '/', realpath(dirname($parent)));
	if(is_win()) {
	    $dir = strtolower($dir);
	}
	// App Directory
	define('APP_DIR', $dir);
//dump(APP_DIR, 'APP_DIR');

        $app_dir_name = basename(APP_DIR);
//dump($app_dir_name, '$app_dir_name');

	// Root directory
	define('DIR', dirname(APP_DIR));
//dump(DIR, 'DIR');

	// Data Directory
	define('DATA_DIR', APP_DIR . '/data');

//dump(DATA_DIR, 'DATA_DIR');

	// Engine title
	define ( 'ENGINE', 'yoCMS');

	// Engine Version
	define('VERSION', '0.9.6');

	// Start Time
	define('_START_', microtime(TRUE));

	// Request Scheme (http/https)
	define('SCHEME', isset($_SERVER['REQUEST_SCHEME']) ? $_SERVER['REQUEST_SCHEME'] : 'http');

	// Site Hostname
	define('HOST', @$_SERVER['HTTP_HOST']);

	// Load configuration file
	require_once (APP_DIR . '/config.php');

	//------------------------------------------------------------------------
        // App URL
	$url = dirname($_SERVER['PHP_SELF']);    // URL to your website without trailing slash.
//dump($_SERVER['PHP_SELF'], '$_SERVER[PHP_SELF]');
//dump($url, '$url');

//	$url = dirname($url);    // URL APP without trailing slash.
	if($url == '.') { // Run from console
		$url = CONSOLE_URL . '/' . $app_dir_name;
	}
//dump($url, '$url');

	define('APP', $url);
//dump(APP, 'APP');

	// Root Web URL (start from the SITE ROOT, W/o ending slash !)
	$url = dirname(APP);    // URL to your website with trailing slash.
	define('URL', preg_replace("/\/$/", '', str_replace('\\', '/', $url)));
//dump(URL, 'URL');

	// Image directory URL (w/o trailing slash)
	define ( 'IMG', APP . '/img');

	// CSS folder URL
	define ( 'CSS', APP . '/css');

	//Top/Bottom navigation URLs
	$GLOBALS['menu_items'] = array_merge(
		array_keys($GLOBALS['menu']),
		array_keys($GLOBALS['menu_bottom']),
		$GLOBALS['exclude_url']);
//dump($GLOBALS['menu_items'], '$GLOBALS[menu_items]');
//dump($_SESSION, '$_SESSION');

}


//-------------------------------------------------
function run() {
	global $sitemap;

	// Load markdown library
	require_once ('lib/markdown.php');

	$item = item();
//dump($item, '$item');

	define('ITEM', $item);
//dump(ITEM, 'ITEM');
//dump(URL, 'URL');
//dump(DIR, 'DIR');
//dump(DATA_DIR, 'DATA_DIR');

	$file = item_file($item);
//dump($file, '$file');

	$GLOBALS['file'] = $file;
	$GLOBALS['ext'] = extension($file);

//dump(FOUND, 'FOUND');
	if(FOUND) {
		$GLOBALS['content'] = load($file);
		$GLOBALS['content'] = str_replace('\\r', '', $GLOBALS['content']);
//dump(htmlspecialchars($GLOBALS['content']), '$GLOBALS[content]');

		$GLOBALS['meta'] = meta($GLOBALS['content'], $GLOBALS['ext']); // Strip & Parse META from content
//dump($GLOBALS['meta'], '$GLOBALS[meta]');
//dump(htmlspecialchars($GLOBALS['content']), '$GLOBALS[content]');

	} else {
		$GLOBALS['ext'] = 'md';
		$GLOBALS['content'] = load(TPL . '/' . NOTFOUND . '.md');
//dump(htmlspecialchars($GLOBALS['content']), '$GLOBALS[content]');

		$GLOBALS['meta'] = meta($GLOBALS['content'], $GLOBALS['ext']); // Strip & Parse META from content
//dump($GLOBALS['meta'], '$GLOBALS[meta]');

		$GLOBALS['content'] = markdown($GLOBALS['content']);
//dump($GLOBALS['content'], '$GLOBALS[content]');
	}

	$sitemap = json_load(DATA_DIR . '/sitemap.json');
//dump($sitemap, 'run: $sitemap');

//dump(ITEM, 'ITEM');
	$GLOBALS['id'] = get_index(ITEM);
//dump($GLOBALS['id'], '$GLOBALS[id]');

	$GLOBALS['prev'] = get_prev($GLOBALS['id']);
//dump($GLOBALS['prev'], '$GLOBALS[prev]');

	$GLOBALS['next'] = get_next($GLOBALS['id']);
//dump($GLOBALS['next'], '$GLOBALS[next]');

	$GLOBALS['breadcrumbs'] = breadcrumbs($GLOBALS['id']);
//dump($GLOBALS['breadcrumbs'], '$breadcrumbs');

	//-------------------------------------------------
	if(isset($_GET['login'])) {
		login();

	} elseif(isset($_GET['logout'])) {
		logout();

//	} elseif(isset($_GET['edit'])) {
//		edit($file);

	} else {
		show($file);

	}

	if(!FOUND) {
		header('HTTP/1.0 404 Not Found');
	}

	require (TPL . '/template.php');
}

//-------------------------------------------------
function item() {

	// Requested Page
	$p = mb_substr($_SERVER['REQUEST_URI'], mb_strlen(URL)); // URI
//dump($_SERVER['REQUEST_URI'], '$_SERVER[REQUEST_URI]');
//dump($p, '$p');

	// Clean QUERY STRING (starting from "?")
	$qpos = mb_strpos($p, '?');
//dump($qpos, '$qpos');
	if (!($qpos === false)) {
		$p = mb_substr($p, 0, $qpos);
	}
//dump($p, '$p');

	$p = rtrim ($p, '/');
//dump($p, '$p');
	return $p;
}

//-------------------------------------------------
function item_file($p) {

//dump(DIR, 'DIR');
//dump(URL, 'URL');
//dump('item() started.');
//dump($p, 'p');

  $dir = $p;
  $is_dir = 0;
  $found = 1;

  $file = CONTENT . rtrim($p, '/');
//dump($file, '$file1');

  // Virtual Directory?
  if(is_dir($file)) {
    $is_dir = 1;
//    $GLOBALS['url'] = rtrim($GLOBALS['url'], '/') . '/';
//dump($GLOBALS['url'], '$GLOBALS[url]');

//    $file .= '/' . INDEX . '.' . EXT;
    $file .= '/' . INDEX;
  }
//dump($file, '$file2');

  // Virtual Content File?
  if(file_exists($file . '.' . EXT)) {
    $dir = str_replace('\\','/',dirname($file));
    $file .= '.' . EXT;
//dump($file, '$file3');

  } else if(file_exists($file . '.' . EXT2)) {
    $dir = str_replace('\\','/',dirname($file));
    $file .= '.' . EXT2;

  } else {
//  if(!file_exists($file)) {
    $found = 0;
//    $file = TPL . '/' . NOTFOUND . '.' . EXT;
//dump($file, '$file4');
//dump('  What the hell?');
  }
//dump($file, '$file');

  define('IS_DIR', $is_dir);
  define('FOUND', $found);

//dump($is_dir, '$is_dir');
//dump($item, '$item');
//dump('item() finished.');

  $dir = ($dir == '.') ? '' : $dir;
//dump($dir, '$dir');
//dump(IS_DIR, 'IS_DIR');

//  define('PAGE_DIR', CONTENT . ($dir ? rtrim($dir, '/') : ''));
  define('PAGE_DIR', $dir);
//dump(PAGE_DIR, 'PAGE_DIR');

  $dir = preg_replace('#^'.CONTENT.'#', URL, $dir);
//dump($dir, '$dir');

//  define('BASE_DIR', URL . ($dir ? $dir : ''));
//  define('BASE_DIR', URL . ($p ? $p : ''));
  define('BASE_DIR', $dir);
//dump(BASE_DIR, 'BASE_DIR');

  return $file;
}

//-------------------------------------------------
function load($file='') {
//dump($file, '$file');
//backtrace();

        $ext = extension($file);
//dump($GLOBALS['ext'], '$ext');
//dump($ext, '$ext');
//dump(EXT, 'EXT');

        if(strtolower($ext) == 'php') {
		if(is_file($file)) {
		ob_start();
		include ($file); // USEPHP
		$content = ob_get_contents();
		ob_end_clean();
		} else {
		}

        } else if($ext == 'md') {
		$content = file_get_contents($file);
//		$content = str_replace('\\\'', '&apos;', $content);
        } else {
		send_file($file);
        }

//dump(htmlspecialchars($GLOBALS['content']), '$GLOBALS[content]');

	$content = str_replace("\r", '', $content);

	return $content;
}

//-------------------------------------------------
function sidebar() {
  $file = CONTENT . '/_sidebar.' . EXT;
//dump($file, '$file1');

  return $file;
}

//-------------------------------------------------
function show() {
//dump($file, 'show::$file');
	define('MODE', 'show');

	check_title();

	$GLOBALS['content'] = markdown($GLOBALS['content']);
//dump($GLOBALS['content'], '$GLOBALS[content]');

	$GLOBALS['content'] = parse_div($GLOBALS['content']);
//dump($GLOBALS['content'], '$GLOBALS[content]');

	strip_title();

	// Prepare children list
	$GLOBALS['children'] = get_children();
//dump($GLOBALS['children'], '$GLOBALS[children]');
}

//-------------------------------------------------------------------------
function check_title() {
	// Page Title
	if (empty($GLOBALS['meta']['title'])) {
		$GLOBALS['title'] = get_title($GLOBALS['content']);
		$GLOBALS['meta']['title'] = $GLOBALS['title'];
	} else {
		$GLOBALS['title'] = $GLOBALS['meta']['title'];
	}

	if(empty($GLOBALS['title'])) {
		$GLOBALS['title'] = TITLE_SUFFIX;
		define('TITLE', TITLE_SUFFIX);
	} else {
		define('TITLE', $GLOBALS['title'] . ' - ' . TITLE_SUFFIX);
	}
//dump($GLOBALS['meta'], '$GLOBALS[meta]');
}

//-------------------------------------------------------------------------
function get_title($str = '')
{
	preg_match("#<h1>(.*?)</h1>#i", $str, $matches);
//dump($matches, '$matches');
	return (@$matches[1]);
}

//-------------------------------------------------------------------------
function strip_title()
{
	$GLOBALS['content'] = preg_replace("#<h1>(.*?)</h1>#i", '', $GLOBALS['content']);
}

//-------------------------------------------------------------------------
function content () {
	echo $GLOBALS['content'];

        $show_toc = preg_match('#<!-- *TOC *-->#', $GLOBALS['content']);

        // Auto Table Of Content
        if ($show_toc) {
		echo toc();
	}

}

//-------------------------------------------------------------------------
function exclude(&$files = array()) {

    // Remove ignored dirs/files/url
    foreach ($files as $i => $file) {
//dump($file, '$file['.$i.']'); flush();

        // Ignore Excluded Directories inside the CONTENT folder
        $dirname = pathinfo($file, PATHINFO_DIRNAME);
        $dirname = substr($dirname, strlen(CONTENT)) . '/';
//dump($dirname, '$dirname');

        $skip = 0;
        foreach($GLOBALS['exclude_dir'] as $dir) {
          if(substr($dirname, 0, strlen($dir)) == $dir) {
//dump('SKIP exclude_dir: "'.$files[$i].'" !!!!!!!!!!!!!!'); flush();
            unset($files[$i]);
            $skip = 1;
            break;
          }
        }
        if($skip) {
            continue;
        }

        // Ignore APP Folder inside the CONTENT folder if yet not ignored
        if(substr($file, 0, strlen(APP_DIR)) == APP_DIR) {
//dump('SKIP _APP file: "'.$files[$i].'" !!!!!!!!!!!!!!'); flush();
            unset($files[$i]);
            continue;
        }

        // Ignore Excluded Files inside the CONTENT folder
        $filename = substr($file, strlen(CONTENT));
//dump($filename, '$filename');
        if(in_array($filename, $GLOBALS['exclude_file'])) {
//dump('SKIP exclude_file: "'.$files[$i].'" !!!!!!!!!!!!!!'); flush();
            unset($files[$i]);
            continue;
        }

        // Item URL
        $url = file_url($file);
//dump($url, '$url');

        // Ignore Excluded URL
        if(in_array($url, $GLOBALS['exclude_url'])) {
//dump('SKIP exclude_url: "'.$url.'" !!!!!!!!!!!!!!'); flush();
            unset($files[$i]);
            continue;
        }

        // Exclude Menu Items
        if(($url <> '/') && in_array($url, $GLOBALS['menu_items'])) {
//dump('Skip MENU_item: "'.$url.'" !!!!!!!!!!!!!!');
            unset($files[$i]);
            continue;
        }

    }
//dump($files, '$files');
//exit;

}

//-------------------------------------------------------------------------
function toc() {
//dump($GLOBALS['children'], '$GLOBALS[children]');
	$children = '<div class="children">' . "\n\n";
	$children .= markdown(make_children(@$GLOBALS['children']));
	$children .= "\n</div>\n";

	return $children;
}

//-------------------------------------------------------------------------
function get_children () {
	$children = array();
//dump(IS_DIR, 'IS_DIR');
//dump(PAGE_DIR, 'PAGE_DIR');
//dump(ITEM, 'ITEM');
//dump(INDEX, 'INDEX');

	if(IS_DIR) {
		$dirs = glob(PAGE_DIR . '/*/' . INDEX . '.{php,md}', GLOB_BRACE | GLOB_NOSORT);
//dump($dirs, '$dirs');
		$files = glob(PAGE_DIR . '/*.{php,md}', GLOB_BRACE | GLOB_NOSORT);
//dump($files, '$files');

                exclude($dirs);
                exclude($files);
//dump($dirs, '$dirs');
//dump($files, '$files');

		foreach ($dirs as $file) {
//dump($file, '$file');
			$ext = extension($file);
			$body = file_get_contents($file);

			$meta = meta($body, $ext);
//dump($meta, '$meta');

			$item = str_replace(CONTENT . '/', '', $file);
//dump($item, '$item1');
			$item = preg_replace("#\.(php|md)$#", '', $item);
//dump($item, '$item2');
			$item = preg_replace('#/' . INDEX . '$#', '', $item);
//dump($item, '$item3');

			$meta['url'] = $item;
			$meta['is_dir'] = 1;
			$meta['file'] = $file;
//dump($meta, '$meta');

			$children[] = $meta;
		}

//dump(ITEM, 'ITEM');

		foreach ($files as $file) {
//dump($file, '$file');
			$item = str_replace(CONTENT . '/', '', $file);
			$item = preg_replace("#\.(php|md)$#", '', $item);
//dump($item, '$item');
//dump(substr($item, -(strlen(INDEX))), 'substr');
			// Skip the INDEX file
			if($item == INDEX || substr($item, -(strlen(INDEX))) == INDEX) {
				continue;
			}

//dump($item, '$item');
			if($item !== ITEM) {

				$item = preg_replace("#/".INDEX."$#", '', $item);
//dump($item, '$item');

				$body = file_get_contents($file);
//dump($body, '$body');

				$meta = meta($body, extension($file));
//dump($meta, '$meta');

				$meta['url'] = $item;
				$meta['is_dir'] = 0;
				$meta['file'] = $file;

				if(empty($meta['title'])) {
					$meta['title'] = $item;
				}
//dump($meta, '$meta');

				$children[] = $meta;
			}
		}

//dump($children, '$children');

	}

//dump($children, '$children');
	return $children;
}

//-------------------------------------------------------------------------
function make_children ($items=array()) {
//dump('make_children():');
//dump($items, '$items');

	$children = '';

	if(count($items)) {
		// Remove Menu Items from the Children list
		foreach($items as $file) {
//dump($file['url'], '$file[url]');

			if(in_array('/' . $file['url'] . '/', $GLOBALS['menu_items'])) {
//dump($file['url'] . ' FOUND');
				continue;
			}
			$children .= '* [' . $file['title'] . '](' . URL . '/' . $file['url'] . "/)\n";
			//[title](https://www.example.com/bla-bla)
		}
	}

	return $children;

}

//-------------------------------------------------
function tpl ($tpl) {
	global $sitemap;
//dump('tpl() started.');
//dump($tpl, '$tpl');

	if($tpl=='404') {
		header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
		header('Status: 404 Not Found');
	}
	//flush();
  
	$file = TPL . "/$tpl.php";

//dump($file, '  file');

	if (file_exists(TPL . "/$tpl.php")) {		

		ob_start();
		include ($file);	  
		$content = ob_get_contents();
		ob_end_clean();

	} else {		
		$content = "<!-- Requested template file $file was not found. -->";
	}

	return $content;
}

/**
 * Parses the file meta from raw file contents
 *
 * Meta data MUST start on the first line of the file,
 * either opened and closed by `---`.
 * Meta info nlock is parsed using a regular expression.
 * Required meta keys can be defined in $headers.
 *
 * @param string   $content raw file contents
 * @param string[] $headers known meta headers
 *
 * @return array parsed meta data
 */
function meta(&$content = '', $ext = '') {
	static $keys = array(
                'title',
                'description',
                'keywords',
                'author',
                'date',
                'updated',
//                'robots',
//                'hidden',
	);

	// Guarantee array key existance
	$meta = array_fill_keys($keys, '');

	if($ext == 'md') {
	    $data = get_meta($content, $meta);
//dump($data, 'GET_meta');

	    if(empty($data)) {
	    	$data = meta_md($content, $meta);
//dump($data, 'MD_meta');
	    }
	} else {
	    $data = meta_html($content, $meta);
//dump($data, 'HTML_meta');
	}

	$key = '';

	foreach ($data as $key => $line) {
//dump($key, '$key');
//dump($line, '$line');
		$key = strtolower($key);
		$meta[$key] = $line;
	}

	return $meta;
}

//-------------------------------------------------------
function meta_md(&$content = '') {
//dump('meta_MD:');
	$meta = array(
	);

	$headers = getHeaders($content, 1);
//dump($headers, '$headers');

	foreach($headers as $header) {
		foreach($header as $level => $line) {
			if($level == 1) {
				$meta['title'] = $line;
				break;
			}
		}
	}

	return $meta;
}

function getHeaders($text, $maxlevel=6) {
	$headers = array();
	# Setext-style headers:
	#	  Header 1
	#	  ========
	#
	#	  Header 2
	#	  --------
	#
	if(preg_match('{ ^(.+?)[ ]*\n(=+|-+)[ ]*\n+ }mx', $text, $matches)) {
//dump($matches, '$matches111');
		$level = $matches[2][0] == '=' ? 1 : 2;
		if($level <= $maxlevel) {
			$headers[] = array($level => $matches[1]);
		}
	}
	# atx-style headers:
	#	# Header 1
	#	## Header 2
	#	## Header 2 with closing hashes ##
	#	...
	#	###### Header 6
	#
	if(preg_match('{
			^(\#{1,6})	# $1 = string of #\'s
			[ ]*
			(.+?)		# $2 = Header text
			[ ]*
			\#*			# optional closing #\'s (not counted)
			\n+
		}xm',
		$text, $matches)) {
//dump($matches, '$matches222');
		$level = strlen($matches[1]);
		if($level <= $maxlevel) {
			$headers[] = array($level => $matches[2]);
		}
	}

	return $headers;
}

//-------------------------------------------------
function get_meta(&$content = '', $strip_meta = true) {
	$meta = array();

	$pattern = "/^(\/(\*)|---)[[:blank:]]*(?:\r)?\n"
		 . "(?:(.*?)(?:\r)?\n)?(?(2)\*\/|---)[[:blank:]]*(?:(?:\r)?\n|$)/s";

	$matches = array();

	if (preg_match($pattern, $content, $matches) /*&& isset($matches[3])*/) {
//dump($matches, '$matches');
		$matches = @$matches[3];
//dump($matches, '$matches');
		// Strip the META structure from the content
                if($strip_meta) {
			$content = preg_replace($pattern, '', $content); // Strip Meta from Content
			$content = preg_replace("/^\s+/", '', $content); // Strip string spaces and CRLF
		}
//dump($matches, '$matches');
//dump(empty($matches), 'empty($matches)');

//	if(!is_array($matches)) {
		$matches = str_replace('\\r', '', $matches);
		$matches = explode("\n", $matches);
//	}

		foreach ($matches as $line) {
			if(preg_match("/^(\w+)\s*:\s*(.*?)\s*$/", $line, $found)) {
				$key = strtolower($found[1]);
//				$meta[$key] = htmlspecialchars($found[2]);
//				$meta[$key] = addslashes($found[2]);
				$meta[$key] = stripslashes($found[2]);
//				$meta[$key] = $found[2];
			} else {
				if(!isset($meta[$key])) {
					$meta[$key] = '';
				}
//				$meta[$key] .= htmlspecialchars($line);
//				$meta[$key] .= addslashes($line);
				$meta[$key] .= stripslashes($line);
//				$meta[$key] .= $line;
			}
		}
	}

	return $meta;
}

//-------------------------------------------------
function meta_fix(&$content = '', &$meta = array()) {
//dump('meta_FIX:');

	if(empty($meta['title'])) {
	    // Get Title
	    $pattern = "/^(.*?)\r*\n"
	             . "(?:(=+?)(?:\r)?\n)/m";

	    if(preg_match($pattern, $content, $matches)) {
//dump($matches, '$matches');
		    $meta['title'] = @$matches[1] . '';
	    }
	}

	if(empty($meta['date'])) {
	    // Get Date
	    $pattern = "/^:::\s+{\.date}\r*\n"
	             . "(?:(.*?)(?:\r)?\n)"
	             . "^:::(?:(?:\r)?\n)/m";

	    if(preg_match($pattern, $content, $matches)) {
//dump($matches, '$matches');
		$meta['date'] = @$matches[1] . '';
	    }
	}

	if(empty($meta['updated'])) {
	    // Get FileMTime
		$meta['updated'] = $meta['file_time'];
	}

	if(empty($meta['author'])) {
	    // Get Date
	    $pattern = "/^:::\s+{\.author}\r*\n"
	             . "(?:(.*?)(?:\r)?\n)"
	             . "^:::(?:(?:\r)?\n)/m";

	    if(preg_match($pattern, $content, $matches)) {
//dump($matches, '$matches');
		$meta['author'] = @$matches[1] . '';
	    }
	}

	if(empty($meta['author'])) {
	    // Get Authors
	    $pattern = "/^Автор: (?:(.*?)(?:\r)?\n)/m";
	    if(preg_match($pattern, $content, $matches)) {
//dump($matches, '$matches');
		    $meta['author'] = @$matches[1] . '';
	    }
	}

	return $meta;
}

//-------------------------------------------------
function meta_html(&$html='', $meta = array()) {
  $title = '';

//dump('parse() started.');

  if(preg_match("/<h1>(.+?)<\/h1>/i",$html,$matches)) {
    $title = $matches[1];
//dump($title, 'title');
  }
  $meta['title'] = $title;

  if(preg_match('~<div class="date">(.+?)</div>~i', $html, $matches)) {
    $date = $matches[1];
//dump($title, 'title');
    $meta['date'] = $date;
  }

  if(preg_match('~<p class="author">(.+?)</p>~i', $html, $matches)) {
    $author = trim($matches[1]);
    $author = preg_replace("/Автор:\s*/", '', $author);
    $meta['author'] = $author;
  }

  return $meta;
}

//-------------------------------------------------------------------------
function extension2($filename='') {
	$info = new SplFileInfo($filename);
	$ext = $info->getExtension();
//dump($ext, '$ext');
	return $ext;
}

//-------------------------------------------------------------------------
function extension($filename='') {
	$ext = pathinfo($filename, PATHINFO_EXTENSION);
//dump($ext, '$ext');
	return $ext;
}


/**
 * Send a file to the browser
 * @param  string $path The output file name
 */
function send_file($path='', $force_download=false) {
//dump('SEND_FILE:');
//dump($path, '$path');

	if($path) {
		if (file_exists($path)) {
			$mime = mime_type($path);

			$pathinfo = explode('/', $path);
			$pathinfo = $pathinfo[count($pathinfo) - 1];
			$ext = extension($pathinfo);
			$filename = preg_replace('#\.' . $ext . '\$#', '', $pathinfo);
//dump($mime, '$mime');
//dump($filename, '$filename');

			// Send response headers to the browser
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Expires: 0');
			header('Pragma: no-cache');
			header('Content-Length: ' . filesize($path));

			if ($force_download) {
				header('Content-Type: application/octet-stream');
				header("Content-Disposition: attachment;filename=$filename");
			} else {
				header('Content-Type: ' . $mime);
			}

			readfile($path);

			exit;
		}
	}
}

/**
 * Detect the file MIME type
 * @param string $filename
 * @param bool $hack_mime Hack the MIME type for the visual representation
 * @return bool|mixed
 */
function mime_type($filename='', $hack_mime = false) {
	static $mimes = array();

	$pathinfo = pathinfo($filename);

	$ext = isset($pathinfo['extension']) ? $pathinfo['extension'] : '';
//dump($ext, '$ext');

	if(!count($mimes)) {
		load_mime_types($mimes);
	}
//dump($mimes, '$mimes');

	// Try to get a real MIME type
	$mime = @$mimes[$ext];
//dump($mime, '$mime');

	// Hack the MIME type for show the code
	if ($hack_mime) {
		if ($ext == 'htm' || $ext == 'html' || $ext == 'shtml') {
			$mime = 'text/html';
		}

		if ($mime == 'application/xml') {
			$mime = 'text/xml';

		} elseif ($mime == 'application/x-php') {
			$mime = 'text/php';

		} elseif ($mime == 'application/x-sh') {
			$mime = 'text/sh';

		} elseif ($mime == 'application/x-javascript') {
			$mime = 'text/javascript';

		} elseif ($mime == 'image/svg+xml') {
			$mime = 'text/svg';
		}
	}

	if (empty($mime)) {
		$mime = 'text/plain';
	}

	return $mime;
}

//-------------------------------------------------------------------------
function load_mime_types(&$mimes=array()) {
	$lines = file(MIME_TYPES);
//dump($lines, '$lines');

	foreach($lines as $line) {
		if (substr($line, 0, 1) == '#') continue; // skip comments

		$line = rtrim($line);

		$parts = preg_split('/\s+/', $line);

		if (count($parts) < 2) {
			continue; // no match to the extension
		}

		$mime = array_shift($parts);

		foreach($parts as $ext) {
			$mimes[$ext] = $mime;
		}
	}

	// Add yet another MIME types
	if(!isset($mimes['php'])) {
		$mimes['php'] = 'text/php';
	}

	if(!isset($mimes['pl'])) {
		$mimes['pl'] = 'text/perl';
	}

	if(!isset($mimes['py'])) {
		$mimes['py'] = 'text/python';
	}

	if(!isset($mimes['shtml'])) {
		$mimes['shtml'] = 'text/html';
	}

//dump($mimes, '$mimes');

}

/**
 * Show debug info
 * @param $data
 * @param string $name
 */
function dump($data, $name = '') {
	$buf = var_export($data, true);

	$buf = str_replace('\\r', '', $buf);
	$buf = preg_replace('/\=\>\s*\n\s+/s', '=> ', $buf);

	echo '<pre>';

	if ($name) {
		echo $name . '=';
	}

	echo $buf;
	echo "</pre>\n";
}

/**
 * Check for signed in
 * @return boolean
 */
function is_logged() {
	if (isset($_SESSION['username'])) {
		return true;
	}
	return false;
}

/**
 * Log in
 */
function login() {
	define('MODE', 'login');

	if(is_logged()) {
		redirect(URL . '/');
	}

	$username = $password = '';
//dump($_SESSION, '$_SESSION');

	// Check for POST
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		// get user credentials
		$username = isset($_POST['username']) ? trim($_POST['username']) : '';
		$password = isset($_POST['password']) ? trim($_POST['password']) : '';

		$GLOBALS['username'] = $username;

		// validate
		if (!($username AND $password)) {

			// wrong login
			$_SESSION['message'] = array(
				'class' => 'error',
				'text' => 'Необходимо ввести логин и пароль!', //'You have to enter a username and password'; //'lang('need_user_and_pass');
			);

		} else {

			if($username == USERNAME && $password == PASSWORD) {

				// Set the session parameters
				$_SESSION['username'] = $username;

				// valid username_or_pass
				$_SESSION['message'] = array(
					'class' => 'success',
					'text'  => 'Вы успешно вошли в систему!', //'You have successfully logged in!'; //lang('log_in_ok');
				);

				// redirect to home
				redirect(URL . '/');

			} else {

				// wrong username_or_pass
				$_SESSION['message'] = array(
					'class' => 'error',
					'text' => 'Неверный логин или пароль!'//'Invalid username or password!'; //lang('invalid_user_or_pass');
				);
			}

		}

	}

	//--------------------------------------------------
	// Method GET or invalid login
	$GLOBALS['content'] = tpl('login');
//dump(htmlspecialchars($GLOBALS['content']), 'content');

}

/**
 * Log out
 */
function logout() {
	unset($_SESSION['username']);

	redirect(URL . '/');
}

/**
 * Redirect to URL
 */
function redirect($url = '')
{
	header('Location: ' . $url);
	exit;
}

//-------------------------------------------------------------------------
function edit($file = '') {
	define('MODE', 'edit');
//dump($file, '$file');
//dump(URL, 'URL');
//dump(ITEM, 'ITEM');
//dump($GLOBALS['meta'], 'EDIT META');

	$sef = explode('/', ITEM);
	$sef = $sef[count($sef) - 1];
//dump($sef, '$sef');
	$GLOBALS['sef'] = $sef;

	$content = '';

	$referer = parse_url(@$_SERVER['HTTP_REFERER']);
//dump($referer, '$referer');
//dump($GLOBALS['meta'], '$GLOBALS[meta]');
//dump(meta_text($GLOBALS['meta']), 'meta_text()');

	// Check for POST
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//dump(array_map('htmlspecialchars', $_POST), '$_POST');

		// Get form data
		$content = isset($_POST['content']) ? $_POST['content'] : '';

		$title = isset($_POST['title']) ? trim($_POST['title']) : '';
		$url = isset($_POST['url']) ? trim($_POST['url']) : '';
		$author = isset($_POST['author']) ? trim($_POST['author']) : '';
		$date = isset($_POST['date']) ? trim($_POST['date']) : '';
		$keywords = isset($_POST['keywords']) ? trim($_POST['keywords']) : '';
		$description = isset($_POST['description']) ? trim($_POST['description']) : '';

		// What to do if SEF was changed?
		if($url !== $GLOBALS['sef']) {
			// ?????
		}

		$meta = array (
			'title'  => $title,
			'author' => $author,
			'date'   => $date,
			'keywords' => $keywords,
			'description' => $description,
		);

//dump($title, '$title');
//dump($sef, '$url');
//dump($date, '$date');
//dump($keywords, '$keywords');
//dump($meta, '$meta');

		if(extension($file) == 'md') {
		$content = "---\n" 
                    . 'Title: ' . $title . "\n"
                    . 'Author: ' . $author . "\n"
                    . 'Date: '   . $date . "\n"
                    . 'Keywords: ' . $keywords . "\n"
                    . 'Description: ' . $description . "\n"
                    . "---\n\n"
                    . $content
                    . "\n";
                }
//dump(htmlspecialchars($content), '$content');

		// validate
		if (!1) {
			// Invalid content
			$_SESSION['message'] = array(
				'class' => 'error',
				'text' => 'Invalid content!', //'lang('content_invalid');
			);
		}

		if(file_put_contents($file, $content, LOCK_EX)) {
			// Write OK
			$_SESSION['message'] = array(
				'class' => 'success',
				'text'  => 'The file successfully saved: ' . ITEM, //lang('file_write_ok');//
			);
		} else {
			// Write Error
			$_SESSION['message'] = array(
				'class' => 'error',
				'text' => 'Error writing file: ' . ITEM, //lang('file_write_error');
			);
		}
//dump(URL, 'URL');
//dump(ITEM, 'ITEM');

		// redirect to the article
		redirect(URL . ITEM . '/');

		exit;
	}

	//--------------------------------------------------
	// Method GET
	$GLOBALS['content'] = htmlspecialchars($GLOBALS['content']);

	$GLOBALS['content'] = tpl('edit');

	$GLOBALS['title'] = 'Edit page';
//	$GLOBALS['page_title'] = $GLOBALS['title'];

//dump(htmlspecialchars($GLOBALS['content']), 'content');

}

//-------------------------------------------------------------------------
function meta_text($meta = array()) {
	$txt = '';
	foreach ($meta as $k=>$v) {
		$txt .= ucfirst($k) . ': ' . htmlspecialchars($v) . "\n";
	}
	return $txt;
}

//----------------------------------------------------
// Load JSON file to array
function json_load($file) {
//dump($file, 'json_load: $file');

  $array = array();

  if(is_file($file)) {
    $body = file_get_contents($file);
    $body = htmlspecialchars_decode($body);
//dump($body, '$body');

    $array = @json_decode($body, true);
    if(is_null($array) && json_last_error() !== JSON_ERROR_NONE) {
      die('Error loading JSON file: ' . $file . '.<br>' . json_last_error_msg());
    }
//dump($array, '$array');
  }

  return $array;
}

//----------------------------------------------------
// JSON Error Message
if(!function_exists('json_last_error_msg')) {
function json_last_error_msg() {
    $error = json_last_error();
    switch ($error) {
        case JSON_ERROR_NONE:
            $msg = $error . ' - No errors';
        break;
        case JSON_ERROR_DEPTH:
            $msg = $error . ' - Maximum stack depth exceeded';
        break;
        case JSON_ERROR_STATE_MISMATCH:
            $msg = $error . ' - Underflow or the modes mismatch';
        break;
        case JSON_ERROR_CTRL_CHAR:
            $msg = $error . ' - Unexpected control character found';
        break;
        case JSON_ERROR_SYNTAX:
            $msg = $error . ' - Syntax error, malformed JSON';
        break;
        case JSON_ERROR_UTF8:
            $msg = $error . ' - Malformed UTF-8 characters, possibly incorrectly encoded';
        break;
        default:
            $msg = $error . ' - Unknown error';
        break;
    }
    return $msg;
}
}

//---------------------------------------------------
function breadcrumbs($id=null) {
	global $sitemap;
/*
'/about/' => array (
    'title' => '',
    'description' => '',
    'keywords' => '',
    'author' => '',
    'date' => '',
    'filemtime' => '1634204988',
    'file_time' => '2021-10-14 12:49:48',
  ),
*/
	$breadcrumbs = array();
//dump($GLOBALS['id'], '$GLOBALS[id]');
//dump($sitemap[$GLOBALS['id']], '$sitemap[$GLOBALS[id]]');

	// Current Item
//	$breadcrumbs[] = $sitemap[$GLOBALS['id']];

	// Current url
	$url = ITEM;

	$parts = explode('/', rtrim(ITEM, '/'));

//	array_pop($parts);
//dump($parts, '$parts2');

	while(count($parts)) {
//dump($parts, '$parts');

          $url = implode('/', $parts);
//dump($url, '$url2');
          $url = "/$url/";
//dump($url, '$url3');
          $url = str_replace('//', '/', $url);
//dump($url, '$url4');

	  $id = get_index($url);
//dump($id, '$id');

	  if(!is_null($id)) {
//dump($id, 'Add $id:');
		  $breadcrumbs[] = $sitemap[$id];
	  }

	  array_pop($parts);
	}

//dump($breadcrumbs, '$breadcrumbs');
	return array_reverse($breadcrumbs);
}

//---------------------------------------------------
function get_url($item=array()) {
//dump($item, 'get_url item');
//dump($item['url'], 'get_url item[url]');
	return $item['url'];
}

//---------------------------------------------------
function get_index($url='') {
//dump($url, 'get_index: $url');
	global $sitemap;
//dump($sitemap, '$sitemap');

	if(substr($url, -1) <> '/') {
		$url .= '/';
	}
//dump($url, '$url');

	return array_search($url, array_map('get_url', $sitemap));
}


//---------------------------------------------------
function get_prev($id=null) {
	global $sitemap;
//dump($sitemap, '$sitemap');
//dump($id, 'GET_PREV id');
	$prev = null;

	if($id === false || isset($sitemap[$id]['in_menu'])) {
	} else {
		$prev = $id - 1;
//dump($prev, '$prev1');
		while ($prev > 0) {
//dump($sitemap[$prev], '$sitemap[$prev]');
			if(empty($sitemap[$prev]['in_menu'])) {
				break;
			}
			$prev--;
//dump($prev, '$prev2');
		}
		if ($prev < 0) {
			$prev = null;
		}
//dump($prev, '$prev3');
	}

	return $prev;
}

//---------------------------------------------------
function get_next($id=false) {
	global $sitemap;
//dump($sitemap, '$sitemap');
//dump($id, 'GET_NEXT id');
	$next = null;
	if($id === false || isset($sitemap[$id]['in_menu'])) {
	} else {
	        $last_id = count($sitemap) - 1;
		$next = $id + 1;
		while ($next <= $last_id) {
//dump($next, '$next');
			if(empty($sitemap[$next]['in_menu'])) {
				break;
			}
			$next++;
		}
		if ($next > $last_id) {
			$next = null;
		}
	}
	return $next;
}

//---------------------------------------------------
function get_level($url='') {
        $split = explode('/', $url);
        if(empty($split[count($split) -1])) {
            array_pop($split); 
        }
        return count($split) - 1;
}

//-----------------------------------------------------------------
// Функция рендеринга (теперь принимает массив детей)
function renderTreeNodes(array $nodes) {
    // Сортируем элементы текущего уровня по полю order
    uasort($nodes, function($a, $b) {
//        return ($a['order'] ?? 0) <=> ($b['order'] ?? 0);
        $x = $a['order'];
        $y = $b['order'];
        if ($x == $y) return 0;
        return ($x < $y) ? -1 : 1;
    });

    $html = "<ul class=\"tree\">\n";
    foreach ($nodes as $node) {
        // Проверяем наличие title, чтобы не выводить пустые узлы-заглушки
//        $title = $node['title'] ?? '...';
        $title = empty($node['title']) ? '...' : $node['title'];
//        $url = $node['url'] ?? '#';
        $url = empty($node['url']) ? '#' : $node['url'];

        $html .= "<li>\n";
        $html .= '<a href="' . htmlspecialchars($url) . '" target="_top">' . htmlspecialchars($title) . "</a>\n";
        
        // Если есть вложенные элементы, рекурсивно выводим их
        if (isset($node['children']) && !empty($node['children'])) {
            $html .= renderTreeNodes($node['children']);
        }
        
        $html .= "</li>\n";
    }
    $html .= "</ul>\n";
    
    return $html;
}

//-----------------------------------------------------------------
function show_tree() {
    global $sitemap;
//dump($sitemap, '$sitemap');

    $tree = [];
    foreach ($sitemap as $item) {
        $path = trim($item['url'], '/');
        
        // Пропускаем сам корень "/"
        if ($path === '') continue;

        $parts = explode('/', $path);
        $current = &$tree;
        
        foreach ($parts as $part) {
            if (!isset($current['children'][$part])) {
                $current['children'][$part] = [];
            }
            $current = &$current['children'][$part];
        }
        
        $current['url'] = $item['url'];
        $current['title'] = $item['title'];
        $current['order'] = (int)$item['order'];
    }

    // Вывод: передаем только "детей" верхнего уровня
    if (!empty($tree['children'])) {
        echo renderTreeNodes($tree['children']);
    }

}

//----------------------------------------------------
//Check the last-modified-date of the data file
function check_modified($file='') {
  if($file) {
    $last_modified = filemtime($file);

    $if_modified_since = intval(@$_SERVER['HTTP_IF_MODIFIED_SINCE']);
    if ($if_modified_since >= $last_modified) {
        header('HTTP/1.1 304 Not Modified');
        exit;
    }
    header('Last-Modified: '. $last_modified);
  }
}

//-------------------------------------------------------------------------
function div_callback($matches) {
//dump($matches, '$matches');
        $line = @$matches[3];
//dump($line, '$line');
        if($line) {
            $line = preg_replace("/#([^\s]+)/", "id=\"\\1\"", $line);
            $line = preg_replace("/\.([^\s]+)/", "class=\"\\1\"", $line);
//dump($line, '$line1');
            $line = '<div ' . $line . '>';
//dump($line, '$line1a');
        } else {
            $line = "</div>\n\n";
        }
//dump($line, '$line2');

        return $line;

}

//-------------------------------------------------------------------------
function parse_div($content='') {
//dump($content, '$content');
	$pattern = "/^(<p>)*:::\s*({([^}]+)})*\s*(<\/p>)*$/m";

	$content = preg_replace_callback($pattern, "div_callback", $content);

	return $content;
}

//-------------------------------------------------------------------------
/**
 * Check for running in Windows
 * @return int
 * @author Valery Votintsev
 */
function is_win() {
    return isset($_SERVER['WINDIR']) ? 1 : 0;
}

//------------------------------------------------------------------
function backtrace()
{
    $raw = debug_backtrace();

    echo "<div>\n<b>BackTrace:</b>\n";
    echo '<table border="1" cellPadding="4">', "\n";
    echo '<tr>', "\n";
    echo '<th>File</th>', "\n";
    echo '<th>Line</th>', "\n";
    echo '<th>Function</th>', "\n";
    echo '<th>Args</th>', "\n";
    echo '</tr>', "\n";

    foreach ($raw as $i => $entry) {
//unset($entry['object']);
        $args = '';
        $entry['file'] = str_replace('\\', '/', @$entry['file']);
        $entry['file'] = str_replace(DIR, '', $entry['file']);
//dump($entry, '$entry');

        //if ($entry['function'] != 'backtrace') {
            echo '<tr>', "\n";
            echo '<td>', $entry['file'], '</td>', "\n";
            echo '<td>', @$entry['line'], '</td>', "\n";
            echo '<td>', $entry['function'], '</td>', "\n";

            foreach ($entry['args'] as $a) {
                if (!empty($args)) {
                    $args .= ', ';
                }
                switch (gettype($a)) {
                    case 'integer':
                    case 'double':
                        $args .= $a;
                        break;
                    case 'string':
                        $a = htmlspecialchars(substr($a, 0, 64)) . ((strlen($a) > 64) ? '...' : '');
                        $args .= "\"$a\"";
                        break;
                    case 'array':
                        $args .= 'Array(' . count($a) . ')';
                        break;
                    case 'object':
                        $args .= 'Object(' . get_class($a) . ')';
                        break;
                    case 'resource':
//            $args .= 'Resource('.strstr($a, '#').')';
                        $args .= $a;
                        break;
                    case 'boolean':
                        $args .= $a ? 'True' : 'False';
                        break;
                    case 'NULL':
                        $args .= 'Null';
                        break;
                    default:
                        $args .= 'Unknown';
                }
            }
            if (!$args) {
                $args = '&nbsp;';
            }
            echo '<td>', $args, '</td>', "\n";
            echo '</tr>', "\n";
        //}
    }

    echo '</table>', "\n";
    echo '</div>', "\n";
}

//------------------------------------------------------------------
function file_url($file='')
{
    $url = $file;

    $url = substr($url, strlen(CONTENT));
//dump($url, '$url0');

    $url = preg_replace("/\.(".EXT.'|'.EXT2.")$/", '', $url);
//dump($url, '$url1');

    if(basename($url) == INDEX) {
        $url = preg_replace('#\/'.INDEX.'$#', '', $url);
//dump($url, '$url2');
    }


//    $url = CONSOLE_URL . rtrim($url, '/') . '/';
    $url = rtrim($url, '/') . '/';
//dump($url, '$url3');
//echo "$i: $url";
//echo "$i: $file";
    return $url;
}
