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
        <h2>Lista de usuarios</h2>
    </div>
</div>
<br />
<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered table-striped table-responsive">
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Nombre</th>
                    <th>Tel&eacute;fono de oficina</th>
                    <th>Correo electr&oacute;nico</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach( $personas as $persona ):
                    ?>
                    <tr>
                        <td><?php echo $persona['Usuario']['usuario']?></td>
                        <td><?php echo $persona['Persona']['primer_nombre'] . ' ' . $persona['Persona']['segundo_nombre'] . ' ' . $persona['Persona']['primer_apellido'] . ' ' . $persona['Persona']['segundo_apellido']?></td>
                        <td><?php echo $persona['Persona']['telefono_oficina']?></td>
                        <td><?php echo $persona['Persona']['correo_electronico']?></td>
                    </tr>
                    <?php
                endforeach;    
                ?>
            </tbody>
        </table>
    </div>
</div>