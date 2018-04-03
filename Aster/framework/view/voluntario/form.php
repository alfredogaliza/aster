<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>	
	<?php View::includeView("html/head"); ?>
	<script>
	$(document).ready(function(){
		$("form").submit(function(){
			var email1 = $("[name='email1']").val();
			var email2 = $("[name='email2']").val();
			var acoes = $("[name='acao_id[]']:checked").length;
	
			if (email1 != email2){
				alert("Os emails não coincidem!");
				return false;
			} else if (acoes == 0) {
				alert("Selecione ao menos uma ação para participar!");
				return false;
			} else {
				return true;
			}
		});
	});
</script>
<style>
.container {
	margin-top: 10px;
	padding: 10px 15px;
}

.fail {
	border-left: solid red 4px;
	background-color: lightyellow;
	padding: 4px 20px;
	width: 100%;
	display: block;
}
</style>
</head>
<body>
	<div class="container">
		<?php View::includeView('menu/top')?>
		<h2>Alteração de Dados Pessoais</h2>
		
		<?php if ($this->msg) :?>
		<div class="alert alert-dismissible alert-<?= ($this->msg=='success')? 'success' : 'danger' ?>">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<?php if ($this->msg == 'success'):?>
			Alteração realizada com sucesso!	
			<?php else :?>
			Falha na Operação! Não foi possível realizar a alteração dos dados.
			<?php endif;?>
		</div>
		<?php endif;?>
		
		<form novalidate action="<?= Controller::route("voluntario", "gravarDadosPessoais", Session::getVoluntario('id'))?>" method="POST">
			<input type="hidden" name="id" value="<?= Session::getVoluntario('id')?>" />
			<ul class="nav nav-tabs">
				<li class="active"><a id="nav-pessoal" href="#tab-pessoal" data-toggle="tab">Dados Pessoais</a></li>
				<li class=""><a id="nav-contato" href="#tab-contato" data-toggle="tab">Contato</a></li>
				<li class=""><a id="nav-interesse" href="#tab-interesse" data-toggle="tab">Ações de Interesse</a></li>
			</ul>
			<br>
			<div class="row form-group">
				<div class="col-md-6">
					<div class="tab-content">
						<div class="tab-pane fade in active" id="tab-pessoal">
							<div class="row form-group">
								<div class="col-md-12">
									<label class="required" class="required">Nome</label><br>
									<input name="nome" class="form-control" required type="text" value="<?= $this->voluntario->get('nome')?>"/>
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
										<option value="0" <?= (!$this->voluntario->get('doador_sangue'))? 'selected' : ''?>>Não</option>
									</select>
								</div>
								<div class="col-md-6">
									<label class="required">Doador de Medula?</label><br> <select name="doador_medula" class="form-control" required>
										<option value="">Selecione uma opção</option>
										<option value="1" <?= ($this->voluntario->get('doador_medula') == '1')? 'selected' : ''?>>Sim</option>
										<option value="0" <?= (!$this->voluntario->get('doador_medula'))? 'selected' : ''?>>Não</option>
									</select>
								</div>
							</div>
							<div class="row form-group">
								<div class="col-md-12">
									<label>Formação / Habilidade</label><br> <input value="<?= $this->voluntario->get('formacao')?>" name="formacao" class="form-control" type="text" />
								</div>
							</div>
							<div class="row form-group">
								<div class="col-md-12 text-right">
									<button type="button" class="btn btn-info" onclick="$('#nav-contato').click()">Avançar <i class="fa fa-forward"></i></button>
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
									<label class="required">Email</label><br> <input value="<?= $this->voluntario->get('email')?>" name="email1" class="form-control" type="text" required />
								</div>
							</div>
							<div class="row form-group">
								<div class="col-md-12">
									<label class="required">Digite novamente seu email</label><br> <input value="<?= $this->voluntario->get('email')?>" name="email2" class="form-control" type="text" required />
								</div>
							</div>
							<div class="row form-group">
								<div class="col-md-12 text-right">
									<button type="button" class="btn btn-info" onclick="$('#nav-pessoal').click()"><i class="fa fa-backward"></i> Voltar</button>
									<button type="button" class="btn btn-info" onclick="$('#nav-interesse').click()">Avançar <i class="fa fa-forward"></i></button>
								</div>
							</div>
						</div>
						<div class="tab-pane fade" id="tab-interesse">
							<div class="row form-group">
								<div class="col-md-12">
									Escolha em quais ações você deseja participar.
									Selecione ao menos uma ação para se inscrever. Clique em cada uma para ver detalhes:
									<br>
									<p class="text-right">
										<label><input type="checkbox" onclick="$('.cb-interesse').prop('checked', $(this).prop('checked'))"> Selecionar Todos</label>
									</p>
									<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true" style="height: 300px; overflow-y: scroll">
										<?php foreach (Model::getAll('acao') as $i => $acao):?>
										<div class="panel panel-default">
											<div class="panel-heading" role="tab" id="titulo-acao-<?= $acao->get('id') ?>">
												<h4 class="panel-title">
													<input type="checkbox" class="cb-interesse" name="acao_id[]" value="<?= $acao->get('id') ?>" <?= $this->voluntario->hasAcao($acao->get('id'), false)? 'checked' : ''?> > 
													<a role="button" data-toggle="collapse" data-parent="#accordion" href="#acao-<?= $acao->get('id') ?>" aria-expanded="true" aria-controls="acao-<?= $acao->get('id') ?>">																									
														<?= $acao->get('nome') ?>
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
									<button type="button" class="btn btn-info" onclick="$('#nav-contato').click()"><i class="fa fa-backward"></i> Voltar</button>
									<button type="submit" class="btn btn-primary"><i class="fa fa-send"></i> Enviar dados</button>
								</div>
							</div>
						</div>						
					</div>				
				</div>
			</div>
			<div class="row form-group">
				<div class="col-md-12">
					Campos marcados com <span style="color:red">*</span> são obrigatórios.
				</div>
			</div>
		</form>
	</div>
</body>
</html>
