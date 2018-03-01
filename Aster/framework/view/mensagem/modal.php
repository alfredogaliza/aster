<div class="modal fade" id="modal" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Nova Mensagem</h4>
			</div>
			<div class="modal-body">						
				<form class="form-horizontal" id="form-mensagem" method="post" action="<?php echo Controller::route("mensagem", "gravar")?>">
					<input name="remetente_id" type="hidden" value="<?= $this->mensagem->get('remetente_id', Session::getVoluntario('id')) ?>">					
					<div class="row form-group">
						<label class="col-md-2" for="descricao">Destinatários:</label>
						<div class="col-md-10">
							<select name="destinatario_ids[]" class="form-control multiselect" required multiple>
								<?php echo Model::getOptions('voluntario', 'id', 'nome', $this->mensagem->get('destinatario_id'), 'TRUE', 'nome') ?>
							</select>
						</div>
					</div>
					<div class="row form-group">
						<label class="col-md-2" for="descricao">Assunto:</label>
						<div class="col-md-10">
							<input name="assunto" type="text" class="form-control" value="<?php echo $this->mensagem->get('assunto')?>">
						</div>
					</div>
					<div class="row form-group">
						<label class="col-md-2" for="descricao">Mensagem:</label>
						<div class="col-md-10">
							<textarea size="4" name="texto" class="form-control" ><?php echo $this->mensagem->get('texto')?></textarea>
						</div>
					</div>	
					<div class="text-right">
						<button type="button" class="btn btn-cancel" data-dismiss="modal"><i class="fa fa-close"></i> Fechar</button>
						<button type="submit" class="btn btn-primary"><i class="fa fa-send"></i> Enviar Mensagem</button>						
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script>

	$('.multiselect').multiselect({
		maxHeight: 200,
		enableFiltering: true,
		filterPlaceholder:'Pesquisar...',
		enableCaseInsensitiveFiltering: true,
		includeSelectAllOption: true,
		nonSelectedText: 'Selecionar Destinos',
		numberDisplayed: 1
	});

	$("#modal").modal("show").on('shown.bs.modal', function(){
		container = $('#conversa');
		scrollTo = $('#msg-<?php echo $this->mensagem->get('id')?>');		
		container.animate({
	    	//scrollTop: scrollTo.offset().top - container.offset().top + container.scrollTop()
		});
	});
	
	$("#form-mensagem").submit(function(event){
		event.preventDefault();		
		var form = $(this);
		$.ajax({
			type: "POST",
			url: form.attr('action'),
			data: form.serialize(),
			complete: function(){
				//window.location.reload();
			}
		});
				
		return false;
	});	
</script>