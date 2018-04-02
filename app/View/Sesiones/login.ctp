<div class="row center-vertically">
	<div class="loginform">
		<?php echo $this->Form->create('Usuario',array('role'=>'form'))?>
	    <div class="col-md-2">
	    	<?php echo $this->Html->image('dica.png',array('style'=>'max-width:60px;'))?>
	    </div>
	    <div class="col-md-10">
	    	<p>Bienvenido(a) al Infosistema. Para continuar, inicie sesi&oacute;n usando su ID de usuario y clave.<br /><br /></p>
	    </div>
	    <div class="col-md-12"><?php echo $this->Session->flash()?></div>
	    <div class="col-md-12">
			<div class="form-group">
		        <div class="input-group">
		        	<span class="input-group-addon"><i class="fa fa-user"></i></span>
		            <?php echo $this->Form->input('usuario',array('label'=>false,'div'=>false,'class'=>'form-control','placeholder'=>'ID de usuario','id'=>'txt_usuario','data-validetta'=>'required'))?>
		        </div>
			</div>
			<div class="form-group">    
		        <div class="input-group">
		            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
		            <?php echo $this->Form->input('contrasena',array('type'=>'password','label'=>false,'div'=>false,'class'=>'form-control','placeholder'=>'clave','id'=>'contrasena','data-validetta'=>'required'))?>
		        </div>
			</div>		
	    </div>
	    <div class="col-md-12">	        
	        <input type="button" id="btn_enviar" class="form-control btn btn-primary" value="Entrar">
	        <?php echo $this->Html->link('Olvid&eacute; mi contrase&ntilde;a',array('controller'=>'sesiones','action'=>'recuperar'),array('escape'=>false));?>
	    </div>
	    <?php echo $this->Form->end()?>
	</div>
</div>
<script type="text/javascript">
	var formulario = document.getElementById('UsuarioLoginForm');
    $(document).ready(function(){
        $('#btn_enviar').click(function(){
            if( $('#contrasena').val().length > 0 && $('#txt_usuario').val().length > 0 ){
            	$('#contrasena').val($.md5($('#contrasena').val()));
				formulario.submit();
			}
        });
        $('#contrasena').keypress(function (ev) {
            var keycode = (ev.keyCode ? ev.keyCode : ev.which);
            if (keycode == '13') {
                $('#btn_enviar').click();
            }
        });
        // automatically close alerts
		window.setTimeout(function() {
		    $(".alert-success,.alert-danger").fadeTo(1500, 0).slideUp(500, function(){
		        $(this).remove(); 
		    });
		}, 5000);
    });
</script>