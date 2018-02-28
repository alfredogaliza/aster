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
		<?php View::includeView("menu/top"); ?>
		<div class="row form-group">
			<div class="col-md-offset-4 col-md-4">
				<form action="<?= Controller::route("voluntario", "novaSenha")?>" method="POST">
					<input type="hidden" name="id" value="<?= $this->voluntario->get('id')?>" />					
					<div class="row form-group">
						<div class="col-md-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									<a href="#senha-collapse" data-toggle="collapse">Cadastro de Nova Senha <span class="pull-right"><i class="fa fa-key"></i></span></a>
								</div>
								<div class="panel-collapse collapse in" id="senha-collapse">
									<div class="panel-body">							
								<div class="row form-group">
									<div class="col-md-12">
										<label>Senha Atual</label>
										<input id="senha" autocomplete="off" value="" name="old_senha" class="form-control" required type="password"  />
									</div>
								</div>
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
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
</html>
