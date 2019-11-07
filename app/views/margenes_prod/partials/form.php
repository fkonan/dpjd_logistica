<?php use Core\FH; ?>
<form class="form" action=<?=$this->postAction?> method="post"> 
	<div class="row">
		<?php if (is_null($this->datos->id)):?>
			<?= FH::selectBlock('<h3>Seleccione la linea/casa</h3>','U_CardCode',$this->datos->U_CardCode,$this->casas,['class'=>'form-control','placeHolder'=>'seleccione'],['class'=>'form-group col-md-12'],$this->displayErrors) ?>
		<?php else:?>
			<?= FH::selectBlock('<h3>Seleccione la linea/casa</h3>','U_CardCode',$this->datos->U_CardCode,$this->casas,['class'=>'form-control','placeHolder'=>'seleccione','disabled'=>'disabled'],['class'=>'form-group col-md-12'],$this->displayErrors) ?>
		<?php endif;?>
	</div>
	<h3>Configure los margenes de acuerdo a la Sucursal</h3>
	<div class="row mt-3">
		<div class="col-md-3">
			<div class="card">
				<div class="card-header text-center">
					<h5>Bucaramanga</h5>
				</div>
				<div class="card-body">
					<div class="row">
						<?= FH::inputBlock('text','<b>Margen base</b>','U_MargenBaseBuc',$this->datos->U_MargenBaseBuc,['class'=>'form-control text-center'],['class'=>'form-group col-md-6 px-1 text-center'],$this->displayErrors) ?>
						<?= FH::inputBlock('text','<b>Margen tat</b>','U_MargenTatBuc',$this->datos->U_MargenTatBuc,['class'=>'form-control text-center'],['class'=>'form-group col-md-6 px-1 text-center'],$this->displayErrors) ?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="card">
				<div class="card-header text-center">
					<h5>Cucuta</h5>
				</div>
				<div class="card-body">
					<div class="row">
						<?= FH::inputBlock('text','<b>Margen base</b>','U_MargenBaseCuc',$this->datos->U_MargenBaseCuc,['class'=>'form-control text-center'],['class'=>'form-group col-md-6 px-1 text-center
 px-1'],$this->displayErrors) ?>
						<?= FH::inputBlock('text','<b>Margen tat</b>','U_MargenTatCuc',$this->datos->U_MargenTatCuc,['class'=>'form-control text-center'],['class'=>'form-group col-md-6 px-1 text-center
 px-1'],$this->displayErrors) ?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="card">
				<div class="card-header text-center">
					<h5>Valledupar</h5>
				</div>
				<div class="card-body">
					<div class="row">
						<?= FH::inputBlock('text','<b>Margen base</b>','U_MargenBaseValle',$this->datos->U_MargenBaseValle,['class'=>'form-control text-center'],['class'=>'form-group col-md-6 px-1 text-center
 px-1'],$this->displayErrors) ?>
						<?= FH::inputBlock('text','<b>Margen tat</b>','U_MargenTatValle',$this->datos->U_MargenTatValle,['class'=>'form-control text-center'],['class'=>'form-group col-md-6 px-1 text-center
 px-1'],$this->displayErrors) ?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="card">
				<div class="card-header text-center">
					<h5>Duitama</h5>
				</div>
				<div class="card-body">
					<div class="row">
						<?= FH::inputBlock('text','<b>Margen base</b>','U_MargenBaseDui',$this->datos->U_MargenBaseDui,['class'=>'form-control text-center'],['class'=>'form-group col-md-6 px-1 text-center
 px-1'],$this->displayErrors) ?>
						<?= FH::inputBlock('text','<b>Margen tat</b>','U_MargenTatDui',$this->datos->U_MargenTatDui,['class'=>'form-control text-center'],['class'=>'form-group col-md-6 px-1 text-center
 px-1'],$this->displayErrors) ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<hr>
		<div class="d-flex justify-content-end">
		<a href="<?=PROOT?>margenesProd" class="btn btn-dark btn-xs float-right">Volver</a>
		<?= FH::submitTag('Guardar',['class'=>'btn btn-info ml-2']) ?>
	</div>
</form>
<script>
$(document).ready(function() {
    $('#U_CardCode').select2({
    	allowClear: true,
    });
});
</script>