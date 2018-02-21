<div class="table-responsive">
	<table class="table table-condensed table-hover">
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
					<button class="btn btn-default edit" data-href="<?= Controller::route("responsavel", "modal", $responsavel->get('id')) ?>">
						<i class="fa fa-pencil"></i>
					</button>
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
