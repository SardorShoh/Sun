<?php

function loader($class){
		$file = str_replace('\\', '/', $class).'.php';
		if($file == $class.'.php') $path = '';
		else $path = $_SERVER['DOCUMENT_ROOT'].'/'.$file;
		if(file_exists($path)){
			if($path !== '')
			require_once($path);
		}
	}


spl_autoload_register('loader', true, true);