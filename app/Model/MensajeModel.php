<?php
    /*
     * Autor DIMH@13-08-2014
     * */
     App::uses('AppModel','Model');
     class Mensaje extends AppModel{
         public $name = 'Mensaje';
         public $useTable = 'mensajes';
         public $belongsTo = array(
            'Person' => array(
                'className' => 'Person',
                'foreignKey' => 'persona_id'
            )
         );
     }
?>