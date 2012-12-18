<?php
define("ROOT_PATH", dirname(__FILE__).'/');	// Root dir 

try{
	require_once('./inc/autoload.php');

	// initialithe DataBase object
	$db = new MySQL(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	$request = new Request($_REQUEST,$default);

	$fc = new FrontController($db);//$tf, $pathTo, $default);
	$fc->dispatch($request);

}
catch (LibException $e) {
	echo $e->getMessage();
	exit;
}
?>
