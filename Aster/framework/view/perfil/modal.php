<div class="modal fade" id="modal" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Editar Perfil</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" id="form" method="post" action="<?php echo Controller::route("perfil", "gravar")?>">
					<input name="id" type="hidden" value="<?php echo $this->perfil->get('id')?>">					
					<div class="form-group">
						<label class="col-md-12" for="descricao">Descrição:</label>
						<div class="col-md-12">
							<input name="descricao" class="form-control" required="" type="text" value="<?php echo $this->perfil->get('descricao')?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-12">Recursos:</label>
						<div class="col-md-12">
							<?php foreach (Recurso::getAll() as $recurso):?>
							<div class="checkbox">
							  <label>
							    <input type="checkbox" value="<?php echo $recurso->get('id')?>" name="recurso_id[]" <?php echo $this->perfil->hasRecurso($recurso->get('id'))? "checked=''" : ""?>>
							    <?php echo $recurso->getMenu()->get('descricao') ?>/<?php echo $recurso->get('descricao') ?>
							  </label>
							</div>
							<?php endforeach;?>
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
<script>$("#modal").modal("show");</script>