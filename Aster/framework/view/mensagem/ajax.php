<?php foreach ($this->mensagens as $mensagem): ?>
	<li class="list-group-item">
		<strong class="list-group-item-heading">
			<?= $mensagem->get('assunto')?>			
		</strong>
		<p class="list-group-item-text"><?= $mensagem->get('texto')?></p>
		<p></p>
		<p class="text-muted text-right small"><?= $mensagem->getRemetente('nome').' - '.$mensagem->getDate('datahora')?></p>
	</li>
<?php endforeach;?>