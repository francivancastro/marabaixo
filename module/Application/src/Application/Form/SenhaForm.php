<?php

namespace Application\Form;

use \Marabaixo\Abstrata\AbstractForm;

use Zend\Form\Element\Button;
use Zend\Form\Element\Password;

/**
 * Description of Novoadmin
 *
 * @author zeluis
 */
class SenhaForm extends AbstractForm {
    
    public function __construct($name = null, $options = array()) {
        
        parent::__construct("senha_form");
        
        $this->setAttribute("method", "POST");
        $this->setInputFilter(new Filter\SenhaFilter());
        
        //input text - senha
        $senha = new Password("senha");
        $senha->setLabel("Nova Senha:");
        $senha->setAttributes(array(
            "maxlength" => "100",
            "class" => "form-control col-sm-4"
        ));
        $senha->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($senha);
        
        //input text - confirma senha
        $confirma_senha = new Password("confirma_senha");
        $confirma_senha->setLabel("Confirmar Nova Senha:");
        $confirma_senha->setAttributes(array(
            "maxlength" => "100",
            "class" => "form-control col-sm-4"
        ));
        $confirma_senha->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($confirma_senha);

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
