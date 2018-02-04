<div class="modal fade" id="modal" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Editar Bairro</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" id="form" method="post" action="<?php echo Controller::route("bairro", "gravar")?>">
					<input name="id" type="hidden" value="<?php echo $this->bairro->get('id')?>">
					<div class="row form-group">
						<label class="col-md-2" for="nome">Nome:</label>
						<div class="col-md-10">
							<input name="nome" class="form-control" required="" type="text" value="<?php echo $this->bairro->get('nome')?>">
						</div>
					</div>					
					<div class="row form-group">
						<label class="col-md-2" for="cidade_id">Cidade:</label>
						<div class="col-md-10">
							<select name="cidade_id" class="form-control" required="">
								<option value="">Selecione uma cidade...</option>
								<?php echo Model::getOptions('cidade', 'id', 'nome', $this->bairro->get('cidade_id'))?>
							</select>
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
				$("#modal").modal("hide");
				location.reload(true);
			}
		);
		
		return false;		
	});	
</script>