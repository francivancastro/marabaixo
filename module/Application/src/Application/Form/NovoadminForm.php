<?php

namespace Application\Form;

use \Marabaixo\Abstrata\AbstractForm;

use Zend\Form\Element\Text;
use Zend\Form\Element\Button;
use Zend\Form\Element\Date;
use Zend\Form\Element\Password;
use Zend\Form\Element\File;

/**
 * Description of Novoadmin
 *
 * @author zeluis
 */
class NovoadminForm extends AbstractForm {
    
    public function __construct($name = null, $options = array()) {
        
        parent::__construct("novo_admin");
        
        $this->setAttribute("method", "POST");
        $this->setInputFilter(new Filter\NovoadminFilter());
        
        //input text - cpf
        $cpf = new Text("cpf");
        $cpf->setLabel("C.P.F.:");
        $cpf->setAttributes(array(
            "maxlength" => "14",
            "class" => "form-control col-sm-2 mask_cpf"
        ));
        $cpf->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($cpf);

        //input text - nome
        $nome = new Text("nome");
        $nome->setLabel("Nome:");
        $nome->setAttributes(array(
            "maxlength" => "100",
            "class" => "form-control col-sm-4"
        ));
        $nome->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($nome);
        
        //input text - email
        $email = new Text("email");
        $email->setLabel("E-mail:");
        $email->setAttributes(array(
            "maxlength" => "100",
            "class" => "form-control col-sm-4"
        ));
        $email->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($email);
        
        //input text - data
        $data = new Date("data_nascimento");
        $data->setLabel("Data Nascimento:");
        $data->setAttributes(array(
            "maxlength" => "10",
            "class" => "form-control"
        ));
        $data->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($data);

        //input text - senha
        $senha = new Password("senha");
        $senha->setLabel("Senha:");
        $senha->setAttributes(array(
            "maxlength" => "100",
            "class" => "form-control col-sm-4"
        ));
        $senha->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($senha);
        
        //input text - confirma senha
        $confirma_senha = new Password("confirma_senha");
        $confirma_senha->setLabel("Confirmar Senha:");
        $confirma_senha->setAttributes(array(
            "maxlength" => "100",
            "class" => "form-control col-sm-4"
        ));
        $confirma_senha->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($confirma_senha);

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
        
        //input text - logo do sistema
        $sistema_logo = new File("sistema_logo");
        $sistema_logo->setLabel("Logo do Sistema:");
        $sistema_logo->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($sistema_logo);

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
        
        //input text - logo do cliente
        $cliente_logo = new File("cliente_logo");
        $cliente_logo->setLabel("Logo do Cliente:");
        $cliente_logo->setAttributes(array(
            "maxlength" => "100",
        ));
        $cliente_logo->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($cliente_logo);
        
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
