<div class="modal fade" id="modal" tabindex="-1" role="dialog">	
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Editar Matrícula</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal form-async" id="form" method="post" action="<?php echo Controller::route("matricula", "gravar")?>">
					<input id="id" name="id" type="hidden" value="<?php echo $this->matricula->get('id')?>" />
					<input name="aluno_id" type="hidden" value="<?php echo $this->matricula->get('aluno_id')?>" />
					<input name="data_exclusao" type="hidden" value="<?php echo $this->matricula->get('data_exclusao')?>" />
					<input name="motivo_exclusao" type="hidden" value="<?php echo $this->matricula->get('motivo_exclusao')?>" />
					<input name="interrompido" type="hidden" value="<?php echo $this->matricula->get('interrompido', 0)?>" />										
					<input name="status" type="hidden" value="<?php echo $this->matricula->get('status', Config::STATUS_MATRICULA_EMCURSO )?>" />
					<input name="ativo" type="hidden" value="<?php echo $this->matricula->get('id', 1 )?>" />
					<div class="row form-group">
						<label class="col-md-4">Aluno:</label>
						<div class="col-md-8">
							<?= $this->matricula->getAluno('nome') ?>
						</div>
					</div>
					<div class="row form-group">
						<label class="col-md-4">Polo:</label>
						<div class="col-md-8">
							<?php if (Session::getUsuario()->hasPermission('gerencia', 'global')): ?>
							<select id="polo-select" class="form-control">
								<option value="">Selecione um valor...</option>
								<?= Model::getOptions('polo', 'id', 'quartel', $this->matricula->getTurma('polo_id')) ?>
							</select>
							<?php else: ?>
								<?= $this->matricula->getPolo('quartel') ?>
							<?php endif;?>
						</div>						
					</div>					
					<div class="row form-group">
						<label class="col-md-4">Turma:</label>
						<div class="col-md-8">
							<select id="turma-select" name="turma_id" class="form-control" required="">
								<option value="">Selecione um polo...</option>
							</select>									
						</div>
					</div>															
					<div class="text-right">
						<button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> Fechar</button>
						<button type="submit" class="btn btn-primary"><span class="fa fa-floppy-o"></span> Gravar Dados</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script>
	$("#modal").modal("show").trigger('ajax.complete');
	
	$("#polo-select").change(function(){
		$("#turma-select").load("<?= Controller::route('matricula', 'optionsTurmas')?>/?polo_id="+$(this).val()+"&turma_id="+$("#turma-select").val());
	});

	$("#turma-select").load("<?= Controller::route('matricula', 'optionsTurmas')?>/?polo_id=<?= $this->matricula->getTurma('polo_id')?>&turma_id=<?= $this->matricula->get('turma_id')?>");
</script>
