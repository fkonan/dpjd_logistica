<?php use Core\FH; ?>
<form class="form" action=<?=$this->postAction?> method="post" >
	<?= FH::displayErrors($this->displayErrors) ?>
	<?= FH::csrfInput() ?>
	<div class="card border-info">
		<div class="card-header text-center bg-info text-white">
	   		<b>Datos Generales del Ciudadano</b>
	   		<p class="mb-0">Tenga en cuenta que los campos con * son obligatorios</p>
	  	</div>
		<div class="card-body">
			<div class="row">
				<?= FH::selectBlock('Tipo de documento *','tipo_doc_id',$this->datos->tipo_doc_id,$this->tipo_doc,['class'=>'form-control','placeHolder'=>'seleccione'],['class'=>'form-group col-md-3'],$this->displayErrors) ?>
				
				<?= FH::inputBlock('number','Documento * <code>(sin puntos ni comas)</code>','documento',$this->datos->documento,['class'=>'form-control'],['class'=>'form-group col-md-3'],$this->displayErrors) ?>

				<?= FH::inputBlock('text','Nombres *','nombres',$this->datos->nombres,['class'=>'form-control'],['class'=>'form-group col-md-3'],$this->displayErrors) ?>

				<?= FH::inputBlock('text','Primer apellido *','primer_apellido',$this->datos->primer_apellido,['class'=>'form-control'],['class'=>'form-group col-md-3'],$this->displayErrors) ?>
			</div>
			<div class="row">
				<?= FH::inputBlock('text','Segundo apellido','segundo_apellido',$this->datos->segundo_apellido,['class'=>'form-control'],['class'=>'form-group col-md-3'],$this->displayErrors) ?>

				<?= FH::inputBlock('text','Fecha de nacimiento *','fecha_nacimiento',$this->datos->fecha_nacimiento,['class'=>'form-control',"data-provide"=>"datepicker"],['class'=>'form-group col-md-2 input-group date'],$this->displayErrors) ?>

				<?= FH::inputBlock('text','Edad','edad',$this->datos->edad,['class'=>'form-control'],['class'=>'form-group col-md-1'],$this->displayErrors) ?>

				<?= FH::selectBlock('Género *','sexo',$this->datos->sexo,['MASCULINO'=>'MASCULINO','FEMENINO'=>'FEMENINO'],['class'=>'form-control','placeHolder'=>'seleccione'],['class'=>'form-group col-md-3'],$this->displayErrors) ?>

				<?= FH::selectBlock('Estado civil','estado_civil',$this->datos->estado_civil,['SOLTERO' => 'SOLTERO', 'CASADO' => 'CASADO' , 'VIUDO' => 'VIUDO' ,  'DIVORCIADO' => 'DIVORCIADO', 'UNION MARITAL DE HECHO' => 'UNION MARITAL DE HECHO'],['class'=>'form-control','placeHolder'=>'seleccione'],['class'=>'form-group col-md-3'],$this->displayErrors) ?>
			</div>
			<div class="row">
				<?= FH::selectBlock('Pais de nacimiento *','pais_nac_id',$this->datos->pais_nac_id,$this->pais,['class'=>'form-control','placeHolder'=>'seleccione'],['class'=>'form-group col-md-3'],$this->displayErrors) ?>

				<?= FH::selectBlock('Departamento de nacimiento *','depto_nac_codigo',$this->datos->depto_nac_codigo,$this->depto,['class'=>'form-control','placeHolder'=>'seleccione'],['class'=>'form-group col-md-3'],$this->displayErrors) ?>

				<?= FH::selectBlock('Municipio de nacimiento *','muni_nac_codigo',$this->datos->muni_nac_codigo,$this->muni,['class'=>'form-control','placeHolder'=>'seleccione'],['class'=>'form-group col-md-3'],$this->displayErrors) ?>
			</div>
		</div>
	</div>

	<div class="card border-info">
		<div class="card-header text-center bg-info text-white">
			<b>Ocupación y Grado de Escolaridad</b>
    	</div>
		<div class="card-body">
			<div class="row">
				<?= FH::selectBlock('Nivel educativo *','nivel_educativo_id',$this->datos->nivel_educativo_id,
				$this->nivel_educativo,['class'=>'form-control','placeHolder'=>'seleccione'],['class'=>'form-group col-md-3'],$this->displayErrors) ?>

				<?= FH::checkboxBlock('¿Esta graduado? *','graduado_opcion',$this->datos->graduado_opcion,['class'=>'checkbox'],['class'=>'form-group col-md-1'],$this->displayErrors) ?>

				<?= FH::selectBlock('Ocupación *','ocupacion_id',$this->datos->ocupacion_id,$this->ocupacion,['class'=>'form-control','placeHolder'=>'seleccione'],['class'=>'form-group col-md-4'],$this->displayErrors) ?>
				
				<?= FH::selectBlock('Profesión *','profesion_id',$this->datos->profesion_id,$this->profesion,['class'=>'form-control','placeHolder'=>'seleccione'],['class'=>'form-group col-md-4'],$this->displayErrors) ?>
			</div>
			<div class="row d-none" id="ies">
				<?= FH::inputBlock('text','Institución donde obtuvo el título de técnico laboral (*)','ies',$this->datos->ies,['class'=>'form-control'],['class'=>'form-group col-md-6'],$this->displayErrors) ?>
				<?= FH::inputBlock('text','Digite El nombre del programa (*)','nombre_programa_ies',$this->datos->nombre_programa_ies,['class'=>'form-control'],['class'=>'form-group col-md-6'],$this->displayErrors) ?>
        	</div>
		</div>
	</div>
	<div class="card border-info">
		<div class="card-header text-center bg-info text-white">
        	<b>Ubicación Geográfica</b>
    	</div>
		<div class="card-body">
			<div class="row">
				<?= FH::selectBlock('Municipio de residencia *','muni_codigo',$this->datos->muni_codigo,$this->muni,['class'=>'form-control','placeHolder'=>'seleccione'],['class'=>'form-group col-md-3'],$this->displayErrors) ?>

				<?= FH::selectBlock('Barrio','barrio_codigo',$this->datos->barrio_codigo,$this->barrio,['class'=>'form-control','placeHolder'=>'seleccione'],['class'=>'form-group col-md-3'],$this->displayErrors) ?>

				<?= FH::selectBlock('Comuna','comuna_codigo',$this->datos->comuna_codigo,$this->comuna,['class'=>'form-control','placeHolder'=>'seleccione','disabled'=>'true'],['class'=>'form-group col-md-3'],$this->displayErrors) ?>

				<?= FH::selectBlock('Vereda','vereda_codigo',$this->datos->vereda_codigo,$this->vereda,['class'=>'form-control','placeHolder'=>'seleccione'],['class'=>'form-group col-md-3'],$this->displayErrors) ?>
			</div>
			<div class="row">
				<?= FH::selectBlock('Corregimiento','corregimiento_codigo',$this->datos->corregimiento_codigo,$this->vereda,['class'=>'form-control','placeHolder'=>'seleccione','disabled'=>'true'],['class'=>'form-group col-md-2'],$this->displayErrors) ?>

				<?= FH::inputBlock('text','Dirección (*)','direccion',$this->datos->direccion,['class'=>'form-control'],['class'=>'form-group col-md-6'],$this->displayErrors) ?>

				<?= FH::inputBlock('number','Estrato','estrato',$this->datos->estrato,['class'=>'form-control'],['class'=>'form-group col-md-1'],$this->displayErrors) ?>
			</div>
		</div>
	</div>

	<div class="card border-info">
		<div class="card-header text-center bg-info text-white">
        	<b>Tipo de Población</b>
    	</div>
		<div class="card-body">
			<div class="row">
				<?= FH::selectBlock('Situación particular','situacion_particular_id',$this->datos->situacion_particular_id,$this->situacion,['class'=>'form-control','placeHolder'=>'seleccione'],['class'=>'form-group col-md-4'],$this->displayErrors) ?>

				<?= FH::selectBlock('Grupo étnico *','grupo_etnico_id',$this->datos->grupo_etnico_id,$this->grupo_etnico,['class'=>'form-control','placeHolder'=>'seleccione'],['class'=>'form-group col-md-4'],$this->displayErrors) ?>

				<?= FH::selectBlock('Discapacidad *','discapacidad_id',$this->datos->discapacidad_id,$this->discapacidad,['class'=>'form-control','placeHolder'=>'seleccione'],['class'=>'form-group col-md-4'],$this->displayErrors) ?>
			</div>
		</div>
	</div>
	<div class="card border-info">
		<div class="card-header text-center bg-info text-white">
        	<b>Datos de contacto</b>
    	</div>
		<div class="card-body">
			<div class="row">
				<?= FH::inputBlock('text','Teléfono fijo','telefono',$this->datos->telefono,['class'=>'form-control'],['class'=>'form-group col-md-6'],$this->displayErrors) ?>

				<?= FH::inputBlock('text','Teléfono celular','telefono2',$this->datos->telefono2,['class'=>'form-control'],['class'=>'form-group col-md-6'],$this->displayErrors) ?>

				<?= FH::inputBlock('text','Correo electrónico','correo',$this->datos->correo,['class'=>'form-control'],['class'=>'form-group col-md-6'],$this->displayErrors) ?>

				<?= FH::inputBlock('text','Correo electrónico adicional','correo2',$this->datos->correo2,['class'=>'form-control'],['class'=>'form-group col-md-6'],$this->displayErrors) ?>
			</div>
		</div>
	</div>
	<div class="d-flex justify-content-end">
		<?= FH::submitTag('Guardar',['class'=>'btn btn-success btn-block btn-lg mt-2']) ?>
	</div>
</form>
<script>
$(document).ready(function () {
    var date_input=$('input[name="fecha_nacimiento"]'); //our date input has the name "date"
    var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
    date_input.datepicker({
    	locale: 'es-es',
        format: 'yyyy/mm/dd',
        container: container,
        todayHighlight: true,
        autoclose: true,
        change: function (e) {
            var fecha = new Date($(this).val());
		    var hoy = new Date();
		    var edad = parseInt((hoy -fecha)/365/24/60/60/1000)
		    $("#edad").val(edad);
        }
    });

    var date_ingreso=$('input[name="fecha_ingreso"]'); //our date input has the name "date"
    var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
    date_ingreso.datepicker({
    	locale: 'es-es',
        format: 'yyyy/mm/dd',
        container: container,
        todayHighlight: true,
        autoclose: true,
    });

    $('#pais_nac_id').on('change',function(){
		document.getElementById("depto_nac_codigo").selectedIndex = "0";
		document.getElementById("muni_nac_codigo").selectedIndex = "0";
        if ($('#pais_nac_id').val()!=45){
            $('#depto_nac_codigo').prop('disabled',true);
            $('#muni_nac_codigo').prop('disabled',true);
        }else{
        	$('#depto_nac_codigo').prop('disabled',false);
        }
	});

    $('#depto_nac_codigo').on('change',function(){
		$.ajax({
		    type: "POST",
		    url : '<?=PROOT?>datosGenerales/cargarMuni/'+this.value,
		    success : function(resp){
		    	if(resp.success){
		    		var html='';
 					html += '<option value="">Seleccionar</option>';
		    		$.each(resp.municipio, function(idx, opt) {
        				html += '<option value="'+idx+'">'+opt+'</option>';
		    		});
		    		$('#muni_nac_codigo').html(html);
            		$('#muni_nac_codigo').prop('disabled',false);
		    	}else{

		    	}
			}
		});
	});

	$('#muni_codigo').on('change',function(){
		$('#barrio_codigo').val('');
		$('#comuna_codigo').val('');

        if ($('#muni_codigo').val()!='68001'){
            $('#barrio_codigo').prop('disabled',true);
            $('#vereda_codigo').prop('disabled',true);
        }else{
        	$('#barrio_codigo').prop('disabled',false);
            $('#vereda_codigo').prop('disabled',false);
        }
	});

	$('#barrio_codigo').on('change',function(){
		$.ajax({
		    type: "POST",
		    url : '<?=PROOT?>datosGenerales/cargarComuna/'+this.value,
		    success : function(resp){
		    	if(resp.success){
		    		var html='';
		    		html+='<option value="'+resp.comuna.codigo+'">'+resp.comuna.nombre+'</option>';
		    		$('#comuna_codigo').html(html);
		    	}else{

		    	}
			}
		});
	});

	$('#vereda_codigo').on('change',function(){
		$.ajax({
		    type: "POST",
		    url : '<?=PROOT?>datosGenerales/cargarCorregimiento/'+this.value,
		    success : function(resp){
		    	if(resp.success){
		    		var html='';
		    		html+='<option value="'+resp.corregimiento.codigo+'">'+resp.corregimiento.nombre+'</option>';
		    		$('#corregimiento_codigo').html(html);
		    	}else{

		    	}
			}
		});
	});

    $('#barrio_codigo').on('change', function(){
        if ($('#barrio_codigo').val()!='')
        {
            $('#vereda_codigo').val(null).trigger('change');
            $('#corregimiento_codigo').val(null).trigger('change');
        }
        else{
            $('#vereda_codigo').prop('disabled',false);
        }
    });
    $('#vereda_codigo').on('change', function(){
        if ($('#vereda_codigo').val()!='')
        {
            $('#barrio_codigo').val(null).trigger('change');
            $('#comuna_codigo').val(null).trigger('change');
        }
        else{
            $('#barrio_codigo').prop('disabled',false);
        }
    });
});

$('#tipo_servicio').on('change',function(){
	$.ajax({
	    type: "POST",
	    url : '<?=PROOT?>datosGenerales/cargarServicios/'+this.value,
	    success : function(resp){
	    	if(resp.success){
	    		var html='';
					html += '<option value="">Seleccionar</option>';
	    		$.each(resp.servicios, function(idx, opt) {
    				html += '<option value="'+idx+'">'+opt+'</option>';
	    		});
	    		$('#servicio_id').html(html);
        		$('#servicio_id').prop('disabled',false);
	    	}else{

	    	}
		}
	});
});

$('.custom-file-input').on('change', function() { 
   let fileName = $(this).val().split('\\').pop(); 
   $(this).next('.custom-file-label').addClass("selected").html(fileName); 
});

</script>