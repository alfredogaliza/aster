<form action="<?= Controller::route("assistido", "gravar")?>" method="POST" class="" enctype="multipart/form-data">
	<input value="<?= $this->assistido->get('id')?>" name="id" type="hidden" />
	<div class="modal fade" id="modal" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Cadastro de Assistido</h4>
				</div>
				<div class="modal-body">
					<ul class="nav nav-tabs">
						<li class="active"><a id="nav-pessoal" href="#tab-pessoal" data-toggle="tab">Dados Pessoais</a></li>
						<li class=""><a id="nav-contato" href="#tab-contato" data-toggle="tab">Contato</a></li>
						<li class=""><a id="nav-tratamento" href="#tab-tratamento" data-toggle="tab">Tratamento</a></li>
						<li class=""><a id="nav-responsaveis" href="#tab-responsaveis" data-toggle="tab">Responsáveis</a></li>
						<li class=""><a id="nav-observacao" href="#tab-observacao" data-toggle="tab">Observações</a></li>
					</ul>
					<br>
					<div class="row form-group">
						<div class="col-md-12">
							<div class="tab-content">
								<div class="tab-pane fade in active" id="tab-pessoal">
									<div class="row form-group">
										<div class="col-md-12">
											<label class="required" class="required">Nome</label><br> <input name="nome" class="form-control" required type="text" value="<?= $this->assistido->get('nome')?>" />
										</div>
									</div>
									<div class="row form-group">
										<div class="col-md-2">
											<label class="required" class="required">Estado</label><br>
											<select id="sel-estado" class="form-control" required>
												<option value="">Selecione...</option>
												<?= Model::getOptions('cidade', 'DISTINCT estado', 'estado', $this->assistido->getCidade('estado'))?>
											</select>
										</div>
										<div class="col-md-10">
											<label class="required" class="required">Cidade</label><br>
											<select id="sel-cidade" name="cidade_id" class="form-control" required></select>
										</div>
									</div>
									<div class="row form-group">
										<div class="col-md-6">
											<label class="required">Nascimento</label><br> <input value="<?= $this->assistido->getDate('data_nascimento')?>" name="data_nascimento" class="form-control date" required type="text" />
										</div>
										<div class="col-md-6">
											<label class="required">Sexo</label><br> <select name="sexo" class="form-control" required>
												<option value="">Selecione uma opção</option>
												<option value="M" <?= ($this->assistido->get('sexo') == 'M')? 'selected' : ''?>>Masculino</option>
												<option value="F" <?= ($this->assistido->get('sexo') == 'F')? 'selected' : ''?>>Feminino</option>
											</select>
										</div>
									</div>									
									<div class="row form-group">
										<input class="hidden" id="upload_foto" name="upload_foto" type="file" accept="image/*"/>
										<input class="hidden" id="send_foto" name="send_foto" value="<?=$this->assistido->get('foto')? '1' : '0' ?>" />
										<label class="col-md-12">Foto:
											<span id="name_foto"><?= $this->assistido->get('foto', 'Nenhuma foto') ?></span>
										</label>																	
										<div class="col-md-3">
											<div class="row form-group">												
												<div class="col-md-12 form-group">																																			
													<button type="button" class="btn btn-info form-control" id="choose_foto">
														<i class="fa fa-upload"></i> Upload
													</button>
												</div>																																
												<div class="col-md-12 form-group">
													<button type="button" class="btn btn-danger form-control <?=$this->assistido->get('foto')? '' : 'hidden' ?>" id="delete_foto">
														<i class="fa fa-remove"></i> Excluir
													</button>				
												</div>
												<div class="col-md-12 form-group">							
													<a target="_blank" href="<?= Controller::route('assistido', 'foto', $this->assistido->get('id'))?>" class="btn btn-success form-control <?=$this->assistido->get('foto')? '' : 'hidden' ?>" id="download_foto">
														<i class="fa fa-download"></i> Download
													</a>
												</div>
											</div>
										</div>										
										<div class="col-md-9" id="show_foto">
											<img src="<?= $this->assistido->get('foto')? Controller::route('assistido', 'miniFoto', $this->assistido->get('id')) : ""?>" class="img-thumbnail" />
										</div>																
									</div>									
									<div class="row form-group">
										<div class="col-md-12">
											<label>
												<input type="checkbox" value="1" <?=$this->assistido->get('autorizado')? 'checked' : ''?> name='autorizado'>
												Autorizado o uso de imagem para divulgação.
											</label>																							
										</div>
									</div>																
									<div class="row form-group">
										<div class="col-md-12 text-right">
											<button type="button" class="btn btn-info" onclick="$('#nav-contato').click()">
												Avançar <i class="fa fa-forward"></i>
											</button>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="tab-contato">
									<div class="row form-group">
										<div class="col-md-12">
											<label class="required">Endereço Atual</label><br> <input value="<?= $this->assistido->get('endereco_atual')?>" name="endereco_atual" class="form-control" required type="text" />
										</div>
									</div>
									<div class="row form-group">
										<div class="col-md-12">
											<label class="required">Endereço Anterior</label><br> <input value="<?= $this->assistido->get('endereco_anterior')?>" name="endereco_anterior" class="form-control" required type="text" />
										</div>
									</div>
									<div class="row form-group">
										<div class="col-md-6">
											<label>Telefone</label><br> <input value="<?= $this->assistido->get('contato')?>" name="contato" class="form-control telefone" type="text" />
										</div>
										<div class="col-md-6">
											<label>Whatsapp</label><br> <input value="<?= $this->assistido->get('whatsapp')?>" name="whatsapp" class="form-control telefone" type="text" />
										</div>
									</div>
									<div class="row form-group">
										<div class="col-md-12">
											<label>Email</label><br> <input value="<?= $this->assistido->get('email')?>" name="email" class="form-control" type="email" />
										</div>
									</div>									
									<div class="row form-group">
										<div class="col-md-12 text-right">
											<button type="button" class="btn btn-info" onclick="$('#nav-pessoal').click()">
												<i class="fa fa-backward"></i> Voltar
											</button>
											<button type="button" class="btn btn-info" onclick="$('#nav-tratamento').click()">
												Avançar <i class="fa fa-forward"></i>
											</button>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="tab-tratamento">
									<div class="row form-group">
										<div class="col-md-6">
											<label>Data de Início</label>
											<input type="text" name="data_tratamento" value="<?= $this->assistido->getDate('data_tratamento') ?>" class="form-control date" />
										</div>
										<div class="col-md-6">
											<label>Data de Atualização</label>
											<input type="text" name="data_atualizacao" value="<?= $this->assistido->getDate('data_atualizacao') ?>" class="form-control" disabled />
										</div>
									</div>
									<div class="row form-group">
										<div class="col-md-6">
											<label>Diagnóstico</label><br> <input value="<?= $this->assistido->get('diagnostico')?>" name="diagnostico" class="form-control" type="text" />
										</div>
										<div class="col-md-6">
											<label class="required">Fase do Tratamento</label><br>
											<select required name="fase_tratamento" class="form-control">
												<option value="">Selecione uma opção...</option>
												<option value="1" <?= ($this->assistido->get('fase_tratamento') == Assistido::STATUS_INICIO)? 'selected' : ''?>>Início</option>
												<option value="2" <?= ($this->assistido->get('fase_tratamento') == Assistido::STATUS_TRATAMENTO)? 'selected' : ''?>>Em Tratamento</option>
												<option value="3" <?= ($this->assistido->get('fase_tratamento') == Assistido::STATUS_MANUTENCAO)? 'selected' : ''?>>Manutenção</option>
												<option value="4" <?= ($this->assistido->get('fase_tratamento') == Assistido::STATUS_RECAIDA)? 'selected' : ''?>>Recaída</option>
												<option value="5" <?= ($this->assistido->get('fase_tratamento') == Assistido::STATUS_CURA)? 'selected' : ''?>>Cura</option>
												<option value="6" <?= ($this->assistido->get('fase_tratamento') == Assistido::STATUS_INATIVO)? 'selected' : ''?>>Inativo</option>
											</select>
										</div>
									</div>
									<div class="row form-group">
										<div class="col-md-12 text-right">
											<button type="button" class="btn btn-info" onclick="$('#nav-contato').click()">
												<i class="fa fa-backward"></i> Voltar
											</button>
											<button type="button" class="btn btn-info" onclick="$('#nav-responsaveis').click()">
												Avançar <i class="fa fa-forward"></i>
											</button>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="tab-responsaveis">
									<div class="row form-group">
										<div class="col-md-12">
											<button type="button" class="btn btn-success form-control" id="responsavel-add">
												<i class="fa fa-plus"></i> Adicionar Responsável
											</button>
										</div>
									</div>
									<div class="row form-group">
										<div class="col-md-12" id="responsaveis">
											<?php foreach ($this->responsaveis as $responsavel): ?>										
											<div class="panel panel-primary panel-responsavel">
												<div class="panel-heading text-right">
													<span class="responsavel-nome pull-left"><?= $responsavel->get('nome')?></span>
													<span class="responsavel-delete">
														<a class="btn btn-danger" href="#">
															<i class="fa fa-remove"></i>
														</a>
													</span>
												</div>
												<div class="panel-body">
													<input type="hidden" name="responsavel_id[]" value="<?= $responsavel->get('id')?>" class="form-control">
													<div class="row form-group">
														<div class="col-md-6">
															<label class="required">Nome</label>
															<input type="text" name="responsavel_nome[]" value="<?= $responsavel->get('nome')?>" class="form-control">
														</div>
														<div class="col-md-6">
															<label class="required">Parentesco</label>
															<input type="text" name="responsavel_parentesco[]" value="<?= $responsavel->get('parentesco')?>" class="form-control">
														</div>
													</div>
													<div class="row form-group">
														<div class="col-md-12">
															<label class="required">Endereço</label>
															<input name="responsavel_endereco[]" value="<?= $responsavel->get('endereco')?>" class="form-control">
														</div>
													</div>
													<div class="row form-group">
														<div class="col-md-6">
															<label>Telefone</label><br> <input value="<?= $responsavel->get('contato')?>" name="responsavel_contato[]" class="form-control telefone" type="text" />
														</div>
														<div class="col-md-6">
															<label>Whatsapp</label><br> <input value="<?= $responsavel->get('whatsapp')?>" name="responsavel_whatsapp[]" class="form-control telefone" type="text" />
														</div>
													</div>
													<div class="row form-group">
														<div class="col-md-12">
															<label>Email</label>
															<input type="text" name="responsavel_email[]" value="<?= $responsavel->get('email')?>" class="form-control">
														</div>
													</div>
												</div>
											</div>
											<?php endforeach;?>
										</div>
									</div>
									<div class="row form-group">
										<div class="col-md-12 text-right">
											<button type="button" class="btn btn-info" onclick="$('#nav-tratamento').click()">
												<i class="fa fa-backward"></i> Voltar
											</button>
											<button type="button" class="btn btn-info" onclick="$('#nav-observacao').click()">
												Avançar <i class="fa fa-forward"></i>
											</button>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="tab-observacao">
									<div class="row form-group">
										<div class="col-md-12">
											<textarea name="observacao" class="form-control tinymce"><?= $this->assistido->get('observacao')?></textarea>
										</div>
									</div>
									<div class="row form-group">
										<div class="col-md-12 text-right">
											<button type="button" class="btn btn-info" onclick="$('#nav-responsaveis').click()">
												<i class="fa fa-backward"></i> Voltar
											</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer text-right">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn btn-primary">
						<i class="fa fa-send"></i> Enviar dados
					</button>
				</div>
			</div>
		</div>
	</div>
</form>

<div class="panel panel-primary panel-responsavel hidden" id="responsavel-template">
	<div class="panel-heading text-right">
		<span class="responsavel-nome pull-left">Nome do Responsável</span>
		<span class="responsavel-delete">
			<a class="btn btn-danger" href="#">
				<i class="fa fa-remove"></i>
			</a>
		</span>
	</div>
	<div class="panel-body">
		<input type="hidden" name="responsavel_id[]" value="" class="form-control">
		<div class="row form-group">
			<div class="col-md-6">
				<label class="required">Nome</label>
				<input required type="text" name="responsavel_nome[]" value="" class="form-control">
			</div>
			<div class="col-md-6">
				<label class="required">Parentesco</label>
				<input required type="text" name="responsavel_parentesco[]" value="" class="form-control">
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-12">
				<label class="required">Endereço</label>
				<input required name="responsavel_endereco[]" value="" class="form-control">
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-6">
				<label>Telefone</label><br> <input value="" name="responsavel_contato[]" class="form-control telefone" type="text" />
			</div>
			<div class="col-md-6">
				<label>Whatsapp</label><br> <input value="" name="responsavel_whatsapp[]" class="form-control telefone" type="text" />
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-12">
				<label>Email</label>
				<input type="email" name="responsavel_email[]" value="" class="form-control">
			</div>
		</div>
	</div>
</div>


<script>

	$("#responsavel-add").click(function(){
		var $clone = $("#responsavel-template").clone();
		$clone.attr('id', '').appendTo('#responsaveis').removeClass('hidden');
		$clone.trigger('ajax.complete');
	});

	$("#sel-estado").change(function(){
		var estado = $(':selected', this).val();
		$("#sel-cidade").load(
				"<?= Controller::route('assistido', 'cidade') ?>/?estado="+
				estado+"&cidade_id=<?= $this->assistido->get('cidade_id')?>",
				function(){
					$(this).prepend("<option value=''>Selecione uma cidade</option>"); 
				});
	}).change();

	$("#modal").on('click','.responsavel-delete', function(e){
		e.stopImmediatePropagation();
		var $panel = $(this).parents('.panel-responsavel');
		if (confirm('Não será possível recuperar um responsável após a exclusão. Deseja continuar?'))
			$panel.remove();
	});

	$("#modal").on('keyup',"[name='responsavel_nome[]']", function(){
		var $panel = $(this).parents('.panel-responsavel');
		var $title = $('.responsavel-nome', $panel);
		var txt = $(this).val();
		if (txt != ''){
			$title.text(txt);
		} else {
			$title.text('Responsável');
		}
	});

	$("#modal").on('click','.panel-responsavel .panel-heading', function(){
		var $panel = $(this).parents('.panel-responsavel');
		var $body = $('.panel-body', $panel);
		$body.slideToggle(); 
	});

	$("#modal").on('hidden.bs.modal', function(){
		tinymce.remove();
	});

	$("#upload_foto").change(function(event){		
		if ($(this).val() != "") {
			$("#send_foto").attr('value', 1);
			$("#name_foto").text(/[^\\]*$/g.exec($(this).val())[0]);
			$("#show_foto img").attr('src', URL.createObjectURL(event.target.files[0]));
			$("#delete_foto,#show_foto").removeClass('hidden');
		}
		else {
			$("#send_foto").attr('value', 0);
			$("#name_foto").text('Nenhuma foto');			
			$("#delete_foto,#show_foto").addClass('hidden');
		}
	});

	$("#delete_foto").click(function(){
		$("#send_foto").attr('value', 0);
		$("#name_foto").text('Nenhuma foto');
		$("#delete_foto,#download_foto,#show_foto").addClass('hidden');
	});

	$("#choose_foto").click(function(){
		$("#upload_foto").click();
	});

	tinymce.init({
		  selector: '.tinymce',
		  language: 'pt_BR'
	});

	$("#modal").modal("show").trigger('ajax.complete');
</script>