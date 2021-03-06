<div class="panel panel-default">
	<div class="panel-heading">
		<a data-toggle="collapse" href="#filtro"> Filtro de Assistidos<span class="pull-right"><i class="fa fa-filter"></i></span>
		</a>
	</div>
	<div class="panel-collapse collapse" id="filtro">
		<div class="panel-body">
			<div class="row form-group">
				<div class="col-md-12">
					<label>Nº Cadastro</label><br> <input type="text" name="id" class="form-control" value="<?= Globals::get('id')?>" />
				</div>
			</div>
			<div class="row form-group">
				<div class="col-md-12">
					<label>Nome</label><br> <input type="text" name="nome" class="form-control" value="<?= Globals::get('nome')?>" />
				</div>
			</div>
			<div class="row form-group">
				<div class="col-md-12">
					<label>Sexo</label><br>
					<select name="sexo" class="form-control">
						<option value="">Ambos os sexos</option>
						<?php
						foreach ( $options = [ 
								'M' => 'Masculino',
								'F' => 'Feminino' 
						] as $value => $desc ) :
							?>
						<option value="<?= $value ?>" <?= (Globals::get('sexo')==$value)? 'selected' : ''?>><?= $desc?></option>
						<?php endforeach;?>
					</select>
				</div>
			</div>
			<div class="row form-group">
				<div class="col-md-12">
					<label>Ações</label><br>
					<select name="acao_id" class="form-control">
						<option value="">Todas as ações</option>
						<?= Model::getOptions("acao", "id", "nome", Globals::get('acao_id'))?>
					</select>
				</div>
			</div>
			<div class="row form-group">
				<div class="col-md-12">
					<label class="" class="required">Estado</label><br>
					<select id="filter-estado" name="estado" class="form-control">
						<option value="">Selecione...</option>
						<?= Model::getOptions('cidade', 'DISTINCT estado', 'estado', NULL, "TRUE", 'estado')?>
					</select>
				</div>
			</div>
			<div class="row form-group">
				<div class="col-md-12">
					<label>Cidade</label><br>
					<select id="filter-cidade" name="cidade_id" class="form-control">
						<option value="">Todos as cidades</options>
					</select>
				</div>
			</div>			
			<div class="row form-group">
				<div class="col-md-12">
					<label>Diagnóstico</label><br>
					<input type="text" name="diagnostico" class="form-control" value="<?= Globals::get('"diagnostico"')?>" />
				</div>
			</div>
			<div class="row form-group">
				<div class="col-md-12">
					<label>Início do Tratamento</label>
					<div class="row">
						<div class="col-md-6">
							<input type="text" name="data_tratamento_inicio" class="form-control date" value="<?= Globals::get('data_tratamento_inicio')?>" placeholder="Início" />
						</div>
						<div class="col-md-6">
							<input type="text" name="data_tratamento_fim" class="form-control date" value="<?= Globals::get('data_tratamento_fim')?>" placeholder="Fim" />
						</div>
					</div>
				</div>
			</div>
			<div class="row form-group">
				<div class="col-md-12">
					<label>Última atualização</label>
					<div class="row">
						<div class="col-md-6">
							<input type="text" name="data_atualizacao_inicio" class="form-control date" value="<?= Globals::get('data_atualizacao_inicio')?>" placeholder="Início" />
						</div>
						<div class="col-md-6">
							<input type="text" name="data_atualizacao_fim" class="form-control date" value="<?= Globals::get('data_atualizacao_fim')?>" placeholder="Fim" />
						</div>
					</div>
				</div>
			</div>
			<div class="row form-group">
				<div class="col-md-12">
					<label>Aniversário</label>
					<div class="row">
						<div class="col-md-6">
							<input type="text" name="aniversario_inicio" class="form-control birthday" value="<?= Globals::get('aniversario_inicio')?>" placeholder="Início" />
						</div>
						<div class="col-md-6">
							<input type="text" name="aniversario_fim" class="form-control birthday" value="<?= Globals::get('aniversario_fim')?>" placeholder="Fim" />
						</div>
					</div>
				</div>
			</div>		
			<div class="row form-group">
				<div class="col-md-12">
					<button class="btn btn-default form-control" type="reset">
						<i class="fa fa-remove"></i> Limpar
					</button>
				</div>
			</div>
			<div class="row form-group">
				<div class="col-md-12">
					<button class="btn btn-primary form-control" type="submit">
						<i class="fa fa-search"></i> Buscar
					</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
$("#filter-estado").change(function(){
	var estado = $(':selected', this).val();
	$("#filter-cidade").load(
			"<?= Controller::route('assistido', 'cidade') ?>/?estado="+estado,
			function(){
				$(this).prepend("<option value=''>Todas as cidades...</option>"); 
			});
	}).change();
</script>