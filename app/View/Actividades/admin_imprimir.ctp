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
        <h2>Lista de actividades econ&oacute;micas</h2>
    </div>
</div>
<br />
<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered table-striped table-responsive">
            <thead>
                <tr>
                    <th>C&oacute;digo</th>
                    <th>Actividad econ&oacute;mica</th>
                    <th>Subcategor&iacute;a</th>
                    <th>Categor&iacute;a</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach( $actividades as $actividad ):
                    ?>
                    <tr>
                        <td><?php echo $actividad['ActividadesEconomica']['actividad_codigo']?></td>
                        <td><?php echo $actividad['ActividadesEconomica']['actividad_nombre']?></td>
                        <td><?php echo $actividad['ActividadesEconomica']['subactividad']?></td>
                        <td><?php echo $actividad['ActividadesEconomica']['actividad_principal']?></td>
                    </tr>
                    <?php
                endforeach;    
                ?>
            </tbody>
        </table>
    </div>
</div>