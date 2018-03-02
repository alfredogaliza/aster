<div class="table-responsive">
	<table class="table table-condensed ">
		<thead>
			<tr>
				<th>Título</th>
				<th>Data</th>
				<th class='text-center'>Ações</th>
			</tr>
		</thead>
		<tbody>									
		<?php if ($this->noticias): foreach ($this->noticias as $noticia): ?>
			<tr>
				<td><?= $noticia->get('titulo')?></td>
				<td><?= $noticia->getDate('datahora')?></td>				
				<td class='text-center'>
					<a data-toggle="tooltip" title="Editar" class="btn btn-default edit"
						href="<?= Controller::route("noticia", "modal", $noticia->get('id')) ?>">
						<i class="fa fa-pencil"></i>
					</a>
					<a data-toggle="tooltip" title="Excluir" class="btn btn-danger async-confirm" href="<?= Controller::route("noticia", "delete", $noticia->get('id')) ?>">
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
