<div class="table-responsive">
	<table class="table table-condensed ">
		<thead>
			<tr>
				<th>Responsável</th>
				<th>Contato</th>
				<th class='text-center'>Ações</th>
			</tr>
		</thead>
		<tbody>									
		<?php if ($this->responsaveis): foreach ($this->responsaveis as $responsavel): ?>
			<tr>
				<td><?= $responsavel->get('nome')?><br>
					<small><?= $responsavel->get('parentesco')?> de <?= $responsavel->getAssistido()->get('nome')?></small>
				</td>
				<td><?= $responsavel->get('contato', 'Sem contato', false)?> /
					<?= $responsavel->get('whatsapp', 'Sem WhatsApp', false)?><br>
					<?= $responsavel->get('email')?>
				</td>
				<td class='text-center'>
					<a data-toggle="tooltip" title="Editar" class="btn btn-default edit"
						href="<?= Controller::route("responsavel", "modal", $responsavel->get('id')) ?>">
						<i class="fa fa-pencil"></i>
					</a>
					<a data-toggle="tooltip" title="Excluir" class="btn btn-danger async-confirm" href="<?= Controller::route("responsavel", "delete", $responsavel->get('id')) ?>">
						<i class="fa fa-trash"></i>
					</a>
				</td>
			</tr>
		</tbody>
		<?php endforeach; else :?>
		<tr>
			<td colspan=4>Sem Registros</td>
		</tr>
		<?php endif;?>
	</table>
</div>
