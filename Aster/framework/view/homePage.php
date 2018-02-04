<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="pt-br">
	<head>	
		<?php
			View::includeBlock("head");
		?>
	</head>		
	<body>		
		<div class="container">			
			<div class="row">
				<h2>Olá voluntário <?= Session::getUsuario('nome') ?>!</h2>		
				<?php foreach(Session::getUsuario()->getAttrs() as $key => $value): ?>
				<label><?= $key ?>:</label> <?= $value ?><br>
				<?php endforeach;?>
			</div>
		</div>
	</body>
</html>