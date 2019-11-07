<?php $this->setSiteTitle('Nuevo Cliente'); ?>
<?php $this->start('body');?>
<div class="card border-success">
  <div class="card-header text-center bg-success text-white">
    Nuevo Cliente
  </div>
  <div class="card-body">
    <?php $this->partial('clientes','form');?>
  </div>
</div>
<?php $this->end(); ?>