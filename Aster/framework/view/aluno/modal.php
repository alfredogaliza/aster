<div class="modal fade" id="modal" tabindex="-1" role="dialog">	
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Editar Aluno</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" id="form" method="post" action="<?php echo Controller::route("aluno", "gravar")?>">
					<input name="id" type="hidden" value="<?php echo $this->aluno->get('id')?>" />
					<input name="inclusao" type="hidden" value="<?php echo $this->aluno->get('inclusao')?>" />
					<input name="rematricula" type="hidden" value="<?php echo $this->aluno->get('id')? $this->aluno->get('rematricula') : 0 ?>" />
					<input name="ativo" type="hidden" value="<?php echo $this->aluno->get('id')? $this->aluno->get('ativo') : 1 ?>" />
					<input name="status" type="hidden" value="<?php echo $this->aluno->get('id')? $this->aluno->get('status') : 1 ?>" />
					<ul class="nav nav-tabs">
					  <li class="active"><a data-toggle="tab" href="#pessoal">Dados Pessoais</a></li>
					  <li><a data-toggle="tab" href="#escolar">Dados Escolares</a></li>
					  <li><a data-toggle="tab" href="#socioeconomico">Dados Sócio-econômicos</a></li>
					  <li><a data-toggle="tab" href="#responsaveis">Responsáveis</a></li>
					</ul>
					<div class="tab-content">
  						<div id="pessoal" class="tab-pane fade in active">
  							<div class="row">&nbsp;</div>						
							<div class="row form-group">
								<label class="col-md-8">Polo:</label>
								<label class="col-md-4">Ano Entrada:</label>
								<div class="col-md-8">
									<select name="polo_id" class="form-control" required="">
										<option value="">Selecione um valor... </option>
										<?php echo Model::getOptions("polo", "id", "quartel", $this->aluno->get("polo_id"), Session::getUsuario()->hasPermission('gerencia', 'global')? 'TRUE' : "id = '".Session::getUsuario('polo_id')."'")?>
									</select>									
								</div>
								<div class="col-md-4">
									<input name="ano_entrada" class="dateyear form-control" type="text" value="<?php echo $this->aluno->get('ano_entrada')?>" required>
								</div>
							</div>
							<div class="row form-group">
								<label class="col-md-8" for="nome">Nome:</label>
								<label class="col-md-4" for="nome">Nascimento:</label>
								<div class="col-md-8">
									<input name="nome" class="form-control" required="" type="text" value="<?php echo $this->aluno->get('nome')?>">
								</div>						
								<div class="col-md-4">
									<input name="nascimento" class="date form-control" required="" type="text" value="<?php echo $this->aluno->getDate('nascimento')?>">
								</div>
							</div>
							<div class="row form-group">						
								<label class="col-md-8" for="email">Naturalidade:</label>
								<label class="col-md-4" for="login">Sexo:</label>
								<div class="col-md-8">
									<input name="naturalidade" class="form-control" required="" type="text" value="<?php echo $this->aluno->get('naturalidade')?>">
								</div>
								<div class="col-md-4">
									<input type="radio" name="sexo" type="text" value="M" <?= ($this->aluno->get('sexo') == 'M')? 'checked' : '' ?>>M
									<input type="radio" name="sexo" type="text" value="F" <?= ($this->aluno->get('sexo') == 'F')? 'checked' : '' ?>>F
								</div>
							</div>
							<div class="row form-group">
								<label class="col-md-8" for="nome">Endereço:</label>
								<label class="col-md-4" for="email">CEP:</label>
								<div class="col-md-8">
									<textarea name="endereco" class="form-control" required=""><?php echo $this->aluno->get('endereco')?></textarea>
								</div>		
								<div class="col-md-4">
									<input name="endereco_cep" class="form-control cep" required="" type="text" value="<?php echo $this->aluno->get('endereco_cep')?>">
								</div>						
							</div>
							<div class="row form-group">
								<label class="col-md-6" for="nome">Complemento:</label>
								<label class="col-md-6" for="nome">Referência:</label>
								<div class="col-md-6">
									<input name="endereco_complemento" class="form-control"  type="text" value="<?php echo $this->aluno->get('endereco_complemento')?>">
								</div>
								<div class="col-md-6">
									<input name="endereco_referencia" class="form-control"  type="text" value="<?php echo $this->aluno->get('endereco_referencia')?>">
								</div>
							</div>
							<div class="row form-group">
								<label class="col-md-6">Cidade:</label>
								<label class="col-md-6">Bairro:</label>
								<div class="col-md-6">
									<select id="cidade" name="cidade_id" class="form-control" required="">
										<option value="">Selecione um valor... </option>
										<?php echo Model::getOptions("cidade", "id", "nome", $this->aluno->get("cidade_id"))?>
									</select>
								</div>
								<div class="col-md-6">
									<input type="text" name="bairro" class="form-control" value="<?= $this->aluno->get('bairro')?>" />
								</div>
							</div>
							<div class="row form-group">
								<label class="col-md-4" for="nome">Tel. Residencial:</label>
								<label class="col-md-4" for="nome">Tel. Celular:</label>
								<label class="col-md-4" for="nome">Outro Tel.:</label>
								<div class="col-md-4">
									<input name="tel_residencial" class="form-control telefone"  type="text" value="<?php echo $this->aluno->get('tel_residencial')?>">
								</div>
								<div class="col-md-4">
									<input name="tel_celular" class="form-control telefone"  type="text" value="<?php echo $this->aluno->get('tel_celular')?>">
								</div>
								<div class="col-md-4">
									<input name="tel_outro" class="form-control telefone"  type="text" value="<?php echo $this->aluno->get('tel_outro')?>">
								</div>						
							</div>
							<div class="row form-group">
								<label class="col-md-6">Religião:</label>
								<label class="col-md-6">Plano de Saúde:</label>
								<div class="col-md-6">
									<select name="religiao_id" class="form-control" required="">
										<option value="">Selecione um valor... </option>
										<?php echo Model::getOptions("religiao", "id", "descricao", $this->aluno->get("religiao_id"))?>
									</select>
								</div>
								<div class="col-md-6">
									<input name="plano_saude" class="form-control"  type="text" value="<?php echo $this->aluno->get('plano_saude')?>">
								</div>
							</div>
							<div class="row form-group">
								<label class="col-md-6">Atividades Extra-curriculares:</label>
								<label class="col-md-6">Problemas de Saúde:</label>
								<div class="col-md-6">
									<select name="aluno_atividade[]" class="form-control"  multiple>
										<?php echo Model::getOptions("atividade", "id", "descricao", $this->aluno->getAtividadeIds())?>
									</select>
								</div>
								<div class="col-md-6">
									<select name="aluno_saude[]" class="form-control"  multiple>
										<?php echo Model::getOptions("saude", "id", "descricao", $this->aluno->getSaudeIds())?>
									</select>
								</div>
							</div>
						</div>
  						<div id="escolar" class="tab-pane fade">
  							<div class="row">&nbsp;</div>
  							<div class="row form-group">
								<label class="col-md-12">Escola:</label>
								<div class="col-md-12">
									<input name="escola" class="form-control"  type="text" value="<?php echo $this->aluno->get('escola')?>">
								</div>
							</div>
							<div class="row form-group">
								<label class="col-md-6" for="nome">Série/Grau:</label>
								<label class="col-md-6" for="nome">Turno:</label>
								<div class="col-md-6">
									<select name="escolaridade_id" class="form-control" required="">
										<option value="">Selecione um valor... </option>
										<?php echo Model::getOptions("escolaridade", "id", "descricao", $this->aluno->get("escolaridade_id"))?>
									</select>
								</div>
								<div class="col-md-4">
									<input type="radio" name="escola_turno" type="text" value="Matutino" <?= ($this->aluno->get('escola_turno') == 'Matutino')? 'checked' : '' ?>>Matutino
									<input type="radio" name="escola_turno" type="text" value="Vespertino" <?= ($this->aluno->get('escola_turno') == 'Vespertino')? 'checked' : '' ?>>Vespertino
									<input type="radio" name="escola_turno" type="text" value="Noturno" <?= ($this->aluno->get('escola_turno') == 'Noturno')? 'checked' : '' ?>>Noturno
								</div>				
							</div>
							<div class="row form-group">
								<label class="col-md-6" for="nome">Média Geral (0 a 10):</label>
								<label class="col-md-6" for="nome">Frequência (0 a 100):</label>
								<div class="col-md-6">
									<input name="escola_rendimento" class="form-control real"  type="text" value="<?php echo $this->aluno->get('escola_rendimento')?>">
								</div>
								<div class="col-md-6">
									<input name="escola_frequencia" class="form-control real"  type="text" value="<?php echo $this->aluno->get('escola_frequencia')?>">
								</div>					
							</div>
							<div class="row form-group">
								<label class="col-md-4">Facilidades:</label>
								<label class="col-md-4">Dificuldades:</label>
								<label class="col-md-4">Dependências:</label>
								<div class="col-md-4">
									<select name="disciplina_facilidade[]" class="form-control"  multiple>
										<?php echo Model::getOptions("disciplina", "id", "descricao", $this->aluno->getDisciplinaFacilidadeIds())?>
									</select>
								</div>
								<div class="col-md-4">
									<select name="disciplina_dificuldade[]" class="form-control"  multiple>
										<?php echo Model::getOptions("disciplina", "id", "descricao", $this->aluno->getDisciplinaDificuldadeIds())?>
									</select>
								</div>
								<div class="col-md-4">
									<select name="disciplina_dependencia[]" class="form-control"  multiple>
										<?php echo Model::getOptions("disciplina", "id", "descricao", $this->aluno->getDisciplinaDependenciaIds())?>
									</select>
								</div>								
							</div>						
  						</div>
  						<div id="socioeconomico" class="tab-pane fade">
  							<div class="row">&nbsp;</div>
							<div class="row form-group">
								<label class="col-md-3" for="nome">Renda Familiar (R$):</label>
								<label class="col-md-3" for="nome">Tipo:</label>
								<label class="col-md-3" for="nome">Material:</label>
								<label class="col-md-3" for="nome">Situação:</label>
								<div class="col-md-3">
									<input name="renda" class="form-control money"  type="text" value="<?php echo $this->aluno->get('renda')?>" required>
								</div>
								<div class="col-md-3">
									<select name="moradia_tipo" class="form-control" required>
										<option value="">Selecione um item...</option>
										<?= Config::makeOptions(Config::getMoradiaTipo(), $this->aluno->get('moradia_tipo'))?>
									</select>
								</div>
								<div class="col-md-3">
									<select name="moradia_material" class="form-control" required>
										<option value="">Selecione um item...</option>
										<?= Config::makeOptions(Config::getMoradiaMaterial(), $this->aluno->get('moradia_material'))?>
									</select>
								</div>
								<div class="col-md-3">
									<select name="moradia_situacao" class="form-control" required>
										<option value="">Selecione um item...</option>
										<?= Config::makeOptions(Config::getMoradiaSituacao(), $this->aluno->get('moradia_situacao'))?>
									</select>
								</div>					
							</div>
							<div class="row form-group">
								<label class="col-md-3" for="nome">Moradores:</label>
								<label class="col-md-3" for="nome">Cômodos:</label>
								<label class="col-md-3" for="nome">Tempo (Anos):</label>
								<label class="col-md-3" for="nome">Infraestrutura:</label>
								<div class="col-md-3">
									<select name="moradia_residentes" class="form-control" required>
										<option value="">Selecione um item...</option>
										<?= Config::makeOptions([0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20], $this->aluno->get('moradia_residentes'))?>
									</select>
								</div>
								<div class="col-md-3">
									<select name="moradia_comodos" class="form-control" required>
										<option value="">Selecione um item...</option>
										<?= Config::makeOptions([0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15], $this->aluno->get('moradia_comodos'))?>
									</select>
								</div>
								<div class="col-md-3">
									<select name="moradia_tempo" class="form-control" required>
										<option value="">Selecione um item...</option>
										<?= Config::makeOptions([0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30], $this->aluno->get('moradia_tempo'))?>
									</select>
								</div>
								<div class="col-md-3">
									<select name="aluno_infraestrutura[]" class="form-control"  multiple>
										<?php echo Model::getOptions("infraestrutura", "id", "descricao", $this->aluno->getInfraestruturaIds())?>
									</select>
								</div>					
							</div>  						
  						</div>
  						<div id="responsaveis" class="tab-pane fade">
  							<div class="row">&nbsp;</div>
  							<div class="row form-group">
  								<div class="col-md-12">
  									<button type="button" id="add-responsavel" class="form-control btn btn-success"><span class="fa fa-plu"></span> Adicionar Responsável</button>
  								</div>
  							</div>
  							<div class="panel-group" id="group-responsavel">
  							<?php $i = 0;?>
							<?php foreach ($this->responsaveis as $responsavel): ?>
							<?php $i = $i + 1;?>
								<div class="panel panel-primary">
								    <div class="panel-heading">
								        <?= $responsavel->get('nome')?>
								        <button type="button" onclick="$(this).closest('.panel').remove()" class="btn btn-danger btn-xs pull-right glyphicon glyphicon-remove"></button>
								    </div>
								    <div class="panel-body">
								    	<input type='hidden' name='responsavel[id][]' value="<?= $responsavel->get('id')?>" />
								    	<input type='hidden' name='responsavel[aluno_id][]' value="<?= $responsavel->get('aluno_id')?>" />								        
							            <div class="row form-group">
							                <label class="col-md-8">Nome:</label>
							                <label class="col-md-4">Tipo:</label>
							                <div class="col-md-8">
							                	<input required class="form-control" name="responsavel[nome][]" type="text" value="<?= $responsavel->get('nome')?>" onkeydown="$('.panel-heading', $(this).closest('.panel')).text(this.value?this.value:'Novo Responsável')">                    
							                </div>
							                <div class="col-md-4">
												<select name="responsavel[tipo][]" class="form-control" required>
													<option value="">Selecione um item...</option>
													<?= Config::makeOptions(['Pai','Mãe','Responsável'], $responsavel->get('tipo'))?>
												</select>
											</div>
							            </div> 
							            <div class="row form-group">
											<label class="col-md-4" for="nome">Nascimento:</label>
											<label class="col-md-4" for="nome">RG:</label>
											<label class="col-md-4" for="nome">Naturalidade:</label>
											<div class="col-md-4">
												<input required name="responsavel[nascimento][]" class="form-control date"  type="text" value="<?= $responsavel->getDate('nascimento')?>">
											</div>
											<div class="col-md-4">
												<input required name="responsavel[rg][]" class="form-control"  type="text" value="<?= $responsavel->get('rg')?>">
											</div>
											<div class="col-md-4">
												<input name="responsavel[naturalidade][]" class="form-control"  type="text" value="<?= $responsavel->get('naturalidade')?>">
											</div>	
										</div>
										<div class="row form-group"> 
											<label class="col-md-6">Escolaridade:</label>
											<label class="col-md-6">Profissão:</label>
							                <div class="col-md-6">
												<select name="responsavel[escolaridade_id][]" class="form-control" required>
													<option value="">Selecione um item...</option>
													<?= Model::getOptions("escolaridade", "id", "descricao", $responsavel->get('escolaridade_id'))?>
												</select>
											</div>
											<div class="col-md-6">
												<input name="responsavel[profissao][]" class="form-control"  type="text" value="<?= $responsavel->get('profissao')?>">
											</div>
										</div>
										<div class="row form-group"> 
											<label class="col-md-6">Endereço Residencial:</label>
											<label class="col-md-6">Endereço Profissional:</label>
											<div class="col-md-6">
												<textarea name="responsavel[endereco_residencial][]" class="form-control" required><?= $responsavel->get('endereco')?></textarea>
											</div>
											<div class="col-md-6">
												<textarea name="responsavel[endereco_profissional][]" class="form-control"><?= $responsavel->get('profissao_endereco')?></textarea>
											</div>			
										</div>
										<div class="row form-group">
											<label class="col-md-4" for="nome">Tel. Residencial:</label>
											<label class="col-md-4" for="nome">Tel. Celular:</label>
											<label class="col-md-4" for="nome">Tel. Trabalho:</label>
											<div class="col-md-4">
												<input name="responsavel[tel_residencial][]" class="telefone form-control"  type="text" value="<?php echo $responsavel->get('tel_residencial')?>">
											</div>
											<div class="col-md-4">
												<input name="responsavel[tel_celular][]" class="telefone form-control"  type="text" value="<?php echo $responsavel->get('tel_celular')?>">
											</div>
											<div class="col-md-4">
												<input name="responsavel[tel_trabalho][]" class="telefone form-control"  type="text" value="<?php echo $responsavel->get('tel_trabalho')?>">
											</div>						
										</div>	      
								    </div>
								</div>							
							<?php endforeach;?>  							  							
  							</div>
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

<!--  Template de Responsável -->
<div class="panel panel-primary hidden" id="template-responsavel">
    <div class="panel-heading">
        Novo Responsável
        <button type="button" onclick="$(this).closest('.panel').remove()" class="btn btn-danger btn-xs pull-right glyphicon glyphicon-remove"></button>
    </div>
    <div class="panel-body">
    	<input type='hidden' name='responsavel[id][]' value="" />
    	<input type='hidden' name='responsavel[aluno_id][]' value="" />								        
            <div class="row form-group">
                <label class="col-md-8">Nome:</label>
                <label class="col-md-4">Tipo:</label>
                <div class="col-md-8">
                	<input required class="form-control" name="responsavel[nome][]" type="text" value="" onkeydown="$('.panel-heading', $(this).closest('.panel')).text(this.value?this.value:'Novo Responsável')">                    
                </div>
                <div class="col-md-4">
					<select name="responsavel[tipo][]" class="form-control" required>
						<option value="">Selecione um item...</option>
						<?= Config::makeOptions(['Pai','Mãe','Responsável'])?>
					</select>
				</div>
            </div> 
            <div class="row form-group">
				<label class="col-md-4" for="nome">Nascimento:</label>
				<label class="col-md-4" for="nome">RG:</label>
				<label class="col-md-4" for="nome">Naturalidade:</label>
				<div class="col-md-4">
					<input required name="responsavel[nascimento][]" class="form-control date"  type="text" value="">
			</div>
			<div class="col-md-4">
				<input required name="responsavel[rg][]" class="form-control"  type="text" value="">
			</div>
			<div class="col-md-4">
				<input name="responsavel[naturalidade][]" class="form-control"  type="text" value="">
				</div>	
			</div>
			<div class="row form-group"> 
				<label class="col-md-6">Escolaridade:</label>
				<label class="col-md-6">Profissão:</label>
                <div class="col-md-6">
					<select name="responsavel[escolaridade_id][]" class="form-control" required>
						<option value="">Selecione um item...</option>
						<?= Model::getOptions("escolaridade", "id", "descricao")?>
				</select>
			</div>
			<div class="col-md-6">
				<input name="responsavel[profissao][]" class="form-control"  type="text" value="">
			</div>
		</div>
		<div class="row form-group"> 
			<label class="col-md-6">Endereço Residencial:</label>
			<label class="col-md-6">Endereço Profissional:</label>
			<div class="col-md-6">
				<textarea name="responsavel[endereco_residencial][]" class="form-control" required></textarea>
			</div>
			<div class="col-md-6">
				<textarea name="responsavel[endereco_profissional][]" class="form-control"></textarea>
			</div>			
		</div>
		<div class="row form-group">
			<label class="col-md-4" for="nome">Tel. Residencial:</label>
			<label class="col-md-4" for="nome">Tel. Celular:</label>
			<label class="col-md-4" for="nome">Tel. Trabalho:</label>
			<div class="col-md-4">
				<input name="responsavel[tel_residencial][]" class="telefone form-control"  type="text" value="">
			</div>
			<div class="col-md-4">
				<input name="responsavel[tel_celular][]" class="telefone form-control"  type="text" value="">
			</div>
			<div class="col-md-4">
				<input name="responsavel[tel_trabalho][]" class="telefone form-control"  type="text" value="">
			</div>						
		</div>	      
    </div>
</div>

<script>
	$("#modal").modal("show").trigger('ajax.complete');
	
	$("#form").on("submit", function(event){
		event.preventDefault();
		if ($("#group-responsavel").children().length === 0){
			alert("Adicione ao menos um responsável");
			return false;
		}

		$("button[type='submit']", this).html("<i class='fa fa-spinner fa-pulse'></i> Carregando...").prop("disabled", true);
		$("input[type='submit']", this).val("Carregando...").prop("disabled", true);
			
		$.post(
			$(this).attr('action'),
			$(this).serialize(),
			function(){				
				location.reload(true);
			}
		);
		
		return false;		
	});
	
	$("#add-responsavel").click(function(){
		var $group = $("#group-responsavel");
		var len = $group.length + 1;		
		$template = $('#template-responsavel').clone().removeClass('hidden').attr('id', '');		

		$(".panel-collapse", $group).removeClass('in');
		$group.append($template).trigger("ajax.complete");
		
		$(".panel-collapse", $template).attr('id', "panel-responsavel"+len);
		$(".panel-toggler", $template).attr('href', "#panel-responsavel"+len);
		
	});
</script>
