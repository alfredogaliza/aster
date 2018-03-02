<ul class="nav nav-tabs">
	<li class="<?= !Globals::get('status', 0)?'active':''?>"><a href="#" data-status="0" class="change-status">Todos</a></li>
	<li class="<?= (Globals::get('status', 0)==Voluntario::STATUS_OK)?'active':''?>"><a href="#" data-status="1" class="change-status"><span class="tab-legend bg-success"></span> Ativos</a></li>
	<li class="<?= (Globals::get('status', 0)==Voluntario::STATUS_NOTEFFECTIVE)?'active':''?>"><a href="#" data-status="4" class="change-status"><span class="tab-legend bg-info"></span> Não Efetivado</a></li>
	<li class="<?= (Globals::get('status', 0)==Voluntario::STATUS_CONFIRM)?'active':''?>"><a href="#" data-status="3" class="change-status"><span class="tab-legend bg-warning"></span> Não Confirmados</a></li>
	<li class="<?= (Globals::get('status', 0)==Voluntario::STATUS_BLOCK)?'active':''?>"><a href="#" data-status="2" class="change-status"><span class="tab-legend bg-danger"></span> Inativos</a></li>

</ul>
<?php if ($this->voluntarios): ?>
<div class="table-responsive">
	<table class="table table-condensed ">
		<thead>
			<tr>
				<th>Voluntário</th>
				<th>Contato</th>
				<th>Perfil</th>
				<th class='text-center'>Ações</th>
			</tr>
		</thead>
		<tbody>									
										<?php foreach ($this->voluntarios as $voluntario): ?>
										<tr class="<?= $voluntario->getStatusClass() ?>">
				<td><?= $voluntario->get('nome')?></td>
				<td>
												<?= $voluntario->get('contato', 'Sem contato', false)?> /
												<?= $voluntario->get('whatsapp', 'Sem WhatsApp', false)?><br>
												<?= $voluntario->get('email')?>
											</td>
				<td><?= $voluntario->getPerfil('descricao')?></td>
				<td class='text-center'>
					<a data-toggle="tooltip" title="Editar" class="btn btn-default edit" href="<?= Controller::route("voluntario", "modal", $voluntario->get('id')) ?>">
						<i class="fa fa-pencil"></i>
					</a>
												<?php if ($voluntario->get('ativo')):?>
												<a data-toggle="tooltip" title="Bloquear" class="btn btn-default async-confirm" data-pagination="#pagination" href="<?= Controller::route('voluntario', 'block', $voluntario->get('id')) ?>"> <i class="fa fa-ban"></i>
						</a>
												<?php else : ?>
												<a  data-toggle="tooltip" title="Desbloquear" class="btn btn-default async-confirm" data-pagination="#pagination" href="<?= Controller::route('voluntario', 'unblock', $voluntario->get('id')) ?>"> <i class="fa fa-check"></i>
							</a>
												<?php endif;?>
												<a data-toggle="tooltip" title="Excluir" class="btn btn-danger async-confirm" href="<?= Controller::route("voluntario", "delete", $voluntario->get('id')) ?>">
						<i class="fa fa-trash"></i>
					</a>

			
				
				</td>
			</tr>
		
									<?php endforeach; ?>
									</tbody>
								</table>
</div>
<?php else :?>
<div class="row form-group">
	<div class="col-md-12">
		<div class="">Sem registros.</div>
	</div>
</div>
<?php endif ?>								