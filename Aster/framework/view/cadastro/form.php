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
		<h2>Formulário de Cadastro de Voluntários</h2>
		<form action="<?= Controller::route("cadastro", "gravar")?>" method="POST">
			<ul class="nav nav-tabs">
				<li class="active"><a id="nav-pessoal" href="#tab-pessoal" data-toggle="tab">Dados Pessoais</a></li>
				<li class=""><a id="nav-contato" href="#tab-contato" data-toggle="tab">Contato</a></li>
				<li class=""><a id="nav-interesse" href="#tab-interesse" data-toggle="tab">Ações de Interesse</a></li>
				<li class=""><a id="nav-compromisso" href="#tab-compromisso" data-toggle="tab">Termo de Compromisso</a></li>
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
										<option value="0" <?= ($this->voluntario->get('doador_sangue') === 'O')? 'selected' : ''?>>Não</option>
									</select>
								</div>
								<div class="col-md-6">
									<label class="required">Doador de Medula?</label><br> <select name="doador_medula" class="form-control" required>
										<option value="">Selecione uma opção</option>
										<option value="1" <?= ($this->voluntario->get('doador_medula') == '1')? 'selected' : ''?>>Sim</option>
										<option value="0" <?= ($this->voluntario->get('doador_medula') === 'O')? 'selected' : ''?>>Não</option>
									</select>
								</div>
							</div>
							<div class="row form-group">
								<div class="col-md-12">
									<label>Formação Técnica/Acadêmica</label><br> <input value="<?= $this->voluntario->get('formacao')?>" name="formacao" class="form-control" type="text" />
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
													<input type="checkbox" class="cb-interesse" name="acao_id[]" value="<?= $acao->get('id') ?>" <?= $this->voluntario->hasAcao($acao->get('id'), true)? 'checked' : ''?> > 
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
									<button type="button" class="btn btn-info" onclick="$('#nav-compromisso').click()">Avançar <i class="fa fa-forward"></i></button>
								</div>
							</div>
						</div>
						<div class="tab-pane fade" id="tab-compromisso">
							<div class="row form-group">
								<h3>Termo de Compromisso</h3>
								<div class="col-md-12" style="border-radius: 10px; text-align: justify; height: 250px; overflow-y: scroll; border: solid gray 1px">
									DECLARO para os devidos fins de direito, com fulcro na Lei nº 9.608/1998, referente ao trabalho voluntário que:
									<ol>
										<li>Estes serviços serão prestados por mim, gratuitamente, de livre e espontânea vontade, em dias e
										horários por mim escolhidos, firmados com o Instituto Áster, por prazo indeterminado, a título de colaboração.
										<li>Sendo serviços de natureza voluntário, estou ciente que estes não geram qualuqer vínculo empregatício, nem
										obrigação de natureza trabalhista, previdenciária ou afim, entre a minha pessoa e o Instituto Áster, sendo que
										, a qualquer título, exigir indenização pelos serviços prestados ou qualquer compensação em gênero ou espécie.
										<li> AUTORIZO, desde já, o uso de minha imagem e voz a título gratuito, em todo território nacional e no exterior,
										nos meios de comunicação em todas as modalidades e, em destaque, das seguintes formas: Outdoor, Busdoor, folhetos em
										geral (encartes, malas diretas, catálogos, etc.), folder de apresentação, anúncios em revista e jornais em geral, homepage,
										cartazes, backlight, mídia eletrônica (painéis, videotapes, televisão, cinema, programa para rádio, etc) e todo e qualquer material
										entre fotos, documentos e outros meios de comunicação, quando utilizada para divulgação do trabalho desenvolvido por esta
										comunidade, no exercício das atividades como voluntário.
										<li>A qualquer momento posso deixar de prestar os serviços acima referidos em decorrência da natureza gratuita e não
										econômica da minha colaboração voluntária.
										<li>Fica reservado ao presidente a autorização para uso dos bens da instituição como também ressarcimento das
										despesas comprovadas para realização das atividades voluntárias, desde que previamente autorizadas.										 
									</ol>									
									Por ser expressão de verdade, firmo o presente Termo, com a anuência do PRESIDENTE do Instituto Áster
								</div>
							</div>
							<div class="row form-group">
								<label class="col-md-12 required"><input type="checkbox" required <?= $this->voluntario->get('id')? 'checked' : ''?>> Li e aceito o termo de compromisso.</label>
							</div>
							<div class="row form-group">
								<div class="col-md-12 text-right">
									<button type="button" class="btn btn-info" onclick="$('#nav-interesse').click()"><i class="fa fa-backward"></i> Voltar</button>
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
			<div class="row form-group">
				<div class="col-md-4">
					<a href="<?= Controller::route("login")?>" class=""><i class="fa fa-backward"></i> Voltar para tela inicial</a>
				</div>
			</div>
		</form>
	</div>
</body>
</html>
