<form action="<?= Controller::route("acao", "gravar")?>" method="POST" class="form-async">
	<input value="<?= $this->acao->get('id')?>" name="id" type="hidden" />
	<div class="modal fade" id="modal" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Cadastro de Ação</h4>
				</div>
				<div class="modal-body">					
					<div class="row form-group">
						<div class="col-md-12">
							<div class="row form-group">
								<div class="col-md-12">
									<label class="required" class="required">Nome</label><br> <input name="nome" class="form-control" required type="text" value="<?= $this->acao->get('nome')?>" />
								</div>
							</div>
							<div class="row form-group">
								<div class="col-md-12">
									<label class="required" class="required">Descrição</label><br>
									<textarea name="descricao" class="form-control tinymce" required><?= $this->acao->get('descricao')?></textarea>
								</div>
							</div>								
						</div>
					</div>
				</div>
				<div class="modal-footer text-right">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn btn-primary">
						<i class="fa fa-send"></i> Enviar dados
					</button>
				</div>
			</div>
		</div>
	</div>
</form>
<script>
	$("#modal").modal("show").trigger('ajax.complete');

	$("#modal").on('hidden.bs.modal', function(){
		tinymce.remove();
	});

	tinymce.init({
		  selector: '.tinymce',
		  language: 'pt_BR'
	});		
</script>