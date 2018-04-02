<?php
/*
 * Autor DIMH@09-08-2014
 * */
    App::uses('CakeEmail', 'Network/Email');
    class SesionesController extends AppController{
        public $components = array('Session', 'Cookie');
        public $uses = array('Persona','Usuario','Correo');
        public $helpers = array('Js','Form','Html','Session');
        public $layout = 'loginlayout';
        
        public function index(){
            return $this->redirect(array('action' => 'login'));
        }
        public function login(){
            
            if( strlen($this->Cookie->read('usuario')) > 0 )
                $this->redirect(array('controller'=>'busquedas','action'=>'index'));
            if( $this->request->is('post') ){
                if( $this->Usuario->find('count',array('conditions'=>array('Usuario.usuario'=>$this->request->data['Usuario']['usuario'],'Usuario.contrasena'=>$this->request->data['Usuario']['contrasena']))) == 1 ){
                        
                    $usuario = $this->Usuario->find('first',
                        array(
                            'fields' => array('Persona.*','Usuario.*'),
                            'conditions'=>array('Usuario.usuario'=>$this->request->data['Usuario']['usuario']),
                            'joins' => array(
                                array(
                                    'alias' => 'Persona',
                                    'table' => 'personas',
                                    'type' => 'INNER',
                                    'conditions' => 'Persona.id = Usuario.persona_id'
                                )
                            )
                        )
                    );
                    $this->Usuario->save(array('Usuario'=>array('id'=>$usuario['Usuario']['id'],'token_recuperacion'=>'')));
                    //$persona        
                    $this->Cookie->write('persona',$usuario);
                    $this->Cookie->write('usuario',$usuario['Usuario']['usuario'],false);
                    // crear array de modulos a los que tiene acceso.
                    $modulos = array();
					if( $usuario['Usuario']['modulo_administracion'] == 1 )array_push($modulos,'administracion');
					if( $usuario['Usuario']['modulo_busqueda'] == 1 )array_push($modulos,'busqueda');
					if( $usuario['Usuario']['modulo_empresa'] == 1 )array_push($modulos,'empresa');
					if( $usuario['Usuario']['modulo_ticket'] == 1 )array_push($modulos,'ticket');
					if( $usuario['Usuario']['modulo_reporte'] == 1 )array_push($modulos,'reporte');
					$this->Cookie->write('modulos',$modulos);	
                    $this->redirect(array('controller'=>'busquedas','action'=>'index'));
                }else{
                    $this->Session->setFlash(__('<div class="alert alert-danger"><strong>Error:</strong> Sus credenciales son incorrectas.</div>'));
                    $this->redirect(array('action'=>'login'));
                }
            }/* fin de post */

        }/* fin de funcion login */   
        
        public function recuperar( $token = '' ){
            
            if( $this->request->is('get') && strlen($token) == 32 ){
                // buscar el codigo en la base de datos
                if( $this->Usuario->find('count',array('conditions'=>array('Usuario.token_recuperacion'=>$token))) == 1 ){
                    $this->set('usuario',$this->Usuario->find('first',array('conditions'=>array('Usuario.token_recuperacion'=>$token))));
                    $this->render('/Sesiones/cambiarcontrasena');
                }else{
                    $this->Session->setFlash('<div class="alert alert-danger"><strong>Error: </strong> Su c&oacute;digo de recuperaci&oacute;n no pudo ser verificado. Por favor solicite acceso al sistema nuevamente.</div>','default');
                    $this->redirect( array('action'=>'login') );
                }
            }
            
            if( $this->request->is('post') && strlen($token) == 32 ){
                // cambiar contrasena.
                if( $this->Usuario->find('count',array('conditions'=>array('Usuario.token_recuperacion'=>$token))) == 1 ){
                    $this->request->data['Usuario']['token_recuperacion'] = '';
                    if( $this->Usuario->save($this->request->data) ){
                        $this->Session->setFlash('<div class="alert alert-success"><strong>&Eacute;xito: </strong> Su contrase&ntilde;a fue cambiada satisfactoriamente. Por favor inicie sesi&oacute;n.</div>','default');
                        $this->redirect( array('action'=>'login') );           
                    }           
                }
                $this->Session->setFlash('<div class="alert alert-danger"><strong>Error: </strong> Su c&oacute;digo de recuperaci&oacute;n no pude ser verificado. Por favor solicite acceso al sistema nuevamente.</div>','default');
                $this->redirect( array('action'=>'login') );
            }
            
            if( $this->request->is('post') && strlen($token) == 0 ){
                $this->generarCodigoRecuperacion();
            }    
            
        }/* fin de funcion recuperar */
        
        public function salir(){
            $this->Cookie->delete('usuario');
            $this->Cookie->delete('persona');
            $this->Cookie->delete('modulos');
            $this->redirect(array('controller'=>'sesiones','action'=>'login'));
        }/* fin de funcion salir */
        
        public function generarCodigoRecuperacion(){

            if( isset($_POST['email'])){
                $email = $_POST['email'];
                // verificar si el correo existe en la base de datos.
                $persona = $this->Usuario->find('first',array(
                    'fields' => array('Persona.*','Usuario.*'),
                    'conditions'=>array('Persona.correo_electronico'=>$email),
                    'joins' => array(
                       array(
                           'alias' => 'Persona',
                           'table' => 'personas',
                           'type' => 'Inner',
                           'conditions' => 'Persona.id = Usuario.persona_id'
                       ) 
                    )
                ));
                if( array_key_exists('Persona', $persona) ){
                    $codigo = md5(rand(10000,100000));
                    $objeto = array(
                        'Usuario' => array(
                            'id' => $persona['Usuario']['id'],
                            'token_recuperacion' => $codigo
                        )
                    );
                    if( $this->Usuario->save($objeto) ):
                        // enviar correo electronico con Token.
                        $nombre = $persona['Persona']['primer_nombre'] . ' ' . $persona['Persona']['primer_apellido'];
                        $usuario = $persona['Usuario']['usuario'];
                        $sistema = Configure::read('Institucion.nombre_sistema');
                        $correo = Configure::read('Institucion.correo');
                        $url = Router::fullbaseUrl();
                        $mensaje = $this->Correo->recuperacion;
                        $mensaje = sprintf($mensaje,$nombre,$sistema,$url,$codigo,$usuario);

                        $Email = new CakeEmail('smtp');
                        $Email->emailFormat('html')
                            ->to($email)
                            ->subject('Recuperación de acceso')
                            ->send($mensaje);
                        $this->Session->setFlash('<div class="alert alert-success"><strong>&Eacute;xito! </strong> Se ha enviado instrucciones para recuperar su acceso a su correo electr&oacute;nico.</div>');
                        $this->redirect( array('action'=>'login') );
                    endif;
                }// fin de si existe email.
            }
            $this->Session->setFlash( '<div class="alert alert-danger"><strong>Error: </strong> Su identidad no pudo ser verificada. Por favor dig&iacute;te un correo electr&oacute;nico v&aacute;lido para recuperar su acceso al sistema.</div>','default');    
        }/* fin de metodo */
    }
?>