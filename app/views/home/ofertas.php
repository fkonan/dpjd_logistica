<?php 
$this->setSiteTitle('Ofertas')?>

<?php $this->start('head'); ?>
    <link rel="stylesheet" href="<?=PROOT?>css/footable/footable.standalone.css">
<?php $this->end(); ?>

<?php $this->start('body'); ?>
<div class="card border-success">
  <div class="card-header text-center bg-success text-white">
    Listado de Ofertas
  </div>
  <div class="card-body pt-2">
    <a href="<?=PROOT?>Home/pvd" class="btn btn-info btn-xs float-right mb-2">Volver</a>
    <div class="table-responsive">
      <table class="table table-striped table-condensed table-bordered table-hover">
        <thead class="bg-info text-center">
          <th class="col-auto">Tipo de oferta</th>
          <th class="col-auto">Nombre de la oferta</th>
          <th class="col-auto">Horario</th>
          <th class="col-auto">Requisitos</th>
          <th class="col-auto">Información adicional</th>
          <th class="col-auto">Cupos</th>
          <th class="col-auto">Fecha de inicio</th>
          <th class="col-auto" data-filterable="false">Acciones</th>
        </thead>
        <tbody class="small">
          <?php foreach($this->datos as $datos): ?>
            <tr>
              <td><?= $datos->tipo_servicio; ?></a></td>
              <td><?= $datos->servicio; ?></a></td>
              <td><?= $datos->oferta; ?></a></td>
              <td><?= $datos->horario; ?></a></td>
              <td><?= $datos->requisitos; ?></a></td>
              <td><?= $datos->informacion; ?></a></td>
              <td><?= $datos->cupos; ?></a></td>
              <td><?= $datos->fecha_inicio; ?></a></td>
              <td>
                <a href="<?=PROOT?>datosGenerales/nuevo" class="btn btn-info btn-xs btn-sm">
                   Aplicar
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