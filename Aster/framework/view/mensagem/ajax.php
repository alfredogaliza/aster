<?php foreach ($this->mensagens as $mensagem): ?>
	<li class="list-group-item list-group-item-<?= $mensagem->get('data_leitura')? 'success' : 'warning' ?>">
		<p class="list-group-item-heading">
			<strong><?= $mensagem->get('assunto')?></strong>
			<span class="pull-right">
				<a data-toggle="tooltip" title="Abrir" class="btn btn-default edit" href="<?= Controller::route('mensagem', 'modalReply', $mensagem->get('id'))?>">
					<i class="fa fa-envelope-open"></i>
				</a>			
				<a data-toggle="tooltip" title="Deletar" class="btn btn-default delete async" href="<?= Controller::route('mensagem', 'delete', $mensagem->get('id'))?>">
					<i class="fa fa-trash"></i>
				</a>
			</span>
		</p>
		
		<p class="list-group-item-text"><?= preg_replace("/^(.{20}).*/", "$1 (...)", $mensagem->get('texto'))?></p>
		<p></p>
		<p class="text-muted text-right small"><?= $mensagem->getRemetente('nome').' - '.$mensagem->getDate('datahora')?></p>
	</li>
<?php endforeach;?>