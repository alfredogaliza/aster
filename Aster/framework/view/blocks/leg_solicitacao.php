<div class="legenda row form-group">
	<?php foreach (Config::getStatusAprovacao() as $id => $status):?>
	<div class="item-legenda col-md-2">
		<span class="quadro-legenda bg-<?php echo Config::getStatusAprovacaoClass($id)?>"></span><br/>
		<span class="titulo-legenda"><?php echo Config::getStatusAprovacao($id)?></span>
	</div>
	<?php endforeach; ?>
</div>
