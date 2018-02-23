<div class="table-responsive">
	<table class="table table-condensed table-hover">
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
					<button class="btn btn-default edit" data-href="<?= Controller::route("noticia", "modal", $noticia->get('id')) ?>">
						<i class="fa fa-pencil"></i>
					</button>
					<a class="btn btn-default delete async" href="<?= Controller::route("noticia", "delete", $noticia->get('id')) ?>">
						<i class="fa fa-remove"></i>
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
