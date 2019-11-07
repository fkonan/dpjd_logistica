<?php use Core\FH; ?>
<?php $this->setSiteTitle('Buscar persona'); ?>

<?php $this->start('body');?>
<div class="card border-success">
    <div class="card-header text-center bg-success text-white">
        Buscar persona
    </div>
    <div class="card-body">
        <form class="form" action=<?=$this->postAction?> method="post" id="form"> 
            <?= FH::displayErrors($this->displayErrors) ?>
            <div class="row">
                <?= FH::inputBlock('number','Número de documento','documento',$this->datos->documento,['class'=>'form-control'],['class'=>'form-group col-md-4','onchange'=>'buscar(); return false;'],$this->displayErrors) ?>
                
                <?= FH::inputBlock('text','Nombres','nombres',$this->datos->nombres,['class'=>'form-control'],['class'=>'form-group col-md-4','onchange'=>'buscar(); return false;'],$this->displayErrors) ?>
                
                <?= FH::inputBlock('text','Primer apellido','primer_apellido',$this->datos->primer_apellido,['class'=>'form-control'],['class'=>'form-group col-md-4','onchange'=>'buscar(); return false;'],$this->displayErrors) ?>
            </div>
            <div class="d-flex justify-content-end">
                <a href="#" onclick="buscar(); return false;" class="btn btn-info btn-xs">Buscar</a>
                <a href="<?=PROOT?>datosGenerales/nuevo" class="btn btn-success btn-xs ml-2">Crear persona</a>
            </div>
        </form>
    </div>
</div>
<div class="card border-success">
    <div class="card-header text-center bg-success text-white">
        Resultado de la busqueda
    </div>
    <div class="card-body">
        <form class="form" action=""method="get">
            <div class="table-responsive">
                <table class="table table-striped table-condensed table-bordered table-hover">
                    <thead class="bg-info text-center">
                        <th class="col-auto">Documento</th>
                        <th class="col-auto">Nombres</th>
                        <th class="col-auto">Primer apellido</th>
                        <th class="col-auto">Segundo apellido</th>
                        <th class="col-auto">Acciones</th>
                    </thead>
                    <tbody class="small" id="contenido">
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</div>

<script>
function buscar(){
    var actual=window.location+'';
    var split = actual.split("/");
    var editar = split[split.length-1];
    editar=editar.replace('#','');
    if(editar=='1'){
        editar='/1';
    }
    else{
        editar='';        
    }
    var data = $("#form").serialize();  
    $.ajax({
        type: "POST",
        url : '<?=PROOT?>datosGenerales/buscar'+editar,
        data:data,
        success : function(resp){
            if(resp.success){
                var html='';
                var formulario='nuevo';
                if(resp.editar){
                    formulario='editar';
                }
                $.each(resp.datos, function(idx, opt) {
                html+='<tr><td>'+opt.documento+'</td><td>'+opt.nombres+'</td><td>'+opt.primer_apellido+'</td><td>'+opt.segundo_apellido+'</td><td><a role="button" class="btn btn-primary btn-xs" title="Seleccionar" href="<?=PROOT;?>datosGenerales/'+formulario+'/'+opt.id+'"><span ><i class="fas fa-check-circle fa-2x tn-group-vertical"></i></span></a></td></tr>';
                });

                $('#contenido').html(html);
                
            }else{
                alertMsg(resp.error, 'danger');                
            }
        }
    });
}
</script>

<?php $this->end();?>
