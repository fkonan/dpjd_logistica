<?php use Core\FH; ?>
<form class="form" action=<?=$this->postAction?> method="post"> 
	<?= FH::displayErrors($this->displayErrors) ?>
	<?= FH::csrfInput() ?>
	<div class="row">
		<?= FH::inputBlock('text','Nombre del producto','producto',$this->datos->producto,['class'=>'form-control'],['class'=>'form-group col-md-10'],$this->displayErrors) ?>
		<?= FH::inputBlock('number','Valor del producto','valor',$this->datos->valor,['class'=>'form-control'],['class'=>'form-group col-md-2'],$this->displayErrors) ?>
	</div>
	<div class="d-flex justify-content-end">
		<a href="<?=PROOT?>producto" class="btn btn-primary btn-xs float-right">Volver</a>
		<?= FH::submitTag('Guardar',['class'=>'btn btn-success ml-2']) ?>
	</div>
</form>
