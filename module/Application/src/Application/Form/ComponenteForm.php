<?php

namespace Application\Form;

use \Marabaixo\Abstrata\AbstractForm;

use Zend\Form\Element\Text;
use Zend\Form\Element\Button;
use Zend\Form\Element\Date;
use Zend\Form\Element\Password;
use Zend\Form\Element\File;

/**
 * Description of Novoadmin
 *
 * @author zeluis
 */
class ComponenteForm extends AbstractForm {
    
    public function __construct($name = null, $options = array()) {
        
        parent::__construct("formulario_componente");
        
        $this->setAttribute("method", "POST");
        $this->setInputFilter(new Filter\ComponenteFilter());

        $id = new \Zend\Form\Element\Hidden("id_componente");
        $id->setAttribute("id", $id->getName());
        $this->add($id);
        
        $descricao = new Text("descricao");
        $descricao->setLabel("Descriçao:");
        $descricao->setAttributes(array(
            "maxlength" => "100",
            "class" => "form-control col-sm-4"
        ));
        $descricao->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($descricao);
        
        $icone = new Text("icone");
        $icone->setLabel("Icone:");
        $icone->setAttributes(array(
            "maxlength" => "100",
            "class" => "form-control col-sm-4"
        ));
        $icone->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($icone);
        
        $ordem = new \Zend\Form\Element\Select("ordem");
        $ordem->setLabel("Ordem:");
        $ordem->setAttributes(array(
            "class" => "form-control col-sm-4"
        ));
        $ordem->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($ordem);
        
        $submit = new Button("submit");
        $submit->setValue("Salvar");
        $submit->setAttributes(array(
            "type" => "submit",
            "class" => "btn btn-primary"
        ));
        $submit->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($submit);
        
        $cancelar = new Button("cancelar");
        $cancelar->setValue("Cancelar");
        $cancelar->setAttributes(array(
            "class" => "btn btn-default"
        ));
        $cancelar->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($cancelar);
    }
}
