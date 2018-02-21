<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="pt-br">
<head>	
	<?php View::includeView('html/head'); ?>		
	<link rel="stylesheet" href="<?= Controller::route("style", "zabuto.css")?>">
	<script src="<?= Controller::route('script','snippets/zabuto.js')?>" type="text/javascript" language="javascript"></script>
	<script src="<?= Controller::route('script','snippets/pagination.js')?>" type="text/javascript" language="javascript"></script>
	<script src="<?= Controller::route('script','snippets/dragndrop.js')?>" type="text/javascript" language="javascript"></script>
</head>
<body>
	<div class="container">
		<?php View::includeView('menu/top')?>		
		<div class="row form-group">
			<div class="col-md-4 droppable">
				<?php View::includeView('menu/admin')?>
				<div class="panel panel-default">
					<div class="panel-heading">
						<a data-toggle="collapse" href="#noticias"> Notícias <span class="pull-right"><i class="fa fa-newspaper-o"></i></span>
						</a>
					</div>
					<div class="panel-collapse collapse in" id="noticias">
						<ul class="list-group" id="div-noticias"></ul>
						<div class="panel-footer text-right">
							<ul class="pagination pagination-ajax" data-url="<?= Controller::route('noticia', 'ajax')?>" data-target="#div-noticias" style="margin: 0"></ul>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4 droppable">
				<div class="panel panel-default">
					<div class="panel-heading">
						<a data-toggle="collapse" href="#agenda"> Agenda <span class="pull-right"><i class="fa fa-calendar"></i></span>
						</a>
					</div>
					<div class="panel-collapse collapse in row" id="agenda">
						<div class="col-md-12" id="my-calendar"></div>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">
						<a data-toggle="collapse" href="#ultimas-tarefas"> Tarefas Atribuídas <span class="pull-right"><i class="fa fa-clock-o"></i></span>
						</a>
					</div>
					<div class="panel-collapse collapse in" id="ultimas-tarefas">
						<div class="panel-body" id="div-tarefas-atribuidas"></div>
						<div class="panel-footer text-center">
							<ul class="pagination pagination-ajax" data-url="<?= Controller::route('tarefa', 'ajaxAtribuida')?>" data-target="#div-tarefas-atribuidas" style="margin: 0"></ul>
						</div>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">
						<a data-toggle="collapse" href="#tarefas-abertas"> Tarefas Abertas <span class="pull-right"><i class="fa fa-list-ol"></i></span>
						</a>
					</div>
					<div class="panel-collapse collapse in" id="tarefas-abertas">
						<div class="panel-body" id="div-tarefas-abertas"></div>
						<div class="panel-footer text-center">
							<ul class="pagination pagination-ajax" data-url="<?= Controller::route('tarefa', 'ajaxAberta')?>" data-target="#div-tarefas-abertas" style="margin: 0"></ul>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4 droppable">
				<div class="panel panel-default">
					<div class="panel-heading">
						<a data-toggle="collapse" href="#pontuacao"> Pontuação <span class="pull-right"><i class="fa fa-trophy"></i></span>
						</a>
					</div>
					<div class="panel-collapse collapse in" id="pontuacao">
						<div class="panel-body"></div>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">
						<a data-toggle="collapse" href="#mensagens"> Mensagens <span class="pull-right"><i class="fa fa-comments"></i></span>
						</a>
					</div>
					<div class="panel-collapse collapse in" id="mensagens">
						<div class="panel-body" id="div-mensagens"></div>
						<div class="panel-footer text-center">
							<ul class="pagination pagination-ajax" data-url="<?= Controller::route('mensagem', 'ajax')?>" data-target="#div-mensagens" style="margin: 0"></ul>
						</div>
					</div>
				</div>				
			</div>
		</div>		
	</div>
</body>
</html>