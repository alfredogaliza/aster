<form action="<?= Controller::route("perfil", "gravar")?>" method="POST" class="form-async">
	<input value="<?= $this->perfil->get('id')?>" name="id" type="hidden" />
	<div class="modal fade" id="modal" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Cadastro de Perfil</h4>
				</div>
				<div class="modal-body">					
					<div class="row form-group">
						<div class="col-md-12">
							<div class="row form-group">
								<div class="col-md-12">
									<label class="required" class="required">Descrição</label><br> <input name="descricao" class="form-control" required type="text" value="<?= $this->perfil->get('descricao')?>" />
								</div>
							</div>															
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<label>Recursos Disponíveis</label>
							<ul class="list-group">
								<?php foreach(Model::getAll('recurso') as $recurso):?>
								<li class="list-group-item">
									<label>
										<input type='checkbox' name='recurso_id[]' value='<?= $recurso->get('id')?>' <?= $this->perfil->hasRecurso($recurso->get('id'))? 'checked' : ''?>/>
										<?= $recurso->get('descricao')?>
									</label>
								</li>
								<?php endforeach;?>
							</ul>
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