<?php $this->setSiteTitle('Clientes')?>

<?php $this->start('head'); ?>
    <link rel="stylesheet" href="<?=PROOT?>css/footable/footable.standalone.css">
<?php $this->end(); ?>

<?php $this->start('body'); ?>
<div class="card border-success">
  <div class="card-header text-center bg-success text-white">
    Listado de clientes
  </div>
  <div class="card-body pt-2">
    <a href="<?=PROOT?>clientes/nuevo" class="btn btn-info btn-xs float-right mb-2">Nuevo registro</a>
    <div class="table-responsive">
      <table class="table table-striped table-condensed table-bordered table-hover">
        <thead class="bg-info text-center">
          <th class="col-auto">Número de documento</th>
          <th class="col-auto">Nombre del cliente</th>
          <th class="col-auto">Dirección</th>
          <th class="col-auto">Barrio</th>
          <th class="col-auto">Teléfono</th>
          <th class="col-auto">Celular</th>
          <th class="col-auto">Correo</th>
          <th class="col-auto">Fecha de nacimiento</th>
          <th class="col-auto" data-filterable="false">Acciones</th>
        </thead>
        <tbody class="small">
          <?php foreach($this->datos as $datos): ?>
            <tr>
              <td><?= $datos->documento; ?></a></td>
              <td><?= $datos->nombre; ?></a></td>
              <td><?= $datos->direccion; ?></a></td>
              <td><?= $datos->barrio; ?></a></td>
              <td><?= $datos->telefono; ?></a></td>
              <td><?= $datos->celular; ?></a></td>
              <td><?= $datos->correo; ?></a></td>
              <?php
                $mes_actual = date('m');
                $fecha_cumple = $datos->fecha_nacimiento;
                $mes_cumple = date('m', strtotime($fecha_cumple));
                if ($mes_actual == $mes_cumple):
              ?>
                <td class="bg-warning text-white font-weight-bold"><?= $datos->fecha_nacimiento; ?></a></td>
                <?php else:?>
                  <td><?= $datos->fecha_nacimiento; ?></a></td>
                <?php endif;?>
              <td>
                <a href="<?=PROOT?>clientes/editar/<?=$datos->id?>" class="btn btn-info btn-xs btn-sm">
                   Editar
                </a>
                <a href="<?=PROOT?>clientes/eliminar/<?=$datos->id?>" class="btn btn-danger btn-xs btn-sm" onclick="if(!confirm('Desea eliminar este registro?')){return false;}">
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
  <script src="<?=PROOT?>js/footable/footable.js"></script>
  <script src="<?=PROOT?>js/footable/footableConfig.js"></script>
<?php $this->end(); ?>