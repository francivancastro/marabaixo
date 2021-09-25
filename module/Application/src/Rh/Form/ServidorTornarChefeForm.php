<?php

namespace Rh\Form;

use \Marabaixo\Abstrata\AbstractForm;
use Zend\Form\Element\Text;
use Zend\Form\Element\Button;
use Zend\Form\Element\Select;
use Zend\Form\Element\Checkbox;

/**
 * Description of Novoadmin
 *
 * @author janio
 */
class ServidorTornarChefeForm extends AbstractForm {

    public function __construct($name = null, $options = array()) {

        parent::__construct("formulario_tornar_chefe");

        $this->setAttribute("method", "POST");
        $this->setInputFilter(new Filter\ServidorTornarChefeFilter());
        
        $id = new \Zend\Form\Element\Hidden("id_servidor");
        $id->setAttribute("id_servidor", $id->getName());
        $this->add($id);

        $servidor = new Text("nome");
        $servidor->setLabel("Servidor:");
        $servidor->setAttributes(array(            
            "class" => "form-control col-sm-2"
        ));
        $servidor->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($servidor);
        
        $data_ingresso = new Text("data_ingresso");
        $data_ingresso->setLabel("Data de ingresso:");
        $data_ingresso->setAttributes(array(            
            "class" => "form-control col-sm-2"
        ));
        $data_ingresso->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($data_ingresso);
        
        $data_ultima_alteracao = new Text("data_ultima_alteracao");
        $data_ultima_alteracao->setLabel("Data da ultima alteração:");
        $data_ultima_alteracao->setAttributes(array(            
            "class" => "form-control col-sm-2"
        ));
        $data_ultima_alteracao->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($data_ultima_alteracao);
        
        $descricao = new Text("descricao");
        $descricao->setLabel("Descrição:");
        $descricao->setAttributes(array(            
            "class" => "form-control col-sm-2"
        ));
        $descricao->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($descricao);
        
        $es = new \Zend\Form\Element\Hidden("encaminhamento_status");
        $es->setAttribute("encaminhamento_status", $es->getName());
        $es->setValue("N");
        $this->add($es);
        
        $matricula = new Text("matricula");
        $matricula->setLabel("Matrícula:");
        $matricula->setAttributes(array(
            "maxlength" => "10",
            "class" => "form-control col-sm-2"
        ));
        $matricula->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($matricula);
        
        $carga_horario = new Text("carga_horaria");
        $carga_horario->setLabel("Carga horária:");
        $carga_horario->setAttributes(array(
            "maxlength" => "10",
            "class" => "form-control col-sm-2"
        ));
        $carga_horario->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($carga_horario);
        
        $cpf = new Text("cpf");
        $cpf->setLabel("CPF:");
        $cpf->setAttributes(array(
            "maxlength" => "10",
            "class" => "form-control col-sm-2"
        ));
        $cpf->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($cpf);

        $input = new \Marabaixo\Form\Element\Dominio("id_orgao");
        $input->setLabel("Orgão:");
        $input->setOption("dominio", "Orgao");
        $input->setLabelAttributes(array("class" => "col-sm-2 control-label"));
        $input->setAttribute("class", "form-control-item");
        $this->add($input);
        
        $input = new \Marabaixo\Form\Element\Dominio("id_servidor_cargo");
        $input->setLabel("Cargo:");
        $input->setOption("dominio", "ServidorCargo");
        $input->setLabelAttributes(array("class" => "col-sm-2 control-label"));
        $input->setAttribute("class", "form-control-item");
        $this->add($input);
        
        $input = new \Marabaixo\Form\Element\Dominio("id_servidor_funcao");
        $input->setLabel("Função:");
        $input->setOption("dominio", "ServidorFuncao");
        $input->setLabelAttributes(array("class" => "col-sm-2 control-label"));
        $input->setAttribute("class", "form-control-item");
        $this->add($input);
        
        $input = new \Marabaixo\Form\Element\Dominio("id_servidor_chefia_tipo");
        $input->setLabel("Tipo de Chefia:");
        $input->setOption("dominio", "ServidorChefiaTipo");
        $input->setLabelAttributes(array("class" => "col-sm-2 control-label"));
        $input->setAttribute("class", "form-control-item");
        $this->add($input);      
        
        $submit = new Button("submit");
        $submit->setValue("Salvar");
        $submit->setAttributes(array(
            "type" => "submit",
            "class" => "btn btn-primary"
        ));
        $submit->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($submit);
    }

}
