<form novalidate action="<?= Controller::route("acao", "gravar")?>" method="POST" class="form-async">
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
							<label class="required" class="required">Nome</label><br>
							<input name="nome" class="form-control" required type="text" value="<?= $this->acao->get('nome')?>" />
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-6">
							<label class="required">Obrigatório</label>
							<select name="obrigatorio" class="form-control" required>
								<option value="">Selecione</option>
								<option value="1" <?= $this->acao->get('obrigatorio')? 'selected' : ''?>>Sim</option>
								<option value="0" <?= $this->acao->get('obrigatorio')? '' : 'selected'?>>Não</option>
							</select>
							<small>Ações obrigatórias sempre são vinculadas aos voluntários</small>
						</div>
						<div class="col-md-6">
							<label class="required">Privado</label>
							<select name="privado" class="form-control" required>
								<option value="">Selecione</option>
								<option value="1" <?= $this->acao->get('privado')? 'selected' : ''?>>Sim</option>
								<option value="0" <?= $this->acao->get('privado')? '' : 'selected'?>>Não</option>
							</select>
							<small>Ações privadas só podem ser vinculadas a voluntários pela administração</small>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-12">
							<label>Descrição</label><br>
							<textarea name="descricao" class="form-control tinymce"><?= $this->acao->get('descricao')?></textarea>
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