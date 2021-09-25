<?php

namespace Rh\Form;

use \Marabaixo\Abstrata\AbstractForm;

use Zend\Form\Element\Text;
use Zend\Form\Element\Button;
use Zend\Form\Element\Select;

/**
 * Description of Novoadmin
 *
 * @author zeluis
 */
class LotacaoForm extends AbstractForm {
    
    public function __construct($name = null, $options = array()) {
        
        parent::__construct("formulario_lotacao");
        
        $this->setAttribute("method", "POST");
        $this->setInputFilter(new Filter\LotacaoFilter());

        $id = new \Zend\Form\Element\Hidden("id");
        $id->setAttribute("id", $id->getName());
        $this->add($id);
        
        $servidor = new Text("servidor");
        $servidor->setLabel("Servidor:");
        $servidor->setAttributes(array(
            "maxlength" => "100",
            "class" => "form-control col-sm-4"
        ));
        $servidor->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $servidor->add($servidor);
        
        $data_inicio = new Text("data_inicio");
        $data_inicio->setLabel("Data inicio:");
        $data_inicio->setAttributes(array(
            "maxlength" => "10",
            "class" => "form-control col-sm-2"
        ));
        $data_inicio->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($data_inicio);
        
        $data_fim = new Text("data_fim");
        $data_fim->setLabel("Data fim:");
        $data_fim->setAttributes(array(
            "maxlength" => "10",
            "class" => "form-control col-sm-2"
        ));
        $data_fim->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($data_fim);    
        
        $lotacao_status = new Text("lotacao_status");
        $lotacao_status->setLabel("Lotação status:");
        $lotacao_status->setAttributes(array(
            "maxlength" => "100",
            "class" => "form-control col-sm-4"
        ));
        $lotacao_status->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $lotacao_status->add($lotacao_status);
        
        $chefia = new Text("chefia");
        $chefia->setLabel("Chefia:");
        $chefia->setAttributes(array(
            "maxlength" => "100",
            "class" => "form-control col-sm-4"
        ));
        $chefia->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $chefia->add($chefia);
        
        $input = new \Marabaixo\Form\Element\Dominio("id_lotacao_tipo");
        $input->setLabel("Lotacão tipo:");
        $input->setOption("dominio", "LotacaoTipo");
        $input->setLabelAttributes(array("class" => "col-sm-2 control-label"));
        $input->setAttribute("class", "form-control-item");
        $this->add($input);
        
        $input = new \Marabaixo\Form\Element\Dominio("id_orgao");
        $input->setLabel("Orgão");
        $input->setOption("dominio", "orgao");
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
