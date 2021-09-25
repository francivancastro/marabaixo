<?php

namespace Rh\Controller;

use Zend\View\Model\ViewModel;

class ServidorocorrenciaController extends \Marabaixo\Controller\AcessoController {

    public function indexAction() {

        $view = new ViewModel();

        $sl = $this->getServiceLocator();
        $app = $sl->get("AplicacaoFachada");

        $filtros = array("page", "filtro_data_ocorrencia", "filtro_nome", "filtro_matricula", "filtro_tipo_ocorrencia");

        $dados = \Marabaixo\Util::atualizaFiltros($filtros, $this);

        $view->setVariable("pesquisa_dados", $dados);

        $dados["dominio"] = "ServidorOcorrencia";
       
        $xml = $app->listarPorPagina(\Marabaixo\Util::array_to_xml($dados));

        $result = \Marabaixo\Util::xml_to_array($xml);
        
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
            $xml = $app->getInfo(\Marabaixo\Util::array_to_xml(array("id" => $id, "dominio" => "ServidorOcorrencia")));

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

}
