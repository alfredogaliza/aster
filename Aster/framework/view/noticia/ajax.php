<?php foreach ($this->noticias as $noticia): ?>
	<li class="list-group-item">
		<strong class="list-group-item-heading">
			<?= $noticia->get('titulo')?>			
		</strong>
		<p class="list-group-item-text"><?= $noticia->get('texto')?></p>
		<p></p>
		<p class="text-muted text-right small"><?= $noticia->getDate('datahora')?></p>
	</li>
<?php endforeach;?>