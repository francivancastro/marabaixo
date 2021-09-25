<?php

namespace Ged\Form\Filter;

use Zend\InputFilter\Input;

/**
 * Description of NovoadminFilter
 *
 * @author zeluis
 */
class DocumentoCampoFilter extends \Zend\InputFilter\InputFilter{
    
    public function __construct() {
        
        $obj = new Input("documento_campo_tipo_chave");
        $obj->setRequired(true);
        $vc = $obj->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $this->add($obj);
        
        $obj = new Input("entidade");
        $obj->setRequired(false);
        $fc = $obj->getFilterChain();
        $fc->attach(new \Zend\Filter\StringTrim());
        $fc->attach(new \Zend\Filter\StripTags());
        $this->add($obj);
        
        $obj = new Input("nome");
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
        
        $obj = new Input("tamanho");
        $obj->setRequired(false);
        $vc = $obj->getValidatorChain();
        $vc->attach(new \Zend\Validator\Digits());
        $this->add($obj);
        
        $obj = new Input("ordem");
        $obj->setRequired(false);
        $vc = $obj->getValidatorChain();
        $vc->attach(new \Zend\Validator\Digits());
        $this->add($obj);
        
        $obj = new Input("obrigatorio");
        $obj->setRequired(true);
        $vc = $obj->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $this->add($obj);
        
        $obj = new Input("mostrar_listagem");
        $obj->setRequired(true);
        $vc = $obj->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $this->add($obj);
        
        $obj = new Input("to_string");
        $obj->setRequired(true);
        $vc = $obj->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $this->add($obj);
        
        $obj = new Input("filtro");
        $obj->setRequired(true);
        $vc = $obj->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $this->add($obj);
      
    }
}
