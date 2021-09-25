<?php

namespace Saude\Form\Filter;

use Zend\InputFilter\Input;

/**
 * Description of NovoadminFilter
 *
 * @author zeluis
 */
class EstabelecimentoSaudeFilter extends \Zend\InputFilter\InputFilter{
    
    public function __construct() {
        
        $obj = new Input("codigo_cnes");
        $obj->setRequired(true);
        $fc = $obj->getFilterChain();
        $fc->attach(new \Zend\Filter\StringTrim());
        $fc->attach(new \Zend\Filter\StripTags());
        $vc = $obj->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $this->add($obj);

        $obj = new Input("id_estabelecimento_saude_tipo");
        $obj->setRequired(true);
        $vc = $obj->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $this->add($obj);

        $obj = new Input("id_estabelecimento_gestao");
        $obj->setRequired(true);
        $vc = $obj->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $this->add($obj);
        
        $obj = new Input("sigla");
        $obj->setRequired(true);
        $fc = $obj->getFilterChain();
        $fc->attach(new \Zend\Filter\StringTrim());
        $fc->attach(new \Zend\Filter\StripTags());
        $vc = $obj->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $this->add($obj);
        
        $obj = new Input("descricao");
        $obj->setRequired(true);
        $fc = $obj->getFilterChain();
        $fc->attach(new \Zend\Filter\StringTrim());
        $fc->attach(new \Zend\Filter\StripTags());
        $vc = $obj->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $this->add($obj);
        
        $obj = new Input("id_pessoa_fisica");
        $obj->setRequired(true);
        $vc = $obj->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $this->add($obj);        
        
        $obj = new Input("id_pessoa_juridica");
        $obj->setRequired(true);
        $vc = $obj->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $this->add($obj);        
    }
}
