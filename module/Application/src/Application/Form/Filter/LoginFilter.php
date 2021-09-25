<?php

namespace Application\Form\Filter;

use Zend\InputFilter\Input;

/**
 * Description of NovoadminFilter
 *
 * @author zeluis
 */
class LoginFilter extends \Zend\InputFilter\InputFilter{
    
    public function __construct() {
        
        $email = new Input("email");
        $email->setRequired(true);
        $vc = $email->getValidatorChain();
        $vc->attach(new \Zend\Validator\EmailAddress());
        $this->add($email);
        
        $senha = new Input("senha");
        $senha->setRequired(true);
        $fc = $senha->getFilterChain();
        $fc->attach(new \Zend\Filter\StringTrim());
        $vc = $senha->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $vc->attach(new \Zend\Validator\StringLength(array('min' => 6)));
        $this->add($senha);

    }
}
