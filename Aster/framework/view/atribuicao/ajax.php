<?php foreach ($this->atribuicoes as $atribuicao): ?>
	<li class="list-group-item">
		<p class="list-group-item-heading ">
			<strong><?= $atribuicao->getTarefa('nome') ?></strong>
			<a data-toggle="tooltip" title="Desistir" class="pull-right async-confirm" href="<?= Controller::route('tarefa', 'desistir', $atribuicao->get('id'))?>">
				<i class="fa fa-thumbs-down"></i>
			</a>
		</p>
		<p class="list-group-item-text"><?= $atribuicao->getTarefa('descricao')?></p>
		<p></p>
		<p class="text-muted text-right small">
			<?php if($atribuicao->getTarefa('data_agendada')): ?>
			Agendada para <?= $atribuicao->getTarefa('data_agendada', '', true) ?>
			<?php endif;?>
		</p>
	</li>
<?php endforeach;?>