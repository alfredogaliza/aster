<div class="modal fade" id="modal" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Conversa com <?= $this->mensagem->getRemetente('nome') ?></h4>
			</div>
			<div class="modal-body">
				<div class="pre-scrollable form-group" id="conversa">
					<?php foreach ($this->mensagens as $mensagem):?>
					<div class="alert <?= $mensagem->ownerClass()?>" id="msg-<?php echo $mensagem->get('id')?>">
						<b><?php echo $mensagem->get('assunto') ?> - </b>
						<i><?php echo $mensagem->getDate('datahora')?></i><br>
						<div>
							<?php echo $mensagem->get('texto')?>							
						</div>
						<div class="pull-right">
							<?php if ($mensagem->get('remetente_id') == Session::getVoluntario('id') && $mensagem->get('data_leitura')):?>
							<i class="fa fa-check"></i>
							<?php elseif ($mensagem->get('remetente_id') == Session::getVoluntario('id')): ?>
							<a data-toggle="tooltip" class="delete-msg" title="Excluir Mensagem" href="<?= Controller::route('mensagem', 'delete', $mensagem->get('id'))?>">
								<i class="fa fa-trash"></i>
							</a>
							<?php endif;?>
						</div>
					</div>
					<?php endforeach;?>	
				</div>		
				<form class="form-horizontal" id="form-mensagem" method="post" action="<?php echo Controller::route("mensagem", "gravar")?>">
					<input name="remetente_id" type="hidden" value="<?php echo Session::getVoluntario('id')?>">
					<input name="destinatario_ids[]" type="hidden" value="<?php echo $this->mensagem->get('remetente_id')?>">					
					<div class="row form-group">
						<label class="col-md-2" for="descricao">Assunto:</label>
						<div class="col-md-10">
							<input name="assunto" type="text" class="form-control" value="Re: <?php echo $this->mensagem->get('assunto')?>">
						</div>
					</div>
					<div class="row form-group">
						<label class="col-md-2" for="descricao">Resposta:</label>
						<div class="col-md-10">
							<textarea size="4" name="texto" class="form-control" ><?php echo Globals::post('texto')?></textarea>
						</div>
					</div>	
					<div class="text-right">
						<button type="button" class="btn btn-cancel" data-dismiss="modal"><i class="fa fa-close"></i> Fechar</button>
						<button type="submit" class="btn btn-primary"><i class="fa fa-send"></i> Enviar</button>						
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script>

	$("#modal").modal("show").on('shown.bs.modal', function(){
		container = $('#conversa');
		scrollTo = $('#msg-<?php echo $this->mensagem->get('id')?>');		
		container.animate({
	    	scrollTop: scrollTo.offset().top - container.offset().top + container.scrollTop()
		});
		$(this).trigger('ajax.complete');
	});

	$(".delete-msg").click(function(e){
		e.preventDefault();
		if (confirm("Deseja deletar esta mensagem?")){
			$.get($(this).attr('href'));
			$(this).parents('.msg').remove();
			$("#pag-mensagens .page").click();				
		}		
	});
	
	$("#form-mensagem").submit(function(event){
		event.preventDefault();		
		var form = $(this);
		$.ajax({
			type: "POST",
			url: form.attr('action'),
			data: form.serialize(),
			complete: function(){
				window.location.reload();
			}
		});
				
		return false;
	});	
</script>