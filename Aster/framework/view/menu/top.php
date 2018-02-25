<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Menu</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?= Controller::route('home')?>"> <img height=100% class="" src="<?= Controller::route('image', 'mini-logo.png')?>" />
			</a>
			<div class="navbar-text">Instituto Áster</div>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
		
			<?php if (Session::getVoluntario('id')): ?>		
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-user"></i>
						<?= Session::getVoluntario('nome')?>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li><a href="<?= Controller::route('voluntario','form')?>"><i class="fa fa-user-circle-o"></i> Dados pessoais</a></li>
						<!-- Aguardar definição dos coordenadores 
						<li><a href="#"><i class="fa fa-history"></i> Histórico</a></li>
						<li><a href="#"><i class="fa fa-comments"></i> Mensagens</a></li>
						 -->
						<li><a href="<?= Controller::route('voluntario','senha')?>"><i class="fa fa-lock"></i> Alterar Senha</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="<?= Controller::route('login','logoff')?>"><i class="fa fa-sign-out"></i> Sair</a></li>
					</ul>
				</li>
			</ul>
			<?php endif;?>
			<?php if (Session::getVoluntario()->hasPermission("admin", "menu")):?>
				<?php View::includeView('menu/admin')?>
			<?php endif;?>
			
		</div>
	</div>
</nav>