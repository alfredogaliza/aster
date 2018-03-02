<ul class="nav nav-tabs">
<li class="<?= !Globals::get('status', 0)?'active':''?>"><a href="#" data-status="0" class="change-status">Todos</a></li>
<li class="<?= (Globals::get('status')==Evento::STATUS_ABERTO)?'active':''?>"><a href="#" data-status="1" class="change-status"><span class="tab-legend bg-warning"></span> Aberto</a></li>
<li class="<?= (Globals::get('status')==Evento::STATUS_ANDAMENTO)?'active':''?>"><a href="#" data-status="2" class="change-status"><span class="tab-legend bg-info"></span> Em Andamento</a></li>
<li class="<?= (Globals::get('status')==Evento::STATUS_ENCERRADO)?'active':''?>"><a href="#" data-status="3" class="change-status"><span class="tab-legend bg-success"></span> Encerrado</a></li>
</ul>
<div class="table-responsive">
	<table class="table table-condensed ">
		<thead>
			<tr>
				<th>Nome</th>
				<th>Início/Término</th>
				<th>Informações</th>
				<th class='text-center'>Ações</th>
			</tr>
		</thead>
		<tbody>									
		<?php if ($this->eventos): foreach ($this->eventos as $evento): ?>
			<tr class="<?= $evento->getStatusClass() ?>">
				<td><?= $evento->get('nome')?><br>
				<small>Ação: <?= $evento->getAcao('nome')?></small>
				</td>
				<td>
					<?= $evento->getDate('data_inicio')?> a<br>
					<?= $evento->getDate('data_fim')?>
				</td>
				<td>
					<?= count($evento->getTarefas())?> Tarefa(s)<br>
					<?= count($evento->getAssistencias())?> Assistência(s)
				</td>
				<td class='text-center'>				
					<a data-toggle="tooltip" title="Editar" class="btn btn-default edit"
						href="<?= Controller::route("evento", "modal", $evento->get('id')) ?>">
						<i class="fa fa-pencil"></i>
					</a>
					<?php if (!count($evento->getTarefas()) && !count($evento->getAssistencias())): ?>
					<a data-toggle="tooltip" title="Excluir" class="btn btn-danger async-confirm" href="<?= Controller::route("evento", "delete", $evento->get('id')) ?>">
						<i class="fa fa-trash"></i>
					</a>
					<?php endif;?>
				</td>
			</tr>		
		<?php endforeach; else :?>
			<tr>
				<td colspan="3">Sem Registros</td>
			</tr>
		<?php endif;?>
		</tbody>
	</table>
</div>
