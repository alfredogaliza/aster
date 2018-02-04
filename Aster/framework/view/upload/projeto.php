<div class="modal fade" id="modal" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Upload de Projeto para Análise</h4>
			</div>
			<div class="modal-body" id="modal-body">
				<p>
					Envie o arquivo na extensão .dwg para análise. O arquivo deverá constar todas as pranchas
					a serem analisadas, incluindo o projeto de incêndio, arquitetônico, localização e
					outras informações solicitadas. O tamanho máximo não deve exceder 10MB.
				</p>
				<form id="form-upload" enctype="multipart/form-data" role="form" action="<?php echo Controller::route("upload", "projeto")?>" method="POST">
					<input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
					<input type="hidden" name="solicitacao_id" value="<?= Globals::get('solicitacao_id')?>" />
					<fieldset>
 						<input name="arquivo" type="file" accept=".dwg" required/> <br />
						<div class="text-right">
							<button type="submit" class="btn btn-success" type="submit">
								<span class="glyphicon glyphicon-upload"></span> Enviar
							</button>
							<button type="button" class="btn btn-cancel" data-dismiss="modal">Cancelar</button>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
	$("#modal").modal("show");
</script>