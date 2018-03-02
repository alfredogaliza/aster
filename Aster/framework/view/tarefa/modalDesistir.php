<form action="<?= Controller::route("tarefa", "desistir", $this->atribuicao->get('id'))?>" method="POST" class="form-async">
	<div class="modal fade" id="modal" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Desistência</h4>
				</div>
				<div class="modal-body">
					<p>Confirmar a desistência da atribuição abaixo?</p>
					<label>Evento:</label> <?= $this->tarefa->getEvento('nome')?><br/>
					<?php if ($this->tarefa->getEvento('descricao')): ?><label>Descrição do Evento:</label><br/><?= $this->tarefa->getEvento('descricao')?><br/><?php endif;?>
					<label>Tarefa:</label> <?= $this->tarefa->get('nome')?><br/>
					<?php if ($this->tarefa->get('descricao')): ?><label>Descrição da Tarefa:</label><br/><?= $this->tarefa->get('descricao')?><br/><?php endif;?>
					<?php if ($this->tarefa->get('data_agendada')): ?><label>Data:</label> <?= $this->tarefa->getDate('data_agendada')?><?php endif;?>
				</div>
				<div class="modal-footer text-right">
					<button type="button" class="btn btn-default" data-dismiss="modal">
						<i class="fa fa-close"></i>
						Cancelar
					</button>
					<button type="submit" class="btn btn-danger">
						<i class="fa fa-thumbs-down"></i> Desistir
					</button>
				</div>
			</div>
		</div>
	</div>
</form>

<script>
	$("#modal").modal("show").trigger('ajax.complete');
</script>