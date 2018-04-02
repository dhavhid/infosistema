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
        <h2>Lista de empresas</h2>
    </div>
</div>
<br />
<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered table-striped table-responsive footable">
            <thead>
                <tr>
                    <th>Empresa</th>
                    <th>NIT</th>
                    <th>Contacto</th>
                    <th>Giro</th>
                    <th>Direcci&oacute;n</th>
                    <th>Tel&eacute;fono</th>
                    <th>Correo electr&oacute;nico</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach( $empresas as $empresa ):
                    ?>
                    <tr>
                        <td><?php echo $empresa['Empresa']['nombre_empresa']?></td>
                        <td><?php echo $empresa['Empresa']['nit']?></td>
                        <td><?php echo $empresa['Persona']['primer_nombre'] . ' ' . $empresa['Persona']['primer_apellido']?></td>
                        <td><?php echo $empresa['Empresa']['giro']?></td>
                        <td><?php echo $empresa['Empresa']['direccion_final'] . '<br />' . $empresa['Municipio']['nombre_municipio'] . '<br />' . $empresa['Departamento']['nombre_departamento'];?></td>
                        <td><a href="tel:<?php echo $empresa['Empresa']['telefono']?>"><?php echo $empresa['Empresa']['telefono']?></a></td>
                        <td><a href="mailto:<?php echo $empresa['Empresa']['correo_electronico']?>" target="_blank"><?php echo $empresa['Empresa']['correo_electronico']?></a></td>
                    </tr>
                    <?php
                endforeach;    
                ?>
            </tbody>
        </table>
    </div>
    <?php //print_r($empresas)?>
</div>
