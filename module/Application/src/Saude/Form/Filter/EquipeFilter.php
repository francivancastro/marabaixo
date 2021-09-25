<?php

namespace Saude\Form\Filter;

use Zend\InputFilter\Input;

/**
 * Description of NovoadminFilter
 *
 * @author zeluis
 */
class EquipeFilter extends \Zend\InputFilter\InputFilter{
    
    public function __construct() {
        
        $descricao = new Input("descricao");
        $descricao->setRequired(true);
        $fc = $descricao->getFilterChain();
        $fc->attach(new \Zend\Filter\StringTrim());
        $fc->attach(new \Zend\Filter\StripTags());
        $vc = $descricao->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $this->add($descricao);

        $obj = new Input("id_equipe_tipo");
        $obj->setRequired(true);
        $fc = $obj->getFilterChain();
        $fc->attach(new \Zend\Filter\StringTrim());
        $fc->attach(new \Zend\Filter\StripTags());
        $vc = $obj->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $this->add($obj);
        
        $ine = new Input("ine");
        $ine->setRequired(true);
        $fc = $ine->getFilterChain();
        $fc->attach(new \Zend\Filter\StringTrim());
        $fc->attach(new \Zend\Filter\StripTags());
        $vc = $ine->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $this->add($ine);
        
        $obj = new Input("id_equipe_area");
        $obj->setRequired(true);
        $fc = $obj->getFilterChain();
        $fc->attach(new \Zend\Filter\StringTrim());
        $fc->attach(new \Zend\Filter\StripTags());
        $vc = $obj->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $this->add($obj);
        
        $obj = new Input("id_segmento_territorial");
        $obj->setRequired(true);
        $fc = $obj->getFilterChain();
        $fc->attach(new \Zend\Filter\StringTrim());
        $fc->attach(new \Zend\Filter\StripTags());
        $vc = $obj->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $this->add($obj);
        
        $obj = new Input("id_equipe_zona");
        $obj->setRequired(true);
        $fc = $obj->getFilterChain();
        $fc->attach(new \Zend\Filter\StringTrim());
        $fc->attach(new \Zend\Filter\StripTags());
        $vc = $obj->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $this->add($obj);
        
        $obj = new Input("id_populacao_assistida");
        $obj->setRequired(true);
        $fc = $obj->getFilterChain();
        $fc->attach(new \Zend\Filter\StringTrim());
        $fc->attach(new \Zend\Filter\StripTags());
        $vc = $obj->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $this->add($obj);
      
    }
}
