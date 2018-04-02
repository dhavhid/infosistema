<br />
<div class="row">
    <div class="loginform">
        <div class="col-md-12">
            <p>Por favor digite su correo electr&oacute;nico con el cual ha sido registrado en el sistema para enviarle instrucciones para recuperar su acceso al sistema.</p>
        </div>
        <div class="col-md-12" id="mensajes_alerta"><?php echo $this->Session->flash()?></div>
        <?php echo $this->Form->create('Usuario')?>
        <div class="col-md-12">
            <div class="form-group">
                <label>Correo electr&oacute;nico <span class="required">*</span></label>
                <input type="text" class="form-control" data-validetta="required,email" id="txt_mail" name="email">
            </div>
            <div class="form-group">
                <a href="/sesiones/login" class="btn btn-default">Cancelar</a>
                <input type="submit" id="btn_enviar" class="btn btn-primary" value="Solicitar acceso" />
            </div>
        </div>
        <?php echo $this->Form->end()?>
    </div><!-- fin de login div -->
</div>
<script type="text/javascript">
    $(document).ready(function(){
        validetta_obj = $('form').validetta({
            realTime : true,
            display: 'inline',
            onError: function(event){
                $('#mensajes_alerta').empty().append('<div class="alert alert-danger"><strong>Error:</strong> Existen errores en el formulario que desea enviar, por favor asegúrese de haber completado todos los campos obligatorios y haber digitado los datos correctamente.</div>');
                var body = $("html, body");
                body.animate({scrollTop:0}, '500', 'swing', function() {
                    $(".alert-danger").delay(10000).fadeTo(1500, 0).slideUp(500, function(){
                        $(this).remove(); 
                    });
                });
            }
        });
    });
</script>