<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>	
	<?php View::includeBlock("head"); ?>
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
		<h2>Formulário de Cadastro de Voluntários</h2>
		<form action="<?= Controller::route("voluntario", "cadastrar")?>" method="POST">
			<div class="row">
				<div class="col-md-6">
					<div class="row">
						<div class="col-md-12">
							<label class="required" class="required">Nome</label><br> <input name="nome" class="form-control" required type="text" />
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<label class="required">Nascimento</label><br> <input name="data_nascimento" class="form-control date" required type="text" />
						</div>
						<div class="col-md-6">
							<label class="required">Estado Civil</label><br> <select name="estado_civil" class="form-control" required>
								<option value="">Selecione uma opção</option>
								<option>Solteiro(a)</option>
								<option>Casado(a)</option>
								<option>Divorciado(a)</option>
								<option>Viúvo(a)</option>
								<option>União Estável</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<label class="required">Sexo</label><br> <select name="sexo" class="form-control" required>
								<option value="">Selecione uma opção</option>
								<option value="M">Masculino</option>
								<option value="F">Feminino</option>
							</select>
						</div>
						<div class="col-md-6">
							<label class="required">CPF</label><br> <input name="cpf" class="cpf form-control" required type="text" />
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<label class="required">Doador de Sangue?</label><br> <select name="doador_sangue" class="form-control" required>
								<option value="">Selecione uma opção</option>
								<option value="1">Sim</option>
								<option value="0">Não</option>
							</select>
						</div>
						<div class="col-md-6">
							<label class="required">Doador de Medula?</label><br> <select name="doador_medula" class="form-control" required>
								<option value="">Selecione uma opção</option>
								<option value="1">Sim</option>
								<option value="0">Não</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<label class="required">Tipo Sanguíneo</label><br> <select name="tipo_sanguineo" class="form-control" required>
								<option value="">Selecione uma opção</option>
								<option value="NS">Não sabe</option>
								<option>A+</option>
								<option>B+</option>
								<option>AB+</option>
								<option>O+</option>
								<option>A-</option>
								<option>B-</option>
								<option>AB-</option>
								<option>O-</option>								
							</select>
						</div>
						<div class="col-md-6">
							<label class="required">CEP</label><br> <input name="cep" class="cep form-control" required type="text" />
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<label class="required">Endereço Completo</label><br> <input name="endereco" class="form-control" required type="text" />
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<label>Telefone</label><br> <input name="contato" class="form-control telefone" type="text" />
						</div>
						<div class="col-md-6">
							<label>Whatsapp</label><br> <input name="whatsapp" class="form-control telefone" type="text" />
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<label>Formação Técnica/Acadêmica</label><br> <input name="formacao" class="form-control" type="text" />
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<label class="required">Email</label><br> <input name="email1" class="form-control" type="text" required />
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<label class="required">Digite novamente seu email</label><br> <input name="email2" class="form-control" type="text" required />
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">Campo marcados com <label class="required"></label> são obrigatórios.</div>
					</div>						
				</div>
				<div class="col-md-6">
					<div class="row">
						<div class="col-md-12">
							Escolha em quais ações você deseja participar.
							Selecione ao menos uma ação para se inscrever.
							Clique em cada uma para ver detalhes:
							<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
								<?php foreach (Model::getAll('acao') as $i => $acao):?>
								<div class="panel panel-default">
									<div class="panel-heading" role="tab" id="titulo-acao-<?= $acao->get('id') ?>">
										<h4 class="panel-title">
											<a role="button" data-toggle="collapse" data-parent="#accordion" href="#acao-<?= $acao->get('id') ?>" aria-expanded="true" aria-controls="acao-<?= $acao->get('id') ?>"> <?= $acao->get('nome') ?></a> <label class="pull-right"> <input type="checkbox" name="acao_id[]" value="<?= $acao->get('id') ?>"> Quero participar!
											</label>
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
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<a href="<?= Controller::route("login")?>" class="btn btn-info"><i class="fa fa-backward"></i> Voltar</a>
				</div>
				<div class="col-md-8 text-right">
					<button type="reset" class="btn btn-default">
						<i class="fa fa-close"></i> Limpar Formulário
					</button>
					<button type="submit" class="btn btn-primary">
						<i class="fa fa-send"></i> Enviar dados
					</button>
				</div>
			</div>
		</form>
	</div>
</body>
</html>
