<div class="modal fade" id="modal" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Editar Recurso</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" id="form" method="post" action="<?php echo Controller::route("recurso", "gravar")?>">
					<input name="id" type="hidden" value="<?php echo $this->recurso->get('id')?>">
					<div class="form-group">
						<label class="col-md-12" for="menu_id">Menu:</label>
						<div class="col-md-12">
							<select name="menu_id" class="form-control" id="menu_id" required="">
								<option value=""> Selecione um valor... </option>
								<option value="-1">Sem Menu</option>
								<?php echo Model::getOptions("menu", "id", "descricao", $this->recurso->get('menu_id'))?>
							</select>
						</div>
					</div>					
					<div class="form-group">
						<label class="col-md-12" for="descricao">Descrição:</label>
						<div class="col-md-12">
							<input name="descricao" class="form-control" required="" type="text" value="<?php echo $this->recurso->get('descricao')?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-12" for="controle">Controle:</label>
						<div class="col-md-12">
							<input name="controle" class="form-control" required="" type="text" value="<?php echo $this->recurso->get('controle')?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-12" for="acao">Ação:</label>
						<div class="col-md-12">
							<input name="acao" class="form-control" required="" type="text" value="<?php echo $this->recurso->get('acao')?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-12" for="ordem">Ordem:</label>
						<div class="col-md-12">
							<input name="ordem" class="form-control" required="" type="number" value="<?php echo $this->recurso->get('ordem')?>">
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
</script>