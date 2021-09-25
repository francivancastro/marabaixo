<?php

namespace Application\Form\Filter;

use Zend\InputFilter\Input;
use Zend\InputFilter\FileInput;

/**
 * Description of NovoadminFilter
 *
 * @author zeluis
 */
class RecuperaFilter extends \Zend\InputFilter\InputFilter{
    
    public function __construct() {
        
        $email = new Input("email");
        $email->setRequired(true);
        $vc = $email->getValidatorChain();
        $vc->attach(new \Zend\Validator\EmailAddress());
        $this->add($email);
        
    }
}
