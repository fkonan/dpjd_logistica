<?php $this->setSiteTitle('Nuevo usuario'); ?>
<?php $this->start('body');?>
<div class="card border-success">
  <div class="card-header text-center bg-success text-white">
    Nuevo usuario
  </div>
  <div class="card-body">
    <?php $this->partial('users','form');?>
  </div>
</div>
<?php $this->end(); ?>