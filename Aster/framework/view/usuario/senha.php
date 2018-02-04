<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="pt-br">
	<head>
		<?php View::includeBlock("head"); ?>
		<script>
			$(document).ready(function(){
				$("#eye1").mousedown(function(){
					$(this).removeClass('btn-success').
							addClass('btn-danger');
					$('#senha').attr('type', 'text');
				})
				.mouseup(function(){
					$(this).removeClass('btn-danger').addClass('btn-success');
					$('#senha').attr('type', 'password');
				});
				$("#eye2").mousedown(function(){
					$(this).removeClass('btn-success').
							addClass('btn-danger');
					$('#novasenha').attr('type', 'text');
				})
				.mouseup(function(){
					$(this).removeClass('btn-danger').addClass('btn-success');
					$('#novasenha').attr('type', 'password');
				});
			});
		</script>	
	</head>
	<body>
		<div class="container">			
			<?php View::includeBlock("menu-top") ?>
			<div class="row">
				<div class="col-md-12">
					<ol class="breadcrumb">					
						<li><a href="http://siga.bombeiros.pa.gov.br"><span class="glyphicon glyphicon-home"></span></a></li>
						<li><a href="<?php echo Controller::route("home", "default");?>">GEPEV</a></li>
						<li class="active">Alterar Senha</li>
					</ol>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<div class="row">
						<div class="col-md-12">
							<?php View::includeBlock("menu-left") ?>
						</div>
					</div>
				</div>
				<div class="col-md-9">
					<div class="row">
						<div class="col-md-12">						
							<form class="form col-md-6 col-md-offset-3" method="POST" action="<?php echo Controller::route("usuario", "novasenha")?>">
								<div class="panel panel-success">
									<div class="panel-heading">
										<span class="glyphicon glyphicon-lock"></span>
										Alteração de Senha
									</div>
									<div class="panel-body">				
										<div class="row form-group">
											<label class="col-md-4">Senha Antiga:</label>
											<div class="col-md-6">
												<input type="password" name="senha" id="senha" class="form-control" required>
											</div>
											<div class="col-md-2">
												<button type="button" class="btn btn-warning form-control" id="eye1"><span class="glyphicon glyphicon-eye-open"></span></button>
											</div>
										</div>
										<div class="row form-group">
											<label class="col-md-4">Nova Senha:</label>
											<div class="col-md-6">
												<input type="password" name="novasenha" class="form-control" id="novasenha" required>
											</div>
											<div class="col-md-2">
												<button type="button" class="btn btn-warning form-control" id="eye2"><span class="glyphicon glyphicon-eye-open"></span></button>
											</div>
										</div>
										<div class="row form-group">
											<div class="col-md-12">
												<button type="submit" class="btn btn-primary form-control" >
													<span class="glyphicon glyphicon-check"></span> Enviar
												</button>
											</div>
										</div>
									</div>
								</div>
							</form>
							<?php if ($this->msg == 'success'):?>
							<div class="col-md-12">
								<div class="alert alert-info fade in">
									Operação realizada com sucesso!
									<a href="#" class="close" data-dismiss="alert">&times;</a>
								</div>
							</div>
							<?php else : if ($this->msg == 'fail'): ?>
							<div class="col-md-12">
								<div class="alert alert-danger fade in">
									Falha na operação!
									<a href="#" class="close" data-dismiss="alert">&times;</a>
								</div>
							</div>
							<?php endif; endif; ?>
						</div>
					</div>
				</div>	
			</div>				
		</div>
	</body>	
</html>