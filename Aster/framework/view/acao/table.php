<div class="table-responsive">
	<table class="table table-condensed  table-striped">
		<thead>
			<tr>
				<th>Nome</th>
				<th class='text-center'>Detalhes</th>
				<th class='text-center'>Ações</th>
			</tr>
		</thead>
		<tbody>									
		<?php if ($this->acoes): foreach ($this->acoes as $acao): ?>
			<tr>
				<td><b><?= $acao->get('nome')?></b><br>
				<small><?= $acao->get('descricao')?></small></td>
				<td class="text-center">
					<?php if($acao->get('obrigatorio') ):?>
					<span data-toggle="tooltip" title="Obrigatório" class="btn btn-default">
						<i class="fa fa-lock"></i>
					</span>
					<?php endif; ?>
					<?php if($acao->get('privado') ):?>
					<span data-toggle="tooltip" title="Privado" class="btn btn-default">
						<i class="fa fa-eye-slash"></i>
					</span>
					<?php endif; ?>				
				</td>
				<td class="text-right">
					<a data-toggle="tooltip" title="Editar" class="btn btn-default edit" href="<?= Controller::route("acao", "modal", $acao->get('id')) ?>">
						<i class="fa fa-pencil"></i>
					</a>
					<a data-toggle="tooltip" title="Excluir" class="btn btn-danger async-confirm" data-pagination="pagination" href="<?= Controller::route("acao", "delete", $acao->get('id')) ?>">
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
