<div class="panel panel-default">
	<div class="panel-heading">
		<a data-toggle="collapse" href="#filtro"> Filtro de Voluntários<span class="pull-right"><i class="fa fa-filter"></i></span>
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
					<label>Perfil</label><br> <select name="perfil_id" class="form-control">
						<option value="">Todos os perfis</option>
													<?= Model::getOptions("perfil", "id", "descricao", Globals::get('perfil_id'))?>
												</select>
				</div>
			</div>
			<div class="row form-group">
				<div class="col-md-12">
					<label>Doador de Sangue</label><br>
					<select name="doador_sangue" class="form-control">
					<option value="">Doador / Não Doador</option>
						<?php
						foreach ( $options = [ 
								'D' => 'Todos os Doadores',
								'N' => 'Todos os Não Doadores',
								'A+' => 'Doadores A+',
								'B+' => 'Doadores B+',
								'AB+' => 'Doadores AB+',
								'O+' => 'Doadores O+',
								'A-' => 'Doadores A-',
								'B-' => 'Doadores B-',
								'AB-' => 'Doadores AB-',
								'O-' => 'Doadores O-' 
						] as $value => $desc ) :
							?>
						<option value="<?= $value ?>" <?= (Globals::get('doador_sangue')==$value)? 'selected' : ''?>><?= $desc?></option>
						<?php endforeach;?>
					</select>
				</div>
			</div>
			<div class="row form-group">
				<div class="col-md-12">
					<label>Doador de Medula</label><br>
					<select name="doador_medula" class="form-control">
						<option value="">Doador / Não Doador</option>
						<?php
						foreach ( $options = [ 
								'D' => 'Todos os Doadores',
								'N' => 'Todos os Não Doadores' 
						] as $value => $desc ) :
							?>
						<option value="<?= $value ?>" <?= (Globals::get('doador_medula')==$value)? 'selected' : ''?>><?= $desc?></option>
						<?php endforeach;?>
					</select>
				</div>
			</div>
			<div class="row form-group">
				<div class="col-md-12">
					<label>Formação / Habilidade</label><br> <input type="text" name="formacao" class="form-control" value="<?= Globals::get('formacao')?>" />
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
					<button class="btn btn-primary form-control" type="submit">
						<i class="fa fa-search"></i> Buscar
					</button>
				</div>
			</div>
			<div class="row form-group">
				<div class="col-md-12">
					<button class="btn btn-default form-control" type="reset">
						<i class="fa fa-remove"></i> Limpar
					</button>
				</div>
			</div>
		</div>
	</div>
</div>