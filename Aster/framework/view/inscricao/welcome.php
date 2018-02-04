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
			
				<h2 style="color:white">
					Bem vindos ao Sistema de Gerenciamento do "Programa Escola da Vida"
				</h2>
				
			
			<ul class="well">
				<li>Para efetuar login no sistema, clique no link: <a href="<?= Controller::route("login") ?>">Realizar Login</a><br>
				<li>Para inscrição no processo seletivo de novos alunos, escolha um dos polos abaixo:								
			</ul>
			<div class="row">
				<div class="col-md-6">
			<?php $i = 1; foreach ($this->polos as $polo): if ($i++ > count($this->polos)/2) echo "</div><div class='col-md-6'>\n"; ?>						
					<div class="panel panel-primary">
						<div class="panel-heading"><h4><?= $polo->get('quartel')?></h4></div>
						<div class="panel-body">
							<div class="row">
								<label class="col-md-4">Endereço:</label>
								<div class="col-md-8"><?= $polo->get('endereco')?></div>
							</div>
							<div class="row">
								<label class="col-md-12">Turmas:</label>
							</div>
							<?php foreach($turmas = $polo->getTurmasAbertas() as $turma): ?>
							<div class="well">
								<div class="row">
									<label class="col-md-4">Nome:</label><div class="col-md-8"><?= $turma['descricao']?></div>
								</div>
								<div class="row">
									<label class="col-md-4">Vagas:</label><div class="col-md-8"><?= $turma['vagas_abertas']?></div>
								</div>
							</div>
							<?php endforeach;?>
						</div>
						<div class="panel-footer text-right">
							<?php if ($turmas) :?>
							<button class="btn btn-warning edit" data-href="<?= Controller::route('inscricao', 'modal',NULL,['polo_id'=>$polo->get('id')])?>">Realizar inscrição neste Polo</button>
							<?php else:?>
							<button class="btn btn-warning" disabled>Cadastro indisponível neste Polo</button>
							<?php endif; ?>
						</div>
					</div>
			<?php endforeach;?>
				</div>
			</div>
			<div id="modal-container"></div>
		</div>
	</body>
</html>