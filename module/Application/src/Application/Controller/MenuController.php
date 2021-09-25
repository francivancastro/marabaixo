<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;

class MenuController extends \Marabaixo\Controller\AcessoController {
    
    public function indexAction() {
        
        $view = new ViewModel();
        
        $sl = $this->getServiceLocator();
        $app = $sl->get("AplicacaoFachada");
                
        $filtros = array("pesquisa_descricao", "page");

        $dados = \Marabaixo\Util::atualizaFiltros($filtros, $this);

        $view->setVariable("pesquisa_dados", $dados);
        
        $xml = $app->listarMenusPorPagina(\Marabaixo\Util::array_to_xml($dados));
        
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
            $xml = $app->getInfoMenu(\Marabaixo\Util::array_to_xml(array("id" => $id)));
            
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
        $xml = $app->getInfoMenu(\Marabaixo\Util::array_to_xml(array("id" => $id)));

        $result = \Marabaixo\Util::xml_to_array($xml);

        $errors = $this->showMessages($result);

        if (!$errors) {
            if (isset($result["data"])) {
                
                $form = new \Application\Form\MenuForm();
                
                $xml = $app->pegaUltimaOrdemMenu();
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
                    $fe->setValue($ordem);
                }

                $xml = $app->listarMenu();
                $array = \Marabaixo\Util::xml_to_array($xml);
                if (!empty($array["data"])) {
                    $array = $array["data"];
                    
                    if (count($array)) {
                        $items = array();
                        $items[""] = "==> SELECIONE <==";
                        foreach ($array as $obj) {
                            $items[$obj["id"]] = $obj["tostring"];
                        }
                    }
                    $fe = $form->get("id_menu_superior");
                    $fe->setValueOptions($items);
                    $fe->setValue("");
                }
                
                if (!empty($result["data"])) {
                    $result = $result["data"];

                    $dados_form = array();
                    $dados_form["id_menu"] = $result["id"];
                    $dados_form["descricao"] = $result["descricao"];
                    $dados_form["controller"] = $result["controller"];
                    $dados_form["action"] = $result["action"];
                    $dados_form["icone"] = $result["icone"];
                    $dados_form["ordem"] = $result["ordem"];
                    $dados_form["id_menu_superior"] = 0;
                    if (isset($result["menu_superior"]["id"])) {
                        $dados_form["id_menu_superior"] = $result["menu_superior"]["id"];
                    }

                    $form->setData($dados_form);
                }
                
                $request = $this->getRequest();
                if ($request->isPost()) {
                    $post = $request->getPost();
                    
                    $form->setData($post);

                    if ($form->isValid()) {
                        $dados = $form->getData();
                        
                        $xml = $app->salvarMenu(\Marabaixo\Util::array_to_xml($dados));
                        
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
            $xml = $app->excluirMenu(\Marabaixo\Util::array_to_xml(array("id" => $id)));
            
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
}
