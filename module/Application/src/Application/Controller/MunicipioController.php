<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;

class MunicipioController extends \Marabaixo\Controller\AcessoController {
    
     public function indexAction() {
        
        $session = new \Zend\Session\Container();
        if (isset($session->id_municipio)) {
            unset($session->id_municipio);
        }
        
        $view = new ViewModel();
        
        $sl = $this->getServiceLocator();
        $app = $sl->get("AplicacaoFachada");
                
        $filtros = array("page", "filtro_descricao");

        $dados = \Marabaixo\Util::atualizaFiltros($filtros, $this);

        $view->setVariable("pesquisa_dados", $dados);
        
        $xml = $app->listarMunicipioPorPagina(\Marabaixo\Util::array_to_xml($dados));
        
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
    
    public function listarAction() {
        try {
            $dados = array();
            
            $request = $this->getRequest();
            $response = $this->getResponse();

            $filtros = array("filtro_id_uf");
            $pesquisa_dados = \Marabaixo\Util::atualizaFiltros($filtros, $this);
            
            $app = $this->getServiceLocator()->get("AplicacaoFachada");
            $xml = $app->listarMunicipio(\Marabaixo\Util::array_to_xml($pesquisa_dados));

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
        $xml = $app->getInfoMunicipio(\Marabaixo\Util::array_to_xml(array("id" => $id)));

        $result = \Marabaixo\Util::xml_to_array($xml);

        $errors = $this->showMessages($result);
        
        if ($errors) {
            $this->redirect(null, array("action" => "index"), true);
        }

        if (!isset($result["data"])) {
            $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!");
            $this->redirect(null, array("action" => "index"), true);            
        }
        
        $form = new \Application\Form\MunicipioForm();
        
        if (!empty($result["data"])) {
            $result = $result["data"];

            $dados_form = array();
            $dados_form["id"] = $result["id"];
            $dados_form["descricao"] = $result["descricao"];
            $dados_form["ibge"] = $result["ibge"];
            $dados_form["id_uf"] = $result["uf"]["id"];

            $form->setData($dados_form);
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = $request->getPost();

            $form->setData($post);

            if ($form->isValid()) {
                
                $dados = $form->getData();

                $xml = $app->salvarMunicipio(\Marabaixo\Util::array_to_xml($dados));

                $result = \Marabaixo\Util::xml_to_array($xml);

                $errors = $this->showMessages($result);

                if (!$errors) {
                    $this->flashMessenger()->addSuccessMessage("Operação Efetuada com Sucesso!");
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
    
    public function viewAction() {
        $view = new ViewModel();
        
        $id = $this->params("id");
        
        if ($id) {
            $app = $this->getServiceLocator()->get("AplicacaoFachada");
            $xml = $app->getInfoMunicipio(\Marabaixo\Util::array_to_xml(array("id" => $id)));
            
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
    
     public function excluirAction() {
        $view = new ViewModel();
        
        $id = $this->params("id");
        
        if (!$id) {
            $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!");
            $this->redirect(null, array("action" => "index"), true);
        }
        
        $app = $this->getServiceLocator()->get("AplicacaoFachada");
        $xml = $app->excluirMunicipio(\Marabaixo\Util::array_to_xml(array("id" => $id)));

        $result = \Marabaixo\Util::xml_to_array($xml);

        $errors = $this->showMessages($result);

        if (!$errors) {
            $this->flashMessenger()->addSuccessMessage("Operação Efetuada com Sucesso!");
        }
        
        $this->redirect(null, array("action" => "index"), true);
        
        return $view;
    }
    
    public function addAction() {
        try {
            $dados = array();
            
            $request = $this->getRequest();
            $response = $this->getResponse();

            $filtros = array("id_uf", "descricao");
            $pesquisa_dados = \Marabaixo\Util::atualizaFiltros($filtros, $this);
            
            $app = $this->getServiceLocator()->get("AplicacaoFachada");
            $xml = $app->salvarMunicipio(\Marabaixo\Util::array_to_xml($pesquisa_dados));
            $result = \Marabaixo\Util::xml_to_array($xml);

            if (isset($result["data"]) && !empty($result["data"])) {
                $dados["obj"] = $result["data"];
            } elseif (isset($result["errors"]) && !empty($result["errors"])) {
                throw new \Exception(implode("<br>", $result["errors"]));
            }
            
        } catch (\Exception $ex) {
            $dados["errors"] = $ex->getMessage();
        }
        
        $response->setContent(\Zend\Json\Json::encode($dados));
        
        return $response;
    }
    
    public function bairroAction() {

        try {
            
            $view = new ViewModel();
            
            $session = new \Zend\Session\Container();
            if (isset($session->id_municipio)) {
                $id = $session->id_municipio;
            } else {
                $id = $this->params("id");
            }

            if (!$id) {
                throw new \Exception("Falha ao Executar Operação, Município Não Informado!");
            }

            $sl = $this->getServiceLocator();
            $app = $sl->get("AplicacaoFachada");
            
            $xml = $app->getInfoMunicipio(\Marabaixo\Util::array_to_xml(array("id" => $id)));

            $result = \Marabaixo\Util::xml_to_array($xml);

            $errors = $this->showMessages($result);
            if ($errors) {
                throw new \Exception("Falha ao Executar Operação, Município Inválido!");
            }

            if (!(isset($result["data"]) && !empty($result["data"]))) {
                throw new \Exception("Falha ao Executar Operação, Município Inválido!");
            }
            
            $session->id_municipio = $id;

            $view->setVariable("municipio", $result["data"]);

            $filtros = array("page");
            
            $dados = \Marabaixo\Util::atualizaFiltros($filtros, $this);
            $dados["filtro_id_municipio"] = $id;

            $view->setVariable("pesquisa_dados", $dados);

            $xml = $app->listarBairroPorPagina(\Marabaixo\Util::array_to_xml($dados));

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
                                                                                  "action" => "bairroeditar",
                                                                                  "id" => "0"))));
            $botoes->addAction(array("titulo" => "Voltar",
                                     "icone" => "fa-reply",
                                     "url" => $this->url()->fromRoute(null, array("controller" => "municipio", 
                                                                                  "action" => "index",
                                                                                  "id" => "0"))));

            return $view;
        } catch (\Exception $ex) {
            $this->flashMessenger()->addErrorMessage($ex->getMessage());
            $this->redirect(null, array("action" => "index"), true);
        }
            
    }
    
    public function bairroeditarAction() {
        $view = new ViewModel();

        //validação do município
        $session = new \Zend\Session\Container();
        if (!isset($session->id_municipio)) {
            throw new \Exception("Falha ao Executar Operação, Município Não Informado!");
        }
        
        $id_municipio = $session->id_municipio;
        if (!$id_municipio) {
            throw new \Exception("Falha ao Executar Operação, Município Não Informado!");
        }

        $sl = $this->getServiceLocator();
        $app = $sl->get("AplicacaoFachada");

        $xml = $app->getInfoMunicipio(\Marabaixo\Util::array_to_xml(array("id" => $id_municipio)));

        $result = \Marabaixo\Util::xml_to_array($xml);

        $errors = $this->showMessages($result);
        if ($errors) {
            throw new \Exception("Falha ao Executar Operação, Município Inválido!");
        }

        if (!(isset($result["data"]) && !empty($result["data"]))) {
            throw new \Exception("Falha ao Executar Operação, Município Inválido!");
        }
        $view->setVariable("municipio", $result["data"]);
        
        //validação bairro
        $id = $this->params("id");
        
        $xml = $app->getInfoBairro(\Marabaixo\Util::array_to_xml(array("id" => $id)));

        $result = \Marabaixo\Util::xml_to_array($xml);

        $errors = $this->showMessages($result);
        
        if ($errors) {
            $this->redirect(null, array("action" => "bairro"), true);
        }

        if (!isset($result["data"])) {
            $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!");
            $this->redirect(null, array("action" => "bairro"), true);            
        }
        
        $form = new \Application\Form\BairroForm();
        
        if (!empty($result["data"])) {
            $result = $result["data"];

            $dados_form = array();
            $dados_form["id"] = $result["id"];
            $dados_form["descricao"] = $result["descricao"];

            $form->setData($dados_form);
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = $request->getPost();

            $form->setData($post);

            if ($form->isValid()) {
                
                $dados = $form->getData();
                $dados["id_municipio"] = $id_municipio;

                $xml = $app->salvarBairro(\Marabaixo\Util::array_to_xml($dados));

                $result = \Marabaixo\Util::xml_to_array($xml);

                $errors = $this->showMessages($result);

                if (!$errors) {
                    $this->flashMessenger()->addSuccessMessage("Operação Efetuada com Sucesso!");
                    $this->redirect(null, array("action" => "bairro"), true);
                }
            }
            
            $form->showErrorMessages($this);
        }

        $view->setVariable("form", $form);

        $botoes = $this->getServiceLocator()->get("button");
        $botoes->setController($this);
        $botoes->addAction(array("titulo" => "Voltar",
                                 "icone" => "fa-reply",
                                 "url" => $this->url()->fromRoute(null, array("action" => "bairro", "id" => "0"), true)));

        
        return $view;
    }
    
    public function bairroexcluirAction() {
        $view = new ViewModel();
        
        $id = $this->params("id");
        
        if (!$id) {
            $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!");
            $this->redirect(null, array("action" => "bairro"), true);
        }
        
        $app = $this->getServiceLocator()->get("AplicacaoFachada");
        $xml = $app->excluirBairro(\Marabaixo\Util::array_to_xml(array("id" => $id)));

        $result = \Marabaixo\Util::xml_to_array($xml);

        $errors = $this->showMessages($result);

        if (!$errors) {
            $this->flashMessenger()->addSuccessMessage("Operação Efetuada com Sucesso!");
        }
        
        $this->redirect(null, array("action" => "bairro"), true);
        
        return $view;
    }
    
    public function bairroviewAction() {
        $view = new ViewModel();
        
        $id = $this->params("id");
        
        if ($id) {
            $app = $this->getServiceLocator()->get("AplicacaoFachada");
            $xml = $app->getInfoBairro(\Marabaixo\Util::array_to_xml(array("id" => $id)));
            
            $result = \Marabaixo\Util::xml_to_array($xml);

            $errors = $this->showMessages($result);

            if (!$errors) {
                if (isset($result["data"]) && !empty($result["data"])) {
                    $view->setVariable("result", $result["data"]);
                    
                    $botoes = $this->getServiceLocator()->get("button");
                    $botoes->setController($this);
                    $botoes->addAction(array("titulo" => "Voltar",
                                             "icone" => "fa-reply",
                                             "url" => $this->url()->fromRoute(null, array("action" => "bairro", "id" => "0"), true)));
                    
                } else {
                    $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!");
                    $this->redirect(null, array("action" => "bairro"), true);
                }
            } else {
                $this->redirect(null, array("action" => "bairro"), true);
            }
        } else {
            $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!");
            $this->redirect(null, array("action" => "bairro"), true);
        }
        
        return $view;
    }
}
