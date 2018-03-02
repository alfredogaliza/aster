<div class="modal fade" id="modal" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Erro</h4>
			</div>
			<div class="modal-body">					
				<div class="row form-group">
					<div class="col-md-12">
						<div class="alert alert-danger">
							Ocorreu uma falha na execução do comando!<br><br>
							<strong>Informações Técnicas:</strong>
							<p class="well">
								<?= Globals::post('msg')?>
							</p>
						</div>						
					</div>
				</div>
			</div>
			<div class="modal-footer text-right">
				<button type="button" class="btn btn-default" data-dismiss="modal">
					<i class="fa fa-close"></i> Fechar
				</button>				
			</div>
		</div>
	</div>
</div>

<script>
	$("#modal").modal("show").trigger('ajax.complete');
</script>