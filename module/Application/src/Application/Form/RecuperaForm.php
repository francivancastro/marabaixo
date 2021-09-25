<?php

namespace Application\Form;

use \Marabaixo\Abstrata\AbstractForm;

use Zend\Form\Element\Button;
use Zend\Form\Element\Text;

/**
 * Description of Novoadmin
 *
 * @author zeluis
 */
class RecuperaForm extends AbstractForm {
    
    public function __construct($name = null, $options = array()) {
        
        parent::__construct("recupera_senha_form");
        
        $this->setAttribute("method", "POST");
        $this->setInputFilter(new Filter\RecuperaFilter());
        
        //input text - email
        $email = new Text("email");
        $email->setLabel("E-mail:");
        $email->setAttributes(array(
            "maxlength" => "100",
            "class" => "form-control col-sm-4"
        ));
        $email->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($email);

        //input submit - enviar
        $submit = new Button("submit");
        $submit->setValue("Enviar Formulário");
        $submit->setAttributes(array(
            "type" => "submit",
            "class" => "btn btn-primary"
        ));
        $submit->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($submit);
        
    }
}
