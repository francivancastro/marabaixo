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
class ArquivoTipoForm extends AbstractForm {
    
    public function __construct($name = null, $options = array()) {
        
        parent::__construct("formulario_arquivo_tipo");
        
        $this->setAttribute("method", "POST");
        $this->setInputFilter(new Filter\ArquivoTipoFilter());

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

        $obj = new Text("extensao");
        $obj->setLabel("Extensão:");
        $obj->setAttributes(array(
            "maxlength" => "100",
            "class" => "form-control col-sm-4"
        ));
        $obj->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($obj);

        $obj = new \Marabaixo\Form\Element\Arquivo("id_arquivo");
        $obj->setLabel("Imagem:");
        $obj->setAttributes(array(
            "class" => "form-control col-sm-4"
        ));
        $obj->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($obj);
        
        $obj = new Text("mime_type");
        $obj->setLabel("Mime Type:");
        $obj->setAttributes(array(
            "maxlength" => "100",
            "class" => "form-control col-sm-4"
        ));
        $obj->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($obj);

        $obj = new \Zend\Form\Element\Select("padrao");
        $obj->setLabel("Padrão:");
        $obj->setAttributes(array(
            "class" => "form-control col-sm-4",
            "options" => array(
                "S" => "SIM",
                "N" => "NÃO"
            )
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
