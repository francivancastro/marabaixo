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
class ControllerActionForm extends AbstractForm {
    
    public function __construct($name = null, $options = array()) {
        
        parent::__construct("formulario_controller_action");
        
        $this->setAttribute("method", "POST");
        $this->setInputFilter(new Filter\ControllerActionFilter());

        $id = new \Zend\Form\Element\Hidden("id_controller_action");
        $id->setAttribute("id", $id->getName());
        $this->add($id);

        $id_controller = new \Zend\Form\Element\Hidden("id_controller");
        $id_controller->setAttribute("id", $id->getName());
        $this->add($id_controller);
        
        $descricao = new Text("descricao");
        $descricao->setLabel("Descriçao:");
        $descricao->setAttributes(array(
            "maxlength" => "100",
            "class" => "form-control col-sm-4"
        ));
        $descricao->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($descricao);
        
        $action = new Text("action");
        $action->setLabel("Action:");
        $action->setAttributes(array(
            "maxlength" => "100",
            "class" => "form-control col-sm-4"
        ));
        $action->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($action);
        
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
