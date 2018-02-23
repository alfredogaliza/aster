<?php foreach ($this->atribuicoes as $atribuicao): ?>
	<li class="list-group-item">
		<p class="list-group-item-heading ">
			<?= $atribuicao->getTarefa('nome') ?>
			<a class="pull-right" href="<?= Controller::route('atribuicao', 'delete', $atribuicao->get('id'))?>">
				<i class="fa fa-thumbs-down"></i>
			</a>
		</p>
		<p class="list-group-item-text"><?= $atribuicao->getTarefa('descricao')?></p>
		<p></p>
		<p class="text-muted text-right small"><?= $atribuicao->getTarefa('data_inicio','',true)?> a <?= $atribuicao->getTarefa('data_fim','',true)?></p>
	</li>
<?php endforeach;?>