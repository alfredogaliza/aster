<?php

	//Configura o INCLUDE_PATH do PHP
	set_include_path(
		ini_get("include_path").
		PATH_SEPARATOR.
		__DIR__.
		"/../framework"
	);
	
	spl_autoload_register(function ($class_name) {
		$base = __DIR__.'/../framework';
		
		$control_name = "$base/control/$class_name.php";
		$model_name   = "$base/model/$class_name.php";
		$lib_name     = "$base/lib/$class_name.php";		
		
		     if (file_exists($control_name)) include_once $control_name;
		else if (file_exists($model_name))   include_once $model_name;
		else if (file_exists($lib_name))     include_once $lib_name;
		
	});
	
	setlocale(LC_CTYPE, 'pt_BR.UTF8');
	setlocale(LC_TIME, 'pt_BR', 'Portuguese_Brazil');

	//Resgata os parâmetros da execução
	$controller = isset($_GET['controller'])? $_GET['controller'] : "default";
	$action = isset($_GET['action'])? $_GET['action'] : "default";	
	
	//Determina o nome do Controlador e da Ação a ser executada
	$Controller = ucfirst($controller)."Controller";
	
	//Instancia o Controlador e executa a aplicação
	$app = new $Controller($action);
	$app->run();
	
	//Termina a execução
	die;