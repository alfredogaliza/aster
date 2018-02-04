<div class="modal fade" id="modal" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Editar Usuário</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" id="form" method="post" action="<?php echo Controller::route("usuario", "gravar")?>">
					<input name="id" type="hidden" value="<?php echo $this->usuario->get('id')?>">
					
					<input name="ativo" type="hidden" value="<?php echo is_null($this->usuario->get('ativo'))? '1' : $this->usuario->get('ativo')?>">
					<input name="bloqueado" type="hidden" value="<?php echo is_null($this->usuario->get('bloqueado'))? '0' : $this->usuario->get('bloqueado')?>">
					<input name="ultimo_login" value="<?= $this->usuario->get('ultimo_login')?>" type="hidden" />
					<input name="senha" type="hidden" value="<?php echo $this->usuario->get('senha')?>">
								
					<div class="form-group">
						<label class="col-md-12" for="unidade_id">Polo:</label>
						<div class="col-md-12">
							<select name="polo_id" class="form-control" id=""polo_id"" required="">
								<option value="">Selecione um valor... </option>
								<?php echo Model::getOptions("polo", "id", "quartel", $this->usuario->get("polo_id"))?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-12" for="perfil_id">Perfil:</label>
						<div class="col-md-12">
							<select name="perfil_id" class="form-control" id="perfil_id" required>
								<option value=""> Selecione um valor... </option>
								<?php echo Model::getOptions("perfil", "id", "descricao", $this->usuario->get('perfil_id'), "id >= '".Session::getUsuario('perfil_id')."'")?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-12" for="nome">Nome:</label>
						<div class="col-md-12">
							<input name="nome" class="form-control" required="" type="text" value="<?php echo $this->usuario->get('nome')?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-12" for="email">Email:</label>
						<div class="col-md-12">
							<input name="email" class="form-control" required="" type="text" value="<?php echo $this->usuario->get('email')?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-12" for="login">Login:</label>
						<div class="col-md-12">
							<input name="login" class="form-control" required="" type="text" value="<?php echo $this->usuario->get('login')?>">
						</div>
					</div>										
					<div class="text-right">
						<input type="submit" class="btn btn-primary" value="Enviar" /> 
						<button type="button" class="btn btn-cancel" data-dismiss="modal">Fechar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
	$("#modal").modal("show");
	$("#form").submit(function(event){
		event.preventDefault();
		$.post(
			$(this).attr('action'),
			$(this).serialize(),
			function(){
				location.reload(true);
			}
		);
		$("#modal").modal("hide");
		return false;		
	});
</script>
