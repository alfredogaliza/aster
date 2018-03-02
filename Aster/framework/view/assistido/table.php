<ul class="nav nav-tabs">
	<li class="<?= !Globals::get('status', 0)?'active':''?>"><a href="#"
		data-status="0" class="change-status">Todos</a></li>
	<li
		class="<?= (Globals::get('status')==Assistido::STATUS_INICIO)?'active':''?>"><a
		href="#" data-status="1" class="change-status"><span
			class="tab-legend bg-primary"></span> Início</a></li>
	<li
		class="<?= (Globals::get('status')==Assistido::STATUS_TRATAMENTO)?'active':''?>"><a
		href="#" data-status="2" class="change-status"><span
			class="tab-legend bg-warning"></span> Tratamento</a></li>
	<li
		class="<?= (Globals::get('status')==Assistido::STATUS_MANUTENCAO)?'active':''?>"><a
		href="#" data-status="3" class="change-status"><span
			class="tab-legend bg-info"></span> Manutenção</a></li>
	<li
		class="<?= (Globals::get('status')==Assistido::STATUS_RECAIDA)?'active':''?>"><a
		href="#" data-status="4" class="change-status"><span
			class="tab-legend bg-danger"></span> Recaída</a></li>
	<li
		class="<?= (Globals::get('status')==Assistido::STATUS_CURA)?'active':''?>"><a
		href="#" data-status="5" class="change-status"><span
			class="tab-legend bg-success"></span> Cura</a></li>
	<li
		class="<?= (Globals::get('status')==Assistido::STATUS_INATIVO)?'active':''?>"><a
		href="#" data-status="6" class="change-status"><span
			class="tab-legend bg-default"></span> Inativo</a></li>
</ul>
<div class="table-responsive">
	<table class="table table-condensed ">
		<thead>
			<tr>
				<th>Nº Cadastro</th>
				<th>Assistido</th>
				<th>Contato</th>
				<th>Atualização</th>
				<th class='text-center'>Ações</th>
			</tr>
		</thead>
		<tbody>									
			<?php if ($this->assistidos): foreach ($this->assistidos as $assistido): ?>
			<tr class="<?= $assistido->getStatusClass() ?>">
				<td><?= str_pad($assistido->get('id'), 6,0,STR_PAD_LEFT)?></td>
				<td><?= $assistido->get('nome')?></td>
				<td>
								<?= $assistido->get('contato', 'Sem contato', false)?> /
					<?= $assistido->get('whatsapp', 'Sem WhatsApp', false)?><br>
					<?= $assistido->get('email', 'Sem Email', false)?>
							</td>
				<td><?= $assistido->getDate('data_atualizacao')?></td>
				<td class='text-center'>
					<a data-toggle="tooltip" title="Editar" class="btn btn-default edit"
						href="<?= Controller::route("assistido", "modal", $assistido->get('id')) ?>">
						<i class="fa fa-pencil"></i>
					</a>
					<a data-toggle="tooltip" title="Excluir" class="btn btn-danger async-confirm" data-pagination="pagination" href="<?= Controller::route("assistido", "delete", $assistido->get('id')) ?>">
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
