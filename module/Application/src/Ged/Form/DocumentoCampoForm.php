<?php

namespace Ged\Form;

use \Marabaixo\Abstrata\AbstractForm;

use Zend\Form\Element\Text;
use Zend\Form\Element\Button;
use Zend\Form\Element\Select;

/**
 * Description of Novoadmin
 *
 * @author zeluis
 */
class DocumentoCampoForm extends AbstractForm {
    
    public function __construct($name = null, $options = array()) {
        
        parent::__construct("formulario_documento_campo");
        
        $this->setAttribute("method", "POST");
        $this->setInputFilter(new Filter\DocumentoCampoFilter());

        $obj = new \Zend\Form\Element\Hidden("id");
        $obj->setAttribute("id", $obj->getName());
        $this->add($obj);
        
        $obj = new \Marabaixo\Form\Element\Dominio("documento_campo_tipo_chave");
        $obj->setLabel("Tipo:");
        $obj->setOption("dominio", "DocumentoCampoTipo");
        $obj->setOption("field_key", "chave");
        $obj->setLabelAttributes(array("class" => "col-sm-4 control-label"));
        $obj->setAttribute("class", "form-control-item");      
        $this->add($obj);
        
        $obj = new Text("entidade");
        $obj->setLabel("Domínio:");
        $obj->setAttributes(array(
            "maxlength" => "100",
            "class" => "form-control col-sm-4"
        ));
        $obj->setLabelAttributes(array('class' => 'col-sm-4 control-label'));
        $this->add($obj);
        
        $obj = new Text("nome");
        $obj->setLabel("Nome:");
        $obj->setAttributes(array(
            "maxlength" => "100",
            "class" => "form-control col-sm-4"
        ));
        $obj->setLabelAttributes(array('class' => 'col-sm-4 control-label'));
        $this->add($obj);
        
        $obj = new Text("descricao");
        $obj->setLabel("Descrição:");
        $obj->setAttributes(array(
            "maxlength" => "100",
            "class" => "form-control col-sm-4"
        ));
        $obj->setLabelAttributes(array('class' => 'col-sm-4 control-label'));
        $this->add($obj);
        
        $obj = new Text("tamanho");
        $obj->setLabel("Tamanho:");
        $obj->setAttributes(array(
            "maxlength" => "5",
            "class" => "form-control col-sm-2"
        ));
        $obj->setLabelAttributes(array('class' => 'col-sm-4 control-label'));
        $this->add($obj);        
        
        $obj = new \Zend\Form\Element\Select("ordem");
        $obj->setLabel("Ordem:");
        $obj->setAttributes(array(
            "maxlength" => "5",
            "class" => "form-control col-sm-2"
        ));
        $obj->setLabelAttributes(array('class' => 'col-sm-4 control-label'));
        $this->add($obj);        

        $obj = new \Zend\Form\Element\Select("obrigatorio");
        $obj->setLabel("Obrigatório:");
        $obj->setAttributes(array(
            "class" => "form-control col-sm-4",
            "options" => array(
                "S" => "SIM",
                "N" => "NÃO"
            )
        ));
        $obj->setLabelAttributes(array('class' => 'col-sm-4 control-label'));
        $this->add($obj);

        $obj = new \Zend\Form\Element\Select("mostrar_listagem");
        $obj->setLabel("Mostrar Listagem:");
        $obj->setAttributes(array(
            "class" => "form-control col-sm-4",
            "options" => array(
                "S" => "SIM",
                "N" => "NÃO"
            )
        ));
        $obj->setLabelAttributes(array('class' => 'col-sm-4 control-label'));
        $obj->setValue("N");
        $this->add($obj);

        $obj = new \Zend\Form\Element\Select("to_string");
        $obj->setLabel("To String:");
        $obj->setAttributes(array(
            "class" => "form-control col-sm-4",
            "options" => array(
                "S" => "SIM",
                "N" => "NÃO"
            )
        ));
        $obj->setLabelAttributes(array('class' => 'col-sm-4 control-label'));
        $obj->setValue("N");
        $this->add($obj);

        $obj = new \Zend\Form\Element\Select("filtro");
        $obj->setLabel("Filtro:");
        $obj->setAttributes(array(
            "class" => "form-control col-sm-4",
            "options" => array(
                "S" => "SIM",
                "N" => "NÃO"
            )
        ));
        $obj->setLabelAttributes(array('class' => 'col-sm-4 control-label'));
        $obj->setValue("N");
        $this->add($obj);
        
        $submit = new Button("submit");
        $submit->setValue("Salvar");
        $submit->setAttributes(array(
            "type" => "submit",
            "class" => "btn btn-primary"
        ));
        $submit->setLabelAttributes(array('class' => 'col-sm-4 control-label'));
        $this->add($submit);
                        
    }
}
