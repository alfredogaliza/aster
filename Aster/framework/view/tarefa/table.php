<ul class="nav nav-tabs">
<li class="<?= !Globals::get('status', 0)?'active':''?>"><a href="#" data-status="0" class="change-status">Todos</a></li>
<li class="<?= (Globals::get('status')==Tarefa::STATUS_ABERTA)?'active':''?>"><a href="#" data-status="1" class="change-status"><span class="tab-legend bg-warning"></span> Aberta</a></li>
<li class="<?= (Globals::get('status')==Tarefa::STATUS_ANDAMENTO)?'active':''?>"><a href="#" data-status="2" class="change-status"><span class="tab-legend bg-info"></span> Em Andamento</a></li>
<li class="<?= (Globals::get('status')==Tarefa::STATUS_CONCLUIDA)?'active':''?>"><a href="#" data-status="3" class="change-status"><span class="tab-legend bg-success"></span> Concluída</a></li>
</ul>
<div class="table-responsive">
	<table class="table table-condensed ">
		<thead>
			<tr>
				<th>Nome</th>
				<th>Fechamento</th>
				<th>Data</th>
				<th>Informações</th>
				<th class='text-center'>Ações</th>
			</tr>
		</thead>
		<tbody>									
		<?php if ($this->tarefas): foreach ($this->tarefas as $tarefa): ?>
			<tr class="<?= $tarefa->getStatusClass() ?>">
				<td><?= $tarefa->get('nome')?><br>
				<small>Evento: <?= $tarefa->getEvento('nome')?></small>
				</td>
				<td>
					<?= $tarefa->getDate('data_fechamento')?>
				</td>
				<td>
					<?= $tarefa->getDate('data_agendada')?>
				</td>
				<td>
					<?= $atrs = count($tarefa->getAtribuicoes())?>
					<?= $tarefa->get('max_atribuicoes')? "/ ".$tarefa->get('max_atribuicoes') : '' ?>
					Atribuições<br>
					<?= $tarefa->getConcluidas() ?> Concluídas
				</td>
				<td class='text-center'>
					<a data-toggle="tool-tip" title="Editar" class="btn btn-default edit"
						href="<?= Controller::route("tarefa", "modal", $tarefa->get('id')) ?>">
						<i class="fa fa-pencil"></i>
					</a>
					<?php if (!count($tarefa->getAtribuicoes())): ?>
					<a data-toggle="tool-tip" title="Excluir" class="btn btn-danger async-confirm" href="<?= Controller::route("tarefa", "delete", $tarefa->get('id')) ?>">
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
