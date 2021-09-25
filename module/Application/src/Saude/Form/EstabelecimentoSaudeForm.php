<?php

namespace Saude\Form;

use \Marabaixo\Abstrata\AbstractForm;

use Zend\Form\Element\Text;
use Zend\Form\Element\Button;

/**
 * Description of Novoadmin
 *
 * @author zeluis
 */
class EstabelecimentoSaudeForm extends AbstractForm {
    
    public function __construct($name = null, $options = array()) {
        
        parent::__construct("formulario_estabelecimento_saude");
        
        $this->setAttribute("method", "POST");
        $this->setInputFilter(new Filter\EstabelecimentoSaudeFilter());

        $obj = new \Zend\Form\Element\Hidden("id");
        $obj->setAttribute("id", $obj->getName());
        $this->add($obj);

        $obj = new Text("codigo_cnes");
        $obj->setLabel("Código CNES:");
        $obj->setAttributes(array(
            "maxlength" => "30",
            "class" => "form-control col-sm-4"
        ));
        $obj->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($obj);
        
        $obj = new \Marabaixo\Form\Element\Dominio("id_estabelecimento_saude_tipo");
        $obj->setLabel("Tipo:");
        $obj->setOption("dominio", "EstabelecimentoSaudeTipo");
        $obj->setLabelAttributes(array("class" => "col-sm-2 control-label"));
        $obj->setAttribute("class", "form-control-item");
        $this->add($obj);        
        
        $obj = new \Marabaixo\Form\Element\Dominio("id_estabelecimento_gestao");
        $obj->setLabel("Gestão:");
        $obj->setOption("dominio", "EstabelecimentoGestao");
        $obj->setLabelAttributes(array("class" => "col-sm-2 control-label"));
        $obj->setAttribute("class", "form-control-item");
        $this->add($obj);        
        
        $obj = new Text("sigla");
        $obj->setLabel("Sigla:");
        $obj->setAttributes(array(
            "maxlength" => "20",
            "class" => "form-control col-sm-4"
        ));
        $obj->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($obj);
        
        $obj = new Text("descricao");
        $obj->setLabel("Descriçao:");
        $obj->setAttributes(array(
            "maxlength" => "100",
            "class" => "form-control col-sm-4"
        ));
        $obj->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($obj);
        
        $obj = new \Marabaixo\Form\Element\PessoaFisica("id_pessoa_fisica");
        $obj->setLabel("Responsavel:");
        $obj->setAttributes(array(
            "class" => "form-control col-sm-4"
        ));
        $obj->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($obj);
        
        $obj = new \Marabaixo\Form\Element\PessoaJuridica("id_pessoa_juridica");
        $obj->setLabel("Pessoa Jurídica:");
        $obj->setAttributes(array(
            "class" => "form-control col-sm-4"
        ));
        $obj->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($obj);
              
        $obj = new Button("submit");
        $obj->setValue("Salvar");
        $obj->setAttributes(array(
            "type" => "submit",
            "class" => "btn btn-primary"
        ));
        $obj->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($obj);

        $obj = new \Zend\Form\Element\Hidden("id_endereco");
        $obj->setAttribute("id", $obj->getName());
        $this->add($obj);
        
        $obj = new \Zend\Form\Element\Hidden("cep");
        $obj->setAttribute("id", $obj->getName());
        $this->add($obj);

        $obj = new \Zend\Form\Element\Hidden("logradouro");
        $obj->setAttribute("id", $obj->getName());
        $this->add($obj);

        $obj = new \Zend\Form\Element\Hidden("numero");
        $obj->setAttribute("id", $obj->getName());
        $this->add($obj);

        $obj = new \Zend\Form\Element\Hidden("complemento");
        $obj->setAttribute("id", $obj->getName());
        $this->add($obj);

        $obj = new \Zend\Form\Element\Hidden("id_uf");
        $obj->setAttribute("id", $obj->getName());
        $this->add($obj);

        $obj = new \Zend\Form\Element\Hidden("id_municipio");
        $obj->setAttribute("id", $obj->getName());
        $this->add($obj);

        $obj = new \Zend\Form\Element\Hidden("id_bairro");
        $obj->setAttribute("id", $obj->getName());
        $this->add($obj);
        
    }
}
