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
class WidgetForm extends AbstractForm {
    
    public function __construct($name = null, $options = array()) {
        
        parent::__construct("formulario_widget");
        
        $this->setAttribute("method", "POST");
        $this->setInputFilter(new Filter\WidgetFilter());

        $id = new \Zend\Form\Element\Hidden("id_widget");
        $id->setAttribute("id", $id->getName());
        $this->add($id);
        
        $obj = new Text("descricao");
        $obj->setLabel("Descriçao:");
        $obj->setAttributes(array(
            "maxlength" => "100",
            "class" => "form-control col-sm-4"
        ));
        $obj->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($obj);

        $obj = new Text("nome_classe");
        $obj->setLabel("Nome da Classe:");
        $obj->setAttributes(array(
            "maxlength" => "100",
            "class" => "form-control col-sm-4"
        ));
        $obj->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($obj);
        
        $obj = new \Zend\Form\Element\Select("status");
        $obj->setLabel("Status:");
        $obj->setAttributes(array(
            "class" => "form-control col-sm-4"
        ));
        $obj->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $obj->setValueOptions(array(
             'A' => 'ATIVO',
             'I' => 'INATIVO',
        ));
        $obj->setValue("A");
        $this->add($obj);

        $obj = new \Zend\Form\Element\Select("ordem");
        $obj->setLabel("Ordem:");
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
        
        $obj = new Button("cancelar");
        $obj->setValue("Cancelar");
        $obj->setAttributes(array(
            "class" => "btn btn-default"
        ));
        $obj->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($obj);
                
    }
}
