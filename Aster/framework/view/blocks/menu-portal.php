<nav class="navbar navbar-default" id="menu-top">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?php echo Controller::route("login", "logoff")?>"><?php echo Config::SYS_SIGLA?></a>
		</div>
		<div class="collapse navbar-collapse" id="myNavbar">
			<ul class="nav navbar-nav">
				<li><a href="<?php echo Controller::route("portal", "solicitacao")?>">Solicitação</a></li>
				<li><a href="<?php echo Controller::route("portal", "orientacao")?>">Orientações</a></li>					
				<li><a href="<?php echo Controller::route("portal", "andamento")?>">Andamentos</a></li>
				<li><a href="<?php echo Controller::route("portal", "pagamento")?>">Pagamento</a></li>
				<li><a href="<?php echo Controller::route("portal", "exigencia")?>">Exigências</a></li>
				<li><a href="<?php echo Controller::route("portal", "projeto")?>">Projeto</a></li>
				<li><a href="<?php echo Controller::route("portal", "certificado")?>">Certificado</a></li>
				<li><a href="<?php echo Controller::route("login", "logoff")?>">Sair</a></li>
			</ul>
		</div>
	</div>
</nav>