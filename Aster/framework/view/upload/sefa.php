<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="pt-br">
	<head>
		<?php View::includeBlock("head"); ?>		
	</head>
	<body>
		<div class="container">
			<?php View::includeBlock("menu-top") ?>
			<div class="row">
				<div class="col-md-12">
					<ol class="breadcrumb">					
						<li><a href="http://siga.bombeiros.pa.gov.br"><span class="glyphicon glyphicon-home"></span></a></li>
						<li><a href="<?php echo Controller::route("home", "default");?>">SISGAT</a></li>
						<li class="active">Upload de Arquivo</li>
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
							<div class="panel panel-success">
								<div class="panel-heading">
									<span class="glyphicon glyphicon-upload"></span>
									Upload de Arquivo da SEFA
								</div>
								<div class="panel-body">
									<form class="row form-group" method="post" enctype="multipart/form-data" action="<?php echo Controller::route("upload", "sefa")?>" >
										<input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
										<div class="col-md-10">
											<input name="arquivo" type="file" />
										</div>
										<div class="col-md-2">		
											<button type="submit" class="btn btn-success form-control" type="submit">
												<span class="glyphicon glyphicon-upload"></span> Enviar
											</button>
										</div>					
									</form>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<?php if ($this->msg == 'success'):?>
						<div class="col-md-12">
							<div class="alert alert-info fade in">
								Operação realizada com sucesso!
								<?= $this->count ?> Registros atualizados!
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
	</body>	
</html>