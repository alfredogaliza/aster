<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>	
	<?php View::includeView("html/head"); ?>
	<script src="<?= Controller::route('script','snippets/pagination.js')?>" type="text/javascript" language="javascript"></script>
	<script src="<?= Controller::route('script','vendor/tinymce/tinymce.min.js')?>" type="text/javascript" language="javascript"></script>

</head>
<body>
	<div class="container">
		<?php View::includeView('menu/top')?>
		<form novalidate id="form-busca" action="<?= Controller::route('acao', 'table') ?>" method="GET">
			<input type="hidden" name="status" value="<?= Globals::get('status', 0) ?>" id="status"/>
			
			<div class="row">
				<div class="col-md-3">
					<div class="row form-group">
						<div class="col-md-12">
							<?php View::includeView('acao/filter')?>							
							<div class="row form-group">
								<div class="col-md-12">
									<button type="button" class="btn btn-success form-control edit" data-href="<?= Controller::route('acao', 'modal') ?>">
										<i class="fa fa-plus"></i> Adicionar Ação
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-9">
					<div class="panel panel-default">
						<div class="panel-heading">
							<a href="#" data-toggle="collapse" data-target="#resultados">Resultados de Ações <span class="pull-right"><i class="fa fa-users"></i></span></a>
						</div>
						<div class="panel-collapse collapse in" id="resultados">
							<div class="panel-body">								
								<div id="div-acoes"></div>
							</div>
							<div class="panel-footer text-right">
								<ul id="pagination" class="pagination pagination-ajax" data-form="#form-busca" data-target="#div-acoes" style="margin: 0"></ul>
							</div>
						</div>							
					</div>
				</div>
			</div>
		</form>
		<div id="modal-container"></div>
	</div>
</body>
</html>
