<?php

namespace Application\Form;

use \Marabaixo\Abstrata\AbstractForm;

use Zend\Form\Element\Text;
use Zend\Form\Element\Password;

/**
 * Description of Novoadmin
 *
 * @author zeluis
 */
class LoginForm extends AbstractForm {
    
    public function __construct($name = null, $options = array()) {
        
        parent::__construct("login");
        
        $this->setAttribute("method", "POST");
        $this->setInputFilter(new Filter\LoginFilter());
        
        //input text - email
        $email = new Text("email");
        $email->setLabel("E-mail:");
        $email->setAttributes(array(
            "maxlength" => "100",
            "class" => "form-control",
            "placeholder" => "E-Mail"
        ));
        $email->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($email);

        //input text - senha
        $senha = new Password("senha");
        $senha->setLabel("Senha:");
        $senha->setAttributes(array(
                "maxlength" => "100",
                "class" => "form-control",
                "placeholder" => "Senha"
        ));
        $senha->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($senha);
        
    }
}
