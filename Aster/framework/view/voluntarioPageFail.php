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
	font-size: large;
	
}
</style>
</head>
<body>
	<div class="container">
		<h2>Ocorreu um erro no seu cadastro!</h2>
		<div class="fail">
			<?php if ($this->msg == 'duplicidade'): ?>
			O CPF ou email informado já se encontra em nosso sistema!
			<?php elseif ($this->msg == 'erro'): ?>
			Ocorreu um erro em nossos registros. Por favor, tente mais tarde!
			<?php elseif ($this->msg == 'recuperacao'): ?>
			Usuário/Senha não encontrado!
			<?php elseif ($this->msg == 'email'): ?>
			Email não encontrado!
			<?php endif; ?>
		</div>
		<br>
		Para recuperar sua senha, clique
		<a href="<?= Controller::route('voluntario', 'recuperacao') ?>" class="edit">aqui!</a>
		<br>
		<br>
		<br>
		<a href="<?= Controller::route("login")?>" class="btn btn-info"><i class="fa fa-backward"></i> Voltar</a>
	</div>
	<div id="modal-container"></div>
</body>
</html>
