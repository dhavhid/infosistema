<?php
    /*
     * Autor DIMH@14-08-2014
     * */
     class ContribuyentesController extends AppController{
        public $uses = array('Contribuyente');
        public $components = array('Session', 'Cookie','Paginator');
        public $helpers = array('Js','Form','Html','Session','Paginator');
        public $layout = 'default';
        public $paginate = array(
            'fields' => array('Contribuyente.nit','Contribuyente.contribuyente_nombre'),
            'limit' => PER_PAGE,
            'order' => array('Contribuyente.contribuyente_nombre'=>'asc')
        );
        
        public function beforeRender(){
            parent::beforeRender();
            $this->set('menu_activo','administracion');
        }
        
        public function admin_index( $filtro = '' ){
        	// verificar permisos
        	if( $this->checkPermissions( 'administracion', 'index' ) === FALSE ):
        		$this->iraBuscar('alert-danger','<strong>Acceso denegado: </strong> usted no ha sido autorizado a acceder a esta secci&oacute;n.');
        	endif;
            
           $this->Paginator->settings = $this->paginate;
           $this->set('contribuyentes',$this->Paginator->paginate($this->Contribuyente,array(
                'OR' => array(
                    'Contribuyente.nit LIKE'=>"%{$filtro}%",
                    'Contribuyente.contribuyente_nombre LIKE'=>"%{$filtro}%"
                )
           )));
           $this->set('filtro',$filtro);
            
        }/* fin de funcion index */
        
        public function admin_importar(){
        	// verificar permisos
        	if( $this->checkPermissions( 'administracion', 'importar' ) === FALSE ):
        		$this->iraBuscar('alert-danger','<strong>Acceso denegado: </strong> usted no ha sido autorizado a acceder a esta secci&oacute;n.');
        	endif;
            if( $this->request->is('post') ){
                if( $_FILES['archivo'] && $_FILES['archivo']['error'] == UPLOAD_ERR_OK ):
                   
                    if(strtolower($_FILES['archivo']['type']) == 'text/csv'){
                        $data = $this->Csv->import($_FILES['archivo']['tmp_name'],
                            array(
                                'Contribuyente.nit',
                                'Contribuyente.contribuyente_nombre'
                            )
                        );
                        if( is_array($data) && count($data) > 1 ){
                            // guardar datos
                            array_shift($data); // se remueve la fila de cabeceras.
                            foreach( $data as $contribuyente ):
                                if( substr($contribuyente['Contribuyente']['nit'], 0, (strlen($contribuyente['Contribuyente']['nit'])-1)) != '0' )
                                    $contribuyente['Contribuyente']['nit'] = '0'.$contribuyente['Contribuyente']['nit'];
                                $this->Contribuyente->deleteAll(array('nit'=>$contribuyente['Contribuyente']['nit']));
                                $this->Contribuyente->create();
                                $this->Contribuyente->save($contribuyente);
                            endforeach;   
                            $this->Session->setFlash('<strong>&Eacute;xito!</strong> Las contribuyentes se importaron correctamente.','default',array('class'=>'alert alert-success'));
                            $this->redirect(array('action'=>'admin_index')); 
                        }else{
                            $this->Session->setFlash('<strong>Error:</strong> El archivo que est&aacute; tratando de adjuntar no contiene el formato v&aacute;lido de importaci&oacute;n.','default',array('class'=>'alert alert-danger'));
                        }
                    }else{
                        $this->Session->setFlash('<strong>Error:</strong> El archivo que est&aacute; tratando de adjuntar no es v&aacute;lido.','default',array('class'=>'alert alert-danger'));
                    }
                endif;
                }
        }/* fin de funcion importar */
        
        public function admin_imprimir( $filtro = '' ){
        	// verificar permisos
        	if( $this->checkPermissions( 'administracion', 'imprimir' ) === FALSE ):
        		$this->iraBuscar('alert-danger','<strong>Acceso denegado: </strong> usted no ha sido autorizado a acceder a esta secci&oacute;n.');
        	endif;
        	
            $this->set('contribuyentes',$this->Contribuyente->find('all',array(
                    'conditions' => array(
                        'OR' => array(
                            'Contribuyente.nit LIKE'=>"%{$filtro}%",
                            'Contribuyente.contribuyente_nombre LIKE'=>"%{$filtro}%"
                        )
                    ),
                    'order' => array('Contribuyente.contribuyente_nombre'=>'asc')
                ))
            );
            $this->layout = 'impresion';
        }/* fin de funcion imprimir */
     }
?>