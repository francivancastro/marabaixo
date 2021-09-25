<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;

class IconeController extends \Marabaixo\Controller\AcessoController {
    
    public function indexAction() {
        
        $view = new ViewModel();
        
        $app = $this->getServiceLocator()->get("AplicacaoFachada");
                
        $filtros = array("pesquisa_icone", "page");

        $dados = \Marabaixo\Util::atualizaFiltros($filtros, $this);

        $view->setVariable("pesquisa_dados", $dados);
        
        $xml = $app->listarIconePorPagina(\Marabaixo\Util::array_to_xml($dados));
        
        $result = \Marabaixo\Util::xml_to_array($xml);
        
        $this->showMessages($result);
        
        if (isset($result["data"])) {
            $view->setVariable("result", $result["data"]);
        }

        $botoes = $this->getServiceLocator()->get("button");
        $botoes->setController($this);
        $botoes->addScript(array("titulo" => "Importar",
                                 "icone" => "fa-download",
                                 "url" => "importar()"));        
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
            $xml = $app->getInfoIcone(\Marabaixo\Util::array_to_xml(array("id" => $id)));
            
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
        $xml = $app->getInfoIcone(\Marabaixo\Util::array_to_xml(array("id" => $id)));

        $result = \Marabaixo\Util::xml_to_array($xml);

        $errors = $this->showMessages($result);

        if (!$errors) {
            if (isset($result["data"])) {
                
                $form = new \Application\Form\IconeForm();

                if (!empty($result["data"])) {
                    $result = $result["data"];

                    $dados_form = array();
                    $dados_form["id_icone"] = $result["id"];
                    $dados_form["icone"] = $result["icone"];

                    $form->setData($dados_form);
                }
                
                $request = $this->getRequest();
                if ($request->isPost()) {
                    $post = $request->getPost();
                    
                    $form->setData($post);

                    if ($form->isValid()) {
                        $dados = $form->getData();
                        
                        $xml = $app->salvarIcone(\Marabaixo\Util::array_to_xml($dados));
                        
                        $result = \Marabaixo\Util::xml_to_array($xml);

                        $errors = $this->showMessages($result);

                        if (!$errors) {
                            $this->flashMessenger()->addSuccessMessage("Operação Efetuada com Sucesso!");
                            $this->redirect(null, array("action" => "index"), true);
                        }
                    } else {
                        $form->showErrorMessages($this);
                    }
                }
                
                $view->setVariable("form", $form);

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
        
        return $view;
    }
    
    public function excluirAction() {
        $view = new ViewModel();
        
        $id = $this->params("id");
        
        if ($id) {
            $app = $this->getServiceLocator()->get("AplicacaoFachada");
            $xml = $app->excluirIcone(\Marabaixo\Util::array_to_xml(array("id" => $id)));
            
            $result = \Marabaixo\Util::xml_to_array($xml);

            $errors = $this->showMessages($result);

            if (!$errors) {
                $this->flashMessenger()->addSuccessMessage("Operação Efetuada com Sucesso!");
            }
        } else {
            $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!");
        }
        $this->redirect(null, array("action" => "index"), true);
        
        return $view;
    }
    
    public function importarAction() {
        $request = $this->getRequest();
        
        $files = $request->getFiles("icone_arquivo");
        
        if (!isset($files["size"]) || !$files["size"]) {
            $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Nenhum Arquivo Importado!");
            $this->redirect(null, array("controller" => "icone", "action" => "index"));
        }
        
        $app = $this->getServiceLocator()->get("AplicacaoFachada");
        
        $xml = $app->importarIcones(\Marabaixo\Util::array_to_xml($files));
        $result = \Marabaixo\Util::xml_to_array($xml);
        
        $errors = $this->showMessages($result);
        if (!$errors) {
            if (isset($result["data"]["quantidade"]) && $result["data"]["quantidade"]) {
                $this->flashMessenger()->addSuccessMessage($result["data"]["quantidade"] . " Registro(s) Importado(s).");
            }
        }
        
        $this->redirect(null, array("action" => "index"), true);
    }
}
