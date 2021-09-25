<?php

namespace Rh\Form;

use \Marabaixo\Abstrata\AbstractForm;
use Zend\Form\Element\Textarea;
use Zend\Form\Element\Button;
use Zend\Form\Element\Checkbox;

/**
 * 
 *
 * @author janio
 */
class ServidorAtivarForm extends AbstractForm {

    public function __construct($name = null, $options = array()) {

        parent::__construct("formulario_ativar");

        $this->setAttribute("method", "POST");
//        $this->setInputFilter(new Filter\ServidorEncaminhamentoFilter());

        $id = new \Zend\Form\Element\Hidden("id");
        $id->setAttribute("id", $id->getName());
        $this->add($id);

        $obj = new Checkbox('servidor_situacao');
        $obj->setLabel('Ativar/Desativar Servidor');
        $obj->setUseHiddenElement(true);
        $obj->setCheckedValue('A');
        $obj->setUncheckedValue('D');
        $obj->setAttributes(array(
            "class" => "checkbox"
        ));
        $obj->setLabelAttributes(array(
            'class' => 'col-sm-2 control-label'));

        $this->add($obj);

        $motivo = new Textarea("motivo");
        $motivo->setLabel("Motivo da Ativação/Desativação");
        $motivo->setAttributes(array(
            "class" => "col-sm-12",
            "rows" => "8"
        ));
        $this->add($motivo);


        $submit = new Button("submit");
        $submit->setValue("Ativar/Desativar");
        $submit->setAttributes(array(
            "type" => "submit",
            "class" => "btn btn-primary"
        ));
        $submit->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($submit);
    }

}
