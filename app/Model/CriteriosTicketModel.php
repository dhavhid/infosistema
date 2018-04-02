<?php
    /*
     * Autor DIMH@13-08-2014
     * */
     App::uses('AppModel','Model');
     class CriteriosTicket extends AppModel{
             
         public $name = 'Criteriosticket';
         public $useTable = 'criterio_tickets';
         public $primaryKey = 'id_criterio_ticket';
         public $belongsTo = array(
            'Persona' => array(
                'className' => 'Persona',
                'foreignKey' => 'persona_id'
            )
         );
     }
?>