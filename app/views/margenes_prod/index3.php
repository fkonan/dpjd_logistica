<?php use App\Models\MargenesProd; ?>

<?php $this->setSiteTitle('Margenes de productos')?>
<?php $this->start('head'); ?>
<link rel="stylesheet" href="<?=PROOT?>css/webdatarocks/webdatarocks.min.css">
<?php $this->end(); ?>

<?php $this->start('body'); ?>

<div class="card border-dark">
   <div class="card-header text-center bg-dark text-white">
      <h5>Listado de margenes de productos</h5>
   </div>
   <div class="card-body pt-2">
      <a href="<?=PROOT?>margenesProd/nuevo" class="btn btn-info btn-xs float-right mb-2">Nuevo registro</a>
      <div id="wdr-component"></div>

   </div>
</div>
<?php $this->end(); ?>
<?php $this->start('footer'); ?>
<script src="<?=PROOT?>js/webdatarocks/webdatarocks.toolbar.min.js" type="text/javascript"></script>
<script src="<?=PROOT?>js/webdatarocks/webdatarocks.js" type="text/javascript"></script>
<script>
   jQuery.ajax({
      url : '<?=PROOT?>margenesProd/indexAPI',
      method : "GET",
      success : function(resp){

         if(resp){
            var data=JSON.parse(resp);
            var pivot = new WebDataRocks({
                 container: "#wdr-component",
                 toolbar: true,
                 report: {
                     dataSource: {
                         data: data
                     }
                 }
             });
         }else {

            console.log('error, no rtrajo el suces');
            console.log(resp.msg);
            alertMsg("Ha ocurrido un error",'danger');
            return;
         }
      }
   });

    
</script>
<?php $this->end();?>