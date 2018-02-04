<div class="modal fade" id="modal" tabindex="-1" role="dialog">	
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Editar Polo</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal form-async" id="form" method="post" action="<?php echo Controller::route("polo", "gravar")?>">
					<input id="id" name="id" type="hidden" value="<?php echo $this->polo->get('id')?>" />
					<input name="cadastravel" type="hidden" value="<?php echo $this->polo->get('cadastravel', 1)?>" />
					<input name="ativo" type="hidden" value="<?php echo $this->polo->get('ativo', 1) ?>" />
					<div class="row form-group">
						<label class="col-md-4">Quartel:</label>
						<div class="col-md-8">
							<input name="quartel" class="form-control" required="" type="text" value="<?php echo $this->polo->get('quartel')?>">
						</div>						
					</div>
					<div class="row form-group">
						<label class="col-md-4">Endereço:</label>
						<div class="col-md-8">
							<textarea name="endereco" class="form-control" required="" ><?php echo $this->polo->get('endereco')?></textarea>
						</div>						
					</div>											
					<div class="row form-group">
						<label class="col-md-4">Cidade:</label>
						<div class="col-md-8">
							<select name="cidade_id" class="form-control" required="">
								<option value="">Selecione um valor... </option>
								<?php echo Model::getOptions("cidade", "id", "nome", $this->polo->get("cidade_id"))?>
							</select>									
						</div>
					</div>
					<div class="row form-group">
						<label class="col-md-4">Comandante:</label>
						<div class="col-md-8">
							<select name="comandante_id" class="form-control">
								<option value="">Sem comandante</option>
								<?php echo Model::getOptions("usuario", "id", "nome", $this->polo->get("comandante_id"),"ativo AND polo_id='".$this->polo->get('id')."'")?>
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
</script>
