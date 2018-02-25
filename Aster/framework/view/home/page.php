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
				<div class="panel panel-default">
					<div class="panel-heading">
						<a data-toggle="collapse" href="#noticias"> Notícias <span class="pull-right"><i class="fa fa-newspaper-o"></i></span>
						</a>
					</div>
					<div class="panel-collapse collapse in" id="noticias">
						<div class="panel-body">
							<ul class="list-group" id="div-noticias"></ul>
						</div>
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
						<a data-toggle="collapse" href="#ultimas-tarefas"> Atribuições Pendentes <span class="pull-right"><i class="fa fa-clock-o"></i></span>
						</a>
					</div>
					<div class="panel-collapse collapse in" id="ultimas-tarefas">
						<div class="panel-body" id="div-tarefas-atribuidas"></div>
						<div class="panel-footer text-right">
							<ul class="pagination pagination-ajax" data-url="<?= Controller::route('home', 'atribuicoes')?>" data-target="#div-tarefas-atribuidas" style="margin: 0"></ul>
						</div>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">
						<a data-toggle="collapse" href="#tarefas-abertas"> Tarefas Disponíveis <span class="pull-right"><i class="fa fa-list-ol"></i></span>
						</a>
					</div>
					<div class="panel-collapse collapse in" id="tarefas-abertas">
						<div class="panel-body" id="div-tarefas-abertas"></div>
						<div class="panel-footer text-right">
							<ul class="pagination pagination-ajax" data-url="<?= Controller::route('home', 'tarefas')?>" data-target="#div-tarefas-abertas" style="margin: 0"></ul>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4 droppable">
				<div class="panel panel-default">
					<div class="panel-heading">
						<a data-toggle="collapse" href="#estatisticas"> Estatísticas <span class="pull-right"><i class="fa fa-flag"></i></span>
						</a>
					</div>
					<div class="panel-collapse collapse in" id="estatisticas">
						<div class="panel-body">
							<ul class="list-group">							
							<li class="list-group-item"><b>Perfil:</b> <?= Session::getVoluntario()->getPerfil('descricao')?><br>
							<li class="list-group-item"><b>Participação em Eventos:</b> <?= Session::getVoluntario()->getNEventos()?><br>
							<li class="list-group-item"><b>Atribuições Concluídas:</b> <?= Session::getVoluntario()->getNAtribuicoesConcluidas()?><br>
							<li class="list-group-item"><b>Assistências Diretas:</b> <?= Session::getVoluntario()->getNAssistenciasDiretas()?><br>
							</ul>
						</div>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">
						<a data-toggle="collapse" href="#mensagens"> Mensagens <span class="pull-right"><i class="fa fa-comments"></i></span>
						</a>
					</div>
					<div class="panel-collapse collapse in" id="mensagens">
						<div class="panel-body">
							<div id="div-mensagens" class="form-group"></div>
							<a class="form-control btn btn-success edit" href="<?= Controller::route('mensagem', 'modal')?>">
								<i class="fa fa-plus"></i> Nova Mensagem
							</a>
						</div>
						<div class="panel-footer text-right">
							<ul class="pagination pagination-ajax" data-url="<?= Controller::route('mensagem', 'ajax')?>" data-target="#div-mensagens" style="margin: 0"></ul>							
						</div>
					</div>
				</div>				
			</div>
		</div>
		<div id="modal-container"></div>	
	</div>
</body>
</html>