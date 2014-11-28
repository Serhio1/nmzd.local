<?php

function autoloader($classname)
{	
	$dirs = array(
		'app/',
		'app/core/',
		'src/',
		'src/controllers/',
		'src/services/',
		'src/models/',
	);
	
	foreach ($dirs as $num => $dir) {
		$filename = __DIR__.'/'.$dir.$classname.'.php';
		if(file_exists($filename)) {
			include_once($filename);
		} else {
			if($num == count($dirs)) {
				print 'file not exist: '.$filename.'<br>';
			}
		}
	}
}
spl_autoload_register('autoloader');
