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
class RegiaoForm extends AbstractForm {
    
    public function __construct($name = null, $options = array()) {
        
        parent::__construct("formulario_regiao");
        
        $this->setAttribute("method", "POST");
        $this->setInputFilter(new Filter\RegiaoFilter());

        $obj = new \Zend\Form\Element\Hidden("id");
        $obj->setAttribute("id", $obj->getName());
        $this->add($obj);
        
        $obj = new Text("descricao");
        $obj->setLabel("Descriçao:");
        $obj->setAttributes(array(
            "maxlength" => "100",
            "class" => "form-control col-sm-4"
        ));
        $obj->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($obj);
        
        $obj = new Text("sigla");
        $obj->setLabel("Sigla:");
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
              
        $obj = new Button("submit");
        $obj->setValue("Salvar");
        $obj->setAttributes(array(
            "type" => "submit",
            "class" => "btn btn-primary"
        ));
        $obj->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($obj);
        
    }
}
