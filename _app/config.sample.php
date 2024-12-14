<?php

// META Title Suffix added to the end of a title
define('HOME_TITLE', 'Yo.CMS');
define('TITLE_SUFFIX', 'Yo.CMS');
define('COPYRIGHT', 'Yo.CMS');
define('COPYRIGHT_URL', '//yo.cms');

// Site Slogan
define('SLOGAN', '<b>Yo</b>.CMS
      <div>
        Simple and fast flat file CMS
      </div>
');

// Default META Keywords for Home page
define('KEYWORDS', 'Yo.CMS, CMS, PHP');

// Content page extension
define ( 'EXT', 'md');
define ( 'EXT2', 'php');

// Starting page name w/o extension
define ( 'INDEX', 'index'); //For index.md, index.php, index.txt, etc.
//define ( 'INDEX', 'README'); //For readme.md, readme.txt, README.md etc.

// For example "not-found", if you want to use not-found.md
define ( 'NOTFOUND', 'not-found');

// Your content directory with md files
//define ( 'CONTENT', DIR . '/content');
define ( 'CONTENT', DIR);

// Root directory for console app
define ( 'CONSOLE_URL', '/docs');

// Template folder
define ( 'TPL', APP_DIR . '/tpl');

// Theme name
define ( 'THEME', 'default');

// Image directory URL (w/o trailing slash)
define ( 'IMG', URL .'/app/img');

// CSS folder
define ( 'CSS', URL . '/app/css');

// Apache MIME types file
//define ( 'MIME_TYPES', 'D:/software/xampp/apache/conf/mime.types');
define ( 'MIME_TYPES', '/usr/local/etc/apache/conf/mime.types');

$GLOBALS['menu'] = array(
	'/'		=> 'Home',
	'/about/'	=> 'About',
	'/authors/'	=> 'Authors',
	'/links/'	=> 'Links',
	'/download/'	=> 'Download',
);
//dump($GLOBALS['menu'], 'menu');

$GLOBALS['menu_bottom'] = array(
	'/copyright/'	         => 'Copyright note',
	'/markdown-cheat-sheet/' => 'About MarkDown',
);
//dump($GLOBALS['menu_bottom'], 'menu_bottom');

$GLOBALS['exclude_url'] = array(
	'/README/',
);

// Administrator login
define ('USERNAME', 'admin');

// Administrator password
define ('PASSWORD', 'admin');
