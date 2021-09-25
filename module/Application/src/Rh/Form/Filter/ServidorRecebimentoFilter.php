<?php

namespace Rh\Form\Filter;

use Zend\InputFilter\Input;

/**
 * Description of NovoadminFilter
 *
 * @author Janio
 */
class ServidorEncaminhamentoFilter extends \Zend\InputFilter\InputFilter {

    public function __construct() {

        $obj = new Input("id_servidor");
        $obj->setRequired(true);
        $fc = $obj->getFilterChain();
        $fc->attach(new \Zend\Filter\StringTrim());
        $fc->attach(new \Zend\Filter\StripTags());
        $vc = $obj->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $this->add($obj);
        
        $obj = new Input("id_orgao");
        $obj->setRequired(true);
        $fc = $obj->getFilterChain();
        $fc->attach(new \Zend\Filter\StringTrim());
        $fc->attach(new \Zend\Filter\StripTags());
        $vc = $obj->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $this->add($obj);
        
        
        $obj = new Input("id_servidor_encaminhamento_tipo");
        $obj->setRequired(true);
        $fc = $obj->getFilterChain();
        $fc->attach(new \Zend\Filter\StringTrim());
        $fc->attach(new \Zend\Filter\StripTags());
        $vc = $obj->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $this->add($obj);

           
        
    }

}
