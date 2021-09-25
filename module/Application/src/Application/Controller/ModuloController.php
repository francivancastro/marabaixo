<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;

class ModuloController extends \Marabaixo\Controller\AcessoController {
    
    public function indexAction() {
        $session = new \Zend\Session\Container();
        if (isset($session->id_controller)) {
            unset($session->id_controller);
        }
        
        $view = new ViewModel();
        
        $app = $this->getServiceLocator()->get("AplicacaoFachada");
                
        $filtros = array("pesquisa_controller", "pesquisa_descricao", "page");

        $dados = \Marabaixo\Util::atualizaFiltros($filtros, $this);

        $view->setVariable("pesquisa_dados", $dados);
        
        $xml = $app->listarControllersPorPagina(\Marabaixo\Util::array_to_xml($dados));
        
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
            $xml = $app->getInfoController(\Marabaixo\Util::array_to_xml(array("id" => $id)));
            
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
        $xml = $app->getInfoController(\Marabaixo\Util::array_to_xml(array("id" => $id)));

        $result = \Marabaixo\Util::xml_to_array($xml);

        $errors = $this->showMessages($result);

        if (!$errors) {
            if (isset($result["data"])) {
                
                $form = new \Application\Form\ModuloForm();
                $xml = $app->listarComponentes();
                $array = \Marabaixo\Util::xml_to_array($xml);
                if (isset($array["data"]) && !empty($array["data"])) {
                    $comps = $array["data"];
                    $items = array();
                    foreach ($comps as $comp) {
                        $items[$comp["id"]] = $comp["tostring"];
                    }
                    $fe = $form->get("id_componente");
                    $fe->setValueOptions($items);
                }
                
                if (!empty($result["data"])) {
                    $result = $result["data"];

                    $dados_form = array();
                    $dados_form["id_controller"] = $result["id"];
                    $dados_form["descricao"] = $result["descricao"];
                    $dados_form["controller"] = $result["controller"];
                    $dados_form["id_componente"] = array();

                    if (isset($result["componentes"]) && !empty($result["componentes"])) {
                        foreach ($result["componentes"] as $comp) {
                            $dados_form["id_componente"][] = $comp["id"];
                        }
                    }

                    $form->setData($dados_form);
                }
                
                $request = $this->getRequest();
                if ($request->isPost()) {
                    $post = $request->getPost();
                    
                    $form->setData($post);

                    if ($form->isValid()) {
                        $dados = $form->getData();
                        
                        $xml = $app->salvarController(\Marabaixo\Util::array_to_xml($dados));
                        
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
            $xml = $app->excluirController(\Marabaixo\Util::array_to_xml(array("id" => $id)));
            
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
    
    public function actionAction() {
        
        $id = 0;
        $session = new \Zend\Session\Container();
        if (isset($session->id_controller)) {
            $id = $session->id_controller;
        } else {
            $id = $this->params("id");
        }
        
        if ($id) {
            $session->id_controller = $id;
            
            $view = new ViewModel();

            $app = $this->getServiceLocator()->get("AplicacaoFachada");
            
            $xml = $app->getInfoController(\Marabaixo\Util::array_to_xml(array("id" => $id)));
            
            $result = \Marabaixo\Util::xml_to_array($xml);
            
            $errors = $this->showMessages($result);

            if (!$errors) {
                
                $controller = $result["data"];
                
                $view->setVariable("controller", $controller);
                
                $filtros = array("page");
                $dados = \Marabaixo\Util::atualizaFiltros($filtros, $this);
                $dados["id_controller"] = $controller["id"];

                $xml = $app->listarControllerActionsPorPagina(\Marabaixo\Util::array_to_xml($dados));

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
                                                                                      "action" => "editaraction",
                                                                                      "id" => "0"))));
                $botoes->addAction(array("titulo" => "Voltar",
                                         "icone" => "fa-reply",
                                         "url" => $this->url()->fromRoute(null, array("controller" => $this->getControllerName(), 
                                                                                      "action" => "index",
                                                                                      "id" => "0"))));
            } else {
                $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!");
                $this->redirect(null, array("action" => "index"), true);
            }
        } else {
            $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!");
            $this->redirect(null, array("action" => "index"), true);
        }
        
        return $view;
    }
    
    public function viewactionAction() {
        $view = new ViewModel();
        
        $id = $this->params("id");
        
        if ($id) {
            $app = $this->getServiceLocator()->get("AplicacaoFachada");
            $xml = $app->getInfoControllerAction(\Marabaixo\Util::array_to_xml(array("id" => $id)));
            
            $result = \Marabaixo\Util::xml_to_array($xml);

            $errors = $this->showMessages($result);

            if (!$errors) {
                if (isset($result["data"]) && !empty($result["data"])) {
                    $view->setVariable("result", $result["data"]);
                    
                    $botoes = $this->getServiceLocator()->get("button");
                    $botoes->setController($this);
                    $botoes->addAction(array("titulo" => "Voltar",
                                             "icone" => "fa-reply",
                                             "url" => $this->url()->fromRoute(null, array("action" => "action", "id" => "0"), true)));
                    
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
    
    public function editaractionAction() {
        $id = 0;
        $session = new \Zend\Session\Container();
        if (isset($session->id_controller)) {
            $id = $session->id_controller;
        }
        if ($id) {
            $app = $this->getServiceLocator()->get("AplicacaoFachada");
            $view = new ViewModel();
            
            $xml = $app->getInfoController(\Marabaixo\Util::array_to_xml(array("id" => $id)));
            $result = \Marabaixo\Util::xml_to_array($xml);
            
            $errors = $this->showMessages($result);

            if ($errors) {
                $this->redirect(null, array("action" => "action"), true);
            }
                
            if (!isset($result["data"])) {
                $this->flashMessenger()->addErrorMessage("Falha ao Executar Operaçao, Dados Invalidos!");
                $this->redirect(null, array("action" => "action"), true);
            }
            
            $controller = $result["data"];
            $view->setVariable("controller", $controller);

            $id = $this->params("id");

            $xml = $app->getInfoControllerAction(\Marabaixo\Util::array_to_xml(array("id" => $id)));

            $result = \Marabaixo\Util::xml_to_array($xml);

            $errors = $this->showMessages($result);

            if (!$errors) {
                if (isset($result["data"])) {

                    $form = new \Application\Form\ControllerActionForm();

                    $dados_form = array();
                    $dados_form["id_controller"] = $controller["id"];
                    if (!empty($result["data"])) {
                        $result = $result["data"];

                        $dados_form["id_controller_action"] = $result["id"];
                        $dados_form["descricao"] = $result["descricao"];
                        $dados_form["action"] = $result["action"];
                        
                    }
                    
                    $form->setData($dados_form);

                    $request = $this->getRequest();
                    if ($request->isPost()) {
                        $post = $request->getPost();

                        $form->setData($post);

                        if ($form->isValid()) {
                            $dados = $form->getData();

                            $xml = $app->salvarControllerAction(\Marabaixo\Util::array_to_xml($dados));

                            $result = \Marabaixo\Util::xml_to_array($xml);

                            $errors = $this->showMessages($result);

                            if (!$errors) {
                                $this->flashMessenger()->addSuccessMessage("Operação Efetuada com Sucesso!");
                                $this->redirect(null, array("action" => "action"), true);
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
                                             "url" => $this->url()->fromRoute(null, array("action" => "action", "id" => "0"), true)));

                } else {
                    $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!");
                    $this->redirect(null, array("action" => "action"), true);
                }
            } else {
                $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!");
                $this->redirect(null, array("action" => "action"), true);
            }
        }
        
        return $view;
    }
    
    public function excluiractionAction() {
        $view = new ViewModel();
        
        $id = $this->params("id");
        
        if ($id) {
            $app = $this->getServiceLocator()->get("AplicacaoFachada");
            $xml = $app->excluirControllerAction(\Marabaixo\Util::array_to_xml(array("id" => $id)));
            
            $result = \Marabaixo\Util::xml_to_array($xml);

            $errors = $this->showMessages($result);

            if (!$errors) {
                $this->flashMessenger()->addSuccessMessage("Operação Efetuada com Sucesso!");
            }
        } else {
            $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!");
        }
        $this->redirect(null, array("action" => "action"), true);
        
        return $view;
    }
    
    public function listarAction() {
        $request = $this->getRequest();
        $response = $this->getResponse();
        
        $id = 0;
        
        if ($request->isPost()) {
            $id = $request->getPost()->get("id_controller");
        }
        
        $dados = false;
        
        if ($id) {
            $app = $this->getServiceLocator()->get("AplicacaoFachada");
            $xml = $app->listarControllerAction(\Marabaixo\Util::array_to_xml(array("id_controller" => $id)));

            $result = \Marabaixo\Util::xml_to_array($xml);

            if (isset($result["data"]) && !empty($result["data"])) {
                $dados = $result["data"];
            }
        }
        $response->setContent(\Zend\Json\Json::encode($dados));
        
        return $response;
    }
}
