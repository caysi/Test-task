<?php
require_once(ROOT_PATH.'inc/configs/config.php');
require_once(ROOT_PATH.'inc/configs/siteSettings.php');
require_once(ROOT_PATH.'inc/lib/LibException.php');

$paths = array(
		'inc/lib',
		'application/controllers',
		'application/models',
		'application/views',
);

// Set deafut include paths
foreach($paths as $path){
	set_include_path(get_include_path().PATH_SEPARATOR.ROOT_PATH.$path);
}

function __autoload($className){
	$classPath = $className.'.php';
	require_once($classPath);
}
