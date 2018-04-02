<?php
    /*
     * Autor DIMH@15092014
     * */
     App::uses('AppModel','Model');
    class Correo extends AppModel{
        public $name = 'Correo';
        public $useTable = false;
        public $recuperacion = "<p>Estimado(a) %s,<p> <p>Recibimos una solicitud para recuperar su acceso al sistema %s</p>
                                <h3><a href='%s/sesiones/recuperar/%s'>Recuperar acceso</a></h3><p>Su nombre de usuario es: <strong>%s</strong></p>
                                <p>Si ignora este mensaje su nombre de usuario y contrase&ntilde;a no se cambiar&aacute;n.</p>";
        
        public $nuevo_ticket = "<p>Un nuevo ticket ha sido creado por <strong>%s</strong></p>
                                <p><a href='%s/tickets/ver/%s'>%s</a></p>
                                <hr />
                                %s";
        
        public $nuevo_mensaje = "<p>Hola %s,</p>
                                 <p>%s ha comentado en el ticket <a href='%s/tickets/ver/%s'>%s</a>: </p>
                                 <hr />
                                 %s";
        
        public $servicio_sugerido_cliente = "<p>Hola %s</p>
                                    <p>%s ha sugerido el Servicio Tecnol&oacute;gico &#8220;%s&#8221; en el ticket <a href='%s/tickets/ver/%s'>%s</a>: </p>
                                    <hr />
                                    %s";
        
        public $servicio_sugerido_oferente = "<p>Hola %s</p>
                                    <p>%s ha sugerido su Servicio Tecnol&oacute;gico &#8220;%s&#8221; en el ticket <a href='%s/tickets/ver/%s'>%s</a>: </p>
                                    <hr />
                                    %s";
    }
?>