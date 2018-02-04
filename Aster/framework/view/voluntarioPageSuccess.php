<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>	
	<?php View::includeBlock("head"); ?>
	<script>
	$(document).ready(function(){
	$(".cpf").mask("999.999.999-99");
	$(".celular").mask("(99) 99999-9999");
	$(".cep").mask("99.999-999");
	});
</script>
<style>
.container {
	margin-top: 10px;
	padding: 10px 15px;
}

.fail {
	border-left: solid red 4px;
	background-color: lightyellow;
	padding: 4px 20px;
	width: 100%;
	display: block;
}
</style>
</head>
<body>
	<div class="container">
		<h2>Obrigado pela sua participação!</h2>
		Seu cadastro foi recebido com sucesso! Enviamos um email para <?= $this->voluntario->get('email')?>.
		<br>
		Abra o email e clique no link de ativação para efetivar seu cadastro e criar sua nova
		senha!
		<br>
		<br>
		<br>
		<a href="<?= Controller::route("login")?>" class="btn btn-info"><i class="fa fa-backward"></i> Voltar</a>	
	</div>
</body>
</html>
