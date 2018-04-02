<br />
<div class="row">
    <div class="col-md-3">
        <a href="javascript:window.history.back();" class="btn btn-default">
            <i class="fa fa-times"></i>
            Cerrar
        </a>
        <a href="javascript:window.print();" class="btn btn-primary">
            <i class="fa fa-print"></i>
            Imprimir
        </a>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <h2>Lista de servicios tecnol&oacute;gicos</h2>
    </div>
</div>
<br />
<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered table-striped table-responsive footable">
            <thead>
                <tr>
                    <th>Servicio Tecnol&oacute;gico</th>
                    <th>Empresa</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach( $servicios as $servicio ):
                    ?>
                    <tr>
                        <td><?php echo $servicio['ServicioTecnologico']['nombre_servicio']?></td>
                        <td><?php echo $servicio['Empresa']['nombre_empresa']?></td>
                        <td><?php echo $this->Number->currency($servicio['ServicioTecnologico']['precio_servicio'], 'USD')?></td>
                    </tr>
                    <?php
                endforeach;    
                ?>
            </tbody>
        </table>
    </div>
    <?php //print_r($empresas)?>
</div>
