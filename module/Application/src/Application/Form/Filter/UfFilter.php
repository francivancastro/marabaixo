<?php

namespace Application\Form\Filter;

use Zend\InputFilter\Input;

/**
 * Description of NovoadminFilter
 *
 * @author zeluis
 */
class UfFilter extends \Zend\InputFilter\InputFilter{
    
    public function __construct() {
        
        $descricao = new Input("descricao");
        $descricao->setRequired(true);
        $fc = $descricao->getFilterChain();
        $fc->attach(new \Zend\Filter\StringTrim());
        $fc->attach(new \Zend\Filter\StripTags());
        $vc = $descricao->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $this->add($descricao);

        $codigo = new Input("codigo");
        $codigo->setRequired(true);
        $fc = $codigo->getFilterChain();
        $fc->attach(new \Zend\Filter\StringTrim());
        $fc->attach(new \Zend\Filter\StripTags());
        $vc = $codigo->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $this->add($codigo);
    }
}
