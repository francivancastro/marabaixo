<?php

namespace Rh\Form;

use \Marabaixo\Abstrata\AbstractForm;
use Zend\Form\Element\Text;
use Zend\Form\Element\Button;
use Zend\Form\Element\Select;
use Zend\Form\Element\Checkbox;

/**
 * Description of Novoadmin
 *
 * @author fernando
 */
class OrgaoForm extends AbstractForm {

    public function __construct($name = null, $options = array()) {

        parent::__construct("formulario_orgao");

        $this->setAttribute("method", "POST");

        $this->setInputFilter(new Filter\OrgaoFilter());

        $obj = new \Zend\Form\Element\Hidden("id");
        $obj->setAttribute("id", $obj->getName());
        $this->add($obj);

        $obj = new Text("codigo");
        $obj->setLabel("Código:");
        $obj->setAttributes(array(
            "maxlength" => "100",
            "class" => "form-control col-sm-4"
        ));
        $obj->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($obj);

        $obj = new Text("descricao");
        $obj->setLabel("Descriçao:");
        $obj->setAttributes(array(
            "maxlength" => "100",
            "class" => "form-control col-sm-4"
        ));
        $obj->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($obj);

        $obj = new Text("portaria");
        $obj->setLabel("Portaria:");
        $obj->setAttributes(array(
            "maxlength" => "100",
            "class" => "form-control col-sm-4"
        ));
        $obj->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $this->add($obj);

        $input = new \Marabaixo\Form\Element\Dominio("id_orgao_superior");
        $input->setLabel("Orgão Superior:");
        $input->setOption("dominio", "Orgao");
        $input->setLabelAttributes(array("class" => "col-sm-2 control-label"));
        $input->setAttribute("class", "form-control-item");
        $this->add($input);

        $obj = new Checkbox('gestao_ingresso');
        $obj->setLabel('Gestor de Ingresso');
        $obj->setUseHiddenElement(true);
        $obj->setCheckedValue('S');
        $obj->setUncheckedValue('N');
        $obj->setAttributes(array(
            "class" => "checkbox"
        ));
        $obj->setLabelAttributes(array(
            'class' => 'col-sm-2 control-label'));

        $this->add($obj);
////////////////////////////////////////////////////////////////////////////
        if (isset($_REQUEST['id_orgao_superior'])):
            $orgao_principal = $_REQUEST['id_orgao_superior'];
        endif;
        if (isset($_REQUEST['gestao_ingresso'])):
            $orgao_gestor_ingresso = $_REQUEST['gestao_ingresso'];
        endif;
        if (empty($orgao_principal)):            

            if ($orgao_gestor_ingresso == null || $orgao_gestor_ingresso == 'S') {
                $this->setInputFilter(new Filter\ServidorFilter());

                $id = new \Zend\Form\Element\Hidden("id");
                $id->setAttribute("id", $id->getName());
                $this->add($id);

                $pf = new \Marabaixo\Form\Element\PessoaFisica("id_pessoa_fisica");
                $pf->setLabel("Pessoa Física:");
                $pf->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
                $this->add($pf);

                $matricula = new Text("matricula");
                $matricula->setLabel("Matrícula:");
                $matricula->setAttributes(array(
                    "maxlength" => "10",
                    "class" => "form-control col-sm-2"
                ));
                $matricula->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
                $this->add($matricula);

                $identificacao_unica = new Text("identificacao_unica");
                $identificacao_unica->setLabel("Identificação Unica:");
                $identificacao_unica->setAttributes(array(
                    "maxlength" => "10",
                    "class" => "form-control col-sm-2"
                ));
                $identificacao_unica->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
                $this->add($identificacao_unica);

                $data_ingresso = new Text("data_ingresso");
                $data_ingresso->setLabel("Data Ingresso:");
                $data_ingresso->setAttributes(array(
                    "maxlength" => "100",
                    "class" => "form-control col-sm-2"
                ));
                $data_ingresso->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
                $this->add($data_ingresso);

                $data_ultima_alteracao = new Text("data_ultima_alteracao");
                $data_ultima_alteracao->setLabel("Data Ultima Alteração:");
                $data_ultima_alteracao->setAttributes(array(
                    "maxlength" => "100",
                    "class" => "form-control col-sm-2"
                ));
                $data_ultima_alteracao->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
                $this->add($data_ultima_alteracao);

                $carga_horaria = new Text("carga_horaria");
                $carga_horaria->setLabel("Carga Horária:");
                $carga_horaria->setAttributes(array(
                    "maxlength" => "100",
                    "class" => "form-control col-sm-2"
                ));
                $carga_horaria->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
                $this->add($carga_horaria);

                $input = new \Marabaixo\Form\Element\Dominio("id_servidor_cargo");
                $input->setLabel("Cargo");
                $input->setOption("dominio", "ServidorCargo");
                $input->setLabelAttributes(array("class" => "col-sm-2 control-label"));
                $input->setAttribute("class", "form-control-item");
                $this->add($input);

                $input = new \Marabaixo\Form\Element\Dominio("id_servidor_classe");
                $input->setLabel("Classe");
                $input->setOption("dominio", "ServidorClasse");
                $input->setLabelAttributes(array("class" => "col-sm-2 control-label"));
                $input->setAttribute("class", "form-control-item");
                $this->add($input);

                $input = new \Marabaixo\Form\Element\Dominio("id_servidor_funcao");
                $input->setLabel("Função");
                $input->setOption("dominio", "ServidorFuncao");
                $input->setLabelAttributes(array("class" => "col-sm-2 control-label"));
                $input->setAttribute("class", "form-control-item");
                $this->add($input);

                $input = new \Marabaixo\Form\Element\Dominio("id_servidor_nivel");
                $input->setLabel("Nivel");
                $input->setOption("dominio", "ServidorNivel");
                $input->setLabelAttributes(array("class" => "col-sm-2 control-label"));
                $input->setAttribute("class", "form-control-item");
                $this->add($input);

                $input = new \Marabaixo\Form\Element\Dominio("id_regime_juridico");
                $input->setLabel("Regime Jurídico:");
                $input->setOption("dominio", "RegimeJuridico");
                $input->setLabelAttributes(array("class" => "col-sm-2 control-label"));
                $input->setAttribute("class", "form-control-item");
                $this->add($input);
            }
        endif;
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
