<?php use Core\FH; ?>
<form class="form" action=<?=$this->postAction?> method="post"> 
	<?= FH::displayErrors($this->displayErrors) ?>
	<?= FH::csrfInput() ?>
	<div class="row">
		<?= FH::inputBlock('text','Número de documento','documento',$this->datos->documento,['class'=>'form-control'],['class'=>'form-group col-md-3'],$this->displayErrors) ?>
		<?= FH::inputBlock('text','Nombre del cliente','nombre',$this->datos->nombre,['class'=>'form-control'],['class'=>'form-group col-md-3'],$this->displayErrors) ?>
		<?= FH::inputBlock('text','Dirección','direccion',$this->datos->direccion,['class'=>'form-control'],['class'=>'form-group col-md-3'],$this->displayErrors) ?>

		<?= FH::inputBlock('text','Fecha de nacimiento','fecha_nacimiento',$this->datos->fecha_nacimiento,['class'=>'form-control'],['class'=>'form-group col-md-3'],$this->displayErrors) ?>
	</div>
	<div class="row">
		<?= FH::inputBlock('text','Barrio','barrio',$this->datos->barrio,['class'=>'form-control'],['class'=>'form-group col-md-3'],$this->displayErrors) ?>
		<?= FH::inputBlock('text','Teléfono','telefono',$this->datos->telefono,['class'=>'form-control'],['class'=>'form-group col-md-3'],$this->displayErrors) ?>
		<?= FH::inputBlock('text','Celular','celular',$this->datos->celular,['class'=>'form-control'],['class'=>'form-group col-md-3'],$this->displayErrors) ?>
		<?= FH::inputBlock('text','Correo','correo',$this->datos->correo,['class'=>'form-control'],['class'=>'form-group col-md-3'],$this->displayErrors) ?>
	</div>
	<div class="d-flex justify-content-end">
		<a href="<?=PROOT?>clientes" class="btn btn-primary btn-xs float-right">Volver</a>
		<?= FH::submitTag('Guardar',['class'=>'btn btn-success ml-2']) ?>
	</div>
</form>
<script>
$(document).ready(function() {
 	var hoy;
    hoy = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());

    $('#fecha_nacimiento').datepicker({
    	 maxDate: hoy,
    	 uiLibrary: 'bootstrap4' ,
    	 format: 'yyyy-mm-dd'
    });
});
</script>