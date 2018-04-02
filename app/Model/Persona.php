<?php
 /*
 Autor: DIMH@09-08-2014
 */

App::uses('AppModel','Model');
class Persona extends AppModel{
    public $name = 'Persona';
    public $useTable = 'personas';
    public $hasOne = 'Usuario';
    public $hasMany = array(
        'Mensaje' => array(
            'className' => 'Mensaje',
            'foreignKey' => 'persona_id'
        ),
        'Criterioticket' => array(
            'className' => 'Criterioticket',
            'foreignKey' => 'persona_id'
        )
    );
}
?>