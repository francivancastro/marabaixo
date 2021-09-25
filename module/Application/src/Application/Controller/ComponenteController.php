<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;

class ComponenteController extends \Marabaixo\Controller\AcessoController {
    
    public function indexAction() {
        $session = new \Zend\Session\Container();
        if (isset($session->id_componente)) {
            unset($session->id_componente);
        }
        $view = new ViewModel();
        
        $app = $this->getServiceLocator()->get("AplicacaoFachada");
                
        $filtros = array("pesquisa_descricao", "page");

        $dados = \Marabaixo\Util::atualizaFiltros($filtros, $this);

        $view->setVariable("pesquisa_dados", $dados);
        
        $xml = $app->listarComponentesPorPagina(\Marabaixo\Util::array_to_xml($dados));
        
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
            $xml = $app->getInfoComponente(\Marabaixo\Util::array_to_xml(array("id" => $id)));
            
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
        $xml = $app->getInfoComponente(\Marabaixo\Util::array_to_xml(array("id" => $id)));

        $result = \Marabaixo\Util::xml_to_array($xml);

        $errors = $this->showMessages($result);

        if (!$errors) {
            if (isset($result["data"])) {
                
                $form = new \Application\Form\ComponenteForm();
                
                $xml = $app->pegaUltimaOrdemComponente();
                $array = \Marabaixo\Util::xml_to_array($xml);
                if (isset($array["data"]) && !empty($array["data"])) {
                    $ordem = 1;
                    if (isset($array["data"]["ordem"]) && $array["data"]["ordem"]) {
                        $ordem = $array["data"]["ordem"];
                    }
                    $ordem++;
                    
                    $items = array();
                    for ($o = 1; $o <= $ordem; $o++) {
                        $items[$o] = $o;
                    }
                    $fe = $form->get("ordem");
                    $fe->setValueOptions($items);
                }

                $dados_form = array();
                if (!empty($result["data"])) {
                    $result = $result["data"];

                    $dados_form["id_componente"] = $result["id"];
                    $dados_form["descricao"] = $result["descricao"];
                    $dados_form["icone"] = $result["icone"];
                    $dados_form["ordem"] = $result["ordem"];
                }
                if (!isset($dados_form["ordem"]) || !$dados_form["ordem"]) {
                    $dados_form["ordem"] = $ordem;
                }
                $form->setData($dados_form);
                
                $request = $this->getRequest();
                if ($request->isPost()) {
                    $post = $request->getPost();
                    
                    $form->setData($post);

                    if ($form->isValid()) {
                        $dados = $form->getData();
                        
                        $xml = $app->salvarComponente(\Marabaixo\Util::array_to_xml($dados));
                        
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
            $xml = $app->excluirComponente(\Marabaixo\Util::array_to_xml(array("id" => $id)));
            
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
    
    public function controllerAction() {
        $session = new \Zend\Session\Container();
        
        $view = new ViewModel();
        
        $id = 0;
        
        if (isset($session->id_componente)) {
            $id = $session->id_componente;
        } else {
            $id = $this->params("id");
        }
        if ($id) {
            $session->id_componente = $id;
            
            $app = $this->getServiceLocator()->get("AplicacaoFachada");
            $xml = $app->getInfoComponente(\Marabaixo\Util::array_to_xml(array("id" => $id)));
            
            $result = \Marabaixo\Util::xml_to_array($xml);

            $errors = $this->showMessages($result);

            if (!$errors) {
                if (isset($result["data"]) && !empty($result["data"])) {
                    $view->setVariable("componente", $result["data"]);
                    
                    $xml = $app->listarControllers();
                    $result = \Marabaixo\Util::xml_to_array($xml);
                    
                    if (isset($result["data"]) && !empty($result["data"])) {
                        $controllers = $result["data"];
                        if (!empty($controllers)) {
                            $view->setVariable("controllers", $controllers);
                            
                            $request = $this->getRequest();
                            if ($request->isPost()) {
                                $post = $request->getPost();
                                $dados = $post->toArray();
                                
                                $xml = $app->vincularControllers(\Marabaixo\Util::array_to_xml($dados));
                                
                                $result = \Marabaixo\Util::xml_to_array($xml);
                                
                                $errors = $this->showMessages($result);
                                
                                if (!$errors) {
                                    if (isset($result["data"]) && !empty($result["data"])) {
                                        $view->setVariable("componente", $result["data"]);
                                    }
                                    $this->flashMessenger()->addSuccessMessage("Operação Efetuada com Sucesso!");
                                } 
                            }

                            $botoes = $this->getServiceLocator()->get("button");
                            $botoes->setController($this);
                            $botoes->addScript(array("titulo" => "Salvar",
                                                     "icone" => "fa-save",
                                                     "url" => "salvarFormulario('formulario')"));
                            $botoes->addAction(array("titulo" => "Voltar",
                                                     "icone" => "fa-reply",
                                                     "url" => $this->url()->fromRoute(null, array("controller" => $this->getControllerName(), 
                                                                                                  "action" => "index",
                                                                                                  "id" => "0"))));
        
                        } else {
                            $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Nenhum Controller Cadastrado!");
                            $this->redirect(null, array("action" => "index"), true);
                        }
                    }
                } else {
                    $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!");
                    $this->redirect(null, array("action" => "index"), true);
                }
            }
        } else {
            $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!");
            $this->redirect(null, array("action" => "index"), true);
        }
        
        return $view;
    }
}
