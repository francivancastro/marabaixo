<?php

namespace Rh\Controller;

use Zend\View\Model\ViewModel;

class OrgaoController extends \Marabaixo\Controller\AcessoController {

    public function indexAction() {
        try {
            $view = new ViewModel();

            $sl = $this->getServiceLocator();
            $app = $sl->get("AplicacaoFachada");

            $filtros = array("pesquisa_codigo", "pesquisa_descricao", "pesquisa_gestor_ingresso", "page");

            $dados = \Marabaixo\Util::atualizaFiltros($filtros, $this);

            $view->setVariable("pesquisa_dados", $dados);
            $dados['dominio'] = "Orgao";

            $xml = $app->listarPorPagina(\Marabaixo\Util::array_to_xml($dados));

            $result = \Marabaixo\Util::xml_to_array($xml);

            $this->showMessages($result);

            if (isset($result["data"])) {
                $view->setVariable("result", $result["data"]);
            }
        } catch (\Exception $ex) {
            $this->flashMessage()->addErrorMessage($ex->getMessage());
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
            $xml = $app->getInfo(\Marabaixo\Util::array_to_xml(array("id" => $id, "dominio" => "Orgao")));

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
                    $this->flashMessenger()->addErrorMessage("Falha ao Executar Opera????o, Dados Inv??lidos!");
                    $this->redirect(null, array("action" => "index"), true);
                }
            } else {
                $this->redirect(null, array("action" => "index"), true);
            }
        } else {
            $this->flashMessenger()->addErrorMessage("Falha ao Executar Opera????o, Dados Inv??lidos!");
            $this->redirect(null, array("action" => "index"), true);
        }

        return $view;
    }

    public function editarAction() {
        $view = new ViewModel();

        $id = $this->params("id");

        $app = $this->getServiceLocator()->get("AplicacaoFachada");

        $xml = $app->getInfo(\Marabaixo\Util::array_to_xml(array("id" => $id, "dominio" => "Orgao")));
        $dados['dominio'] = "Orgao";

        $gi = $app->getOrgaoGestorIngresso(\Marabaixo\Util::array_to_xml(array($dados)));
        $resultgi = \Marabaixo\Util::xml_to_array($gi);


        $result = \Marabaixo\Util::xml_to_array($xml);
        $errors = $this->showMessages($result);

        if ($errors) {
            $this->redirect(null, array("action" => "index"), true);
        }
        if (isset($resultgi)) {
            $view->setVariable("resultgi", $resultgi);
        }

        if (!isset($result["data"])) {
            $this->flashMessenger()->addErrorMessage("Falha ao Executar Opera????o, Dados Inv??lidos!");
            $this->redirect(null, array("action" => "index"), true);
        }

        $form = new \Rh\Form\OrgaoForm();

        if (!empty($result["data"])) {
            $result = $result["data"];


            $dados_form = array();
            $dados_form["id"] = $result["id"];
            $dados_form["codigo"] = $result["codigo"];
            $dados_form["descricao"] = $result["descricao"];
            $dados_form["portaria"] = $result["portaria"];
            $dados_form["gestao_ingresso"] = $result["gestao_ingresso"];
            $dados_form["id_orgao_superior"] = $result["orgaoSuperior"]['id'];


            $form->setData($dados_form);
        }


        $request = $this->getRequest();

        if ($request->isPost()) {

            $post = $request->getPost();

            if (!isset($post["id_orgao_superior"]) || $post["id_orgao_superior"] == "") {
                $post["id_orgao_superior"] = 0;
            }

            $form->setData($post);


            if ($form->isValid()) {

                $dados = $form->getData();

                $dados['dominio'] = "Orgao";

                if ($dados['gestao_ingresso'] == 'N') {
                    $xml = $app->salvar(\Marabaixo\Util::array_to_xml($dados));
                } else {

                    $xml = $app->salvarOrgao(\Marabaixo\Util::array_to_xml($dados));
                }
                $result = \Marabaixo\Util::xml_to_array($xml);
                $errors = $this->showMessages($result);

                if (!$errors) {
                    $this->flashMessenger()->addSuccessMessage("Opera????o Efetuada com Sucesso!");
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
            $this->flashMessenger()->addErrorMessage("Falha ao Executar Opera????o, Dados Inv??lidos!");
            $this->redirect(null, array("action" => "index"), true);
        }

        $app = $this->getServiceLocator()->get("AplicacaoFachada");
        $xml = $app->excluir(\Marabaixo\Util::array_to_xml(array("id" => $id, "dominio" => "Orgao")));

        $result = \Marabaixo\Util::xml_to_array($xml);

        $errors = $this->showMessages($result);

        if (!$errors) {
            $this->flashMessenger()->addSuccessMessage("Opera????o Efetuada com Sucesso!");
        }

        $this->redirect(null, array("action" => "index"), true);

        return $view;
    }

    public function selecionarAction() {
        try {

            $id = $this->params("id");

            $app = $this->getServiceLocator()->get("AplicacaoFachada");
            $xml = $app->selecionarOrgao(\Marabaixo\Util::array_to_xml(array("id" => $id)));

            $result = \Marabaixo\Util::xml_to_array($xml);

            $errors = $this->showMessages($result);

            if ($errors) {
                $this->redirect(null, array("controller" => "index", "action" => "index"), true);
            }

            if (!isset($result["data"]["tostring"])) {
                throw new \Exception("Falha ao Executar Opera????o, Dados Inv??lidos!");
            }

            $regiao = $result["data"];

            $this->flashMessenger()->addSuccessMessage("Org??o: {$orgao["tostring"]} Selecionada!");
        } catch (\Exception $ex) {
            $this->flashMessenger()->addErrorMessage($ex->getMessage());
        }

        $this->redirect(null, array("controller" => "index", "action" => "index"), true);
    }

}
