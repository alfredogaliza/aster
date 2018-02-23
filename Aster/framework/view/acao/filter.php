<div class="panel panel-default">
	<div class="panel-heading">
		<a data-toggle="collapse" href="#filtro"> Filtro de Ações<span class="pull-right"><i class="fa fa-filter"></i></span>
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