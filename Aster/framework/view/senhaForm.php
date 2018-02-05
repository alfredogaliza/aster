<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>	
	<?php View::includeBlock("head"); ?>
	<script>
	$(document).ready(function(){
		$("form").submit(function(){
			var senha1 = $("[name='senha1']").val();
			var senha2 = $("[name='senha2']").val();
	
			if (senha1 != senha2){
				alert("As senhas não coincidem!");
				return false;
			} else {
				return true;
			}
		});
	});
</script>
	<style>
.container {
	margin-top: 10px;
	padding-top: 10px;
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
				<form action="<?= Controller::route("voluntario", "novasenha")?>" method="POST">
					<div class="row form-group">
						<div class="col-md-12">
							<h2>Cadastro de nova senha</h2>
							<div class="row form-group">
								<div class="col-md-12">
									<input id="senha1" autocomplete="off" value="" name="senha2" class="form-control" required type="password" placeholder="Digite sua nova senha" />
								</div>
							</div>
							<div class="row form-group">
								<div class="col-md-12">
									<input id="senha2" autocomplete="off" value="" name="senha1" class="form-control" required type="password" placeholder="Digite novamente" />
								</div>
							</div>
							<div class="row form-group">
								<div class="col-md-12">
									<button type="submit" class="btn btn-primary form-control">
										<i class="fa fa-sign-in"></i> Enviar
									</button>
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
