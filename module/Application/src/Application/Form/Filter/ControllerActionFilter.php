<?php

namespace Application\Form\Filter;

use Zend\InputFilter\Input;
use Zend\InputFilter\FileInput;

/**
 * Description of NovoadminFilter
 *
 * @author zeluis
 */
class ControllerActionFilter extends \Zend\InputFilter\InputFilter{
    
    public function __construct() {
        
        $descricao = new Input("descricao");
        $descricao->setRequired(true);
        $fc = $descricao->getFilterChain();
        $fc->attach(new \Zend\Filter\StringTrim());
        $fc->attach(new \Zend\Filter\StripTags());
        $vc = $descricao->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $this->add($descricao);

        $action = new Input("action");
        $action->setRequired(true);
        $fc = $action->getFilterChain();
        $fc->attach(new \Zend\Filter\StringTrim());
        $fc->attach(new \Zend\Filter\StripTags());
        $vc = $action->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $this->add($action);
        
        $componentes = new Input("id_componente");
        $componentes->setRequired(false);
        $this->add($componentes);
    }
}
