<?php

namespace Rh\Form\Filter;

use Zend\InputFilter\Input;

/**
 * Description of NovoadminFilter
 *
 * @author fernando
 */
class OrgaoFilter extends \Zend\InputFilter\InputFilter{
    
    public function __construct() {
        
        $codigo = new Input("codigo");
        $codigo->setRequired(true);
        $fc = $codigo->getFilterChain();
        $fc->attach(new \Zend\Filter\StringTrim());
        $fc->attach(new \Zend\Filter\StripTags());
        $vc = $codigo->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $this->add($codigo);

        $descricao = new Input("descricao");
        $descricao->setRequired(true);
        $fc = $descricao->getFilterChain();
        $fc->attach(new \Zend\Filter\StringTrim());
        $fc->attach(new \Zend\Filter\StripTags());
        $vc = $descricao->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $this->add($descricao);
        
        $portaria = new Input("portaria");
        $portaria->setRequired(true);
        $fc = $portaria->getFilterChain();
        $fc->attach(new \Zend\Filter\StringTrim());
        $fc->attach(new \Zend\Filter\StripTags());
        $vc = $portaria->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $this->add($portaria);
        
       
       $obj = new Input("id_orgao_superior");
        $obj->setRequired(true);
       $fc = $obj->getFilterChain();
        $fc->attach(new \Zend\Filter\StringTrim());
        $fc->attach(new \Zend\Filter\StripTags());
       $vc = $obj->getValidatorChain();
       $vc->attach(new \Zend\Validator\NotEmpty());
        $this->add($obj);
        
        
    }
}
