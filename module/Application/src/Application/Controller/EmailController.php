<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;

class EmailController extends \Marabaixo\Controller\AcessoController {

    public function indexAction() {

        $view = new ViewModel();

        $sl = $this->getServiceLocator();
        $app = $sl->get("AplicacaoFachada");

        $filtros = array("page");

        $dados = \Marabaixo\Util::atualizaFiltros($filtros, $this);
        $dados["dominio"] = "SmtpMail";

        $view->setVariable("pesquisa_dados", $dados);

        $result = $app->listarPorPagina($dados);

        $this->showMessages($result);

        if (isset($result["data"])) {
            $view->setVariable("result", $result["data"]);
        }

        $botoes = $this->getServiceLocator()->get("button");
        $botoes->setController($this);
        $botoes->addAction(array("titulo" => "Voltar",
            "icone" => "fa-reply",
            "url" => $this->url()->fromRoute(null, array("controller" => "index",
                "action" => "index",
                "id" => "0"))));

        return $view;
    }

    public function viewAction() {
        $view = new ViewModel();
        try {
            $id = $this->params("id");

            if (!$id) {
                throw new \Exception("Falha ao Executar Operação, Dados Inválidos!");
            }
            $app = $this->getServiceLocator()->get("AplicacaoFachada");
            $result = $app->getInfo(array("id" => $id, "dominio" => "SmtpMail"));

            $errors = $this->showMessages($result);
            if ($errors) {
                throw new \UnderflowException("Erros");
            }

            if (!(isset($result["data"]) && !empty($result["data"]))) {
                throw new \Exception("Falha ao Executar Operação, Dados Inválidos!");
            }
            $view->setVariable("result", $result["data"]);

            $botoes = $this->getServiceLocator()->get("button");
            $botoes->setController($this);
            $botoes->addAction(array("titulo" => "Voltar",
                                    "icone" => "fa-reply",
                                    "url" => $this->url()->fromRoute(null, array("action" => "index", "id" => "0"), true)));

            return $view;
        } catch (\UnderflowException $ex) {
            $this->redirect(null, array("action" => "index"), true);
        } catch (\Exception $ex) {
            $this->flashMessenger()->addErrorMessage($ex->getMessage());
            $this->redirect(null, array("action" => "index"), true);
        }
    }

    public function excluirAction() {
        $view = new ViewModel();

        $id = $this->params("id");

        if (!$id) {
            $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!");
            $this->redirect(null, array("action" => "index"), true);
        }

        $app = $this->getServiceLocator()->get("AplicacaoFachada");
        $result = $app->excluir(array("id" => $id, "dominio" => "SmtpMail"));

        $errors = $this->showMessages($result);

        if (!$errors) {
            $this->flashMessenger()->addSuccessMessage("Operação Efetuada com Sucesso!");
        }

        $this->redirect(null, array("action" => "index"), true);

        return $view;
    }

    public function naoprocessadoAction() {
        $view = new ViewModel();

        $id = $this->params("id");

        if (!$id) {
            $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!");
            $this->redirect(null, array("action" => "index"), true);
        }

        $app = $this->getServiceLocator()->get("AplicacaoFachada");
        $result = $app->naoProcessado(array("id" => $id));

        $errors = $this->showMessages($result);

        if (!$errors) {
            $this->flashMessenger()->addSuccessMessage("Operação Efetuada com Sucesso!");
        }

        $this->redirect(null, array("action" => "index"), true);

        return $view;
    }

    public function enviarAction() {
        $view = new ViewModel();

        $id = $this->params("id");

        if (!$id) {
            $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!");
            $this->redirect(null, array("action" => "index"), true);
        }

        $app = $this->getServiceLocator()->get("AplicacaoFachada");
        $result = $app->enviarEmail(array("id" => $id));

        $errors = $this->showMessages($result);

        if (!$errors) {
            $this->flashMessenger()->addSuccessMessage("Operação Efetuada com Sucesso!");
        }

        $this->redirect(null, array("action" => "index"), true);

        return $view;
    }

}
