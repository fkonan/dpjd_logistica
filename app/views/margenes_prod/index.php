<?php use App\Models\MargenesProd; ?>

<?php $this->setSiteTitle('Margenes de productos')?>
<?php $this->start('head'); ?>
<link rel="stylesheet" href="<?=PROOT?>css/footable/footable.bootstrap.css">
<?php $this->end(); ?>

<?php $this->start('body'); ?>

<div class="card border-dark">
   <div class="card-header text-center bg-dark text-white">
      <h5>Listado de margenes de productos</h5>
   </div>
   <div class="card-body pt-2">
      <a href="<?=PROOT?>margenesProd/nuevo" class="btn btn-info btn-xs float-right mb-2">Nuevo registro</a>
      <div class="table-responsive">
         <table id="table" class="table table-striped table-condensed table-bordered table-hover" data-filtering="true">
            <thead>
               <th data-name="Sucursal" class="col-auto">Sucursal</th>
               <th class="col-auto">Nombre de la casa</th>
               <th data-type="number" class="col-auto">Valor margen Base</th>
               <th data-type="number" class="col-auto">Valor margen Tat</th>
               <th class="col-auto">Estado</th>
               <th class="col-auto" data-filterable="false">Acciones</th>
            </thead>
            <tbody class="small">
               <?php foreach(json_decode($this->datos) as $datos): ?>
                  <tr>
                     <td><?= MargenesProd::obtenerSucursal($datos->Sucursal);?></a></td>
                     <td><?= $datos->Casa.' - '.$datos->NombreCasa;?></a></td>
                     <td><?= $datos->U_MargenBase; ?></a></td>
                     <td><?= $datos->U_MargenTat; ?></a></td>
                     <td><?= ($datos->U_Estado)?'Activo':'Inactivo'; ?></a></td>
                     <td>
                        <a href="<?=PROOT?>margenesProd/editar/<?=$datos->Code?>" class="btn btn-info btn-xs btn-sm">
                           Editar
                        </a>
                        <?php if($datos->U_Estado):?>
                           <a href="<?=PROOT?>margenesProd/inactivar/<?=$datos->Code?>" class="btn btn-danger btn-xs btn-sm col-auto" onclick="if(!confirm('Desea INACTIVAR este registro?')){return false;}">
                              Inactivar
                           </a>
                        <?php else:?>
                           <a href="<?=PROOT?>margenesProd/activar/<?=$datos->Code?>" class="btn btn-success btn-xs btn-sm col-auto" onclick="if(!confirm('Desea ACTIVAR este registro?')){return false;}">
                              Activar
                           </a>
                        <?php endif;?>
                     </td>
                  </tr>
                  <?php endforeach; ?>
               </tbody>
            </table>
         </div>
      </div>
   </div>
<?php $this->end(); ?>
<?php $this->start('footer'); ?>
<script src="<?=PROOT?>js/footable/footable.js" type="text/javascript"></script>
<script>
   jQuery(function($){

      FooTable.components.register('filtering', FooTable.FiltroSucural);

      FooTable.init('#table',{
         components: {
            filtering: FooTable.FiltroSucural
         },
         "paging": {
            "enabled": true,
            "size": 20,
            "countFormat": "{CP} de {TP}"
         },
         "sorting": {
            "enabled": true
         },
         "filtering": {
            "enabled": true,
            "placeholder": "Buscar",
            "dropdownTitle":"Campos para buscar",
            "container":"#data-filter-container"
         }
      });
   });

   FooTable.FiltroSucural = FooTable.Filtering.extend({
      construct: function(instance){
         this._super(instance);
         this.Sucursales = ['Bucaramanga','Cucuta','Duitama','Valledupar'];
         this.def = 'Seleccionar';
         this.$Sucursal = null;
      },
      $create: function(){
         this._super();
         var self = this,
         $form_grp = $('<div/>', {'class': 'form-group'})
         .append($('<label/>', {'class': 'col-md-4', text: 'Sucursal'}))
         .prependTo(self.$form);

         self.$Sucursal = $('<select/>', { 'class': 'form-control' })
         .on('change', {self: self}, self._onSucursalDropdownChanged)
         .append($('<option/>', {text: self.def}))
         .appendTo($form_grp);

         $.each(self.Sucursales, function(i, Sucursal){
            self.$Sucursal.append($('<option/>').text(Sucursal));
         });
      },
      _onSucursalDropdownChanged: function(e){
         var self = e.data.self,selected = $(this).val();
         if (selected !== self.def){
            self.addFilter('Sucursal', selected, ['Sucursal']);
         } else {
            self.removeFilter('Sucursal');
         }
         self.filter();
      },
      draw: function(){
         this._super();
         var Sucursal = this.find('Sucursal');
         if (Sucursal instanceof FooTable.Filter){
            this.$Sucursal.val(Sucursal.query.val());
         } else {
            this.$Sucursal.val(this.def);
         }
      }
   });
</script>
<?php $this->end();?>