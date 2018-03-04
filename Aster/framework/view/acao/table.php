<div class="table-responsive">
	<table class="table table-condensed  table-striped">
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
					<a data-toggle="tool-tip" title="Editar" class="btn btn-default edit" href="<?= Controller::route("acao", "modal", $acao->get('id')) ?>">
						<i class="fa fa-pencil"></i>
					</a>
					<a data-toggle="tool-tip" title="Excluir" class="btn btn-danger async-confirm" data-pagination="pagination" href="<?= Controller::route("acao", "delete", $acao->get('id')) ?>">
						<i class="fa fa-trash"></i>
					</a>				
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
