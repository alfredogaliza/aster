<div class="modal fade" id="modal" tabindex="-1" role="dialog">	
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Editar Turma</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal form-async" id="form" method="post" action="<?php echo Controller::route("turma", "gravar")?>">
					<input id="id" name="id" type="hidden" value="<?php echo $this->turma->get('id')?>" />
					<input name="ativo" type="hidden" value="<?php echo $this->turma->get('id')? $this->turma->get('ativo') : 1 ?>" />
					<input name="status" type="hidden" value="<?php echo $this->turma->get('id')? $this->turma->get('status') : 1 ?>" />
					<div class="row form-group">
						<label class="col-md-4">Descrição:</label>
						<div class="col-md-8">
							<input name="descricao" class="form-control" required="" type="text" value="<?php echo $this->turma->get('descricao')?>">
						</div>						
					</div>					
					<div class="row form-group">
						<label class="col-md-4">Polo:</label>
						<div class="col-md-8">
							<select id="polo" name="polo_id" class="form-control" required="">
								<option value="">Selecione um valor... </option>
								<?php echo Model::getOptions("polo", "id", "quartel", $this->turma->get("polo_id"), Session::getUsuario()->hasPermission('gerencia', 'global')? 'TRUE' : "id = '".Session::getUsuario('polo_id')."'")?>
							</select>									
						</div>
					</div>
					<div class="row form-group">
						<label class="col-md-4">Vagas:</label>
						<div class="col-md-8">
							<input name="vagas" class="form-control integer" required="" type="text" value="<?php echo $this->turma->get('vagas')?>">
						</div>						
					</div>					
					<div class="row form-group">
						<label class="col-md-4">Inscrições:</label>
						<div class="col-md-4">
							<input data-end="[name='fechamento']" name="abertura" class="form-control datetime start" required="" type="text" value="<?php echo Config::toDateDMY($this->turma->get('abertura')) ?>">
						</div>
						<div class="col-md-4">
							<input data-start ="[name='abertura']" name="fechamento" class="form-control datetime end" required="" type="text" value="<?php echo Config::toDateDMY($this->turma->get('fechamento'))?>">
						</div>						
					</div>
					<div class="row form-group">
						<label class="col-md-4">Aulas:</label>
						<div class="col-md-4">
							<input data-end="[name='termino']" name="inicio" class="form-control datetime start" required="" type="text" value="<?php echo Config::toDateDMY($this->turma->get('inicio')) ?>">
						</div>
						<div class="col-md-4">
							<input data-start="[name='inicio']" name="termino" class="form-control datetime end" required="" type="text" value="<?php echo Config::toDateDMY($this->turma->get('termino'))?>">
						</div>						
					</div>
					<div class="row form-group">
						<label class="col-md-4">Turnos/Dias:</label>
						<div class="col-md-8">
							<select name="turma_turnodia[]" class="form-control" multiple>
								<?= Model:: getOptions('turnodia', 'id', "CONCAT(dia,'/',turno)", $this->turma->getTurnoDiaIds())?>
							</select>
						</div>						
					</div>
					<div class="row form-group">
						<label class="col-md-4">Coordenadores:</label>
						<div class="col-md-8">
							<select id="coordenadores" name="coordenador_turma[]" class="form-control" multiple>
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

	$("#polo").change(function(){
		$("#coordenadores").load(
			"<?= Controller::route("turma","coordenadores")?>/"+$("#id").val()+"/?polo_id="+this.value,
			function(){
				$(this).multiselect("destroy").multiselect({numberDisplayed: 1});
			}
		);
	}).change();	
	

</script>
