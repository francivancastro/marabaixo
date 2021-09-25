<?php

namespace Application\Form\Filter;

use Zend\InputFilter\Input;
use Zend\InputFilter\FileInput;

/**
 * Description of NovoadminFilter
 *
 * @author zeluis
 */
class UsuarioFilter extends \Zend\InputFilter\InputFilter{
    
    public function __construct() {

        $usuario = new Input("id_pessoa_fisica");
        $usuario->setRequired(true);
        $vc = $usuario->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $this->add($usuario);
        
    }
}
