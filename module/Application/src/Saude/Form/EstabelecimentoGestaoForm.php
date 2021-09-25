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
class EstabelecimentoGestaoForm extends AbstractForm {
    
    public function __construct($name = null, $options = array()) {
        
        parent::__construct("formulario_estabelecimentogestao");
        
        $this->setAttribute("method", "POST");
        $this->setInputFilter(new Filter\EstabelecimentoGestaoFilter());

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
        
        $chave = new Text("chave");
        $chave->setLabel("Chave:");
        $chave->setAttributes(array(
            "maxlength" => "100",
            "class" => "form-control col-sm-4"
        ));
        $chave->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($chave);        
                   
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
