<form novalidate action="<?= Controller::route("voluntario", "gravar")?>" method="POST" class="form-async">
	<input value="<?= $this->voluntario->get('id')?>" name="id" type="hidden" />
	<div class="modal fade" id="modal" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Cadastro de Voluntário</h4>
				</div>
				<div class="modal-body">
					<ul class="nav nav-tabs">
						<li class="active"><a id="nav-pessoal" href="#tab-pessoal" data-toggle="tab">Dados Pessoais</a></li>
						<li class=""><a id="nav-contato" href="#tab-contato" data-toggle="tab">Contato</a></li>
						<li class=""><a id="nav-interesse" href="#tab-interesse" data-toggle="tab">Ações de Interesse</a></li>
					</ul>
					<br>
					<div class="row form-group">
						<div class="col-md-12">
							<div class="tab-content">
								<div class="tab-pane fade in active" id="tab-pessoal">
									<div class="row form-group">
										<div class="col-md-12">
											<label class="required" class="required">Nome</label><br> <input name="nome" class="form-control" required type="text" value="<?= $this->voluntario->get('nome')?>" />
										</div>
									</div>
									<div class="row form-group">
										<div class="col-md-12">
											<label class="required" class="required">Perfil</label><br>
											<select name="perfil_id" class="form-control" required>
												<option value="">Selecione um perfil...</option>
												<?= Model::getOptions('perfil', 'id', 'descricao', $this->voluntario->get('perfil_id'))?>
											</select>
										</div>
									</div>
									<div class="row form-group">
										<div class="col-md-6">
											<label class="required">Nascimento</label><br> <input value="<?= $this->voluntario->getDate('data_nascimento')?>" name="data_nascimento" class="form-control date" required type="text" />
										</div>
										<div class="col-md-6">
											<label class="required">Sexo</label><br> <select name="sexo" class="form-control" required>
												<option value="">Selecione uma opção</option>
												<option value="M" <?= ($this->voluntario->get('sexo') == 'M')? 'selected' : ''?>>Masculino</option>
												<option value="F" <?= ($this->voluntario->get('sexo') == 'F')? 'selected' : ''?>>Feminino</option>
											</select>
										</div>
									</div>
									<div class="row form-group">
										<div class="col-md-6">
											<label class="required">CPF</label><br> <input value="<?= $this->voluntario->get('cpf')?>" name="cpf" class="cpf form-control" required type="text" />
										</div>
										<div class="col-md-6">
											<label class="required">Tipo Sanguíneo</label><br> <select name="tipo_sanguineo" class="form-control" required>
												<option value="">Selecione uma opção</option>
												<option <?= ($this->voluntario->get('tipo_sanguineo') == 'NS')? 'selected' : ''?> value="NS">Não sabe</option>
												<option <?= ($this->voluntario->get('tipo_sanguineo') == 'A+')? 'selected' : ''?>>A+</option>
												<option <?= ($this->voluntario->get('tipo_sanguineo') == 'B+')? 'selected' : ''?>>B+</option>
												<option <?= ($this->voluntario->get('tipo_sanguineo') == 'AB+')? 'selected' : ''?>>AB+</option>
												<option <?= ($this->voluntario->get('tipo_sanguineo') == 'O+')? 'selected' : ''?>>O+</option>
												<option <?= ($this->voluntario->get('tipo_sanguineo') == 'A-')? 'selected' : ''?>>A-</option>
												<option <?= ($this->voluntario->get('tipo_sanguineo') == 'B-')? 'selected' : ''?>>B-</option>
												<option <?= ($this->voluntario->get('tipo_sanguineo') == 'AB-')? 'selected' : ''?>>AB-</option>
												<option <?= ($this->voluntario->get('tipo_sanguineo') == 'O-')? 'selected' : ''?>>O-</option>
											</select>
										</div>
									</div>
									<div class="row form-group">
										<div class="col-md-6">
											<label class="required">Doador de Sangue?</label><br> <select name="doador_sangue" class="form-control" required>
												<option value="">Selecione uma opção</option>
												<option value="1" <?= ($this->voluntario->get('doador_sangue') == '1')? 'selected' : ''?>>Sim</option>
												<option value="0" <?= ($this->voluntario->get('doador_sangue') === "0")? 'selected' : ''?>>Não</option>
											</select>
										</div>
										<div class="col-md-6">
											<label class="required">Doador de Medula?</label><br> <select name="doador_medula" class="form-control" required>
												<option value="">Selecione uma opção</option>
												<option value="1" <?= ($this->voluntario->get('doador_medula') == '1')? 'selected' : ''?>>Sim</option>
												<option value="0" <?= ($this->voluntario->get('doador_medula') === "0")? 'selected' : ''?>>Não</option>
											</select>
										</div>
									</div>
									<div class="row form-group">
										<div class="col-md-12">
											<label>Formação / Habilidade</label><br> <input value="<?= $this->voluntario->get('formacao')?>" name="formacao" class="form-control" type="text" />
										</div>
									</div>
									<?php if ($this->voluntario->get('evento_id')):?>
									<div class="row form-group">
										<div class="col-md-12">
											<label>Evento de Efetivação</label><br>
											<?= $this->voluntario->getEvento()->get('nome')?> (<?= $this->voluntario->getEvento()->getDate('data_inicio')?>)
										</div>
									</div>
									<?php endif;?>
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
											<label class="required">Endereço Completo</label><br> <input value="<?= $this->voluntario->get('endereco')?>" name="endereco" class="form-control" required type="text" />
										</div>
									</div>
									<div class="row form-group">
										<div class="col-md-6">
											<label>Telefone</label><br> <input value="<?= $this->voluntario->get('contato')?>" name="contato" class="form-control telefone" type="text" />
										</div>
										<div class="col-md-6">
											<label>Whatsapp</label><br> <input value="<?= $this->voluntario->get('whatsapp')?>" name="whatsapp" class="form-control telefone" type="text" />
										</div>
									</div>

									<div class="row form-group">
										<div class="col-md-12">
											<label class="required">Email</label><br> <input value="<?= $this->voluntario->get('email')?>" name="email" class="form-control" type="email" required />
										</div>
									</div>									
									<div class="row form-group">
										<div class="col-md-12 text-right">
											<button type="button" class="btn btn-info" onclick="$('#nav-pessoal').click()">
												<i class="fa fa-backward"></i> Voltar
											</button>
											<button type="button" class="btn btn-info" onclick="$('#nav-interesse').click()">
												Avançar <i class="fa fa-forward"></i>
											</button>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="tab-interesse">
									<div class="row form-group">
										<div class="col-md-12">
											<p class="text-right">
												<label><input type="checkbox" onclick="$('.cb-interesse').prop('checked', $(this).prop('checked'))"> Selecionar Todos</label>
											</p>
											<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true" style="height: 300px; overflow-y: scroll">
												<?php foreach (Model::getAll('acao') as $i => $acao):?>
												<div class="panel panel-default">
													<div class="panel-heading" role="tab" id="titulo-acao-<?= $acao->get('id') ?>">
														<h4 class="panel-title <?= $acao->get('obrigatorio')? 'required' : '' ?>">
															<input type="checkbox" class="cb-interesse" name="acao_id[]" value="<?= $acao->get('id') ?>" <?= ($this->voluntario->hasAcao($acao->get('id'), false) || $acao->get('obrigatorio'))? 'checked' : ''?> <?= $acao->get('obrigatorio')? 'onclick="return false;"' : '' ?>>																									
																<?= $acao->get('nome')?>
															</a>
														</h4>
													</div>
													<div id="acao-<?= $acao->get('id') ?>" class="panel-collapse collapse <?= !$i? 'in' : ''?>" role="tabpanel" aria-labelledby="titulo-acao-<?= $acao->get('id') ?>">
														<div class="panel-body">
															<?= $acao->get('descricao') ?>											
														</div>
													</div>
												</div>
												<?php endforeach;?>
											</div>
										</div>
									</div>
									<div class="row form-group">
										<div class="col-md-12 text-right">
											<button type="button" class="btn btn-info" onclick="$('#nav-contato').click()">
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
<script>
	$("#modal").modal("show").trigger('ajax.complete');
</script>