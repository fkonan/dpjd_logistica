<?php $this->setSiteTitle('Vincular Auxiliar'); ?>
<?php $this->start('body');?>
<div class="card border-dark">
  <div class="card-header text-center bg-dark text-white">
    <h5>Vincular Nuevo Auxiliar</h5>
  </div>
  <div class="card-body">
    <?php $this->partial('logistica_pda_auxiliares','form_nuevo');?>
  </div>
</div>
<?php $this->end(); ?>