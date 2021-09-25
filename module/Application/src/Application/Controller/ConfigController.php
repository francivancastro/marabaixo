<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;

class ConfigController extends \Marabaixo\Controller\AcessoController {

    
    public function indexAction() {
        $view = new ViewModel();
        
        $id = $this->params("id");
        
        $app = $this->getServiceLocator()->get("AplicacaoFachada");
        $xml = $app->getInfoConfig(\Marabaixo\Util::array_to_xml(array("id" => $id)));

        $result = \Marabaixo\Util::xml_to_array($xml);

        $errors = $this->showMessages($result);

        if (!$errors) {
            if (isset($result["data"])) {
                
                $form = new \Application\Form\ConfigForm();

                $dados_form = array();
                
                if (!empty($result["data"])) {
                    $result = $result["data"];
                    $dados_form["id_config"] = $result["id"];
                    if (isset($result["sistema_sigla"])) { $dados_form["sistema_sigla"] = $result["sistema_sigla"]; }
                    if (isset($result["sistema_nome"])) { $dados_form["sistema_nome"] = $result["sistema_nome"]; }
                    if (isset($result["arquivo_logo"]["id"])) { $dados_form["id_arquivo_logo"] = $result["arquivo_logo"]["id"]; }
                    if (isset($result["maioridade_idade_minima"])) { $dados_form["maioridade_idade_minima"] = $result["maioridade_idade_minima"]; }
                    if (isset($result["pessoa_juridica"])) {
                        $pj = $result["pessoa_juridica"];                        
                        if (isset($pj["cnpj"])) { $dados_form["cliente_cnpj"] = $pj["cnpj"]; }
                        if (isset($pj["sigla"])) { $dados_form["cliente_sigla"] = $pj["sigla"]; }
                        if (isset($pj["razao_social"])) { $dados_form["cliente_razao_social"] = $pj["razao_social"]; }
                        if (isset($pj["nome_fantasia"])) { $dados_form["cliente_nome_fantasia"] = $pj["nome_fantasia"]; }
                        if (isset($pj["pessoa"])) {
                            $pessoa = $pj["pessoa"];
                            if (isset($pessoa["email"])) { $dados_form["cliente_email"] = $pessoa["email"]; }
                        }
                        if (isset($pj["arquivo_logo"]["id"])) {
                            $dados_form["cliente_id_arquivo_logo"] = $pj["arquivo_logo"]["id"];
                        }
                    }
                    if (isset($result["smtp"])) {
                        $smtp = $result["smtp"];
                        if (isset($smtp["email"])) { $dados_form["smtp_email"] = $smtp["email"]; }
                        if (isset($smtp["host"])) { $dados_form["smtp_host"] = $smtp["host"]; }
                        if (isset($smtp["port"])) { $dados_form["smtp_port"] = $smtp["port"]; }
                        if (isset($smtp["username"])) { $dados_form["smtp_username"] = $smtp["username"]; }
                        if (isset($smtp["password"])) { $dados_form["smtp_password"] = $smtp["password"]; }
                        if (isset($smtp["secure"])) { $dados_form["smtp_secure"] = $smtp["secure"]; }
                    }
                }
                $form->setData($dados_form);
                
                $request = $this->getRequest();
                if ($request->isPost()) {
                    $post = array_merge_recursive(
                        $request->getPost()->toArray(),
                        $request->getFiles()->toArray()
                    );
                    
                    $form->setData($post);

                    if ($form->isValid()) {
                        $dados = $form->getData();
                        
                        $xml = $app->salvarConfig(\Marabaixo\Util::array_to_xml($dados));
                        
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
                                         "url" => $this->url()->fromRoute(null, array("controller" => "index", "action" => "index", "id" => "0"), true)));

            } else {
                $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!");
                $this->redirect(null, array("action" => "index"), true);
            }
        } else {
            $this->redirect(null, array("action" => "index"), true);
        }
        
        return $view;
    }
    
}
