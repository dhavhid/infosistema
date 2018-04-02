<br />
<div class="row">
    <div class="loginform">
        <div class="col-md-12">
            <p>Por favor digite su nueva contrase&ntilde;a. Recuerde que &eacute;sta debe contener por lo menos un n&uacute;mero y debe ser de por lo menos 5 caracteres de longitud.</p>
        </div>
        <div class="col-md-12" id="mensajes_alerta"><?php echo $this->Session->flash()?></div>
        <?php echo $this->Form->create('Usuario')?>
        <div class="col-md-12">
            <div class="form-group">
                <label>Nueva Contrase&ntilde;a <span class="required">*</span></label>
                <?php echo $this->Form->input('contrasena',array('id'=>'c1','type'=>'password','div'=>false,'label'=>false,'class'=>'form-control','data-validetta'=>'required,minLength[5]'))?>
            </div>
            <div class="form-group">
                <label>Repetir Contrase&ntilde;a <span class="required">*</span></label>
                <input type="password" class="form-control" data-validetta="required,minLength[5]" id="c2">
            </div>
            <div class="form-group">
                <a href="/sesiones/login" class="btn btn-default">Cancelar</a>
                <input type="submit" id="btn_enviar" class="btn btn-primary" value="Recuperar" />
            </div>
        </div>
        <?php echo $this->Form->hidden('id',array('value'=>$usuario['Usuario']['id']))?>
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
        $('#btn_enviar').click(function(){
            if( $('#c1').val().length > 0 && $('#c2').val().length > 0 ){
                // verificar si son iguales
                var number = /[0-9]/;
                if( $('#c1').val() != $('#c2').val()  ){
                    alert('Las contraseñas no coinciden.');
                    return false;
                }else{
                    if( !number.test($('#c1').val()) ){
                        alert('La contraseña debe contener por lo menos un número.');
                        return false;
                    }
                    $('#c1').val($.md5($('#c1').val()));
                }
            }
        });
    });
</script>