<form action="<?= Controller::route("tarefa", "gravar")?>" method="POST" class="form-async">
	<input value="<?= $this->tarefa->get('id')?>" name="id" type="hidden" />
	<div class="modal fade" id="modal" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Cadastro de Tarefa</h4>
				</div>
				<div class="modal-body">
					<ul class="nav nav-tabs">
						<li class="active"><a id="nav-geral" href="#tab-geral" data-toggle="tab">Dados Gerais</a></li>
						<li class=""><a id="nav-atribuicoes" href="#tab-atribuicoes" data-toggle="tab">Atribuições</a></li>
					</ul>
					<br>
					<div class="row form-group">
						<div class="col-md-12">
							<div class="tab-content">
								<div class="tab-pane fade in active" id="tab-geral">
									<div class="row form-group">
										<div class="col-md-12">
											<label class="required" class="required">Nome</label><br> <input name="nome" class="form-control" required type="text" value="<?= $this->tarefa->get('nome')?>" />
										</div>
									</div>
									<div class="row form-group">
										<div class="col-md-12">
											<label class="required" class="required">Evento</label><br>
											<span class="form-control"><?= $this->tarefa->getEvento('nome')?></span>
											</select>
										</div>
									</div>
									<div class="row form-group">
										<div class="col-md-4">
											<label class="required">Início</label><br> <input value="<?= $this->tarefa->getDate('data_inicio')?>" name="data_inicio" class="form-control datetime" required type="text" />
										</div>
										<div class="col-md-4">
											<label class="required">Fim</label><br> <input value="<?= $this->tarefa->getDate('data_fim')?>" name="data_fim" class="form-control datetime" required type="text" />
										</div>
										<div class="col-md-4">
											<label>Máx. Atribuições</label><br>
											<input name="max_atribuicoes" class="form-control"  type="number" value="<?= $this->tarefa->get('max_atribuicoes')?>" />
										</div>
									</div>
									<div class="row form-group">
										<div class="col-md-12">
											<label>Descrição</label>
											<textarea class="form-control" name="descricao"><?= $this->tarefa->get('descricao')?></textarea>
										</div>
									</div>
									<div class="row form-group">
										<div class="col-md-12 text-right">
											<button type="button" class="btn btn-info" onclick="$('#nav-atribuicoes').click()">
												Avançar <i class="fa fa-forward"></i>
											</button>
										</div>
									</div>
								</div>								
								<div class="tab-pane fade" id="tab-atribuicoes">
									<div class="row form-group">
										<div class="col-md-12">
											<button type="button" class="btn btn-success form-control" id="atribuicao-add">
												<i class="fa fa-plus"></i> Adicionar Atribuição
											</button>
										</div>
									</div>
									<div class="row form-group">
										<div class="col-md-12" id="atribuicoes">
											<?php foreach ($this->atribuicoes as $atribuicao): ?>										
											<div class="panel <?= $atribuicao->getStatusPanelClass()?> panel-atribuicao">
												<div class="panel-heading">
													<span class="atribuicao-nome"><?= $atribuicao->getVoluntario('nome')?></span>
													<?php if ($atribuicao->getStatus() == Atribuicao::STATUS_ANDAMENTO): ?>
													<span class="atribuicao-delete pull-right">
														<a class="btn btn-danger" href="#"> <i class="fa fa-remove"></i></a>
													</span>
													<?php endif; ?>
												</div>
												<div class="panel-body">
													<input type="hidden" name="atribuicao_id[]" value="<?= $atribuicao->get('id')?>" class="form-control">
													<div class="row form-group">
														<div class="col-md-12">
															<label class="required">Voluntário</label> <select required name="atribuicao_voluntario_id[]" class="form-control">
																<option value="">Selecione um voluntário</option>
																<?= Model::getOptions('voluntario', 'id', 'nome', $atribuicao->get('voluntario_id'))?>
															</select>
														</div>
													</div>													
													<div class="row form-group">
														<div class="col-md-12">
															<label class="required">Concluída</label>
															<select name="atribuicao_concluida[]" class="form-control" required>
																<option value="">Selecione uma opção</option>
																<option value="1" <?= $atribuicao->get('concluida')? 'selected' : ''?>>Sim</option>
																<option value="0" <?= $atribuicao->get('concluida')? '' : 'selected'?>>Não</option>
															</select>
														</div>
													</div>
												</div>
											</div>
											<?php endforeach;?>
										</div>
									</div>
									<div class="row form-group">
										<div class="col-md-12 text-right">
											<button type="button" class="btn btn-info" onclick="$('#nav-geral').click()">
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

<?php $atribuicao = new Atribuicao(); ?>
<div class="panel <?= $atribuicao->getStatusPanelClass()?> panel-atribuicao hidden" id="atribuicao-template">
	<div class="panel-heading">
		<span class="atribuicao-nome">Nova Atribuição</span>
		<?php if ($atribuicao->getStatus() == Atribuicao::STATUS_ANDAMENTO): ?>
		<span class="atribuicao-delete pull-right">
			<a class="btn btn-danger" href="#"> <i class="fa fa-remove"></i></a>
		</span>
		<?php endif; ?>
	</div>
	<div class="panel-body">
		<input type="hidden" name="atribuicao_id[]" value="<?= $atribuicao->get('id')?>" class="form-control">
		<div class="row form-group">
			<div class="col-md-12">
				<label class="required">Voluntário</label> <select required name="atribuicao_voluntario_id[]" class="form-control">
					<option value="">Selecione um voluntário</option>
					<?= Model::getOptions('voluntario', 'id', 'nome', $atribuicao->get('voluntario_id'))?>
				</select>
			</div>
		</div>													
		<div class="row form-group">
			<div class="col-md-12">
				<label class="required">Concluída</label>
				<select name="atribuicao_concluida[]" class="form-control" required>
					<option value="">Selecione uma opção</option>
					<option value="1" <?= $atribuicao->get('concluida')? 'selected' : ''?>>Sim</option>
					<option value="0" <?= $atribuicao->get('concluida')? '' : 'selected'?>>Não</option>
				</select>
			</div>
		</div>
	</div>
</div>

<script>	

	$("#atribuicao-add").click(function(){
		var $container = $("#atribuicoes");
		var $clone = $("#atribuicao-template").clone();
		$(".panel-body", $container).slideUp();
		$clone.attr('id', '').appendTo($container).removeClass('hidden');
		$clone.trigger('ajax.complete');
	});

	$("#modal").on('click','.atribuicao-delete', function(e){
		e.stopImmediatePropagation();
		var $panel = $(this).parents('.panel-atribuicao');
		if (confirm('Não será possível recuperar uma atribuicao após a exclusão. Deseja continuar?'))
			$panel.remove();
	});

	$("#modal").on('change',"[name='atribuicao_voluntario_id[]']", function(){
		var $panel = $(this).parents('.panel-atribuicao');
		var $title = $('.atribuicao-nome', $panel);
		var txt = $(":selected", this).text();
		if (txt != ''){
			$title.text(txt);
		} else {
			$title.text('Nova Atribuição');
		}
	});

	$("#modal").on('click','.panel-atribuicao .panel-heading', function(){
		var $panel = $(this).parents('.panel-atribuicao');
		var $body = $('.panel-body', $panel);
		$body.slideToggle(); 
	});

	$("#modal").on('change', "[name='atribuicao_concluida[]']", function(){
		$panel = $(this).parents('.panel');		
		if ($(this).val() == "1")
			$panel.removeClass('panel-warning').addClass('panel-success');
		else
			$panel.removeClass('panel-success').addClass('panel-warning');
	});

	$("#modal").modal("show").trigger('ajax.complete');

	$("#atribuicoes .panel-body").slideUp(0);

</script>