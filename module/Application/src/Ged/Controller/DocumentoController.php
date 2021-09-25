<?php

namespace Ged\Controller;

use Zend\View\Model\ViewModel;

class DocumentoController extends \Marabaixo\Controller\AcessoController {

    public function indexAction() {

        $session = new \Zend\Session\Container();
        if (isset($session->id_documento)) {
            unset($session->id_documento);
        }
        if (isset($session->id_documento_tipo)) {
            unset($session->id_documento_tipo);
        }

        $view = new ViewModel();

        $sl = $this->getServiceLocator();
        $app = $sl->get("AplicacaoFachada");

        try {

            //tipo de documento
            $result = $app->listar(array("dominio" => "DocumentoTipo"));
            if (!(isset($result["data"]) && !empty($result["data"]))) {
                throw new \Exception("Falha ao Executar Operação, Nenhum Tipo de Documento Disponível!");
            }
            $result_dt = $result["data"];
            $view->setVariable("dts", $result_dt);

            //tipo de listagem
            $filtros = array("id_dt");
            $dados = \Marabaixo\Util::atualizaFiltros($filtros, $this);
            $id_dt = $dados["id_dt"];
            $view->setVariable("id_dt", $id_dt);

            //listagem
            $return = $app->listarDocListagem(array("filtro_id_documento_tipo" => $id_dt));
            if (!(isset($return["data"]) && !empty($return["data"]))) {
                throw new \Exception("Falha ao Executar Operação, Nenhum Campo Disponível!");
            }
            $return_dc = $return["data"];
            $view->setVariable("campos", $return_dc);

            //filtro
            $return_filtro = array();
            $return = $app->listarDocFiltro(array("filtro_id_documento_tipo" => $id_dt));
            if (isset($return["data"]) && !empty($return["data"])) {
                $return_filtro = $return["data"];
                $view->setVariable("filtros", $return_filtro);
            }

            $filtros = array("page");
            $filtros[] = "pesquisa_usuario_nome";
            $filtros[] = "pesquisa_data_criacao_inicio";
            $filtros[] = "pesquisa_data_criacao_final";
            if (count($return_filtro)) {
                foreach ($return_filtro as $filtro) {
                    $filtros[] = "filtro_" . $filtro["nome"];
                }
            }

            $dados = \Marabaixo\Util::atualizaFiltros($filtros, $this);

            $view->setVariable("pesquisa_dados", $dados);

            $dados["dominio"] = "Documento";
            $dados["filtro_id_documento_tipo"] = $id_dt;

            $result = $app->listarPorPagina($dados);

            $this->showMessages($result);

            if (isset($result["data"])) {
                $view->setVariable("result", $result["data"]);
            }

            $botoes = $this->getServiceLocator()->get("button");
            $botoes->setController($this);
            if ($id_dt) {
                $session->id_documento_tipo = $id_dt;
                $botoes->addAction(array("titulo" => "Adicionar",
                    "icone" => "fa-plus-circle",
                    "url" => $this->url()->fromRoute(null, array("controller" => $this->getControllerName(),
                        "action" => "editar",
                        "id" => "0"))));
                $botoes->addScript(array("titulo" => "Pesquisar",
                    "icone" => "fa-search",
                    "url" => "pesquisar()"));
            }
            $botoes->addAction(array("titulo" => "Voltar",
                "icone" => "fa-reply",
                "url" => $this->url()->fromRoute(null, array("controller" => "index",
                    "action" => "index",
                    "id" => "0"))));

            return $view;
        } catch (\Exception $ex) {
            $this->flashMessenger()->addErrorMessage($ex->getMessage());
            $this->redirect(null, array("controller" => "index", "action" => "index"), true);
        }
    }

    public function viewAction() {
        $view = new ViewModel();

        try {

            $id = $this->params("id");

            if (!$id) {
                throw new \Exception("Falha ao Executar Operação, Nenhum Registro Localizado!");
            }

            $app = $this->getServiceLocator()->get("AplicacaoFachada");
            $result = $app->getInfo(array("id" => $id, "dominio" => "Documento"));

            $errors = $this->showMessages($result);

            if ($errors) {
                $this->redirect(null, array("action" => "index"), true);
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
        } catch (\Exception $ex) {
            $this->flashMessenger()->addErrorMessage($ex->getMessage());
            $this->redirect(null, array("action" => "index"), true);
        }
    }

    public function editarAction() {
        $view = new ViewModel();
        try {

            //tipo de documento
            $id_dt = 0;
            $session = new \Zend\Session\Container();
            if (isset($session->id_documento_tipo) && $session->id_documento_tipo) {
                $id_dt = $session->id_documento_tipo;
            }
            if (!$id_dt) {
                throw new \Exception("Falha ao Executar Operação, Tipo de Documento Não Informado!");
            }

            $app = $this->getServiceLocator()->get("AplicacaoFachada");
            $result = $app->getInfo(array("id" => $id_dt, "dominio" => "DocumentoTipo"));
            $errors = $this->showMessages($result);
            if ($errors) {
                $this->redirect(null, array("action" => "index"), true);
            }
            if (!isset($result["data"]) || empty($result["data"])) {
                throw new \Exception("Falha ao Executar Operação, Tipo de Documento Não Localizado!");
            }
            $documento_tipo = $result["data"];
            $view->setVariable("documento_tipo", $result["data"]);
            //fim tipo de documento
            //documento
            $id = $this->params("id");
            $result = $app->getInfo(array("id" => $id, "dominio" => "Documento"));
            $errors = $this->showMessages($result);
            if ($errors) {
                $this->redirect(null, array("action" => "index"), true);
            }
            if (!isset($result["data"])) {
                $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!");
                $this->redirect(null, array("action" => "index"), true);
            }
            $doc = $result["data"];
            $view->setVariable("documento", $doc);
            //fim documento

            $arquivos = array();
            if (isset($doc["arquivos"]) && $doc["arquivos"]) {
                $arquivos = $doc["arquivos"];
            }

            $dados_doc = array();
            if (isset($doc["id"]) && $doc["id"]) {
                $dados_doc["id_documento"] = $doc["id"];
            }
            if (isset($documento_tipo["id"]) && $documento_tipo["id"]) {
                $dados_doc["id_documento_tipo"] = $documento_tipo["id"];
            }

            $request = $this->getRequest();
            if ($request->isPost()) {
                $post = $request->getPost();

                $dados_doc = array_merge($dados_doc, $post->toArray());
                $dados_doc["dominio"] = "Documento";

                $arquivos = array();
                if (isset($dados_doc["lista_id_arquivo"]) && count($dados_doc["lista_id_arquivo"])) {
                    foreach ($dados_doc["lista_id_arquivo"] as $id_arquivo) {
                        $result = $app->getInfo(array("id" => $id_arquivo, "dominio" => "Arquivo"));
                        if (isset($result["data"]) && $result["data"]) {
                            $arquivo_obj = $result["data"];
                            $arquivos[] = $arquivo_obj;
                        }
                    }
                }

                $result = $app->salvar($dados_doc);
                $errors = $this->showMessages($result);
                if (!$errors) {
                    $this->flashMessenger()->addSuccessMessage("Operação Efetuada com Sucesso!");
                    $this->redirect(null, array("action" => "index"), true);
                }
            }

            $result = $app->getDocumentoControles($dados_doc);
            $errors = $this->showMessages($result);
            if ($errors) {
                $this->redirect(null, array("action" => "index"), true);
            }
            if (!(isset($result["data"]["html"]) && $result["data"]["html"])) {
                throw new \Exception("Falha ao Executar Operação, Nenhum Controle Disponível!");
            }

            $view->setVariable("html_controls", $result["data"]["html"]);
            $view->setVariable("arquivos", $arquivos);

            $botoes = $this->getServiceLocator()->get("button");
            $botoes->setController($this);
            $botoes->addAction(array("titulo" => "Voltar",
                "icone" => "fa-reply",
                "url" => $this->url()->fromRoute(null, array("action" => "index", "id" => "0"), true)));

            return $view;
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


        $result = $app->excluir(array("id" => $id, "dominio" => "Documento"));

        $errors = $this->showMessages($result);

        if (!$errors) {
            $this->flashMessenger()->addSuccessMessage("Operação Efetuada com Sucesso!");
        }

        $this->redirect(null, array("action" => "index"), true);

        return $view;
    }

}
