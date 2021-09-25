<?php

namespace Rh\Form;

use \Marabaixo\Abstrata\AbstractForm;
use Zend\Form\Element\Text;
use Zend\Form\Element\Button;
use Zend\Form\Element\Select;
use Zend\Form\Element\Checkbox;

/**
 * 
 *
 * @author janio
 */
class ServidorRecebimentoForm extends AbstractForm {

    public function __construct($name = null, $options = array()) {

        parent::__construct("formulario_receber");

        $this->setAttribute("method", "POST");
        $this->setInputFilter(new Filter\ServidorEncaminhamentoFilter());

        $id = new \Zend\Form\Element\Hidden("id_servidor");
        $id->setAttribute("id_servidor", $id->getName());
        $this->add($id);

        $servidor = new Text("servidor");
        $servidor->setLabel("Servidor:");
        $servidor->setAttributes(array(            
            "class" => "form-control col-sm-2"
        ));
        $servidor->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($servidor);
        
        $descricao = new Text("descricao");
        $descricao->setLabel("Descrição:");
        $descricao->setAttributes(array(            
            "class" => "form-control col-sm-2"
        ));
        $descricao->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($descricao);
        
        $es = new \Zend\Form\Element\Hidden("encaminhamento_status");
        $es->setAttribute("encaminhamento_status", $es->getName());
        $es->setValue("E");
        $this->add($es);
        
        $matricula = new Text("matricula");
        $matricula->setLabel("Matrícula:");
        $matricula->setAttributes(array(
            "maxlength" => "10",
            "class" => "form-control col-sm-2"
        ));
        $matricula->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($matricula);
        
        $cargo = new Text("cargo");
        $cargo->setLabel("Cargo:");
        $cargo->setAttributes(array(
            "maxlength" => "10",
            "class" => "form-control col-sm-2"
        ));
        $cargo->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($cargo);
        
        
        $input = new \Marabaixo\Form\Element\Dominio("id_orgao");
        $input->setLabel("Orgão:");
        $input->setOption("dominio", "Orgao");
        $input->setLabelAttributes(array("class" => "col-sm-2 control-label"));
        $input->setAttribute("class", "form-control-item");
        $this->add($input);
        
        $lotacao_tipo = new \Marabaixo\Form\Element\Dominio("id_lotacao_tipo");
        $lotacao_tipo->setLabel("Lotação Tipo:");
        $lotacao_tipo->setOption("dominio", "ServidorLotacaoTipo");
        $lotacao_tipo->setLabelAttributes(array("class" => "col-sm-2 control-label"));
        $lotacao_tipo->setAttribute("class", "form-control-item");
        $this->add($lotacao_tipo);
        
        
        $data_inicio = new Text("data_inicio");
        $data_inicio ->setLabel("Data Início:");
        $data_inicio ->setAttributes(array(
            "maxlength" => "10",
            "class" => "form-control col-sm-2"
        ));
        $data_inicio ->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($data_inicio);
        
        $data_fim = new Text("data_fim");
        $data_fim ->setLabel("Data Fim:");
        $data_fim ->setAttributes(array(
            "maxlength" => "10",
            "class" => "form-control col-sm-2"
        ));
        $data_fim->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($data_fim);
        
        
        $obj = new Checkbox('chefia');
        $obj->setLabel('Chefia:');
        $obj->setUseHiddenElement(true);
        $obj->setCheckedValue('S');
        $obj->setUncheckedValue('N');
         $obj->setAttributes(array(
          
            "class" => "checkbox"
        ));
        $obj->setLabelAttributes(array(
            
            'class' => 'col-sm-2 control-label'));

        $this->add($obj);


        $submit = new Button("submit");
        $submit->setValue("Encaminhar");
        $submit->setAttributes(array(
            "type" => "submit",
            "class" => "btn btn-primary"
        ));
        $submit->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($submit);
    }

}
