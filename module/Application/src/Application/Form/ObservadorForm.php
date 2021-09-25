<?php

namespace Application\Form;

use \Marabaixo\Abstrata\AbstractForm;

use Zend\Form\Element\Text;
use Zend\Form\Element\Button;

/**
 * Description of Novoadmin
 *
 * @author zeluis
 */
class ObservadorForm extends AbstractForm {
    
    public function __construct($name = null, $options = array()) {
        
        parent::__construct("formulario_observador");
        
        $this->setAttribute("method", "POST");
        $this->setInputFilter(new Filter\ObservadorFilter());

        $obj = new \Zend\Form\Element\Hidden("id");
        $obj->setAttribute("id", $obj->getName());
        $this->add($obj);
        
        $obj = new \Marabaixo\Form\Element\Dominio("id_observador_tipo");
        $obj->setLabel("Tipo");
        $obj->setOption("dominio", "ObservadorTipo");
        $obj->setLabelAttributes(array("class" => "col-sm-2 control-label"));
        $obj->setAttribute("class", "form-control-item");
        $this->add($obj);        
        
        $obj = new Text("descricao");
        $obj->setLabel("Descriçao:");
        $obj->setAttributes(array(
            "maxlength" => "100",
            "class" => "form-control col-sm-4"
        ));
        $obj->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($obj);

        $obj = new Text("class_name");
        $obj->setLabel("Nome Classe:");
        $obj->setAttributes(array(
            "maxlength" => "100",
            "class" => "form-control col-sm-4"
        ));
        $obj->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($obj);

        $obj = new Text("minutos");
        $obj->setLabel("Minutos:");
        $obj->setAttributes(array(
            "maxlength" => "100",
            "class" => "form-control col-sm-2"
        ));
        $obj->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($obj);
        
        $obj = new \Zend\Form\Element\Select("status");
        $obj->setLabel("Status:");
        $obj->setAttributes(array(
            "class" => "form-control col-sm-4"
        ));
        $obj->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $obj->setValueOptions(array(
             'A' => 'ATIVO',
             'I' => 'INATIVO',
        ));
        $obj->setValue("A");
        $this->add($obj);
        
        $obj = new Button("submit");
        $obj->setValue("Salvar");
        $obj->setAttributes(array(
            "type" => "submit",
            "class" => "btn btn-primary"
        ));
        $obj->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($obj);
                        
    }
}
