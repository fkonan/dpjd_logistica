<?php use Core\FH; ?>
<form class="form" action=<?=$this->postAction?> method="post"> 
	<div class="row">

		<?= FH::selectBlock('Auxiliar a vincular *','CC',$this->datos->CC,$this->usuarios,['class'=>'form-control','placeHolder'=>'seleccione'],['class'=>'form-group col-md-4'],$this->displayErrors) ?>
		
		<?= FH::selectBlock('Tipo de separación *','Tipo',$this->datos->Tipo,['C'=>'Cajas','U'=>'Unidades'],['class'=>'form-control','placeHolder'=>'seleccione'],['class'=>'form-group col-md-3'],$this->displayErrors) ?>
		
		<?= FH::inputBlock('text','Agencia','TxtAgencia','',['class'=>'form-control','readOnly'=>true],['class'=>'form-group col-md-3'],$this->displayErrors) ?>
		<?= FH::inputBlock('hidden','Agencia','Agencia',$this->datos->Agencia,['class'=>'form-control','readOnly'=>true],['class'=>'form-group col-md-3 d-none'],$this->displayErrors) ?>

		<?= FH::selectBlock('Sistema *','Sistema',$this->datos->Sistema,['B'=>'Base','T'=>'TAT'],['class'=>'form-control','placeHolder'=>'seleccione'],['class'=>'form-group col-md-2'],$this->displayErrors) ?>
	</div>
	<div class="d-flex justify-content-end">
		<a href="<?=PROOT?>logisticaPdaAuxiliares" class="btn btn-dark btn-xs float-right">Volver</a>
		<?= FH::submitTag('Guardar',['class'=>'btn btn-info ml-2']) ?>
	</div>
</form>
<script>
$(document).ready(function() {
    $('#CC').select2({});

	if(document.getElementById('CC').value.length!=0){
		asignarAgencia(document.getElementById('CC').value);
	}

	$('#CC').on('select2:select', function (e) {
			asignarAgencia(e.params.data.id);
	});
});

function asignarAgencia(CC){
	var txt_agencia=CC.split(';')[1];
	var agencia=CC.split(';')[2];
	document.getElementById('TxtAgencia').value=txt_agencia;
	document.getElementById('Agencia').value=agencia;

}
</script>