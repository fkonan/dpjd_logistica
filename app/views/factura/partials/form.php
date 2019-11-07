<?php use Core\FH; ?>
<form class="form" action=<?=$this->postAction?> method="post"> 
	<?= FH::displayErrors($this->displayErrors) ?>
	<?= FH::csrfInput() ?>
	<div class="row">
		<?= FH::selectBlock('Seleccione el cliente *','cliente_id',$this->datos->cliente_id,$this->clientes,['class'=>'form-control','placeHolder'=>'seleccione'],['class'=>'form-group col-md-4'],$this->displayErrors) ?>

		<?= FH::inputBlock('text','Factura número','factura_no',$this->datos->factura_no,['class'=>'form-control'],['class'=>'form-group col-md-4'],$this->displayErrors) ?>

		<?= FH::selectBlock('Seleccione el tipo de producto *','tipo_producto',$this->factura_detalle->tipo_producto,$this->tipo_producto,['class'=>'form-control','placeHolder'=>'seleccione'],['class'=>'form-group col-md-4'],$this->displayErrors) ?>
	</div>
	<div class="row">
		<?= FH::selectBlock('Seleccione la leche','leche',$this->factura_detalle->leche,$this->leche,['class'=>'form-control','placeHolder'=>'seleccione'],['class'=>'form-group col-md-3'],$this->displayErrors) ?>

		<?= FH::selectBlock('Seleccione el sabor','sabor',$this->factura_detalle->sabor,$this->sabor,['class'=>'form-control','placeHolder'=>'seleccione'],['class'=>'form-group col-md-3'],$this->displayErrors) ?>

		<?= FH::selectBlock('Seleccione el tamaño','tamaño',$this->factura_detalle->tamaño,$this->tamaño,['class'=>'form-control','placeHolder'=>'seleccione'],['class'=>'form-group col-md-3'],$this->displayErrors) ?>
		
		<?= FH::selectBlock('Seleccione algún adicional','adicional',$this->factura_detalle->adicional,$this->adicional,['class'=>'form-control','placeHolder'=>'seleccione'],['class'=>'form-group col-md-3'],$this->displayErrors) ?>
	</div>
	<div class="row">
		<?= FH::inputBlock('text','Cantidad','cantidad',$this->factura_detalle->cantidad,['class'=>'form-control'],['class'=>'form-group col-md-3'],$this->displayErrors) ?>
		<?= FH::inputBlock('text','Valor','valor',$this->factura_detalle->valor,['class'=>'form-control'],['class'=>'form-group col-md-3'],$this->displayErrors) ?>

		<?= FH::inputBlock('text','Fecha factura','fecha',$this->datos->fecha,['class'=>'form-control'],['class'=>'form-group col-md-3'],$this->displayErrors) ?>
		
		<?= FH::inputBlock('text','Fecha notificación','fecha_notificacion',$this->datos->fecha_notificacion,['class'=>'form-control'],['class'=>'form-group col-md-3'],$this->displayErrors) ?>
	</div>
	<div class="d-flex justify-content-end">
		<a href="<?=PROOT?>factura" class="btn btn-primary btn-xs float-right">Volver</a>
		<?= FH::submitTag('Guardar',['class'=>'btn btn-success ml-2']) ?>
	</div>
</form>
<script>
$(document).ready(function() {
    $('#cliente_id').select2({

    });

 	var hoy;
    hoy = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());

    $('#fecha').datepicker({
    	 maxDate: hoy,
    	 uiLibrary: 'bootstrap4' ,
    	 format: 'yyyy-mm-dd'
    });

     $('#fecha_notificacion').datepicker({
    	 uiLibrary: 'bootstrap4' ,
    	 format: 'yyyy-mm-dd'
    });

    $('#producto_id').select2({

    });

    $('#producto_id').on('select2:select', function (e) {
	    var data = e.params.data;
	    cargarValor(data.id);
	});

	function cargarValor(id){
		$.ajax({
			type: "POST",
			url : '<?=PROOT?>producto/cargarValor/'+id,
			success : function(resp){
				if(resp.success){
					$('#valor').val(resp.datos.valor);
				}else{
					//alertMsg('Ha ocurrido un error', 'danger');
					$('#valor').val(0);
				}
			}
		});
	}
});
</script>
