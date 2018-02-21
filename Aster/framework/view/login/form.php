<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>	
	<?php View::includeView("html/head"); ?>
	<style>
.container {
	margin-top: 10px;
	padding-top: 10px;
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
		<div class="row form-group">
			<div class="col-md-offset-4 col-md-4">
				<div class="row form-group">
					<div class="col-md-12 text-center">
						<img src="<?php Config::baseURL()?>/image/logo.jpg" />
					</div>
				</div>				
				<?php if ($this->msg == "fail"):?>
				<div class="row form-group">
					<div class="col-md-12">
						<strong class="fail">Login ou senha inválida!</strong>
					</div>
				</div>
				<?php elseif ($this->msg == "denied"):?>
				<div class="row form-group">
					<div class="col-md-12">
						<strong class="fail">Sessão encerrada!</strong>
					</div>
				</div>
				<?php elseif ($this->msg == "senha"):?>
				<div class="row form-group">
					<div class="col-md-12">
						<strong class="fail">Senha alterada com sucesso!<br>Faça um novo login com sua nova senha.</strong>
					</div>
				</div>
				<?php endif;?>
				<form action="<?= Controller::route("login", "logon")?>" method="POST">
					<div class="row form-group">
						<div class="col-md-12">
							<div class="row form-group">
								<div class="col-md-12">
									<input name="email" class="form-control" required type="text" placeholder="Email" />
								</div>
							</div>
							<div class="row form-group">
								<div class="col-md-12">
									<input id="senha" name="senha" class="form-control" required type="password" placeholder="Senha" />
								</div>
							</div>
							<div class="row form-group">
								<div class="col-md-12">
									<button type="submit" class="btn btn-primary form-control">
										<i class="fa fa-sign-in"></i> Entrar
									</button>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<a class="edit" href="<?= Controller::route("cadastro", "modalEmail")?>"><i class="fa fa-forward"></i> Esqueci minha senha.</a>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<a href="<?= Controller::route("cadastro", "form")?>"><i class="fa fa-forward"></i> Junte-se a nós! Cadastre-se aqui.</a>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<a href="http://www.institutoaster.org.br"><i class="fa fa-forward"></i> Ir para o site institutoaster.org.br.</a>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div id="modal-container"></div>
	</div>

</body>
</html>
