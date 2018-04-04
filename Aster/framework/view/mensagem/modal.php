<div class="modal fade" id="modal" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Nova Mensagem</h4>
			</div>
			<div class="modal-body">						
				<form novalidate class="form-horizontal form-async" id="form-mensagem" method="post" action="<?php echo Controller::route("mensagem", "gravar")?>">
					<input name="remetente_id" type="hidden" value="<?= $this->mensagem->get('remetente_id', Session::getVoluntario('id')) ?>">					
					<div class="row form-group">
						<label class="col-md-12" for="descricao">Ações</label>
						<div class="col-md-12">
							<select id="sel-acao" name="acao_ids[]" class="form-control " multiple>								
								<?php echo Model::getOptions('acao', 'id', 'nome') ?>
							</select>
						</div>
					</div>
					<div class="row form-group">
						<label class="col-md-12" for="descricao">Perfis</label>
						<div class="col-md-12">
							<select id="sel-perfil" name="perfil_ids[]" class="form-control " multiple>
								<?php echo Model::getOptions('perfil', 'id', 'descricao') ?>
							</select>
						</div>
					</div>
					<div class="row form-group">
						<label class="col-md-12 required" for="descricao">Destinatários</label>
						<div class="col-md-12">
							<select id="sel-destinatario" name="destinatario_ids[]" class="form-control" required multiple></select>
						</div>
					</div>
					<div class="row form-group">
						<label class="col-md-12 required" for="descricao">Assunto</label>
						<div class="col-md-12">
							<input required name="assunto" type="text" class="form-control" value="<?php echo $this->mensagem->get('assunto')?>">
						</div>
					</div>
					<div class="row form-group">
						<label class="col-md-12 required" for="descricao">Mensagem</label>
						<div class="col-md-12">
							<textarea size="4" name="texto" class="form-control" ><?php echo $this->mensagem->get('texto')?></textarea>
						</div>
					</div>	
					<div class="text-right">
						<button type="button" class="btn btn-cancel" data-dismiss="modal"><i class="fa fa-close"></i> Fechar</button>
						<button type="submit" class="btn btn-primary"><i class="fa fa-send"></i> Enviar</button>						
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script>

	/*$('.multiselect').multiselect({
		maxHeight: 200,
		enableFiltering: false,
		filterPlaceholder:'Pesquisar...',
		enableCaseInsensitiveFiltering: true,
		includeSelectAllOption: true,
		nonSelectedText: 'Selecionar',
		numberDisplayed: 1
	});	*/

	$("#sel-acao,#sel-perfil").change(function(){
		var form = $("#form-mensagem");
		$.ajax({
			type: "POST",
			url: "<?= Controller::route('mensagem','destinatarios') ?>",
			data: form.serialize(),
			complete: function(data){
				//console.log(data);
				$("#sel-destinatario").html(data.responseText)
				//.multiselect('rebuild');
			}
		});
		
	});

	$("#sel-acao").change();

	$("#modal").modal("show");	
</script>