<?php
	require_once '../tiny-router.php';

	$rt = new TinyRouter();

	$rt->response('GET','/','_index.php');
	$rt->response('GET','/about/','about.php');
	$rt->response('GET|POST','/test/(.+?)/','test.php?q=\\1');
?>