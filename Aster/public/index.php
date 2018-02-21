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
	try{
		$app = new $Controller($action);
		$app->run();
	} catch (Exception $e){
		echo "<div class='debug'>";
		echo "<b>Erro na execução da página:</b>";
		echo "<pre>",$e->getMessage(),"</pre>";
		echo "<b>Informações de Debug:</b>";
		echo "<pre>",$e->getTraceAsString(),"</pre>";
		echo "<b>Variáveis de Sessão:</b>";
		//echo "<pre>",var_dump($_SESSION),"</pre>";
		echo "<b>Variáveis do POST:</b>";
		echo "<pre>",var_dump($_POST),"</pre>";
		echo "<b>Variáveis do GET:</b>";
		echo "<pre>",var_dump($_GET),"</pre>";
		echo "</div>";				
	}
	
	//Termina a execução
	die;