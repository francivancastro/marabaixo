<?php

namespace Application\Form;

use \Marabaixo\Abstrata\AbstractForm;

use Zend\Form\Element\Text;
use Zend\Form\Element\Button;
use Zend\Form\Element\Date;
use Zend\Form\Element\Password;
use Zend\Form\Element\File;

/**
 * Description of Config
 *
 * @author zeluis
 */
class ConfigForm extends AbstractForm {
    
    public function __construct($name = null, $options = array()) {
        
        parent::__construct("config");
        
        $this->setAttribute("method", "POST");
        $this->setInputFilter(new Filter\ConfigFilter());
        
        //input text - sigla do sistema
        $sistema_sigla = new Text("sistema_sigla");
        $sistema_sigla->setLabel("Sigla do Sistema:");
        $sistema_sigla->setAttributes(array(
            "maxlength" => "20",
            "class" => "form-control col-sm-2"
        ));
        $sistema_sigla->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($sistema_sigla);
        
        //input text - nome do sistema
        $sistema_nome = new Text("sistema_nome");
        $sistema_nome->setLabel("Nome do Sistema:");
        $sistema_nome->setAttributes(array(
            "maxlength" => "100",
            "class" => "form-control col-sm-4"
        ));
        $sistema_nome->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($sistema_nome);
        
        /*
        $sistema_logo = new File("sistema_logo");
        $sistema_logo->setLabel("Logo do Sistema:");
        $sistema_logo->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($sistema_logo);
         */
        
        $obj = new \Marabaixo\Form\Element\Arquivo("id_arquivo_logo");
        $obj->setLabel("Logo do Sistema");
        $this->add($obj);
        
        $maioridade_idade_minima = new Text("maioridade_idade_minima");
        $maioridade_idade_minima->setLabel("Maioridade Idade Mínima:");
        $maioridade_idade_minima->setAttributes(array(
            "maxlength" => "10",
            "class" => "form-control col-sm-2"
        ));
        $maioridade_idade_minima->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($maioridade_idade_minima);

        //input text - pj - cnpj
        $cliente_cnpj = new Text("cliente_cnpj");
        $cliente_cnpj->setLabel("C.N.P.J.:");
        $cliente_cnpj->setAttributes(array(
            "maxlength" => "20",
            "class" => "form-control col-sm-4 mask_cnpj"
        ));
        $cliente_cnpj->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($cliente_cnpj);
        
        //input text - cliente email
        $cliente_email = new Text("cliente_email");
        $cliente_email->setLabel("E-mail do Cliente:");
        $cliente_email->setAttributes(array(
            "maxlength" => "100",
            "class" => "form-control col-sm-4"
        ));
        $cliente_email->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($cliente_email);

        //input text - pj - sigla
        $cliente_sigla = new Text("cliente_sigla");
        $cliente_sigla->setLabel("Sigla:");
        $cliente_sigla->setAttributes(array(
            "maxlength" => "20",
            "class" => "form-control col-sm-4"
        ));
        $cliente_sigla->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($cliente_sigla);

        //input text - pj - razao_social
        $cliente_razao_social = new Text("cliente_razao_social");
        $cliente_razao_social->setLabel("Razão Social:");
        $cliente_razao_social->setAttributes(array(
            "maxlength" => "100",
            "class" => "form-control col-sm-4"
        ));
        $cliente_razao_social->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($cliente_razao_social);

        //input text - pj - nome_fantasia
        $cliente_nome_fantasia = new Text("cliente_nome_fantasia");
        $cliente_nome_fantasia->setLabel("Nome Fantasia:");
        $cliente_nome_fantasia->setAttributes(array(
            "maxlength" => "100",
            "class" => "form-control col-sm-4"
        ));
        $cliente_nome_fantasia->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($cliente_nome_fantasia);
        
        //input text - smtp email
        $smtp_email = new Text("smtp_email");
        $smtp_email->setLabel("E-mail de Suporte:");
        $smtp_email->setAttributes(array(
            "maxlength" => "100",
            "class" => "form-control col-sm-4"
        ));
        $smtp_email->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($smtp_email);
        
        //input text - smtp host
        $smtp_host = new Text("smtp_host");
        $smtp_host->setLabel("Hostname:");
        $smtp_host->setAttributes(array(
            "maxlength" => "100",
            "class" => "form-control col-sm-4"
        ));
        $smtp_host->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($smtp_host);
        
        //input text - smtp port
        $smtp_port = new Text("smtp_port");
        $smtp_port->setLabel("Porta:");
        $smtp_port->setAttributes(array(
            "maxlength" => "100",
            "class" => "form-control col-sm-1"
        ));
        $smtp_port->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($smtp_port);
        
        //input text - smtp username
        $smtp_username = new Text("smtp_username");
        $smtp_username->setLabel("Usuário:");
        $smtp_username->setAttributes(array(
            "maxlength" => "100",
            "class" => "form-control col-sm-2"
        ));
        $smtp_username->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($smtp_username);
        
        //input text - smtp password
        $smtp_password = new Password("smtp_password");
        $smtp_password->setLabel("Senha:");
        $smtp_password->setAttributes(array(
            "maxlength" => "100",
            "class" => "form-control col-sm-2"
        ));
        $smtp_password->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($smtp_password);
        
        $secure = new \Zend\Form\Element\Select("smtp_secure");
        $secure->setLabel("Secure:");
        $secure->setAttributes(array(
            "class" => "form-control col-sm-2"
        ));
        $secure->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $secure->setValueOptions(array(
            "" => "==> SELECIONE <==",
            'tls' => 'tls',
            'ssl' => 'ssl',
        ));
        $this->add($secure);
/*
        //input text - logo do cliente
        $cliente_logo = new File("cliente_logo");
        $cliente_logo->setLabel("Logo do Cliente:");
        $cliente_logo->setAttributes(array(
            "maxlength" => "100",
        ));
        $cliente_logo->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($cliente_logo);
 * 
 */
        
        $obj = new \Marabaixo\Form\Element\Arquivo("cliente_id_arquivo_logo");
        $obj->setLabel("Logo do Cliente");
        $this->add($obj);

                
        //input submit - enviar
        $submit = new Button("submit");
        $submit->setValue("Enviar Formulário");
        $submit->setAttributes(array(
            "type" => "submit",
            "class" => "btn btn-primary"
        ));
        $submit->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($submit);
        
    }
}
