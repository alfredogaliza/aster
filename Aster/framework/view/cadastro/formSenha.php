<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>	
	<?php View::includeView("html/head"); ?>
	<script>
	$(document).ready(function(){
		$("form").submit(function(event){
			var senha1 = $("#senha1").val();
			var senha2 = $("#senha2").val();
	
			if (senha1 != senha2){
				alert("As senhas não coincidem!");
				return false;
			} else {
				return true;
			}
		});
	});
</script>
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
				<form novalidate action="<?= Controller::route("cadastro", "novaSenha")?>" method="POST">
					<input type="hidden" name="id" value="<?= $this->voluntario->get('id')?>" />
					<input type="hidden" name="old_senha" value="<?= $this->voluntario->get('senha')?>" />
					<div class="row form-group">
						<div class="col-md-12">
							<h2>Cadastro de nova senha</h2>
							<div class="row form-group">
								<div class="col-md-12">
									<label>Nova senha</label>
									<input id="senha1" autocomplete="off" value="" name="senha1" class="form-control" required type="password"  />
								</div>
							</div>
							<div class="row form-group">
								<div class="col-md-12">
								<label>Digite novamente</label>
									<input id="senha2" autocomplete="off" value="" name="senha2" class="form-control" required type="password" />
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
