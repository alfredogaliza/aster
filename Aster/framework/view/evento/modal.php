<form action="<?= Controller::route("evento", "gravar")?>" method="POST" class="form-async">
	<input value="<?= $this->evento->get('id')?>" name="id" type="hidden" />
	<div class="modal fade" id="modal" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Cadastro de Evento</h4>
				</div>
				<div class="modal-body">
					<ul class="nav nav-tabs">
						<li class="active"><a id="nav-geral" href="#tab-geral" data-toggle="tab">Dados Gerais</a></li>
						<li class=""><a id="nav-tarefas" href="#tab-tarefas" data-toggle="tab">Tarefas</a></li>
						<li class=""><a id="nav-assistencias" href="#tab-assistencias" data-toggle="tab">Assistências</a></li>
					</ul>
					<br>
					<div class="row form-group">
						<div class="col-md-12">
							<div class="tab-content">
								<div class="tab-pane fade in active" id="tab-geral">
									<div class="row form-group">
										<div class="col-md-12">
											<label class="required" class="required">Nome</label><br> <input name="nome" class="form-control" required type="text" value="<?= $this->evento->get('nome')?>" />
										</div>
									</div>
									<div class="row form-group">
										<div class="col-md-12">
											<label class="required" class="required">Ação</label><br> <select name="acao_id" class="form-control" required>
												<option value="">Selecione uma ação...</option>
												<?= Model::getOptions('acao', 'id', 'nome', $this->evento->get('acao_id'))?>
											</select>
										</div>
									</div>
									<div class="row form-group">
										<div class="col-md-6">
											<label class="required">Início</label><br> <input value="<?= $this->evento->getDate('data_inicio')?>" name="data_inicio" class="form-control datetime" required type="text" />
										</div>
										<div class="col-md-6">
											<label class="required">Fim</label><br> <input value="<?= $this->evento->getDate('data_fim')?>" name="data_fim" class="form-control datetime" required type="text" />
										</div>
									</div>
									<div class="row form-group">
										<div class="col-md-12">
											<label>Descrição</label>
											<textarea class="form-control tinymce" name="descricao"><?= $this->evento->get('descricao')?></textarea>
										</div>
									</div>
									<div class="row form-group">
										<div class="col-md-12 text-right">
											<button type="button" class="btn btn-info" onclick="$('#nav-tarefas').click()">
												Avançar <i class="fa fa-forward"></i>
											</button>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="tab-tarefas">
									<div class="row form-group">
										<div class="col-md-12">
											<button type="button" class="btn btn-success form-control" id="tarefa-add">
												<i class="fa fa-plus"></i> Adicionar Tarefa
											</button>
										</div>
									</div>
									<div class="row form-group">
										<div class="col-md-12" id="tarefas">
											<?php foreach ($this->tarefas as $tarefa): ?>										
											<div class="panel panel-tarefa <?= $tarefa->getStatusPanelClass()?>">
												<div class="panel-heading">
													<span class="tarefa-nome"><?= $tarefa->get('nome')?></span>
													<?php if ($tarefa->getStatus() == Tarefa::STATUS_ABERTA): ?>
													<span class="tarefa-delete pull-right"> <a class="btn btn-danger" href="#"> <i class="fa fa-remove"></i></a>
													</span>
													<?php endif;?>
												</div>
												<div class="panel-body">
													<input type="hidden" name="tarefa_id[]" value="<?= $tarefa->get('id')?>" class="form-control">
													<div class="row form-group">
														<div class="col-md-12">
															<label class="required">Nome</label> <input type="text" name="tarefa_nome[]" value="<?= $tarefa->get('nome')?>" class="form-control">
														</div>
													</div>
													<div class="row form-group">
														<div class="col-md-4">
															<label class="required">Fechamento</label><br>
															<input value="<?= $tarefa->getDate('data_fechamento')?>" name="tarefa_data_fechamento[]" class="form-control date" required type="text" />
														</div>
														<div class="col-md-4">
															<label>Agendada para</label><br> <input value="<?= $tarefa->getDate('data_agendada')?>" name="tarefa_data_agendada[]" class="form-control date" type="text" />
														</div>
														<div class="col-md-4">
															<label>Máx. Atribuições</label> <input type="number" name="tarefa_max_atribuicoes[]" value="<?= $tarefa->get('max_atribuicoes')?>" class="form-control">
														</div>
													</div>
													<div class="row form-group">
														<div class="col-md-12">
															<label>Descrição</label>
															<textarea type="text" class="form-control" name="tarefa_descricao[]"><?= $tarefa->get('descricao')?></textarea>
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
											<button type="button" class="btn btn-info" onclick="$('#nav-assistencias').click()">
												Avançar <i class="fa fa-forward"></i>
											</button>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="tab-assistencias">
									<div class="row form-group">
										<div class="col-md-12">
											<button type="button" class="btn btn-success form-control" id="assistencia-add">
												<i class="fa fa-plus"></i> Adicionar Assistência
											</button>
										</div>
									</div>
									<div class="row form-group">
										<div class="col-md-12" id="assistencias">
											<?php foreach ($this->assistencias as $assistencia): ?>										
											<div class="panel panel-primary <?= $assistencia->getStatusPanelClass()?> panel-assistencia">
												<div class="panel-heading">
													<span class="assistencia-nome"><?= $assistencia->getAssistido('nome')?></span>
													<?php if ($assistencia->getStatus() == Assistencia::STATUS_ABERTA): ?>
													<span class="assistencia-delete pull-right">
														<a class="btn btn-danger" href="#"> <i class="fa fa-remove"></i></a>
													</span>
													<?php endif; ?>
												</div>
												<div class="panel-body">
													<input type="hidden" name="assistencia_id[]" value="<?= $assistencia->get('id')?>" class="form-control">
													<div class="row form-group">
														<div class="col-md-12">
															<label class="required">Assistido</label> <select name="assistencia_assistido_id[]" class="form-control">
																<option value="">Selecione um assistido</option>
																<?= Model::getOptions('assistido', 'id', 'nome', $assistencia->get('assistido_id'))?>
															</select>
														</div>
													</div>
													<div class="row form-group">
														<div class="col-md-12">
															<label>Descrição</label><br> <input value="<?= $assistencia->get('descricao')?>" name="assistencia_descricao[]" class="form-control" type="text" />
														</div>
													</div>
													<div class="row form-group">
														<div class="col-md-12">
															<label class="required">Concluída</label>
															<select name="assistencia_concluida[]" class="form-control" required>
																<option value="">Selecione uma opção</option>
																<option value="1" <?= $assistencia->get('concluida')? 'selected' : ''?>>Sim</option>
																<option value="0" <?= $assistencia->get('concluida')? '' : 'selected'?>>Não</option>
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
											<button type="button" class="btn btn-info" onclick="$('#nav-tarefas').click()">
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

<?php $tarefa = new Tarefa(); ?>
<div class="panel <?= $tarefa->getStatusPanelClass()?> panel-tarefa hidden" id="tarefa-template">
	<div class="panel-heading">
		<span class="tarefa-nome">Nova Tarefa</span>
		<?php if ($tarefa->getStatus() == Tarefa::STATUS_ABERTA): ?>
		<span class="tarefa-delete pull-right"> <a class="btn btn-danger" href="#"> <i class="fa fa-remove"></i></a>
		</span>
		<?php endif;?>
	</div>
	<div class="panel-body">
		<input type="hidden" name="tarefa_id[]" value="<?= $tarefa->get('id')?>" class="form-control">
		<div class="row form-group">
			<div class="col-md-12">
				<label class="required">Nome</label> <input type="text" name="tarefa_nome[]" value="<?= $tarefa->get('nome')?>" class="form-control">
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-4">
				<label class="required">Fechamento</label><br>
				<input value="<?= $tarefa->getDate('data_fechamento')?>" name="tarefa_data_fechamento[]" class="form-control date" required type="text" />
			</div>
			<div class="col-md-4">
				<label>Agendada para</label><br> <input value="<?= $tarefa->getDate('data_agendada')?>" name="tarefa_data_agendada[]" class="form-control date" type="text" />
			</div>
			<div class="col-md-4">
				<label>Máx. Atribuições</label> <input type="number" name="tarefa_max_atribuicoes[]" value="<?= $tarefa->get('max_atribuicoes')?>" class="form-control">
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-12">
				<label>Descrição</label>
				<textarea type="text" class="form-control" name="tarefa_descricao[]"><?= $tarefa->get('descricao')?></textarea>
			</div>
		</div>
	</div>
</div>

<?php $assistencia = new Assistencia(); ?>
<div class="panel panel-assistencia <?= $assistencia->getStatusPanelClass()?> hidden" id="assistencia-template">
	<div class="panel-heading">
		<span class="assistencia-nome">Nova Assistência</span>
		<?php if ($assistencia->getStatus() == Assistencia::STATUS_ABERTA): ?>
		<span class="assistencia-delete pull-right">
			<a class="btn btn-danger" href="#"> <i class="fa fa-remove"></i></a>
		</span>
		<?php endif; ?>
	</div>
	<div class="panel-body">
		<input type="hidden" name="assistencia_id[]" value="<?= $assistencia->get('id')?>" class="form-control">
		<div class="row form-group">
			<div class="col-md-12">
				<label class="required">Assistido</label> <select name="assistencia_assistido_id[]" class="form-control">
					<option value="">Selecione um assistido</option>
																<?= Model::getOptions('assistido', 'id', 'nome', $assistencia->get('assistido_id'))?>
															</select>
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-12">
				<label>Descrição</label><br> <input value="<?= $assistencia->get('descricao')?>" name="assistencia_descricao[]" class="form-control" type="text" />
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-12">
				<label class="required">Concluída</label>
				<select name="assistencia_concluida[]" class="form-control" required>
					<option value="">Selecione uma opção</option>
					<option value="1" <?= $assistencia->get('concluida')? 'selected' : ''?>>Sim</option>
					<option value="0" <?= $assistencia->get('concluida')? '' : 'selected'?>>Não</option>
				</select>
			</div>
		</div>
	</div>
</div>

<script>

	var count = 0;

	$("#tarefa-add").click(function(){
		var $container = $("#tarefas");
		var $clone = $("#tarefa-template").clone();
		$(".panel-body", $container).slideUp();
		$clone.attr('id', '').appendTo($container).removeClass('hidden');
		$clone.trigger('ajax.complete');

		id = 'tinymce-'+(count++); 
		$(".tinymce", $clone).attr('id', id);		
		tinymce.EditorManager.execCommand('mceAddEditor', true, "#"+id);
					
	});

	$("#assistencia-add").click(function(){
		var $container = $("#assistencias");
		var $clone = $("#assistencia-template").clone();
		$(".panel-body", $container).slideUp();
		$clone.attr('id', '').appendTo($container).removeClass('hidden');
		$clone.trigger('ajax.complete');

		id = 'tinymce-'+(count++); 
		$(".tinymce", $clone).attr('id', id);		
		tinymce.EditorManager.execCommand('mceAddEditor', true, "#"+id);
	});

	$("#modal").on('click','.tarefa-delete', function(e){
		e.stopImmediatePropagation();
		var $panel = $(this).parents('.panel-tarefa');
		if (confirm('Não será possível recuperar uma tarefa após a exclusão. Deseja continuar?'))
			$panel.remove();
	});
	$("#modal").on('click','.assistencia-delete', function(e){
		e.stopImmediatePropagation();
		var $panel = $(this).parents('.panel-assistencia');
		if (confirm('Não será possível recuperar uma assistência após a exclusão. Deseja continuar?'))
			$panel.remove();
	});

	$("#modal").on('keyup',"[name='tarefa_nome[]']", function(){
		var $panel = $(this).parents('.panel-tarefa');
		var $title = $('.tarefa-nome', $panel);
		var txt = $(this).val();
		if (txt != ''){
			$title.text(txt);
		} else {
			$title.text('Nova Tarefa');
		}
	});

	$("#modal").on('change',"[name='assistencia_assistido_id[]']", function(){
		var $panel = $(this).parents('.panel-assistencia');
		var $title = $('.assistencia-nome', $panel);
		var txt = $(':selected', this).text();
		console.log(this)
		if (txt != ''){
			$title.text(txt);
		} else {
			$title.text('Nova Assistência');
		}
	});

	$("#modal").on('click','.panel-tarefa .panel-heading', function(){
		var $panel = $(this).parents('.panel-tarefa');
		var $body = $('.panel-body', $panel);
		$body.slideToggle(); 
	});

	$("#modal").on('click','.panel-assistencia .panel-heading', function(){
		var $panel = $(this).parents('.panel-assistencia');
		var $body = $('.panel-body', $panel);
		$body.slideToggle(); 
	});

	$("#modal").on('change', "[name='assistencia_concluida[]']", function(){
		$panel = $(this).parents('.panel');
		if ($(':selected', this).val() == '1')
			$panel.removeClass('panel-warning').addClass('panel-success');
		else
			$panel.removeClass('panel-success').addClass('panel-warning');
	});

	$("#modal").modal("show").trigger('ajax.complete');

	$("#modal").on('hidden.bs.modal', function(){
		tinymce.remove();
	});

	$("#tarefas .panel-body").slideUp(0);
	$("#assistencias .panel-body").slideUp(0);

	tinymce.init({
		  selector: '.tinymce',
		  language: 'pt_BR'
	});	
</script>