<?php

namespace Application\Form\Filter;

use Zend\InputFilter\Input;
use Zend\InputFilter\FileInput;

/**
 * Description of NovoadminFilter
 *
 * @author zeluis
 */
class SenhaFilter extends \Zend\InputFilter\InputFilter{
    
    public function __construct() {
        
        $senha = new Input("senha");
        $senha->setRequired(true);
        $fc = $senha->getFilterChain();
        $fc->attach(new \Zend\Filter\StringTrim());
        $vc = $senha->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $vc->attach(new \Zend\Validator\StringLength(array('min' => 6)));
        $this->add($senha);
        
        $confirma_senha = new Input("confirma_senha");
        $confirma_senha->setRequired(true);
        $fc = $confirma_senha->getFilterChain();
        $fc->attach(new \Zend\Filter\StringTrim());
        $vc = $confirma_senha->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $vc->attach(new \Zend\Validator\StringLength(array('min' => 6)));
        $this->add($confirma_senha);

    }
}
