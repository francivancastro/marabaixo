<?php

namespace Saude\Form;

use \Marabaixo\Abstrata\AbstractForm;

use Zend\Form\Element\Text;
use Zend\Form\Element\Button;
use Zend\Form\Element\Select;

/**
 * Description of Novoadmin
 *
 * @author zeluis
 */
class EquipeForm extends AbstractForm {
    
    public function __construct($name = null, $options = array()) {
        
        parent::__construct("formulario_equipe");
        
        $this->setAttribute("method", "POST");
        $this->setInputFilter(new Filter\EquipeFilter());

        $id = new \Zend\Form\Element\Hidden("id");
        $id->setAttribute("id", $id->getName());
        $this->add($id);
        
        $descricao = new Text("descricao");
        $descricao->setLabel("Descriçao:");
        $descricao->setAttributes(array(
            "maxlength" => "100",
            "class" => "form-control col-sm-4"
        ));
        $descricao->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($descricao);
        
        
        $input = new \Marabaixo\Form\Element\Dominio("id_equipe_tipo");        
        $input->setLabel("Tipo Equipe");
        $input->setOption("dominio", "EquipeTipo");
        $input->setLabelAttributes(array("class" => "col-sm-2 control-label"));
        $input->setAttribute("class", "form-control-item");      
        $this->add($input);
        
        $ine = new Text("ine");
        $ine->setLabel("Identificador Nacional de Equipe (INE):");
        $ine->setAttributes(array(
            "maxlength" => "100",
            "class" => "form-control col-sm-4"
        ));
        $ine->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($ine);
        
        $input = new \Marabaixo\Form\Element\Dominio("id_equipe_area");
        $input->setLabel("Area da Equipe");
        $input->setOption("dominio", "EquipeArea");
        $input->setLabelAttributes(array("class" => "col-sm-2 control-label"));
        $input->setAttribute("class", "form-control-item");
        $this->add($input);
        
        $input = new \Marabaixo\Form\Element\Dominio("id_segmento_territorial");
        $input->setLabel("Seguimento Territórial");
        $input->setOption("dominio", "SegmentoTerritorial");
        $input->setLabelAttributes(array("class" => "col-sm-2 control-label"));
        $input->setAttribute("class", "form-control-item");
        $this->add($input);
        
        $input = new \Marabaixo\Form\Element\Dominio("id_equipe_zona");
        $input->setLabel("Tipo Zona");
        $input->setOption("dominio", "EquipeTipoZona");
        $input->setLabelAttributes(array("class" => "col-sm-2 control-label"));
        $input->setAttribute("class", "form-control-item");
        $this->add($input);
        
        $input = new \Marabaixo\Form\Element\DominioCheck("id_populacao_assistida");
        $input->setLabel("População Assistida");
        $input->setOption("dominio", "PopulacaoAssistida");
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
