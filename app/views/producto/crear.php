<?php $this->setSiteTitle('Nueva producto'); ?>
<?php $this->start('body');?>
<div class="card border-success">
  <div class="card-header text-center bg-success text-white">
    Nuevo producto
  </div>
  <div class="card-body">
    <?php $this->partial('producto','form');?>
  </div>
</div>
<?php $this->end(); ?>