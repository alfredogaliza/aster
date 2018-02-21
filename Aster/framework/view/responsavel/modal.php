<form action="<?= Controller::route("responsavel", "gravar")?>" method="POST" class="form-async">
	<input value="<?= $this->responsavel->get('id')?>" name="id" type="hidden" />
	<div class="modal fade" id="modal" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Cadastro de Responsável</h4>
				</div>
				<div class="modal-body">										
					<input type="hidden" name="id" value="<?= $this->responsavel->get('id')?>" class="form-control">
					<div class="row form-group">
						<div class="col-md-6">
							<label class="required">Nome</label>
							<input type="text" name="nome" value="<?= $this->responsavel->get('nome')?>" class="form-control">
						</div>
						<div class="col-md-6">
							<label class="required">Parentesco</label>
							<input type="text" name="parentesco" value="<?= $this->responsavel->get('parentesco')?>" class="form-control">
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-12">
							<label class="required">Endereço</label>
							<input name="endereco" value="<?= $this->responsavel->get('endereco')?>" class="form-control">
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-6">
							<label>Telefone</label><br> <input value="<?= $this->responsavel->get('contato')?>" name="contato" class="form-control telefone" type="text" />
						</div>
						<div class="col-md-6">
							<label>Whatsapp</label><br> <input value="<?= $this->responsavel->get('whatsapp')?>" name="whatsapp" class="form-control telefone" type="text" />
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-12">
							<label>Email</label>
							<input type="text" name="email" value="<?= $this->responsavel->get('email')?>" class="form-control">
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
</script>