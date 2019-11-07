<?php use App\Models\MargenesProd; ?>

<?php $this->setSiteTitle('Margenes por línea')?>
<?php $this->start('head'); ?>
<link rel="stylesheet" href="<?=PROOT?>css/footable/footable.bootstrap.css">
<?php $this->end(); ?>

<?php $this->start('body'); ?>

<div class="card border-dark">
   <div class="card-header text-center bg-dark text-white">
      <h5>Listado de margenes por línea</h5>
   </div>
   <div class="card-body pt-2">
      <a href="<?=PROOT?>margenesProd/nuevo" class="btn btn-info btn-xs float-right mb-2">Nuevo registro</a>
      <div class="table-responsive">
         <table id="table" class="table table-striped table-condensed table-bordered table-hover" data-filtering="true">
            <thead>
                    <tr class="text-center">
                     <th rowspan="2">Casa</th>
                     <th rowspan="2" class="border-secondary border-bottom-0">Nomrbe de la casa</th>
                     <th colspan="2" class="border-secondary">Bucaramanga</th>
                     <th colspan="2" class="border-secondary">Cucuta</th>
                     <th colspan="2" class="border-secondary">Valledupar</th>
                     <th colspan="2" class="border-secondary">Duitama</th>
                     <th rowspan="2">Estado</th>
                     <th rowspan="2">Acciones</th>
                  </tr>
                  <tr class="text-center">
                     <th data-type="text">Base</th>
                     <th data-type="text">Tat</th>
                     <th data-type="text">Base</th>
                     <th data-type="text">Tat</th>
                     <th data-type="text">Base</th>
                     <th data-type="text">Tat</th>
                     <th data-type="text">Base</th>
                     <th data-type="text">Tat</th>
                     <th class="d-none"></th>
                     <th class="d-none"></th>
                     <th class="d-none"></th>
                     <th class="d-none"></th>
                  </tr>
            </thead>
            <tbody class="small">

               <?php if($this->datos) foreach(json_decode($this->datos) as $datos): ?>
                  <tr>
                     <td><?= $datos->Casa;?></td>
                     <td><?= $datos->NombreCasa;?></td>
                     <td><?= $datos->BaseBUC;?></td>
                     <td><?= $datos->TatBUC;?></td>
                     <td><?= $datos->BaseCUC;?></td>
                     <td><?= $datos->TatCUC;?></td>
                     <td><?= $datos->BaseVAL;?></td>
                     <td><?= $datos->TatVAL;?></td>
                     <td><?= $datos->BaseDUI;?></td>
                     <td><?= $datos->TatDUI;?></td>
                     <td class="font-weight-bold text-<?=($datos->Estado)?'success':'danger'?>"><?= ($datos->Estado)?'Activo':'Inactivo'; ?></a></td>

                     <td><a href="<?=PROOT?>margenesProd/editar/<?=$datos->Casa?>" class="btn btn-info btn-xs btn-sm col-xs">
                           Editar
                        </a>
                        <?php if($datos->Estado):?>
                           <a href="<?=PROOT?>margenesProd/inactivar/<?=$datos->Casa?>" class="btn btn-danger btn-xs btn-sm col-xs" onclick="if(!confirm('Desea INACTIVAR este registro?')){return false;}">
                              Inactivar
                           </a>
                        <?php else:?>
                           <a href="<?=PROOT?>margenesProd/activar/<?=$datos->Casa?>" class="btn btn-success btn-xs btn-sm col-xs" onclick="if(!confirm('Desea ACTIVAR este registro?')){return false;}">
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
         
         "paging": {
            "enabled": true,
            "size": 15,
            "countFormat": "Paginas: {CP} de {TP}. Total de registros: {TR}",
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
</script>
<?php $this->end();?>