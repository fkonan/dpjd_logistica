<?php $this->start('body'); ?>
    <div class="container-fluid px-0 text-center">
        <img src="<?=PROOT?>img/Recordatorio.png" alt="Recordatorio">
        <h2>NO OLVIDE CAMBIAR SU FIRMA DE CORREO POR ESTA:</h2>
        <hr>
        <div class="row justify-content-center">
            <div class="col-md-2">
                <img class="border rounded " src="<?=PROOT?>img/logo_dpjd.png" alt="Logo">
            </div>
            <div class="col-md-4 border-left">
                <p class="mb-0 font-weight-bold">Distribuciones Pastor Julio Delgado S.A.</p>
                <p class="mb-0">"Ayudando a crecer"</p>
                <p class="mb-0 font-weight-bold">Nombres y Apellidos Completos</p>
                <p class="mb-0">Nombre del Cargo</p>
                <p class="mb-0">Tel:+(XX) 6XXXXXX  Ext XXX - Cel: 3XXXXXXXXX</p>
                <p class="mb-0">Ciudad/Agencia – Colombia </p>
            </div>
            <div class="col-md-12 text-wrap mt-3">
                <p class="font-weight-bold pt-3 mb-1">CALENDARIO SEMANAL 2019 PARA SOPORTE TELEFÓNICO EXTENDIDO DESDE SISTEMAS</p>
                <p><span class="font-weight-bold"> Nueva Línea Corporativa: <i class="fab fa-whatsapp fa-2x text-success"></i> WhatsApp y Línea de atención 3174017052</span></p>
                <p><span class="font-weight-bold">Horarios de atención regular:</span> Lunes a Viernes: 7:30am a 12:00pm  -  Sábados:7:00am a 12:30pm<br />
                (A través de la línea Corporativa o Extensiones: 123 (Elton Vertel) - 124 (Fabian Rangel) - 125 (Juan Velasco) - 126 (Daniel Torres)</p>

                <p><span class="font-weight-bold">Horarios de atención extendido:</span> Lunes a Viernes: 6:00am a 7:30am -12:00pm a 2:00pm y 6:00pm a 9:00pm  -  Sábados:12:30pm a 6:00pm<br />
                (A través de la nueva línea corporativa: 3174017052)</p>

                <p><b>NO SE ATENDERÁN EN LOS TELÉFONOS PERSONALES DE LOS INGENIEROS. POR FAVOR RESPETAR EL CANAL DE ATENCIÓN.</b></p>
            </div>      
        </div>  
        <hr>
        <div class="row justify-content-center">
            <?php include_once("calendario.php"); ?>
        </div>
    </div>
    <div class="container-fluid mt-2">
    	
    </div>
<?php $this->end(); ?>