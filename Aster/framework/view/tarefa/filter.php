<div class="panel panel-default">
	<div class="panel-heading">
		<a data-toggle="collapse" href="#filtro"> Filtro de Tarefas<span class="pull-right"><i class="fa fa-filter"></i></span>
		</a>
	</div>
	<div class="panel-collapse collapse" id="filtro">
		<div class="panel-body">
			<div class="row form-group">
				<div class="col-md-12">
					<label>Nome</label><br> <input type="text" name="nome" class="form-control" value="<?= Globals::get('nome')?>" />
				</div>
			</div>
			<div class="row form-group">
				<div class="col-md-12">
					<label>Evento</label><br>
					<select name="evento_id" class="form-control">
						<option value="">Todas os eventos</option>
						<?= Model::getOptions('evento', 'id', 'nome', Globals::get('evento_id'))?>
					</select>
				</div>
			</div>
			<div class="row form-group">
				<div class="col-md-12">
					<label>Data de Fechamento</label>
					<div class="row">
						<div class="col-md-6">
							<input type="text" name="data_fechamento_inicio" class="form-control date" value="<?= Globals::get('data_fechamento_inicio')?>" placeholder="Início" />
						</div>
						<div class="col-md-6">
							<input type="text" name="data_fechamento_fim" class="form-control date" value="<?= Globals::get('data_fechamento_fim')?>" placeholder="Fim" />
						</div>
					</div>
				</div>
			</div>
			<div class="row form-group">
				<div class="col-md-12">
					<label>Data Agendada</label>
					<div class="row">
						<div class="col-md-6">
							<input type="text" name="data_agendada_inicio" class="form-control date" value="<?= Globals::get('data_agendada_inicio')?>" placeholder="Início" />
						</div>
						<div class="col-md-6">
							<input type="text" name="data_agendada_fim" class="form-control date" value="<?= Globals::get('data_agendada_fim')?>" placeholder="Fim" />
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