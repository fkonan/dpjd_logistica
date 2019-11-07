<?php use Core\FH; ?>
<form class="form" action=<?=$this->postAction?> method="post"> 
	<div class="row">

		<?= FH::inputBlock('text','Número de documento','CC',$this->datos->CC,['class'=>'form-control','readOnly'=>true],['class'=>'form-group col-md-4'],$this->displayErrors) ?>
		
		<?= FH::inputBlock('text','Nombres del auxiliar','Nombres',$this->datos->Nombres,['class'=>'form-control','readOnly'=>true],['class'=>'form-group col-md-4'],$this->displayErrors) ?>
		
		<?= FH::inputBlock('text','Apellidos del auxiliar','Apellidos',$this->datos->Apellidos,['class'=>'form-control','readOnly'=>true],['class'=>'form-group col-md-4'],$this->displayErrors) ?>

	</div>
	<div class="row">

		<?= FH::inputBlock('text','Agencia','Agencia',$this->datos->Agencia,['class'=>'form-control','readOnly'=>true],['class'=>'form-group col-md-4'],$this->displayErrors) ?>

		<?= FH::selectBlock('Tipo de separación *','Tipo',$this->datos->Tipo,['C'=>'Cajas','U'=>'Unidades'],['class'=>'form-control','placeHolder'=>'seleccione'],['class'=>'form-group col-md-4'],$this->displayErrors) ?>

		<?= FH::selectBlock('Sistema *','Sistema',$this->datos->Sistema,['B'=>'Base','T'=>'TAT'],['class'=>'form-control','placeHolder'=>'seleccione'],['class'=>'form-group col-md-4'],$this->displayErrors) ?>
	</div>
	<div class="d-flex justify-content-end">
		<a href="<?=PROOT?>logisticaPdaAuxiliares" class="btn btn-dark btn-xs float-right">Volver</a>
		<?= FH::submitTag('Guardar',['class'=>'btn btn-info ml-2']) ?>
	</div>
</form>
