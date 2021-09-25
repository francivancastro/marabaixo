<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;

class GrupoController extends \Marabaixo\Controller\AcessoController {
    
    public function indexAction() {
        $session = new \Zend\Session\Container();
        if (isset($session->id_grupo)) {
            unset($session->id_grupo);
        }
        
        $view = new ViewModel();
        
        $app = $this->getServiceLocator()->get("AplicacaoFachada");
                
        $filtros = array("pesquisa_chave", "pesquisa_descricao", "page");

        $dados = \Marabaixo\Util::atualizaFiltros($filtros, $this);

        $view->setVariable("pesquisa_dados", $dados);
        
        $xml = $app->listarGruposPorPagina(\Marabaixo\Util::array_to_xml($dados));
        
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
            $xml = $app->getInfoGrupo(\Marabaixo\Util::array_to_xml(array("id" => $id)));
            
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
        $xml = $app->getInfoGrupo(\Marabaixo\Util::array_to_xml(array("id" => $id)));

        $result = \Marabaixo\Util::xml_to_array($xml);

        $errors = $this->showMessages($result);

        if (!$errors) {
            if (isset($result["data"])) {
                
                $form = new \Application\Form\GrupoForm();

                $dados_form = array();
                
                if (!empty($result["data"])) {
                    $result = $result["data"];

                    $dados_form["id_grupo"] = $result["id"];
                    $dados_form["descricao"] = $result["descricao"];
                    $dados_form["chave"] = $result["chave"];
                    $dados_form["admin"] = $result["administrador"]["chave"];
                    $dados_form["status"] = $result["status"]["chave"];
                }
                $form->setData($dados_form);
                
                $request = $this->getRequest();
                if ($request->isPost()) {
                    $post = $request->getPost();
                    
                    $form->setData($post);

                    if ($form->isValid()) {
                        $dados = $form->getData();
                        
                        $xml = $app->salvarGrupo(\Marabaixo\Util::array_to_xml($dados));
                        
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
            $xml = $app->excluirGrupo(\Marabaixo\Util::array_to_xml(array("id" => $id)));
            
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
    
    public function permissaoAction() {
        $view = new ViewModel();
        
        $session = new \Zend\Session\Container();
        
        $app = $this->getServiceLocator()->get("AplicacaoFachada");
        
        $id = 0;
        if (isset($session->id_grupo)) {
            $id = $session->id_grupo;
        } else {
            $id = $this->params("id");
        }
        
        if ($id) {
            
            $xml = $app->getInfoGrupo(\Marabaixo\Util::array_to_xml(array("id" => $id)));

            $result = \Marabaixo\Util::xml_to_array($xml);

            $errors = $this->showMessages($result);

            if (!$errors) {
                if (isset($result["data"]) && !empty($result["data"])) {
                    
                    $session->id_grupo = $id;
                    
                    $filtros = array("pesquisa_descricao", "page");
                    $dados = \Marabaixo\Util::atualizaFiltros($filtros, $this);
                    $view->setVariable("pesquisa_dados", $dados);
                    $xml = $app->listarControllersPorPagina(\Marabaixo\Util::array_to_xml($dados));
                    $result_modulo = \Marabaixo\Util::xml_to_array($xml);
                    
                    if (!isset($result_modulo["data"]) || empty($result_modulo["data"])) {
                        $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!");
                        $this->redirect(null, array("action" => "index"), true);
                    }
                    
                    $modulos = $result_modulo["data"];
                    $view->setVariable("modulos", $modulos);
                  
                    $dados = $result["data"];
                    $view->setVariable("grupo", $dados);
                    
                    $botoes = $this->getServiceLocator()->get("button");
                    $botoes->setController($this);
                    $botoes->addScript(array("titulo" => "Pesquisar",
                                             "icone" => "fa-search",
                                             "url" => "pesquisar()"));
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
        }
        
        return $view;
    }
    
    public function salvarpermissaoAction() {
        $dados = array();
        
        $request = $this->getRequest();
        $response = $this->getResponse();
        
        try {
            $id_grupo = 0;
            $id_controller_action = array();
            
            if ($request->isPost()) {
                $dados = $request->getPost()->toArray();
                $app = $this->getServiceLocator()->get("AplicacaoFachada");
                $xml = $app->atribuirPermissao(\Marabaixo\Util::array_to_xml($dados));
                $dados = \Marabaixo\Util::xml_to_array($xml);
            } else {
                throw new \Exception("Falha ao Executar Operação, Dados Inválidos!!");
            }
        } catch (\Exception $ex) {
            $dados["errors"] = array($ex->getMessage());
        }
        $response->setContent(\Zend\Json\Json::encode($dados));
        
        return $response;
    }
    
    public function usuarioAction() {
        $id = 0;
        $session = new \Zend\Session\Container();
        $view = new ViewModel();
        
        if (isset($session->id_grupo)) {
            $id = $session->id_grupo;
        } else {
            $id = $this->params("id");
        }
        
        if ($id) {
            
            $session->id_grupo = $id;
            
            $app = $this->getServiceLocator()->get("AplicacaoFachada");
            
            $xml = $app->getInfoGrupo(\Marabaixo\Util::array_to_xml(array("id" => $id)));
            $result = \Marabaixo\Util::xml_to_array($xml);
            
            $errors = $this->showMessages($result);
            
            if ($errors) {
                $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!");
                $this->redirect(null, array("action" => "index"), true);
            }
            
            if (!isset($result["data"]) || empty($result["data"])) {
                $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!!");
                $this->redirect(null, array("action" => "index"), true);
            }
            
            $view->setVariable("grupo", $result["data"]);
            
            $filtros = array("pesquisa_nome", "pesquisa_email", "page");
            $filtro_dados = \Marabaixo\Util::atualizaFiltros($filtros, $this);
            $filtro_dados["id_grupo"] = $id;
            
            $view->setVariable("pesquisa_dados", $filtro_dados);
            
            $xml = $app->listarUsuarioPorPagina(\Marabaixo\Util::array_to_xml($filtro_dados));
            $result = \Marabaixo\Util::xml_to_array($xml);
            
            $errors = $this->showMessages($result);
            
            if ($errors) {
                $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!!!");
                $this->redirect(null, array("action" => "index"), true);
            }
            
            if (!isset($result["data"]) || empty($result["data"])) {
                $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!!!!");
                $this->redirect(null, array("action" => "index"), true);
            }
            
            $view->setVariable("result", $result["data"]);
            
            $botoes = $this->getServiceLocator()->get("button");
            $botoes->setController($this);
            $botoes->addScript(array("titulo" => "Adicionar",
                                     "icone" => "fa-plus-circle",
                                     "url" => "addusuario()"));
            $botoes->addScript(array("titulo" => "Pesquisar",
                                     "icone" => "fa-search",
                                     "url" => "pesquisar()"));
            $botoes->addAction(array("titulo" => "Voltar",
                                     "icone" => "fa-reply",
                                     "url" => $this->url()->fromRoute(null, array("controller" => $this->getControllerName(), 
                                                                                  "action" => "index",
                                                                                  "id" => "0"))));            
        } else {
            $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!!!!!!");
            $this->redirect(null, array("action" => "index"), true);
        }
        
        return $view;
    }
    
    public function vincularusuarioAction() {
        $session = new \Zend\Session\Container();
        $id_grupo = 0;
        if (isset($session->id_grupo)) {
            $id_grupo = $session->id_grupo;
        }
        if (!$id_grupo) {
            $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!");
            $this->redirect(null, array("action" => "usuario"), true);
        }
        $id = $this->params("id");
        if (!$id) {
            $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!!");
            $this->redirect(null, array("action" => "usuario"), true);
        }
        
        $app = $this->getServiceLocator()->get("AplicacaoFachada");
        
        $xml = $app->vincularGrupoUsuario(\Marabaixo\Util::array_to_xml(array("id_grupo" => $id_grupo, "id_usuario" => $id)));
        $result = \Marabaixo\Util::xml_to_array($xml);
        $errors = $this->showMessages($result);
        
        if (!$errors) {
            $this->flashMessenger()->addSuccessMessage("Operação Efetuada com Sucesso!");
        }
        
        $this->redirect(null, array("action" => "usuario"), true);;
    }
    
    public function removerusuarioAction() {
        $session = new \Zend\Session\Container();
        $id_grupo = 0;
        if (isset($session->id_grupo)) {
            $id_grupo = $session->id_grupo;
        }
        if (!$id_grupo) {
            $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!");
            $this->redirect(null, array("action" => "usuario"), true);
        }
        $id = $this->params("id");
        if (!$id) {
            $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!!");
            $this->redirect(null, array("action" => "usuario"), true);
        }
        
        $app = $this->getServiceLocator()->get("AplicacaoFachada");
        
        $xml = $app->removerGrupoUsuario(\Marabaixo\Util::array_to_xml(array("id_grupo" => $id_grupo, "id_usuario" => $id)));
        $result = \Marabaixo\Util::xml_to_array($xml);
        $errors = $this->showMessages($result);
        
        if (!$errors) {
            $this->flashMessenger()->addSuccessMessage("Operação Efetuada com Sucesso!");
        }
        
        $this->redirect(null, array("action" => "usuario"), true);;
    }
}
