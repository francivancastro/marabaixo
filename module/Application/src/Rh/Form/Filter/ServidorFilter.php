<?php

namespace Rh\Form\Filter;

use Zend\InputFilter\Input;

/**
 * Description of NovoadminFilter
 *
 * @author fernando
 */
class ServidorFilter extends \Zend\InputFilter\InputFilter {

    public function __construct() {

        $obj = new Input("id_pessoa_fisica");
        $obj->setRequired(true);
        $fc = $obj->getFilterChain();
        $fc->attach(new \Zend\Filter\StringTrim());
        $fc->attach(new \Zend\Filter\StripTags());
        $vc = $obj->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $this->add($obj);

        $obj = new Input("matricula");
        $obj->setRequired(true);
        $fc = $obj->getFilterChain();
        $fc->attach(new \Zend\Filter\StringTrim());
        $fc->attach(new \Zend\Filter\StripTags());
        $vc = $obj->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $this->add($obj);

        $obj = new Input("identificacao_unica");
        $obj->setRequired(true);
        $fc = $obj->getFilterChain();
        $fc->attach(new \Zend\Filter\StringTrim());
        $fc->attach(new \Zend\Filter\StripTags());
        $vc = $obj->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $this->add($obj);

        $obj = new Input("data_ingresso");
        $obj->setRequired(true);
        $fc = $obj->getFilterChain();
        $fc->attach(new \Zend\Filter\StringTrim());
        $fc->attach(new \Zend\Filter\StripTags());
        $vc = $obj->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $this->add($obj);

        $obj = new Input("data_ultima_alteracao");
        $obj->setRequired(true);
        $fc = $obj->getFilterChain();
        $fc->attach(new \Zend\Filter\StringTrim());
        $fc->attach(new \Zend\Filter\StripTags());
        $vc = $obj->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $this->add($obj);

        $obj = new Input("carga_horaria");
        $obj->setRequired(true);
        $fc = $obj->getFilterChain();
        $fc->attach(new \Zend\Filter\StringTrim());
        $fc->attach(new \Zend\Filter\StripTags());
        $vc = $obj->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $this->add($obj);
        
        $obj = new Input("id_servidor_cargo");
        $obj->setRequired(true);
        $fc = $obj->getFilterChain();
        $fc->attach(new \Zend\Filter\StringTrim());
        $fc->attach(new \Zend\Filter\StripTags());
        $vc = $obj->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $this->add($obj);
        
        $obj = new Input("id_servidor_classe");
        $obj->setRequired(true);
        $fc = $obj->getFilterChain();
        $fc->attach(new \Zend\Filter\StringTrim());
        $fc->attach(new \Zend\Filter\StripTags());
        $vc = $obj->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $this->add($obj);
        
        $obj = new Input("id_servidor_funcao");
        $obj->setRequired(true);
        $fc = $obj->getFilterChain();
        $fc->attach(new \Zend\Filter\StringTrim());
        $fc->attach(new \Zend\Filter\StripTags());
        $vc = $obj->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $this->add($obj);
        
        $obj = new Input("id_servidor_nivel");
        $obj->setRequired(true);
        $fc = $obj->getFilterChain();
        $fc->attach(new \Zend\Filter\StringTrim());
        $fc->attach(new \Zend\Filter\StripTags());
        $vc = $obj->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $this->add($obj);
        
        $obj = new Input("id_regime_juridico");
        $obj->setRequired(true);
        $fc = $obj->getFilterChain();
        $fc->attach(new \Zend\Filter\StringTrim());
        $fc->attach(new \Zend\Filter\StripTags());
        $vc = $obj->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $this->add($obj);
        
        
    }

}
