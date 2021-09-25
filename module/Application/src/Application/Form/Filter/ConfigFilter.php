<?php

namespace Application\Form\Filter;

use Zend\InputFilter\Input;
use Zend\InputFilter\FileInput;

/**
 * Description of ConfigFilter
 *
 * @author zeluis
 */
class ConfigFilter extends \Zend\InputFilter\InputFilter{
    
    public function __construct() {
        
        $sistema_sigla = new Input("sistema_sigla");
        $sistema_sigla->setRequired(true);
        $fc = $sistema_sigla->getFilterChain();
        $fc->attach(new \Zend\Filter\StringTrim());
        $fc->attach(new \Zend\Filter\StringToUpper());
        $fc->attach(new \Zend\Filter\StripTags());
        $vc = $sistema_sigla->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $this->add($sistema_sigla);
        
        $sistema_nome = new Input("sistema_nome");
        $sistema_nome->setRequired(true);
        $fc = $sistema_nome->getFilterChain();
        $fc->attach(new \Zend\Filter\StringTrim());
        $fc->attach(new \Zend\Filter\StripTags());
        $vc = $sistema_nome->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $this->add($sistema_nome);
        
        $cliente_cnpj = new Input("cliente_cnpj");
        $cliente_cnpj->setRequired(true);
        $fc = $cliente_cnpj->getFilterChain();
        $fc->attach(new \Zend\Filter\StringTrim());
        $vc = $cliente_cnpj->getValidatorChain();
        $vc->attach(new \Marabaixo\Form\Validator\CnpjValidator());
        $this->add($cliente_cnpj);

        $cliente_email = new Input("cliente_email");
        $cliente_email->setRequired(true);
        $vc = $cliente_email->getValidatorChain();
        $vc->attach(new \Zend\Validator\EmailAddress());
        $this->add($cliente_email);
        
        $sistema_logo = new FileInput("sistema_logo");
        $sistema_logo->setRequired(false);
        $vc = $sistema_logo->getValidatorChain();
        $vc->attach(new \Zend\Validator\File\Size(array(
            "max" => "2MB"
        )));
        $this->add($sistema_logo);
        
        $sistema_sigla = new Input("cliente_sigla");
        $sistema_sigla->setRequired(true);
        $fc = $sistema_sigla->getFilterChain();
        $fc->attach(new \Zend\Filter\StringTrim());
        $fc->attach(new \Zend\Filter\StringToUpper());
        $fc->attach(new \Zend\Filter\StripTags());
        $vc = $sistema_sigla->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $this->add($sistema_sigla);
        
        $cliente_razao_social = new Input("cliente_razao_social");
        $cliente_razao_social->setRequired(true);
        $fc = $cliente_razao_social->getFilterChain();
        $fc->attach(new \Zend\Filter\StringTrim());
        $fc->attach(new \Zend\Filter\StripTags());
        $vc = $cliente_razao_social->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $this->add($cliente_razao_social);
        
        $cliente_nome_fantasia = new Input("cliente_nome_fantasia");
        $cliente_nome_fantasia->setRequired(true);
        $fc = $cliente_nome_fantasia->getFilterChain();
        $fc->attach(new \Zend\Filter\StringTrim());
        $fc->attach(new \Zend\Filter\StripTags());
        $vc = $cliente_nome_fantasia->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $this->add($cliente_nome_fantasia);
        
        $maioridade_idade_minima = new Input("maioridade_idade_minima");
        $maioridade_idade_minima->setRequired(true);
        $fc = $maioridade_idade_minima->getFilterChain();
        $fc->attach(new \Zend\Filter\StringTrim());
        $fc->attach(new \Zend\Filter\StripTags());
        $vc = $maioridade_idade_minima->getValidatorChain();
        $vc->attach(new \Zend\Validator\NotEmpty());
        $this->add($maioridade_idade_minima);
        
        $secure = new Input("secure");
        $secure->setRequired(false);
        
        $cliente_logo = new FileInput("cliente_logo");
        $cliente_logo->setRequired(false);
        $vc = $cliente_logo->getValidatorChain();
        $vc->attach(new \Zend\Validator\File\Size(array(
            "max" => "2MB"
        )));
        $this->add($cliente_logo);

    }
}
