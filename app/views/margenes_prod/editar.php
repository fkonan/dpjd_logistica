<?php $this->setSiteTitle('Margenes por línea'); ?>
<?php $this->start('body');?>
<div class="card border-dark">
  <div class="card-header text-center bg-dark text-white">
    <h5>Editar registro</h5>
  </div>
  <div class="card-body">
    <?php $this->partial('margenes_prod','form');?>
  </div>
</div>
<?php $this->end(); ?>