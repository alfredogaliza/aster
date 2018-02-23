<div class="table-responsive">
	<table class="table table-condensed table-hover table-striped">
		<thead>
			<tr>
				<th>Nome</th>
				<th class='text-center'>Ações</th>
			</tr>
		</thead>
		<tbody>									
		<?php if ($this->acoes): foreach ($this->acoes as $acao): ?>
			<tr>
				<td><b><?= $acao->get('nome')?></b><br>
				<small><?= $acao->get('descricao')?></small></td>
				<td class="text-right">
					<button class="btn btn-default edit" data-href="<?= Controller::route("acao", "modal", $acao->get('id')) ?>">
						<i class="fa fa-pencil"></i>
					</button>				
				</td>
			</tr>		
		<?php endforeach; else :?>
			<tr>
				<td colspan=4>Sem Registros</td>
			</tr>
		<?php endif;?>
		</tbody>
	</table>
</div>
