<?php foreach ($this->tarefas as $tarefa): ?>
	<li class="list-group-item">
		<p class="list-group-item-heading">
			<a data-toggle="tooltip" title="Participar" class="pull-right edit btn btn-sm btn-success" href="<?= Controller::route('tarefa', 'modalParticipar', $tarefa->get('id'))?>">
				<i class="fa fa-thumbs-up"></i>
			</a>				
			<strong>
				<?= $tarefa->getEvento('nome') ?> <br/>
				<small><?= $tarefa->get('nome')?></small>
			</strong>					
		</p>				
		<p class="list-group-item-text">
			<?= $tarefa->get('descricao')?>
		</p>
		<br>
		<?php if ($tarefa->get('efetivacao')):?>
		<p class="list-group-item-text text-danger small">
			Esta é uma tarefa de efetivação. Após concluí-la, outras tarefas estarão disponíveis.
		</p>
		<br>
		<?php endif?>
		<p class="list-group-item-text text-muted text-right small">
			<?= $tarefa->getDate('data_agendada')? 'Agendado para '.$tarefa->getDate('data_agendada').'<br>' : ''?>
			Disponível até <?= $tarefa->getDate('data_fechamento')?>
		</p>
	</li>
<?php endforeach;?>