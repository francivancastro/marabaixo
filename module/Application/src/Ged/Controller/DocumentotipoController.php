<?php

namespace Ged\Controller;

use Zend\View\Model\ViewModel;

class DocumentotipoController extends \Marabaixo\Controller\AcessoController {

    public function indexAction() {

        $session = new \Zend\Session\Container();
        if (isset($session->id_documento_tipo)) {
            unset($session->id_documento_tipo);
        }

        $view = new ViewModel();

        $sl = $this->getServiceLocator();
        $app = $sl->get("AplicacaoFachada");

        $filtros = array("page");

        $dados = \Marabaixo\Util::atualizaFiltros($filtros, $this);

        $view->setVariable("pesquisa_dados", $dados);

        $dados["dominio"] = "DocumentoTipo";

        $result = $app->listarPorPagina($dados);

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
            $result = $app->getInfo(array("id" => $id, "dominio" => "DocumentoTipo"));

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
        $result = $app->getInfo(array("id" => $id, "dominio" => "DocumentoTipo"));

        $errors = $this->showMessages($result);

        if ($errors) {
            $this->redirect(null, array("action" => "index"), true);
        }

        if (!isset($result["data"])) {
            $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!");
            $this->redirect(null, array("action" => "index"), true);
        }

        $form = new \Application\Form\PadraoAuxiliarForm();

        if (!empty($result["data"])) {
            $result = $result["data"];

            $dados_form = array();
            $dados_form["id"] = $result["id"];
            $dados_form["descricao"] = $result["descricao"];
            $dados_form["chave"] = $result["chave"];

            $form->setData($dados_form);
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = $request->getPost();

            $form->setData($post);

            if ($form->isValid()) {

                $dados = $form->getData();
                $dados["dominio"] = "DocumentoTipo";

                $result = $app->salvar($dados);

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

    public function excluirAction() {
        $view = new ViewModel();

        $id = $this->params("id");

        if (!$id) {
            $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!");
            $this->redirect(null, array("action" => "index"), true);
        }

        $app = $this->getServiceLocator()->get("AplicacaoFachada");


        $result = $app->excluir(array("id" => $id, "dominio" => "DocumentoTipo"));

        $errors = $this->showMessages($result);

        if (!$errors) {
            $this->flashMessenger()->addSuccessMessage("Operação Efetuada com Sucesso!");
        }

        $this->redirect(null, array("action" => "index"), true);

        return $view;
    }

    public function campoAction() {

        $view = new ViewModel();

        try {

            $sl = $this->getServiceLocator();
            $app = $sl->get("AplicacaoFachada");

            $session = new \Zend\Session\Container();
            $id = 0;
            if (isset($session->id_documento_tipo) && $session->id_documento_tipo) {
                $id = $session->id_documento_tipo;
            } else {
                $id = $this->params("id");
            }

            if (!$id) {
                throw new \Exception("Falha ao Executar Operação, Nenhum Tipo de Documento Informado!");
            }

            $result = $app->getInfo(array("id" => $id, "dominio" => "DocumentoTipo"));
            if (!isset($result["data"]) || empty($result["data"])) {
                throw new \Exception("Falha ao Executar Operação, Nenhum Tipo de Documento Informado!!");
            }
            $dt = $result["data"];

            $session->id_documento_tipo = $id;

            $view->setVariable("documentotipo", $dt);

            $filtros = array("page");

            $dados = \Marabaixo\Util::atualizaFiltros($filtros, $this);

            $view->setVariable("pesquisa_dados", $dados);

            $dados["dominio"] = "DocumentoCampo";
            $dados["filtro_id_documento_tipo"] = $dt["id"];

            $result = $app->listarPorPagina($dados);

            $this->showMessages($result);

            if (isset($result["data"])) {
                $view->setVariable("result", $result["data"]);
            }

            $botoes = $this->getServiceLocator()->get("button");
            $botoes->setController($this);
            $botoes->addAction(array("titulo" => "Adicionar",
                "icone" => "fa-plus-circle",
                "url" => $this->url()->fromRoute(null, array("controller" => $this->getControllerName(),
                    "action" => "editarcampo",
                    "id" => "0"))));
            $botoes->addAction(array("titulo" => "Voltar",
                "icone" => "fa-reply",
                "url" => $this->url()->fromRoute(null, array("controller" => $this->getControllerName(),
                    "action" => "index",
                    "id" => "0"))));

            return $view;
        } catch (\Exception $ex) {
            $this->flashMessenger()->addErrorMessage($ex->getMessage());
            $this->redirect(null, array("action" => "index"), true);
        }
    }

    public function editarcampoAction() {
        $view = new ViewModel();
        try {

            $app = $this->getServiceLocator()->get("AplicacaoFachada");
            /*
            $dominios = $app->getDominios();
            var_dump($dominios); die();
             * 
             */

            //documento tipo
            $session = new \Zend\Session\Container();
            $id_dt = 0;
            if (isset($session->id_documento_tipo) && $session->id_documento_tipo) {
                $id_dt = $session->id_documento_tipo;
            }

            if (!$id_dt) {
                throw new \Exception("Falha ao Executar Operação, Nenhum Tipo de Documento Informado!");
            }

            $result = $app->getInfo(array("id" => $id_dt, "dominio" => "DocumentoTipo"));
            if (!isset($result["data"]) || empty($result["data"])) {
                throw new \Exception("Falha ao Executar Operação, Nenhum Tipo de Documento Informado!!");
            }
            $dt = $result["data"];

            $view->setVariable("documentotipo", $dt);
            //fim documento_tipo

            $id = $this->params("id");

            //documento_tipo_campo
            $result = $app->getInfo(array("id" => $id, "dominio" => "DocumentoCampo"));
            $errors = $this->showMessages($result);
            if ($errors) {
                $this->redirect(null, array("action" => "index"), true);
            }

            if (!isset($result["data"])) {
                $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!");
                $this->redirect(null, array("action" => "index"), true);
            }
            //fim documento_tpo_campo

            $form = new \Ged\Form\DocumentoCampoForm();

            //ordem
            $ordem_final = 1;
            $po_result = $app->pegaDocumentoCampoProximaOrdem(array("id_documento_tipo" => $id_dt));
            if (isset($po_result["data"]["ordem"])) {
                $ordem_final = $po_result["data"]["ordem"];
            }

            $ctrl_ordem = $form->get("ordem");
            $ordem_values = array();
            $ordem_values[""] = "==> ORDEM <==";
            for ($x = 1; $x <= $ordem_final; $x++) {
                $ordem_values[$x] = $x;
            }
            $ctrl_ordem->setValueOptions($ordem_values);
            //final ordem

            if (!empty($result["data"])) {
                $result = $result["data"];

                $dados_form = array();
                $dados_form["id"] = $result["id"];
                $dados_form["documento_campo_tipo_chave"] = "";
                $dados_form["entidade"] = $result["entidade"];
                $dados_form["nome"] = $result["nome"];
                $dados_form["descricao"] = $result["descricao"];
                $dados_form["tamanho"] = $result["tamanho"];
                $dados_form["obrigatorio"] = $result["obrigatorio"];
                $dados_form["ordem"] = $result["ordem"];
                $dados_form["mostrar_listagem"] = $result["mostrar_listagem"];
                $dados_form["to_string"] = $result["to_string"];
                $dados_form["filtro"] = $result["filtro"];

                if (isset($result["documento_campo_tipo"]["chave"])) {
                    $dados_form["documento_campo_tipo_chave"] = $result["documento_campo_tipo"]["chave"];
                }
                
                if (isset($result["lista"]) && count($result["lista"])) {
                    $campo_item = array();
                    foreach ($result["lista"] as $item) {
                        $campo_item[$item["chave"]] = $item["descricao"];
                    }
                    $view->setVariable("campo_item", $campo_item);
                }

                $form->setData($dados_form);
            }

            $request = $this->getRequest();
            if ($request->isPost()) {
                $post = $request->getPost();
                
                $campo_item = $post->get("campo_item");
                $view->setVariable("campo_item", $campo_item);

                $form->setData($post);

                if ($form->isValid()) {
                    
                    $dados = $form->getData();
                    $dados["id_documento_tipo"] = $id_dt;
                    $dados["campo_item"] = $campo_item;

                    $result = $app->salvarDocumentoCampo($dados);

                    $errors = $this->showMessages($result);

                    if (!$errors) {
                        $this->flashMessenger()->addSuccessMessage("Operação Efetuada com Sucesso!");
                        $this->redirect(null, array("action" => "campo"), true);
                    }
                }

                $form->showErrorMessages($this);
            }

            $view->setVariable("form", $form);

            $botoes = $this->getServiceLocator()->get("button");
            $botoes->setController($this);
            $botoes->addAction(array("titulo" => "Voltar",
                "icone" => "fa-reply",
                "url" => $this->url()->fromRoute(null, array("action" => "campo", "id" => "0"), true)));


            return $view;
        } catch (\Exception $ex) {
            $this->flashMessenger()->addErrorMessage($ex->getMessage());
            $this->redirect(null, array("action" => "index"), true);
        }
    }

    public function excluircampoAction() {
        $view = new ViewModel();

        $id = $this->params("id");

        if (!$id) {
            $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!");
            $this->redirect(null, array("action" => "index"), true);
        }

        $app = $this->getServiceLocator()->get("AplicacaoFachada");


        $result = $app->excluir(array("id" => $id, "dominio" => "DocumentoCampo"));

        $errors = $this->showMessages($result);

        if (!$errors) {
            $this->flashMessenger()->addSuccessMessage("Operação Efetuada com Sucesso!");
        }

        $this->redirect(null, array("action" => "campo"), true);

        return $view;
    }

    public function viewcampoAction() {
        $view = new ViewModel();

        try {
            $id = $this->params("id");
            if (!$id) {
                throw new \Exception("Falha ao Executar Operação, Nenhum Campo Informado!");
            }

            $app = $this->getServiceLocator()->get("AplicacaoFachada");
            $result = $app->getInfo(array("id" => $id, "dominio" => "DocumentoCampo"));

            $errors = $this->showMessages($result);
            if ($errors) {
                $this->redirect(null, array("action" => "campo"), true);
            }

            if (!(isset($result["data"]) && !empty($result["data"]))) {
                throw new \Exception("Falha ao Executar Operação, Nenhum Campo Informado!");
            }

            $view->setVariable("result", $result["data"]);

            $botoes = $this->getServiceLocator()->get("button");
            $botoes->setController($this);
            $botoes->addAction(array("titulo" => "Voltar",
                "icone" => "fa-reply",
                "url" => $this->url()->fromRoute(null, array("action" => "campo", "id" => "0"), true)));

            return $view;
            
        } catch (\Exception $ex) {
            $this->flashMessenger()->addErrorMessage($ex->getMessage());
            $this->redirect(null, array("action" => "campo"), true);
        }
    }

}
