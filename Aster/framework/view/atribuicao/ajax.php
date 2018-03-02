<?php foreach ($this->atribuicoes as $atribuicao): ?>
	<li class="list-group-item">
		<p class="list-group-item-heading ">
			<a data-toggle="tooltip" title="Desistir" class="pull-right edit btn btn-sm btn-danger" href="<?= Controller::route('tarefa', 'modalDesistir', $atribuicao->get('id'))?>">
				<i class="fa fa-thumbs-down"></i>
			</a>
			<strong>
				<?= $atribuicao->getTarefa()->getEvento('nome') ?> <br/>
				<small><?= $atribuicao->getTarefa('nome') ?></small>				
			</strong>			
		</p>
		<p class="list-group-item-text">
			<?= $atribuicao->getTarefa('descricao', " ")?>
		</p>
		<br>
		<?php if ($atribuicao->getTarefa('efetivacao')):?>
		<p class="list-group-item-text text-danger small">
			Esta é uma tarefa de efetivação. Após concluí-la, outras tarefas estarão disponíveis.
		</p>
		<br>
		<?php endif?>
		<p class="text-muted text-right small">
			<?php if($atribuicao->getTarefa('data_agendada')): ?>
			Agendada para <?= $atribuicao->getTarefa('data_agendada', '', true) ?>
			<?php endif;?>
		</p>
	</li>
<?php endforeach;?>