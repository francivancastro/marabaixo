<?php

namespace Application\Form\Filter;

use Zend\InputFilter\Input;
use Zend\InputFilter\FileInput;

/**
 * Description of NovoadminFilter
 *
 * @author zeluis
 */
class GrupoFilter extends \Zend\InputFilter\InputFilter{
    
    public function __construct() {
        
        $descricao = new Input("descricao");
        $descricao->setRequired(true);
        $fc = $descricao->getFilterChain();
        $fc->attach(new \Zend\Filter\StringTrim());
        $fc->attach(new \Zend\Filter\StripTags());
        $vc = $descricao->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $this->add($descricao);

        $chave = new Input("chave");
        $chave->setRequired(true);
        $fc = $chave->getFilterChain();
        $fc->attach(new \Zend\Filter\StringTrim());
        $fc->attach(new \Zend\Filter\StripTags());
        $vc = $chave->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $this->add($chave);
        
        
    }
}
