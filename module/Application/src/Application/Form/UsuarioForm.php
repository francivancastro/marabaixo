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
class UsuarioForm extends AbstractForm {
    
    public function __construct($name = null, $options = array()) {
        
        parent::__construct("formulario_grupo");
        
        $this->setAttribute("method", "POST");
        $this->setInputFilter(new Filter\UsuarioFilter());

        $id = new \Zend\Form\Element\Hidden("id_usuario");
        $id->setAttribute("id", $id->getName());
        $this->add($id);

        $pf = new \Marabaixo\Form\Element\PessoaFisica("id_pessoa_fisica");
        $pf->setLabel("Pessoa Física:");
        $pf->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($pf);
        
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
