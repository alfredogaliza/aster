<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>	
	<?php View::includeView("html/head"); ?>
</head>
<body>
	<div class="container">
		<div class="jumbotron">
			<h2>
				<?= $this->title ?>
			</h2>
			<?= $this->msg ?>
		</div>
		<a href="<?= Controller::route("login")?>" class="btn btn-link"><i class="fa fa-backward"></i> Voltar para a tela inicial</a>	
	</div>
</body>
</html>
