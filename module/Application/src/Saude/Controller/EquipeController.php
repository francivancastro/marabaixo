<?php
namespace Saude\Controller;

use Zend\View\Model\ViewModel;

class EquipeController extends \Marabaixo\Controller\AcessoController {

    public function indexAction() {

        $view = new ViewModel();

        $sl = $this->getServiceLocator();
        $app = $sl->get("AplicacaoFachada");

        $filtros = array("page");

        $dados = \Marabaixo\Util::atualizaFiltros($filtros, $this);

        $view->setVariable("pesquisa_dados", $dados);
        
        $rs = $app->getEstabelecimentoSaudeAtual(array());
        if(empty($rs['data'])){
            $this->flashMessenger()->addErrorMessage("O usuário não esta vinculado a uma estabelecimento de saúde!");
            $this->redirect(null, array("action" => "index", "controller" => "index" ), true); 
        }

        $dados["dominio"] = "Equipe";

        $xml = $app->listarPorPagina(\Marabaixo\Util::array_to_xml($dados));

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
            $xml = $app->getInfo(\Marabaixo\Util::array_to_xml(array("id" => $id, "dominio" => "Equipe")));

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
        $xml = $app->getInfo(\Marabaixo\Util::array_to_xml(array("id" => $id, "dominio" => "Equipe")));

        $result = \Marabaixo\Util::xml_to_array($xml);        
                
        $errors = $this->showMessages($result);

        if ($errors) {
            $this->redirect(null, array("action" => "index"), true);
        }

        if (!isset($result["data"])) {
            $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!");
            $this->redirect(null, array("action" => "index"), true);
        }
        
        $rs = $app->getEstabelecimentoSaudeAtual(array());
        if(empty($rs['data'])){
            $this->flashMessenger()->addErrorMessage("O usuário não esta vinculado a uma estabelecimento de saúde!");
            $this->redirect(null, array("action" => "index", "controlle" => "index" ), true); 
        }
        
        $form = new \Saude\Form\EquipeForm();
        
    
        if (!empty($result["data"])) {
            $result = $result["data"];
            $dados_form = array();
            $dados_form["id"] = $result["id"];
            $dados_form["descricao"] = $result["descricao"];
            $dados_form["ine"] = $result["ine"];
            $dados_form["id_equipe_tipo"] = $result["equipe_tipo"]['id'];
            $dados_form["id_equipe_area"] = $result["equipe_area"]['id'];
            if (isset($result["equipe_zona"]['id'])) {
                $dados_form["id_equipe_zona"] = $result["equipe_zona"]['id'];
            }
            $dados_form["id_segmento_territorial"] = $result["segmento_territorial"]['id'];
            $dados_form["id_populacao_assistida"] = array();
            if (isset($result["populacao_assistida"])) {
                foreach ($result["populacao_assistida"] as $pa) {
                    $dados_form["id_populacao_assistida"][] = $pa["id"];
                }
            }

            if (isset($result["estabelecimento_saude"]["id"])) {                
                $dados_form["id_estabelecimento_saude"] = $result["estabelecimento_saude"]["id"];
            }
     
           
            $form->setData($dados_form);

        }

        $request = $this->getRequest();              
        if ($request->isPost()) {
            $post = $request->getPost();                 
            $form->setData($post);            
            if ($form->isValid()) {                
                $dados = $form->getData();

                $dados["dominio"] = "Equipe";

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
        $xml = $app->excluir(\Marabaixo\Util::array_to_xml(array("id" => $id, "dominio" => "Equipe")));

        $result = \Marabaixo\Util::xml_to_array($xml);

        $errors = $this->showMessages($result);

        if (!$errors) {
            $this->flashMessenger()->addSuccessMessage("Operação Efetuada com Sucesso!");
        }

        $this->redirect(null, array("action" => "index"), true);

        return $view;
    }

}
