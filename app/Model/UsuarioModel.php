<?php
 /*
 Autor: DIMH@09-08-2014
 */

App::uses('AppModel','Model');
class Usuario extends AppModel{
    public $name = 'Usuario';
    public $useTable = 'usuarios';
    public $belongsTo = array(
        'Persona' => array(
            'className' => 'Persona',
            'foreignKey' => 'persona_id'
        ),
        'Empresa' => array(
            'className' => 'Empresa',
            'foreignKey' => 'empresa_id'
        )
    );
}
?>