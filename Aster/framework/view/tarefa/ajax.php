<?php foreach ($this->tarefas as $tarefa): ?>
	<li class="list-group-item">
		<p class="list-group-item-heading ">
			<strong><?= $tarefa->getEvento('nome') ?></strong>
			<a data-toggle="tooltip" title="Participar" class="pull-right async-confirm" href="<?= Controller::route('tarefa', 'atribuir', $tarefa->get('id'))?>">
				<i class="fa fa-thumbs-up"></i>
			</a>
		</p>
		<small class="list-group-item-text">
			 <?= $tarefa->getDate('data_agendada')? $tarefa->getDate('data_agendada').' - ' : ''?>
			 <?= $tarefa->get('nome')?>
		</small>		
		<p class="list-group-item-text"><?= $tarefa->get('descricao')?></p>
		<p></p>
		<p class="text-muted text-right small">
			Disponível até <?= $tarefa->getDate('data_fechamento')?><?= $tarefa->getDate('data_fim')?>
		</p>
	</li>
<?php endforeach;?>