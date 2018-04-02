<?php
    /*
     * Autor DIMH@16-08-2014
     * */
     class UtilidadesController extends AppController{
         
         public $uses = array('Departamento','Municipio','ActividadesEconomica','Contribuyente','Empresa','Usuario','Persona','Correo');
         public $components = array('Session', 'Cookie','RequestHandler');
         
         public function departamentos(){
             
             $departamentos = $this->Departamento->find('all',array('fields'=>array('Departamento.id','Departamento.nombre_departamento'),'order'=>array('Departamento.nombre_departamento')));
             $items = array();
             foreach( $departamentos as $departamento ):
                 array_push($items,array('id'=>$departamento['Departamento']['id'],'nombre'=>$departamento['Departamento']['nombre_departamento']));
             endforeach;
             $this->set(array('items' => $items, '_serialize' => 'items'));
             
         }/* fin de la funcion departamentos */
         
         public function municipios( $departamento = 0 ){
             
             $municipios = $this->Municipio->find('all',array('conditions'=>array('Municipio.departamento'=>$departamento),'fields'=>array('Municipio.id','Municipio.nombre_municipio'),'order'=>array('Municipio.nombre_municipio')));
             $items = array();
             foreach( $municipios as $municipio ):
                 array_push($items,array('id'=>$municipio['Municipio']['id'],'nombre'=>$municipio['Municipio']['nombre_municipio']));
             endforeach;
             $this->set(array('items' => $items, '_serialize' => 'items'));
             
         }/* fin de la funcion municipios */
         
         public function actividades( $subactividad = '' ){
            
            $actividades = $this->ActividadesEconomica->find('all',array('conditions'=>array('ActividadesEconomica.subactividad'=>$subactividad),'fields'=>array('ActividadesEconomica.actividad_nombre','ActividadesEconomica.actividad_nombre'),'order'=>array('ActividadesEconomica.actividad_nombre ASC')));
            $items = array();
            foreach( $actividades as $actividad ):
                array_push( $items, array('id'=>$actividad['ActividadesEconomica']['actividad_nombre'],'nombre'=>$actividad['ActividadesEconomica']['actividad_nombre']) );
            endforeach;
            $this->set(array('items'=>$items, '_serialize'=>'items'));
                            
         }/* fin de la funcion actividades */
         
         public function actividad_principal(){
                
            $principales = $this->ActividadesEconomica->find('all',array('fields'=>array('DISTINCT ActividadesEconomica.actividad_principal'),'order'=>array('ActividadesEconomica.actividad_principal ASC')));
            $items = array();
            foreach( $principales as $principal ):
                array_push($items,array('id'=>$principal['ActividadesEconomica']['actividad_principal'],'nombre'=>$principal['ActividadesEconomica']['actividad_principal']));
            endforeach;
            $this->set(array('items'=>$items,'_serialize'=>'items'));
               
         }/* fin de la funcion actividad_principal */
         
         public function subactividad( $actividad = '0' ){
                
            $principales = $this->ActividadesEconomica->find('all',array('conditions'=>array('ActividadesEconomica.actividad_principal'=>$actividad),'fields'=>array('DISTINCT ActividadesEconomica.subactividad'),'order'=>array('ActividadesEconomica.subactividad ASC')));
            $items = array();
            foreach( $principales as $principal ):
                array_push($items,array('id'=>$principal['ActividadesEconomica']['subactividad'],'nombre'=>$principal['ActividadesEconomica']['subactividad']));
            endforeach;
            $this->set(array('items'=>$items,'_serialize'=>'items'));
               
         }/* fin de la funcion subactividad */
         
         public function contribuyentes( $tipo = 'nit', $filtro = '' ){
                 
             if( $tipo == 'nit' ){ 
                $contribuyentes = $this->Contribuyente->find('all',array('conditions'=>array('Contribuyente.nit LIKE'=>"{$filtro}%"),'order'=>array('Contribuyente.contribuyente_nombre ASC')));
             }else
                $contribuyentes = $this->Contribuyente->find('all',array('conditions'=>array('Contribuyente.contribuyente_nombre LIKE'=>"{$filtro}%"),'order'=>array('Contribuyente.contribuyente_nombre ASC')));
             
             $items = array();
             foreach( $contribuyentes as $contribuyente ):
                 array_push($items,array('nit'=>$contribuyente['Contribuyente']['nit'],'nombre'=>$contribuyente['Contribuyente']['contribuyente_nombre']));
             endforeach;
             $this->set(array('contribuyentes'=>$items,'_serialize'=>'contribuyentes'));
             
         }/* fin de la funcion contribuyentes */
         
         public function obtener_contacto( $empresa_id = '' ){
                 
             if( !is_numeric($empresa_id) ){
                 $this->set(array('error'=>'Debe especificar una empresa','_serialize'=>'error'));
                 return;
             }
             
             $contacto = $this->Empresa->find('all',
                array(
                    'conditions'=>array('Empresa.id'=>$empresa_id),
                    'fields'=>array('Persona.primer_nombre','Persona.primer_apellido','Persona.correo_electronico','Persona.correo_electronico_secundario'),
                    'joins' => array(
                        array(
                            'alias' => 'Usuario',
                            'table' => 'usuarios',
                            'type' => 'INNER',
                            'conditions' => 'Usuario.empresa_id = Empresa.id'
                        ),
                        array(
                            'alias' => 'Persona',
                            'table' => 'personas',
                            'type' => 'INNER',
                            'conditions' => 'Persona.id = Usuario.persona_id'
                        )
                    ),
                    'order' => array('Persona.primer_nombre ASC','Persona.primer_apellido ASC')                    
                )
             );
             $this->set(array('contactos'=>$contacto,'_serialize'=>'contactos'));
             
         }/* fin de la funcion obtener_contacto */
         
         public function verificar_correo( $correo, $persona_id ){
	         
	         $n = $this->Persona->find('count',array('conditions'=>array('Persona.correo_electronico'=>$correo,'Persona.id !='=>$persona_id)));
	         $this->set( array('items'=>array('n'=>$n),'_serialize'=>'items') );
         }
     }
?>