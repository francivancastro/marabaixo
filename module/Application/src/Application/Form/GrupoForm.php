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
class GrupoForm extends AbstractForm {
    
    public function __construct($name = null, $options = array()) {
        
        parent::__construct("formulario_grupo");
        
        $this->setAttribute("method", "POST");
        $this->setInputFilter(new Filter\GrupoFilter());

        $id = new \Zend\Form\Element\Hidden("id_grupo");
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
        
        $admin = new \Zend\Form\Element\Select("admin");
        $admin->setLabel("Administrador:");
        $admin->setAttributes(array(
            "class" => "form-control col-sm-4"
        ));
        $admin->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $admin->setValueOptions(array(
             'S' => 'SIM',
             'N' => 'NÃO',
        ));
        $admin->setValue("N");
        $this->add($admin);

        $status = new \Zend\Form\Element\Select("status");
        $status->setLabel("Status:");
        $status->setAttributes(array(
            "class" => "form-control col-sm-4"
        ));
        $status->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $status->setValueOptions(array(
             'A' => 'ATIVO',
             'I' => 'INATIVO',
        ));
        $status->setValue("A");
        $this->add($status);
        
        $submit = new Button("submit");
        $submit->setValue("Salvar");
        $submit->setAttributes(array(
            "type" => "submit",
            "class" => "btn btn-primary"
        ));
        $submit->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($submit);
        
        $cancelar = new Button("cancelar");
        $cancelar->setValue("Cancelar");
        $cancelar->setAttributes(array(
            "class" => "btn btn-default"
        ));
        $cancelar->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($cancelar);
                
    }
}
