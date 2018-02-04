<div class="legenda row form-group">
	<?php foreach (Config::getStatusAtribuicao(NULL, true) as $id => $status):?>
	<div class="item-legenda col-md-2">
		<span class="quadro-legenda bg-<?php echo Config::getStatusAtribuicaoClass($id)?>"></span><br/>
		<span class="titulo-legenda"><?php echo $status?></span>
	</div>
	<?php endforeach; ?>
</div>
