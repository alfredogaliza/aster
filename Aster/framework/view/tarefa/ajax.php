<?php foreach ($this->tarefas as $tarefa): ?>
	<li class="list-group-item">
		<p class="list-group-item-heading ">
			<?= $tarefa->getEvento('nome') ?>
			<a class="pull-right" href="<?= Controller::route('tarefa', 'atribuir', $tarefa->get('id'))?>">
				<i class="fa fa-thumbs-up"></i>
			</a>
		</p>
		<small class="list-group-item-text"><?= $tarefa->get('nome')?></small>		
		<p class="list-group-item-text"><?= $tarefa->get('descricao')?></p>
		<p></p>
		<p class="text-muted text-right small"><?= $tarefa->getDate('data_inicio')?> a <?= $tarefa->getDate('data_fim')?></p>
	</li>
<?php endforeach;?>