<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="pt-br">
<head>	
	<?php View::includeBlock ( "head" ); ?>		
<link rel="stylesheet" href="<?= Controller::route("style", "zabuto.css")?>">
<script src="<?= Controller::route('script','dragndrop.js')?>" type="text/javascript" language="javascript"></script>
<script src="<?= Controller::route('script','zabuto.js')?>" type="text/javascript" language="javascript"></script>
<style>
[draggable='true']:hover {
	cursor: move;
}

.droparea {
	width: 100%;
	display: block;
	border: dashed green 3px;
	height: 34px;
	margin: 5px 0px;
}
</style>
<script>
		$(document).ready(function() {
			$("#my-calendar").zabuto_calendar({	
				legend: [
				         {type: "text", label: "Tarefa", badge: "31"},
				         {type: "block", label: "Evento", classname: "bg-info"}				         
				       ],			
				language : 'pt_BR',
				weekstartson: 0,
				ajax : {
					url : '<?= Controller::route('agenda', 'atualizacao') ?>',
					modal: true
				}
			});

			$(".pagination-async").each(function(){

				var $parent = $(this);
				var $container = $($parent.attr('data-container'));
							
				var $prev = $("<li class='disabled'><a href='#' class='prev'><i class='fa fa-backward'></i>&nbsp;</a></li>");
				var $next = $("<li><a href='#' class='next'><i class='fa fa-forward'></i>&nbsp;</a></li>");
				var $navs = [];
				
				var url = $parent.attr('data-url');	

				$(this).empty();
				
				for (i = 1; i <= 5 ; i++){
					var $li = $("<li><a href='#' class='page'>"+i+"</a></li>");
					$navs.push($li);
				}
				var $current = $navs[0];
				
				$prev.click(function(){
					if ($prev.hasClass('disabled')) return false;
					if (parseInt($('a', $current).text()) <= 10){
						$prev.addClass('disabled');
					}					
					$navs.forEach(function($nav){
						var $a = $('a', $nav);
						$a.text(parseInt($a.text())-5);
					});
					
					$current.click();			
				});

				$next.click(function(){
					if ($next.hasClass('disabled')) return false;					
					$navs.forEach(function($nav){
						var $a = $('a',$nav);
						$a.text(parseInt($a.text())+5);
					});
					$prev.removeClass('disabled');
					$current.click();
				});

				$navs.forEach(function($nav){
					$nav.click(function(){
						if ($nav.hasClass('disabled')) return false;
						var page = parseInt($('a', $nav).text());
						$container.load(url, {"page": page}, function(response){
							if (response == ''){
								$container.text('Sem registros.');
								$next.addClass('disabled');
							} else {
								$next.removeClass('disabled');
							}
							$navs.forEach(function($_nav){$_nav.removeClass('active')});
							$nav.addClass('active');
							$current = $nav;
						});
					});
				});

				$parent
					.append($prev)
					.append($navs)
					.append($next);
				
				$current.click();
								
			});
		});
	</script>
</head>
<body>
	<div class="container">
		<?php View::includeBlock('menu-top')?>		
		<div class="row form-group">
			<div class="col-md-4 droppable">
				<div class="panel panel-default">
					<div class="panel-heading">
						<a data-toggle="collapse" href="#noticias"> Notícias <span class="pull-right"><i class="fa fa-newspaper-o"></i></span>
						</a>
					</div>
					<div class="panel-collapse collapse in" id="noticias">
						<ul class="list-group" id="div-noticias"></ul>
						<div class="panel-footer text-right">
							<ul class="pagination pagination-async" data-url="<?= Controller::route('noticia', 'atualizacao')?>" data-container="#div-noticias" style="margin: 0"></ul>
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
							<ul class="pagination pagination-async" data-url="<?= Controller::route('tarefa', 'atualizacaoAtribuida')?>" data-container="#div-tarefas-atribuidas" style="margin: 0"></ul>
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
							<ul class="pagination pagination-async" data-url="<?= Controller::route('tarefa', 'atualizacaoAberta')?>" data-container="#div-tarefas-abertas" style="margin: 0"></ul>
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
							<ul class="pagination pagination-async" data-url="<?= Controller::route('mensagem', 'atualizacao')?>" data-container="#div-mensagens" style="margin: 0"></ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php View::includeBlock('menu-bottom')?>
	</div>
</body>
</html>