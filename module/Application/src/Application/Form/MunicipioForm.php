<?php

namespace Application\Form;

use \Marabaixo\Abstrata\AbstractForm;

use Zend\Form\Element\Text;
use Zend\Form\Element\Button;

/**
 * Description of Novoadmin
 *
 * @author zeluis
 */
class MunicipioForm extends AbstractForm {
    
    public function __construct($name = null, $options = array()) {
        
        parent::__construct("formulario_municipio");
        
        $this->setAttribute("method", "POST");
        $this->setInputFilter(new Filter\MunicipioFilter());

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

        $ibge = new Text("ibge");
        $ibge->setLabel("IBGE:");
        $ibge->setAttributes(array(
            "maxlength" => "100",
            "class" => "form-control col-sm-2"
        ));
        $ibge->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($ibge);
        
        $input = new \Marabaixo\Form\Element\Dominio("id_uf");
        $input->setLabel("UF");
        $input->setOption("dominio", "Uf");
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
