<nav class="navbar navbar-default navbar" id='menu-top'>
	<div class="container-fluid">
		<div class="navbar-header">
 			<a class="navbar-brand" href="<?php echo Controller::route("home", "default")?>">
				<?php echo Config::SYS_SIGLA?>
			</a>
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
				<span class="icon-bar" style="border:solid white 1px"></span>
				<span class="icon-bar" style="border:solid white 1px"></span>
				<span class="icon-bar" style="border:solid white 1px"></span>
			</button> 			
		</div>
		<div class="collapse navbar-collapse" id="myNavbar">
			<div class="navbar-text"><?php echo Config::SYS_TITULO?></div>
			<ul class="nav navbar-nav navbar-right">
				<li>
					<a class="navbar-brand" href="<?php echo Controller::route("login", "logoff")?>">
						<span class="glyphicon glyphicon-off"></span> Sair
					</a>
				</li>
			</ul>
		</div>		
	</div>
</nav>