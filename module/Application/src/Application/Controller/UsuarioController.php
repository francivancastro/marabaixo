<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;

class UsuarioController extends \Marabaixo\Controller\AcessoController {

    public function indexAction() {
        $session = new \Zend\Session\Container();
        if (isset($session->id_usuario)) {
            unset($session->id_usuario);
        }
        
        $view = new ViewModel();
        
        $app = $this->getServiceLocator()->get("AplicacaoFachada");
                
        $filtros = array("pesquisa_nome", "pesquisa_email", "pesquisa_cpf", "pesquisa_status", "page");

        $dados = \Marabaixo\Util::atualizaFiltros($filtros, $this);

        $view->setVariable("pesquisa_dados", $dados);
        
        $xml = $app->listarUsuarioPorPagina(\Marabaixo\Util::array_to_xml($dados));
        
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
            $xml = $app->getInfoUsuario(\Marabaixo\Util::array_to_xml(array("id" => $id)));
            
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
    
    public function listarporpaginaAction() {
        try {
            $dados = array();
            
            $request = $this->getRequest();
            $response = $this->getResponse();

            $filtros = array("pesquisa_nome", "pesquisa_email", "page");
            $pesquisa_dados = \Marabaixo\Util::atualizaFiltros($filtros, $this);
            
            $app = $this->getServiceLocator()->get("AplicacaoFachada");
            $xml = $app->listarUsuarioPorPagina(\Marabaixo\Util::array_to_xml($pesquisa_dados));

            $result = \Marabaixo\Util::xml_to_array($xml);

            if (isset($result["data"]) && !empty($result["data"])) {
                $dados = $result["data"];
            }
        } catch (\Exception $ex) {
            $dados["errors"] = $ex->getMessage();
        }
        
        $response->setContent(\Zend\Json\Json::encode($dados));
        
        return $response;
    }
    
    public function editarAction() {
        $view = new ViewModel();
        
        $id = $this->params("id");
        
        $app = $this->getServiceLocator()->get("AplicacaoFachada");
        $xml = $app->getInfoUsuario(\Marabaixo\Util::array_to_xml(array("id" => $id)));

        $result = \Marabaixo\Util::xml_to_array($xml);

        $errors = $this->showMessages($result);

        if (!$errors) {
            if (isset($result["data"])) {
                
                $form = new \Application\Form\UsuarioForm();
                
                if (!empty($result["data"])) {
                    $result = $result["data"];

                    $dados_form = array();
                    $dados_form["id_usuario"] = $result["id"];
                    $dados_form["id_pessoa_fisica"] = $result["pessoa_fisica"]["id"];

                    $form->setData($dados_form);
                }
                
                $request = $this->getRequest();
                if ($request->isPost()) {
                    $post = $request->getPost();
                    
                    $form->setData($post);

                    if ($form->isValid()) {
                        $dados = $form->getData();
                        
                        $xml = $app->salvarUsuario(\Marabaixo\Util::array_to_xml($dados));
                        
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
            $xml = $app->excluirUsuario(\Marabaixo\Util::array_to_xml(array("id" => $id)));
            
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
    
    public function senhaAction() {
        $id = $this->params("id");
        if ($id) {
            $app = $this->getServiceLocator()->get("AplicacaoFachada");
            
            $xml = $app->recuperaSenha(\Marabaixo\Util::array_to_xml(array("id" => $id)));
            if (!$xml) {
                $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!!");
                $this->redirect(null, array("controller" => "auth", "action" => "index"));
            }
            $result = \Marabaixo\Util::xml_to_array($xml);

            $errors = $this->showMessages($result);
            if (!$errors) {
                $this->flashMessenger()->addSuccessMessage("Um E-mail será Enviado para Você com as Orientações para Alteração de Senha!");
            }
        } else {
            $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!");
        }
        $this->redirect(null, array("controller" => "usuario", "action" => "index"));
    }
    
    public function grupoAction() {
        $view = new ViewModel();
        
        $id = $this->params("id");
        if ($id) {
            $app = $this->getServiceLocator()->get("AplicacaoFachada");
            
            $xml = $app->getInfoUsuario(\Marabaixo\Util::array_to_xml(array("id" => $id)));
            if (!$xml) {
                $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!!");
                $this->redirect(null, array("controller" => "usuario", "action" => "index"));
            }
            $result = \Marabaixo\Util::xml_to_array($xml);

            $errors = $this->showMessages($result);
            if ($errors) {
                $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!");
                $this->redirect(null, array("controller" => "usuario", "action" => "index"));
            }
            if (!(isset($result["data"]) && $result["data"])) {
                $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!");
                $this->redirect(null, array("controller" => "usuario", "action" => "index"));
            }
            $usuario = $result["data"];
            $view->setVariable("usuario", $usuario);
            
            $xml = $app->listarGrupos();
            if (!$xml) {
                $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!!");
                $this->redirect(null, array("controller" => "usuario", "action" => "index"));
            }
            $result = \Marabaixo\Util::xml_to_array($xml);
            
            if (!(isset($result["data"]) & $result["data"])) {
                $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Nenhum Grupo Encontrado!!");
                $this->redirect(null, array("controller" => "usuario", "action" => "index"));
            }
            
            $grupos = $result["data"];
            
            $view->setVariable("grupos", $grupos);
            
            $request = $this->getRequest();
            if ($request->isPost()) {
                $dados = $request->getPost()->toArray();
                
                $xml = $app->vincularUsuarioGrupo(\Marabaixo\Util::array_to_xml($dados));
                if (!$xml) {
                    $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!!");
                    $this->redirect(null, array("controller" => "usuario", "action" => "index"));
                }
                $result = \Marabaixo\Util::xml_to_array($xml);
                
                $errors = $this->showMessages($result);
                
                if (!$errors) {
                    $this->flashMessenger()->addSuccessMessage("Operação Efetuada com Sucesso!");
                    $this->redirect(null, array("controller" => "usuario", "action" => "index"));
                }
                
            }

            $botoes = $this->getServiceLocator()->get("button");
            $botoes->setController($this);
            $botoes->addScript(array("titulo" => "Salvar",
                                     "icone" => "fa-save",
                                     "url" => "salvar()"));
            $botoes->addAction(array("titulo" => "Voltar",
                                     "icone" => "fa-reply",
                                     "url" => $this->url()->fromRoute(null, array("action" => "index", "id" => "0"), true)));            
        } else {
            $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!");
            $this->redirect(null, array("controller" => "usuario", "action" => "index"));
        }
        
        return $view;
    }
}
