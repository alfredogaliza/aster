<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="pt-br">
	<head>	
		<?php
			View::includeBlock("head");			
		?>
		<script>
			$(function(){
				$(".panel-heading").siblings().hide();
			});
		</script>
		<style>
			body {
				margin-top: 1em;				
			}
			#login-container {
				padding: 2em;
				background-color: rgba(0, 0, 0, 0.6);
				border-radius: 20px;			
			}
			.bg-cbmpa {
				text-align: center;
				position: absolute;
				opacity: .2;
				left: 0;
				right: 0;
				top: 0;
				bottom: 0;
				overflow: hidden;
				z-index: -1;
			}
			.bg-cbmpa img {
				width: 100%
			}			
		</style>
	</head>		
	<body>
		<div class="container" id="login-container">
			<div class="bg-cbmpa"><img src="<?php echo Controller::route("image", "logo.png")?>"/></div>
			<div class="well">
				<h2>Cadastro Realizado com sucesso!</h2>
				<h3>Candidato: <?= $this->aluno->get('nome')?></h3>
				<h3>Polo: <?php $polo = new Polo($this->aluno->get('polo_id')); echo $polo->get('quartel')?></h3>
				<h3>Nº de Inscrição: <?= $this->aluno->get('id')?></h3>
				<a href="<?= Controller::route("inscricao","default");?>">Voltar</a>
			</div>
		</div>
	</body>
</html>