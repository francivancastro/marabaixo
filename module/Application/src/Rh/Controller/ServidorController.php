<?php

namespace Rh\Controller;

use Zend\View\Model\ViewModel;

class ServidorController extends \Marabaixo\Controller\AcessoController {

    public function indexAction() {

        $view = new ViewModel();

        $sl = $this->getServiceLocator();
        $app = $sl->get("AplicacaoFachada");
        
        $filtros = array("pesquisa_nome", "pesquisa_cpf", "pesquisa_mat", "page");

        $dados = \Marabaixo\Util::atualizaFiltros($filtros, $this);
        
        $view->setVariable("pesquisa_dados", $dados);

        $dados["dominio"] = "Servidor";

        $xml = $app->listarPorPagina(\Marabaixo\Util::array_to_xml($dados));

        $result = \Marabaixo\Util::xml_to_array($xml);
        
        $this->showMessages($result);

        if (isset($result["data"])) {
            $view->setVariable("result", $result["data"]);
        }

        $botoes = $this->getServiceLocator()->get("button");
        $botoes->setController($this);
        $botoes->addAction(array("titulo" => "Adicionar",
            "icone" => "fa-plus-circle",
            "url" => $this->url()->fromRoute(null, array("controller" => $this->getControllerName(),
                "action" => "editar",
                "id" => "0"))));
        $botoes->addScript(array("titulo" => "Pesquisar",
            "icone" => "fa-search",
            "url" => "pesquisar()"));
        $botoes->addAction(array("titulo" => "Voltar",
            "icone" => "fa-reply",
            "url" => $this->url()->fromRoute(null, array("controller" => "index",
                "action" => "index",
                "id" => "0"))));

        return $view;
    }

    public function viewAction() {
        $view = new ViewModel();

        $id = $this->params("id");

        if ($id) {
            $app = $this->getServiceLocator()->get("AplicacaoFachada");
            $xml = $app->getInfo(\Marabaixo\Util::array_to_xml(array("id" => $id, "dominio" => "Servidor")));

            $result = \Marabaixo\Util::xml_to_array($xml);

            $errors = $this->showMessages($result);

            if (!$errors) {
                if (isset($result["data"]) && !empty($result["data"])) {
                    $view->setVariable("result", $result["data"]);

                    $botoes = $this->getServiceLocator()->get("button");
                    $botoes->setController($this);
                    $botoes->addAction(array("titulo" => "Voltar",
                        "icone" => "fa-reply",
                        "url" => $this->url()->fromRoute(null, array("action" => "index", "id" => "0"), true)));
                } else {
                    $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!");
                    $this->redirect(null, array("action" => "index"), true);
                }
            } else {
                $this->redirect(null, array("action" => "index"), true);
            }
        } else {
            $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!");
            $this->redirect(null, array("action" => "index"), true);
        }

        return $view;
    }

    public function editarAction() {
        $view = new ViewModel();

        $id = $this->params("id");

        $app = $this->getServiceLocator()->get("AplicacaoFachada");
        $xml = $app->getInfo(\Marabaixo\Util::array_to_xml(array("id" => $id, "dominio" => "Servidor")));

        $result = \Marabaixo\Util::xml_to_array($xml);

        $errors = $this->showMessages($result);

        if ($errors) {
            $this->redirect(null, array("action" => "index"), true);
        }

        if (!isset($result["data"])) {
            $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!");
            $this->redirect(null, array("action" => "index"), true);
        }

        $form = new \Rh\Form\ServidorForm();

        if (!empty($result["data"])) {
            $result = $result["data"];
            $dados_form = array();
            $dados_form["id"] = $result["id"];
            $dados_form["id_pessoa_fisica"] = $result["usuario"]['pessoa_fisica']['id'];
            $dados_form["matricula"] = $result["matricula"];
            $dados_form["identificacao_unica"] = $result["identificacao_unica"];
            $dados_form["data_ingresso"] = $result["data_ingresso"];
            $dados_form["data_ultima_alteracao"] = $result["data_ultima_alteracao"];
            $dados_form["carga_horaria"] = $result["carga_horaria"];
            $dados_form["id_orgao"] = $result["orgao"]['id'];
            $dados_form["id_servidor_cargo"] = $result["servidor_cargo"]['id'];
            $dados_form["id_servidor_classe"] = $result["servidor_classe"]['id'];
            $dados_form["id_servidor_funcao"] = $result["servidor_funcao"]['id'];
            $dados_form["id_servidor_nivel"] = $result["servidor_nivel"]['id'];
            $dados_form["id_regime_juridico"] = $result["regime_juridico"]['id'];

            $form->setData($dados_form);
        }
        
        

        $request = $this->getRequest();        
        if ($request->isPost()) {
            $post = $request->getPost();

            $form->setData($post);

            if ($form->isValid()) {

                $dados = $form->getData();


                $dados["dominio"] = "Servidor";
           
                $xml = $app->salvarServidor(\Marabaixo\Util::array_to_xml($dados));

                $result = \Marabaixo\Util::xml_to_array($xml);

                $errors = $this->showMessages($result);

                if (!$errors) {
                    $this->flashMessenger()->addSuccessMessage("Operação Efetuada com Sucesso!");
                    $this->redirect(null, array("action" => "index"), true);
                }
            }

            $form->showErrorMessages($this);
        }

        $view->setVariable("form", $form);

        $botoes = $this->getServiceLocator()->get("button");
        $botoes->setController($this);
        $botoes->addAction(array("titulo" => "Voltar",
            "icone" => "fa-reply",
            "url" => $this->url()->fromRoute(null, array("action" => "index", "id" => "0"), true)));


        return $view;
    }

    public function ativarAction() {
        $view = new ViewModel();

        $id = $this->params("id");
        $app = $this->getServiceLocator()->get("AplicacaoFachada");
        $xml = $app->getInfo(\Marabaixo\Util::array_to_xml(array("id" => $id, "dominio" => "Servidor")));

        $result = \Marabaixo\Util::xml_to_array($xml);

        $errors = $this->showMessages($result);

        if ($errors) {
            $this->redirect(null, array("action" => "index"), true);
        }

        if (!isset($result["data"])) {
            $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!");
            $this->redirect(null, array("action" => "index"), true);
        }

        $form = new \Rh\Form\ServidorAtivarForm();

        if (!empty($result["data"])) {
            $result = $result["data"];

            $dados = array();
            $dados["id"] = $result["id"];
            $dados["servidor_situacao"] = $result["servidor_situacao"]['chave'];

            $form->setData($dados);
        }


        $request = $this->getRequest();

        if ($request->isPost()) {
            $post = $request->getPost();

            $form->setData($post);

            if ($form->isValid()) {

                $dados = $form->getData();


                $dados["dominio"] = "Servidor";

                $xml = $app->servidorAtivacao(\Marabaixo\Util::array_to_xml($dados));

                $result = \Marabaixo\Util::xml_to_array($xml);

                $errors = $this->showMessages($result);

                if (!$errors) {
                    $this->flashMessenger()->addSuccessMessage("Operação Efetuada com Sucesso!");
                    $this->redirect(null, array("action" => "index"), true);
                }
            }
            
            $form->showErrorMessages($this);
        }

        $view->setVariable("form", $form);

        $botoes = $this->getServiceLocator()->get("button");
        $botoes->setController($this);
        $botoes->addAction(array("titulo" => "Voltar",
            "icone" => "fa-reply",
            "url" => $this->url()->fromRoute(null, array("action" => "index", "id" => "0"), true)));


        return $view;
    }

    public function tornarChefeAction() {
         
        $view = new ViewModel();
        $id = $this->params("id");
        
        $app = $this->getServiceLocator()->get("AplicacaoFachada");
        $xml = $app->getInfo(\Marabaixo\Util::array_to_xml(array("id" => $id, "dominio" => "Servidor")));

        $result = \Marabaixo\Util::xml_to_array($xml);
        
        $errors = $this->showMessages($result);

        if ($errors) {
            $this->redirect(null, array("action" => "index"), true);
        }

        if (!isset($result["data"])) {
            $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!");
            $this->redirect(null, array("action" => "index"), true);
        }
         
        $form = new \Rh\Form\ServidorTornarChefeForm();
        
        if (!empty($result["data"])) {
            $result = $result["data"]; 
            
            $dados = array();
            $dados["id"] = $result["id"]; 
            $dados["id_servidor"] = $result["id"];            
            $dados["matricula"] = $result["matricula"];
            $dados["nome"] = $result["usuario"]['tostring'];
            $dados["cpf"] = $result["usuario"]["pessoa_fisica"]['cpf'];
            $dados["data_ingresso"] = $result["data_ingresso"];
            $dados["data_ultima_alteracao"] = $result["data_ultima_alteracao"];
            $dados["id_servidor_funcao"] = $result["servidor_funcao"]['id'];
            $dados["id_servidor_cargo"] = $result["servidor_cargo"]['id'];
            $dados["id_orgao"] = $result["orgao"]['id'];
            $dados["carga_horaria"] = $result["carga_horaria"];
            
            $form->setData($dados);
        }
        
       
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $post = $request->getPost();
           
            $form->setData($post);
            
            if ($form->isValid()) {
                
                $dados = $form->getData();               
                
                $dados["dominio"] = "ServidorChefia";
                
                $xml = $app->tornarChefe(\Marabaixo\Util::array_to_xml($dados));

                $result = \Marabaixo\Util::xml_to_array($xml);

                $errors = $this->showMessages($result);

                if (!$errors) {
                    $this->flashMessenger()->addSuccessMessage("Operação Efetuada com Sucesso!");
                    $this->redirect(null, array("action" => "index"), true);
                }
            }

            $form->showErrorMessages($this);
        }
        
        $view->setVariable("form", $form);

        $botoes = $this->getServiceLocator()->get("button");
        $botoes->setController($this);
        $botoes->addAction(array("titulo" => "Voltar",
            "icone" => "fa-reply",
            "url" => $this->url()->fromRoute(null, array("action" => "index", "id" => "0"), true)));

        
        return $view;
    }

    public function encaminharAction() {
        $view = new ViewModel();

        $id = $this->params("id");

        $app = $this->getServiceLocator()->get("AplicacaoFachada");
        $xml = $app->getInfo(\Marabaixo\Util::array_to_xml(array("id" => $id, "dominio" => "Servidor")));

        $result = \Marabaixo\Util::xml_to_array($xml);

        $errors = $this->showMessages($result);

        if ($errors) {
            $this->redirect(null, array("action" => "index"), true);
        }

        if (!isset($result["data"])) {
            $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!");
            $this->redirect(null, array("action" => "index"), true);
        }

        $form = new \Rh\Form\ServidorEncaminhamentoForm();
        
        if (!empty($result["data"])) {
            $result = $result["data"];

            $dados_form = array();
            $dados_form["id_servidor"] = $result["id"];
            $dados_form["servidor"] = $result["usuario"]["pessoa_fisica"]['nome'];
            $dados_form["matricula"] = $result["matricula"];
            $dados_form["cpf"] = $result["usuario"]["pessoa_fisica"]['cpf'];
            $dados_form["data_ingresso"] = $result["data_ingresso"];
            $dados_form["data_ultima_alteracao"] = $result["data_ultima_alteracao"];
            $dados_form["id_servidor_funcao"] = $result["servidor_funcao"]['id'];
            $dados_form["id_servidor_cargo"] = $result["servidor_cargo"]['id'];
            $dados_form["id_orgao"] = $result["orgao"]['id'];
            $dados_form["carga_horaria"] = $result["carga_horaria"];

            $form->setData($dados_form);
        }


        $request = $this->getRequest();

        if ($request->isPost()) {
            $post = $request->getPost();
            $form->setData($post);

            if ($form->isValid()) {

                $dados = $form->getData();

                $dados["dominio"] = "ServidorMovimento";

                $xml = $app->salvarServidorEncaminhamento(\Marabaixo\Util::array_to_xml($dados));

                $result = \Marabaixo\Util::xml_to_array($xml);

                $errors = $this->showMessages($result);

                if (!$errors) {
                    $this->flashMessenger()->addSuccessMessage("Operação Efetuada com Sucesso!");
                    $this->redirect(null, array("action" => "index"), true);
                }
            }

            $form->showErrorMessages($this);
        }

        $view->setVariable("form", $form);

        $botoes = $this->getServiceLocator()->get("button");
        $botoes->setController($this);
        $botoes->addAction(array("titulo" => "Voltar",
            "icone" => "fa-reply",
            "url" => $this->url()->fromRoute(null, array("action" => "index", "id" => "0"), true)));


        return $view;
    }

    public function ocorrenciaAction() {

        $view = new ViewModel();

        $id = $this->params("id");

        $sl = $this->getServiceLocator();
        $app = $sl->get("AplicacaoFachada");
        $idxml = $app->getInfo(\Marabaixo\Util::array_to_xml(array("id" => $id, "dominio" => "Servidor")));
        $res = \Marabaixo\Util::xml_to_array($idxml);
        $resultado = $res['data'];

        $filtros = array("page", "filtro_data_ocorrencia", "filtro_nome", "filtro_matricula", "filtro_tipo_ocorrencia", "filtro_id");

        $dados = \Marabaixo\Util::atualizaFiltros($filtros, $this);

        $view->setVariable("pesquisa_dados", $dados);

        $dados["dominio"] = "ServidorOcorrencia";
        $dados["filtro_id"] = $resultado['id'];
        $xml = $app->listarPorPagina(\Marabaixo\Util::array_to_xml($dados));

        $result = \Marabaixo\Util::xml_to_array($xml);
        $objs = $result["data"]['registros'][0]['id_servidor_ref'];
        $servidor_ref = $app->getInfo(\Marabaixo\Util::array_to_xml(array("id" => $objs, "dominio" => "Servidor")));
        $srf = \Marabaixo\Util::xml_to_array($servidor_ref);

        $view->setVariable("servidor_ref", $srf);
        $this->showMessages($result);

        if (isset($result["data"])) {
            $view->setVariable("result", $result["data"]);
        }

        $result = $app->listar(array("dominio" => "ServidorOcorrenciaTipo"));
        $objs = false;
        if (isset($result["data"])) {
            $objs = $result["data"];
        }
        if (empty($objs)) {
            throw new \Exception("Falha ao Executar Operação, Nenhum Tipo de Log Cadastrado!");
        }

        $view->setVariable("ocorrencia_tipo", $objs);

        $botoes = $this->getServiceLocator()->get("button");
        $botoes->setController($this);

        $botoes->addScript(array("titulo" => "Pesquisar",
            "icone" => "fa-search",
            "url" => "pesquisar()"));
        $botoes->addAction(array("titulo" => "Voltar",
            "icone" => "fa-reply",
            "url" => $this->url()->fromRoute(null, array("controller" => "servidor",
                "action" => "index",
                "id" => "0"))));

        return $view;
    }

    public function validaOrgaoAtual() {
        $sl = $this->getServiceLocator();
        $app = $sl->get("AplicacaoFachada");
        $result = $app->getOrgaoAtual(array());

        if (!isset($result["data"]) || empty($result["data"])) {
            $this->flashMessenger()->addErrorMessage("Servidor não está vinculado a nenhum Orgão!");
            $this->redirect(null, array("controller" => "index", "action" => "index"), true);
        }
        $gestor_ingresso = $result["data"]["gestao_ingresso"];
        if ($gestor_ingresso != "S") {
            $this->flashMessenger()->addErrorMessage("Orgão atual não é gestor de ingresso!");
            $this->redirect(null, array("controller" => "index", "action" => "index"), true);
        }
        return $result["data"];
    }

    public function validarServidorAtivo() {
        $sl = $this->getServiceLocator();
        $app = $sl->get("AplicacaoFachada");

        $result = $app->ServidorAtivo(array());
        if (!isset($result["data"]) || empty($result["data"])) {
            $this->flashMessenger()->addErrorMessage("Usuario não é Servidor!");
            $this->redirect(null, array("controller" => "index", "action" => "index"), true);
        }
        return $result["data"];
    }

    public function permiteGestorRh() {
        $sl = $this->getServiceLocator();
        $app = $sl->get("AplicacaoFachada");
        $result = $app->getGestorRh(array());

        if (!isset($result["data"]) || empty($result["data"])) {
            $this->flashMessenger()->addErrorMessage("Apenas o Gestor de RH e o Adminstrador do Orgão tem permissão para ingressar Servidor!");
            $this->redirect(null, array("controller" => "index", "action" => "index"), true);
        }
        return $result["data"];
    }

}
