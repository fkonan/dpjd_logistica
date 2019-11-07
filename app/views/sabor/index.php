<?php $this->setSiteTitle('Sabor')?>

<?php $this->start('head'); ?>
    <link rel="stylesheet" href="<?=PROOT?>css/footable/footable.standalone.css">
<?php $this->end(); ?>

<?php $this->start('body'); ?>
<div class="card border-success">
  <div class="card-header text-center bg-success text-white">
    Listado de Sabores
  </div>
  <div class="card-body pt-2">
    <a href="<?=PROOT?>sabor/nuevo" class="btn btn-info btn-xs float-right mb-2">Nuevo registro</a>
    <div class="table-responsive">
      <table class="table table-striped table-condensed table-bordered table-hover">
        <thead class="bg-info text-center">
          <th class="col-auto">Sabor</th>
          <th class="col-auto" data-filterable="false">Acciones</th>
        </thead>
        <tbody class="small">
          <?php foreach($this->datos as $datos): ?>
            <tr>
              <td><?= $datos->sabor; ?></a></td>
              <td>
                <a href="<?=PROOT?>sabor/editar/<?=$datos->id?>" class="btn btn-info btn-xs btn-sm">
                   Editar
                </a>
                <a href="<?=PROOT?>sabor/eliminar/<?=$datos->id?>" class="btn btn-danger btn-xs btn-sm" onclick="if(!confirm('Desea eliminar este registro?')){return false;}">
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