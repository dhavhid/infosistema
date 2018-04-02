<?php
if( array_key_exists('Infosistema', $_COOKIE) ){
    $usuario = (array_key_exists('usuario', $_COOKIE['Infosistema']))? $_COOKIE['Infosistema']['usuario'] : '';
    if( (strlen($usuario) == 0 || empty($usuario)) && strpos($_SERVER['REQUEST_URI'],'/sesiones/login') === FALSE && strpos($_SERVER['REQUEST_URI'],'/sesiones/recuperar') === FALSE ){
        header('Location: /sesiones/login');
        die();
    }
}elseif( strpos($_SERVER['REQUEST_URI'],'/sesiones/login') === FALSE && strpos($_SERVER['REQUEST_URI'],'/sesiones/recuperar') === FALSE ){
    header('Location: /sesiones/login');
    die();
}
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
define('PER_PAGE',10);
class AppController extends Controller {
    
    public $components = array(/*'DebugKit.Toolbar',*/'Csv.Csv');
    
    public function beforeRender(){
		
        if( property_exists($this, 'Cookie') ){
    		if( $this->Cookie->check('persona') ):    	
    	    	$persona = $this->Cookie->read('persona');
    	    	if( is_array($persona) && array_key_exists('Persona', $persona) ){
    		    	$this->set('nombre_completo',$persona['Persona']['primer_nombre']. ' ' . $persona['Persona']['primer_apellido']);
    		    	$this->set('logged_in_user',$persona);
    		    }
    		endif;
        }else{
            $this->set('nombre_completo','Error');    
        }
		
    }/* fin de funcion beforeRender */
    
    public function slugify($text){ 
        // replace accents
        $text = str_replace(array("á","é","í","ó","ú"), array("a","e","i","o","u"), $text);
        
        // replace non letter or digits by -
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
        
        // trim
        $text = trim($text, '-');
        
        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        
        // lowercase
        $text = strtolower($text);
        
        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);
        
        if (empty($text)){
            return 'n-a';
        }
        
        $text = str_replace("'", "", $text);
        return $text;
    }/* fin de funcion slugify */
    
    public function checkPermissions( $modulo, $accion ){
	    
	    $persona = $this->Cookie->read('persona');
	    $modulos = $this->Cookie->read('modulos');
	    //verificar si el modulo esta entre los permitidos para el usuario
	    if( in_array($modulo, $modulos) ){
		    return TRUE;
		}/*else{
			// verificar si el usuario tiene acceso a reportes y la accion es un reporte.
			if( in_array('reporte', $modulos) && ($accion == 'ver' || $accion == 'imprimir') ):
				return TRUE;
			endif;	    
	    }// fin de in array modulo*/
	    return FALSE;
	    
    }/* fin de funcion checkPermissions */
    
    public function iraBuscar($tipoalerta, $mensaje){
    	
    	$this->Session->setFlash("<div class='alert {$tipoalerta}'>{$mensaje}</div>");
	    header('Location: /busquedas/index');
        die();
    }
    
}
