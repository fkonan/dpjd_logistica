<?php $this->setSiteTitle('Editar Auxiliar'); ?>
<?php $this->start('body');?>
<div class="card border-dark">
  <div class="card-header text-center bg-dark text-white">
    <h5>Editar Auxiliar: <?=$this->datos->Nombres.' '.$this->datos->Apellidos?></h5>
  </div>
  <div class="card-body">
    <?php $this->partial('logistica_pda_auxiliares','form_editar');?>
  </div>
</div>
<?php $this->end(); ?>