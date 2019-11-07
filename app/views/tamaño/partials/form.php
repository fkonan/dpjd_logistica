<?php use Core\FH; ?>
<form class="form" action=<?=$this->postAction?> method="post"> 
	<?= FH::displayErrors($this->displayErrors) ?>
	<?= FH::csrfInput() ?>
	<div class="row">
		<?= FH::inputBlock('text','Tamaño','tamaño',$this->datos->tamaño,['class'=>'form-control'],['class'=>'form-group col-md-12'],$this->displayErrors) ?>
	</div>
	<div class="d-flex justify-content-end">
		<a href="<?=PROOT?>tamaño" class="btn btn-primary btn-xs float-right">Volver</a>
		<?= FH::submitTag('Guardar',['class'=>'btn btn-success ml-2']) ?>
	</div>
</form>
