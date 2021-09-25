<?php

namespace Saude\Form\Filter;

use Zend\InputFilter\Input;

/**
 * Description of NovoadminFilter
 *
 * @author zeluis
 */
class RegiaoFilter extends \Zend\InputFilter\InputFilter{
    
    public function __construct() {
        
        $descricao = new Input("descricao");
        $descricao->setRequired(true);
        $fc = $descricao->getFilterChain();
        $fc->attach(new \Zend\Filter\StringTrim());
        $fc->attach(new \Zend\Filter\StripTags());
        $vc = $descricao->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $this->add($descricao);

        $sigla = new Input("sigla");
        $sigla->setRequired(true);
        $fc = $sigla->getFilterChain();
        $fc->attach(new \Zend\Filter\StringTrim());
        $fc->attach(new \Zend\Filter\StripTags());
        $vc = $sigla->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $this->add($sigla);
        
        $pf = new Input("id_pessoa_fisica");
        $pf->setRequired(true);
        $vc = $pf->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $this->add($pf);
    }
}
