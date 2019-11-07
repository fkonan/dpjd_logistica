<?php $this->setSiteTitle('Logistica - Auxiliares')?>


<?php $this->start('head'); ?>
<link rel="stylesheet" href="<?=PROOT?>css/footable/footable.bootstrap.css">
<?php $this->end(); ?>

<?php $this->start('body'); ?>
<div class="card border-dark">
  <div class="card-header text-center bg-dark text-white">
    <h5>Listado de Auxiliares</h5>
  </div>
  <div class="card-body pt-2">
    <a href="<?=PROOT?>logisticaPdaAuxiliares/nuevo" class="btn btn-info btn-xs float-right mb-2">Vincular nuevo auxiliar</a>
    <div class="table-responsive">
        <table id="table" class="table table-striped table-condensed table-bordered table-hover">
        <thead >
          <th class="col-auto">Documento indentidad</th>
          <th class="col-auto">Nombre del auxiliar</th>
          <th class="col-auto">Perfil del auxiliar</th>
          <th class="col-auto">Estado</th>
          <th class="col-auto">Agencia</th>
          <th class="col-auto">Sistema</th>
          <th class="col-auto" data-filterable="false">Acciones</th>
        </thead>
        <tbody class="small">
          <?php foreach(json_decode($this->datos) as $datos): ?>
            <tr>
              <td><?= $datos->CC; ?></a></td>
              <td><?= $datos->Nombres.' '.$datos->Apellidos; ?></a></td>
              <td><?= ($datos->Tipo=='C')?'Cajas':'Unidades' ?></a></td>
              <td class="font-weight-bold text-<?=($datos->Estado)?'success':'danger'?>"><?= ($datos->Estado)?'Activo':'Inactivo'; ?></a></td>
              <td><?= $datos->Sucursal; ?></a></td>
              <td><?= ($datos->Sistema=='B')?'Base':'TAT'; ?></a></td>
              <td>
                <a href="<?=PROOT?>logisticaPdaAuxiliares/editar/<?=$datos->CC?>" class="btn btn-info btn-xs btn-sm">
                   Editar
                </a>
                <?php if($datos->Estado):?>
                  <a href="<?=PROOT?>logisticaPdaAuxiliares/inactivar/<?=$datos->CC?>" class="btn btn-warning btn-xs btn-sm" onclick="if(!confirm('Desea INACTIVAR este registro?')){return false;}">
                    Inactivar
                  </a>
                <?php else:?>
                  <a href="<?=PROOT?>logisticaPdaAuxiliares/activar/<?=$datos->CC?>" class="btn btn-success btn-xs btn-sm" onclick="if(!confirm('Desea ACTIVAR este registro?')){return false;}">
                     Activar
                  </a>
                <?php endif;?>
                <a href="<?=PROOT?>logisticaPdaAuxiliares/eliminar/<?=$datos->CC?>" class="btn btn-danger btn-xs btn-sm" onclick="if(!confirm('Desea ELIMINAR este registro?')){return false;}">
                     Eliminar
                </a>
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
<script src="<?=PROOT?>js/footable/footableConfig.js" type="text/javascript"></script>
<?php $this->end(); ?>