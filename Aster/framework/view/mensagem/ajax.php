<?php foreach ($this->mensagens as $mensagem): ?>
	<li class="list-group-item list-group-item-<?= $mensagem->get('data_leitura')? 'success' : 'warning' ?>">
		<p class="list-group-item-heading">
			<div class="pull-right">
				<a data-toggle="tool-tip" title="Abrir" class="btn btn-sm btn-success edit" href="<?= Controller::route('mensagem', 'modalReply', $mensagem->get('id'))?>">
					<i class="fa fa-envelope-open"></i>
				</a>
				<?php if (!$mensagem->get('data_leitura') && Session::getVoluntario('id') == $mensagem->get('remetente_id')): ?>			
				<a data-toggle="tool-tip" title="Deletar" class="btn btn-sm btn-danger async-confirm" data-pagination="#pag-mensagens" href="<?= Controller::route('mensagem', 'delete', $mensagem->get('id'))?>">
					<i class="fa fa-trash"></i>
				</a>
				<?php endif; ?>
			</div>					
		</p>
		<p class="list-group-item-text">
			<strong><?= $mensagem->get('assunto')?></strong><br>
			<small class="text-muted">Por <?= $mensagem->getRemetente('nome') ?></small>
		</p>
		<br>
		<p class="list-group-item-text">			
			<?= preg_replace("/^(.{20}).*/s", "$1 (...)", $mensagem->get('texto'))?>			
		</p>
		<p class="list-group-item-text text-muted small text-right">
			<?= $mensagem->getDate('datahora')?>
		</p>
	</li>
<?php endforeach;?>