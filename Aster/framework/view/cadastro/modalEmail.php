<div class="modal fade" id="modal" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Recuperação de Senha</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" id="form" method="post" action="<?= Controller::route("cadastro", "emailRecuperacao")?>">					
					<div class="form-group">
						<label class="col-md-12">Email Cadastrado</label>
						<div class="col-md-12">
							<input name="email" class="form-control" required="" type="text" value="">
						</div>
					</div>
					<div class="text-right">
						<input type="submit" class="btn btn-primary" value="Enviar" /> 
						<button type="button" class="btn btn-cancel" data-dismiss="modal">Fechar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script>$("#modal").modal("show");</script>