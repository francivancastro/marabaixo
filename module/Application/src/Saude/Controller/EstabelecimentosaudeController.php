<?php

namespace Saude\Controller;

use Zend\View\Model\ViewModel;

class EstabelecimentosaudeController extends \Marabaixo\Controller\AcessoController {
    
    public function validaRegiaoAtual() {
        $sl = $this->getServiceLocator();
        $app = $sl->get("AplicacaoFachada");
        $result = $app->getRegiaoAtual(array());
        if (!isset($result["data"]) || empty($result["data"])) {
            $this->flashMessenger()->addErrorMessage("Usuário Não Vinculado a Nenhuma Região!");
            $this->redirect(null, array("controller" => "index", "action" => "index"), true);
        }
        return $result["data"];
    }
    
    public function indexAction() {
        try {
            $view = new ViewModel();

            $sl = $this->getServiceLocator();
            $app = $sl->get("AplicacaoFachada");
            
            $regiaoAtual = $this->validaRegiaoAtual();
            $view->setVariable("regiao_atual", $regiaoAtual);
            
            $filtros = array("page");

            $dados = \Marabaixo\Util::atualizaFiltros($filtros, $this);
            $dados["dominio"] = "EstabelecimentoSaude";

            $view->setVariable("pesquisa_dados", $dados);

            $xml = $app->listarPorPagina(\Marabaixo\Util::array_to_xml($dados));

            $result = \Marabaixo\Util::xml_to_array($xml);

            $this->showMessages($result);

            if (isset($result["data"])) {
                $view->setVariable("result", $result["data"]);
            }
        } catch (\Exception $ex) {
            $this->flashMessenger()->addErrorMessage($ex->getMessage());
        }

        $botoes = $this->getServiceLocator()->get("button");
        $botoes->setController($this);
        $botoes->addAction(array("titulo" => "Adicionar",
                                 "icone" => "fa-plus-circle",
                                 "url" => $this->url()->fromRoute(null, array("controller" => $this->getControllerName(), 
                                                                              "action" => "editar",
                                                                              "id" => "0"))));
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
            $xml = $app->getInfo(\Marabaixo\Util::array_to_xml(array("id" => $id, "dominio" => "EstabelecimentoSaude")));
            
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
        $xml = $app->getInfo(\Marabaixo\Util::array_to_xml(array("id" => $id, "dominio" => "EstabelecimentoSaude")));

        $result = \Marabaixo\Util::xml_to_array($xml);

        $errors = $this->showMessages($result);
        
        if ($errors) {
            $this->redirect(null, array("action" => "index"), true);
        }

        if (!isset($result["data"])) {
            $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!");
            $this->redirect(null, array("action" => "index"), true);            
        }
        
        $form = new \Saude\Form\EstabelecimentoSaudeForm();

        $dados_form = array();
        
        if (!empty($result["data"])) {
            $result = $result["data"];
            
            $dados_form["id"] = $result["id"];
            
            $dados_form["codigo_cnes"] = $result["codigo_cnes"];
            $dados_form["id_estabelecimento_saude_tipo"] = $result["estabelecimento_saude_tipo"]["id"];
            $dados_form["id_estabelecimento_gestao"] = $result["estabelecimento_gestao"]["id"];
            
            $dados_form["descricao"] = $result["descricao"];
            $dados_form["sigla"] = $result["sigla"];
            $dados_form["id_pessoa_fisica"] = $result["usuario"]["pessoa_fisica"]["id"];
            $dados_form["id_pessoa_juridica"] = $result["pessoa_juridica"]["id"];
            
            if (isset($result["endereco"]["id"])) { $dados_form["id_endereco"] = $result["endereco"]["id"]; }
            if (isset($result["endereco"]["cep"])) { $dados_form["cep"] = $result["endereco"]["cep"]; }
            if (isset($result["endereco"]["logradouro"])) { $dados_form["logradouro"] = $result["endereco"]["logradouro"]; }
            if (isset($result["endereco"]["numero"])) { $dados_form["numero"] = $result["endereco"]["numero"]; }
            if (isset($result["endereco"]["complemento"])) { $dados_form["complemento"] = $result["endereco"]["complemento"]; }
            if (isset($result["endereco"]["bairro"]["id"])) { $dados_form["id_bairro"] = $result["endereco"]["bairro"]["id"]; }
            if (isset($result["endereco"]["bairro"]["municipio"]["id"])) { $dados_form["id_municipio"] = $result["endereco"]["bairro"]["municipio"]["id"]; }
            if (isset($result["endereco"]["bairro"]["municipio"]["uf"]["id"])) { $dados_form["id_uf"] = $result["endereco"]["bairro"]["municipio"]["uf"]["id"]; }

        }
        
        $form->setData($dados_form);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = $request->getPost();

            $form->setData($post);

            if ($form->isValid()) {
                
                $dados = $form->getData();
                $dados["dominio"] = "EstabelecimentoSaude";

                $xml = $app->salvar(\Marabaixo\Util::array_to_xml($dados));

                $result = \Marabaixo\Util::xml_to_array($xml);

                $errors = $this->showMessages($result);

                if (!$errors) {
                    $this->flashMessenger()->addSuccessMessage("Operação Efetuada com Sucesso!");
                    $this->redirect(null, array("action" => "index"), true);
                }
            }
            
            $form->showErrorMessages($this);
        }
        
        //controle de endereço
        $endereco = "";
        $dados_form = $form->getData();
        $result = $app->htmlEndereco($dados_form);
        if (isset($result["data"]["html"]) && $result["data"]["html"]) {
            $endereco = $result["data"]["html"];
        }
        $view->setVariable("endereco", $endereco);

        $view->setVariable("form", $form);

        $botoes = $this->getServiceLocator()->get("button");
        $botoes->setController($this);
        $botoes->addAction(array("titulo" => "Voltar",
                                 "icone" => "fa-reply",
                                 "url" => $this->url()->fromRoute(null, array("action" => "index", "id" => "0"), true)));

        
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
        $xml = $app->excluir(\Marabaixo\Util::array_to_xml(array("id" => $id, "dominio" => "EstabelecimentoSaude")));

        $result = \Marabaixo\Util::xml_to_array($xml);

        $errors = $this->showMessages($result);

        if (!$errors) {
            $this->flashMessenger()->addSuccessMessage("Operação Efetuada com Sucesso!");
        }
        
        $this->redirect(null, array("action" => "index"), true);
        
        return $view;
    }
    
    public function selecionarAction() {
        try {
            
            $id = $this->params("id");

            $app = $this->getServiceLocator()->get("AplicacaoFachada");
            $xml = $app->selecionarEstabelecimentoSaude(\Marabaixo\Util::array_to_xml(array("id" => $id)));

            $result = \Marabaixo\Util::xml_to_array($xml);

            $errors = $this->showMessages($result);
            
            if ($errors) {
                $this->redirect(null, array("controller" => "index", "action" => "index"), true);
            }
            
            if (!isset($result["data"]["tostring"])) {
                throw new \Exception("Falha ao Executar Operação, Dados Inválidos!");
            }
            
            $us = $result["data"];
            
            $this->flashMessenger()->addSuccessMessage("Estabelecimento de Saúde: {$us["tostring"]} Selecionada!");
            
        } catch (\Exception $ex) {
            $this->flashMessenger()->addErrorMessage($ex->getMessage());
        }

        $this->redirect(null, array("controller" => "index", "action" => "index"), true);
    }
}
