<?php $this->setSiteTitle('Listado de usuarios')?>

<?php $this->start('head'); ?>
    <link rel="stylesheet" href="<?=PROOT?>css/footable/footable.standalone.css">
<?php $this->end(); ?>

<?php $this->start('body'); ?>
<div class="card border-success">
  <div class="card-header text-center bg-success text-white">
    Listado de usuarios
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-striped table-condensed table-bordered table-hover">
        <thead class="bg-info text-center">
            <th class="col-auto">Usuario</th>
            <th class="col-auto">Documento</th>
            <th class="col-auto">Nombre Completo</th>
            <th class="col-auto">Correo</th>
            <th class="col-auto">Entidad</th>
            <th class="col-auto">Programa</th>
            <th class="col-auto">Rol</th>
            <th class="col-auto">Estado</th>
            <th class="col-auto" data-filterable="false">Acciones</th>
        </thead>
        <tbody class="small">
          <?php foreach($this->users as $user): ?>
            <tr>
              <td><?=$user->user; ?></a></td>
              <td><?=$user->documento?></td>
              <td><?=$user->nombres.' '.$user->apellidos;?></td>
              <td><?=$user->correo;?></td>
              <td><?=$user->entidad;?></td>
              <td><?=$user->programa;?></td>
              <td><?=$user->acl;?></td>
              <td><?=$user->estado?'ACTIVO':'INACTIVO';?></td>
              <td>
                <a href="<?=PROOT?>users/editar/<?=$user->id?>" class="btn btn-info btn-xs btn-sm">
                   Editar
                </a>
                <a href="<?=PROOT?>users/eliminar/<?=$user->id?>" class="btn btn-danger btn-xs btn-sm" onclick="if(!confirm('Desea desactivar este usuario?')){return false;}">
                   Inactivar
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