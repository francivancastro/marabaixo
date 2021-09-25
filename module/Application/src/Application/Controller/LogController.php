<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;

class LogController extends \Marabaixo\Controller\AcessoController {
    
    public function indexAction() {
        
        $view = new ViewModel();
        
        $sl = $this->getServiceLocator();
        $app = $sl->get("AplicacaoFachada");
                
        $filtros = array("page", "filtro_id_log_tipo", "filtro_data_inicial", "filtro_data_final", "filtro_cpf", "filtro_nome", "filtro_email", "filtro_id_log_bd_tipo", "filtro_schema", "filtro_tabela", "filtro_identificador");

        $dados = \Marabaixo\Util::atualizaFiltros($filtros, $this);
        $dados["dominio"] = "Log";

        $view->setVariable("pesquisa_dados", $dados);
        
        $result = $app->listarPorPagina($dados);
        
        $this->showMessages($result);
        
        if (isset($result["data"])) {
            $view->setVariable("result", $result["data"]);
        }
        
        $result = $app->listar(array("dominio" => "LogTipo"));
        $objs = false;
        if (isset($result["data"])) {
            $objs = $result["data"];
        }
        if (empty($objs)) {
            throw new \Exception("Falha ao Executar Operação, Nenhum Tipo de Log Cadastrado!");
        }
        $view->setVariable("log_tipos", $objs);

        $result = $app->listar(array("dominio" => "LogBdTipo"));
        $objs = false;
        if (isset($result["data"])) {
            $objs = $result["data"];
        }
        if (empty($objs)) {
            throw new \Exception("Falha ao Executar Operação, Nenhum Tipo de Log de Banco de Dados Cadastrado!");
        }
        $view->setVariable("log_bd_tipos", $objs);
        
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
        
        if (!$id) {
            $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!");
            $this->redirect(null, array("action" => "index"), true);            
        }
        
        $app = $this->getServiceLocator()->get("AplicacaoFachada");
        $result = $app->getInfo(array("id" => $id, "dominio" => "Log"));

        $errors = $this->showMessages($result);

        if ($errors) {
            $this->redirect(null, array("action" => "index"), true);
        }
        
        if (!(isset($result["data"]) && !empty($result["data"]))) {
            $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!");
            $this->redirect(null, array("action" => "index"), true);
        }
        
        $view->setVariable("result", $result["data"]);

        $botoes = $this->getServiceLocator()->get("button");
        $botoes->setController($this);
        $botoes->addAction(array("titulo" => "Voltar",
                                 "icone" => "fa-reply",
                                 "url" => $this->url()->fromRoute(null, array("action" => "index", "id" => "0"), true)));
        
        return $view;
    }
}
