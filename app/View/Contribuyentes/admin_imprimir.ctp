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
        <h2>Lista de contribuyentes</h2>
    </div>
</div>
<br />
<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered table-striped table-responsive">
            <thead>
                <tr>
                    <th>NIT</th>
                    <th>Contribuyente</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach( $contribuyentes as $contribuyente ):
                    ?>
                    <tr>
                        <td><?php echo $contribuyente['Contribuyente']['nit']?></td>
                        <td><?php echo $contribuyente['Contribuyente']['contribuyente_nombre']?></td>
                    </tr>
                    <?php
                endforeach;    
                ?>
            </tbody>
        </table>
    </div>
</div>