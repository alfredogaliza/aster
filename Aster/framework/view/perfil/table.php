<div class="table-responsive">
	<table class="table table-condensed ">
		<thead>
			<tr>
				<th>Descrição</th>
				<th class='text-center'>Ações</th>
			</tr>
		</thead>
		<tbody>									
		<?php if ($this->perfis): foreach ($this->perfis as $perfil): ?>
			<tr>
				<td><?= $perfil->get('descricao')?></td>				
				<td class='text-center'>
					<a data-toggle="tooltip" title="Editar" class="btn btn-default edit"
						href="<?= Controller::route("perfil", "modal", $perfil->get('id')) ?>">
						<i class="fa fa-pencil"></i>
					</a>
					<a data-toggle="tooltip" title="Excluir" class="btn btn-danger async-confirm" href="<?= Controller::route("perfil", "delete", $perfil->get('id')) ?>">
						<i class="fa fa-trash"></i>
					</a>
				</td>
			</tr>		
		<?php endforeach; else :?>
			<tr>
				<td colspan="3">Sem Registros</td>
			</tr>
		<?php endif;?>
		</tbody>
	</table>
</div>
