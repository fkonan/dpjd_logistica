<?php $this->setSiteTitle('Nueva factura'); ?>
<?php $this->start('body');?>
<div class="card border-success">
  <div class="card-header text-center bg-success text-white">
    Nueva Factura
  </div>
  <div class="card-body">
    <?php $this->partial('factura','form');?>
  </div>
</div>
<?php $this->end(); ?>

