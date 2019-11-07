<?php use Core\FH; ?>
<?php $this->setSiteTitle('Logistica - Picking')?>

<?php $this->start('head'); ?>
<link rel="stylesheet" type="text/css" href="<?=PROOT?>css/bootstrap-table/bootstrap-table.min.css">
<link rel="stylesheet" type="text/css" href="<?=PROOT?>css/bootstrap-table/bootstrap-table-reorder-rows.css">
<?php $this->end(); ?>

<?php $this->start('body'); ?>
<div class="modal fade" id="ModalAjax" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="ModalAjaxTitle" aria-hidden="true">
   <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="ModalAjaxTitle">
               <i class="fa fa-info-circle fa-lg" aria-hidden="true"></i>
               <strong class="sr-only">Nota:</strong> Información del sistema
            </h5>
         </div>
         <div class="modal-body text-center">
            <i class="fa fa-refresh fa-spin fa-3x fa-fw"></i>
            <span class="sr-only">Cargando...</span>
            <p class="card-text mb-0">Por favor espere, estamos cargando la información.</p>
         </div>
      </div>
   </div>
</div>
<div class="card border-dark">
   <div class="card-header text-center bg-dark text-white">
      <h5>Listado de Pickings Pendientes</h5>
   </div>

   <div class="card-body pt-2">
      <div class="row">
         <?= FH::selectBlock('Selecione sistema *','sistema',$this->datos->Sistema,['B'=>'Base','T'=>'TAT'],['class'=>'form-control','placeHolder'=>'seleccione'],['class'=>'form-group col-md-3'],[]) ?>

         <div class="form-group col-md-2">
            <a href="#" onClick="listarPickingPendientes(); return;" class="btn btn-info btn-xs mt-4">Cargar/refrescar</a>
         </div>
      </div>

      <div class="row d-none" id="listado">
         <div class="table-responsive">
            <table id="table" 
            class="table table-striped table-condensed table-bordered table-hover"
            data-pagination="true"
            data-pagination-loop="false"
            data-height="100%"
            data-reorderable-rows="true"
            data-use-row-attr-func="true"

            >
               <thead class="thead-light">
                  <th data-field="Orden" class="col-auto">Orden</th>
                  <th data-field="DocNum" class="col-auto">Número de picking</th>
                  <th data-field="Cajas" class="col-auto">Total cajas</th>
                  <th data-field="Unidades" class="col-auto">Total unidades</th>
                  <th data-field="Estado" class="col-auto">Estado del picking</th>
                  <th data-field="Auxiliar" class="col-auto">Auxiliar</th>
                  <th data-field="Separado" class="col-auto">Picking separado?</th>
                  <th data-field="FechaInicio" class="col-auto">Fecha de inicio</th>
                  <th data-field="Sistema" class="col-auto">Sistema</th>
                  <th class="col-auto" data-filterable="true">Acciones</th>
               </thead>
            </table>
         </div>
      </div>
   </div>
</div>


<?php $this->end(); ?>
<?php $this->start('footer'); ?>
<script type="text/javascript" src="<?=PROOT?>js/bootstrap-table/jquery.tablednd.min.js"></script>
<script type="text/javascript" src="<?=PROOT?>js/bootstrap-table/bootstrap-table.min.js"></script>
<script type="text/javascript" src="<?=PROOT?>js/bootstrap-table/bootstrap-table-es-ES.min.js"></script>
<script type="text/javascript" src="<?=PROOT?>js/bootstrap-table/bootstrap-table-reorder-rows.min.js"></script>
<script type="text/javascript" src="<?=PROOT?>js/jquery-ui.min.js"></script>

<script>

function listarPickingPendientes(){
   
   var listado=document.getElementById('listado');//obtengo el div
   var sistema=document.getElementById('sistema').value;//obtengo el sistema que voy a filtrar

   if(sistema.length==0){
      alertMsg("Debe seleccionar un <b>sistema</b> para continuar",'danger');
      listado.classList.add('d-none');
      return;
   }  
   jQuery.ajax({
      //Cargo los pickin pendientes
      url : '<?=PROOT?>LogisticaPdaPicking/listarPickingPendiente',
      method : "POST",
      data : {sistema:sistema},

      beforeSend: function(){
      $('#ModalAjax').modal('show');
      },

      success : function(resp){
         if(resp.success){
            
            $('#ModalAjax').modal('hide');
            var tabla =$('#table');
            var posicion_inicial,posicion_final,orden,pick;

            tabla.bootstrapTable('destroy').bootstrapTable({

               onReorderRow:function(data){
                  jQuery.ajax({
                     url : '<?=PROOT?>LogisticaPdaPicking/organizarPick',
                     method : "POST",
                     data : {datos:data},
                     
                     success : function(resp){

                        if(resp.success){
                           tabla.bootstrapTable('load',resp.datos);
                        }else {

                           console.log('error, no rtrajo el suces');
                           console.log(resp.msg);
                           listado.classList.add('d-none');
                           alertMsg("Ha ocurrido un error",'danger');
                           return;
                        }
                     }
                  });
               },
               data:resp.datos,
               columns: [
                  {},
                  {},
                  {},
                  {},
                  {
                     formatter:cargarEstado
                  },
                  {
                     formatter:cargarAuxiliar
                  },
                  {
                     formatter:pickSeparado
                  },
                  {
                     formatter:fechaInicio
                  },
                  {
                     formatter:cargarSistema
                  },
                  {
                     field: 'Orden',
                     title: 'Acciones',
                     align: 'center',
                     clickToSelect: false,

                     formatter:btnAcciones// '<a class="btn btn-success" href="#" onclick="alert(value)">Ver detalle</a>'
                  }
               ]
            });
            listado.classList.remove('d-none');
         }else {

            console.log('error');
            //coloco el error en consola para saber cual fue.
            console.log(resp.msg);
            listado.classList.add('d-none');
            alertMsg("Ha ocurrido un error",'danger');
            return;
         }
      }
   });

   function btnAcciones(value, row, index,field) {
    
      return [
         '<a class="like" href="javascript:void(0)" onclick="alert(data.id);" title="Like">',
         '<i class="fa fa-heart"></i>',
         '</a>  ',
         '<a class="remove" href="javascript:void(0)" title="Remove">',
         '<i class="fa fa-trash"></i>',
         '</a>'
      ].join('')
   }

   function cargarEstado(value){
      switch(value) {
         case 0:
            return 'Por asignar';
            break;
         case 1:
            return 'Asignado';
            break;
         default:
            return 'Por asignar';
      }
   }

   function cargarAuxiliar(value){
      if(value)
         return value
      else
         return 'Por asignar';
   }

   function pickSeparado(value){
      if(value)
         return 'Si';
      else
         return 'No';
   }

   function fechaInicio(value){
      if(value)
         return value;
      else
         return 'No Asignado';
   }

   function cargarSistema(value){
      if(value=="B")
         return 'Base';
      else
         return 'TAT';
   }
}
</script>
<?php $this->end(); ?>