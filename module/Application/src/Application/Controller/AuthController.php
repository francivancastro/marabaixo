<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;

class AuthController extends \Marabaixo\Controller\DefaultController {

    public function onDispatch(\Zend\Mvc\MvcEvent $e) {

        $exclude_arrays = array("novoadmin", "index");
        $action = $e->getRouteMatch()->getParam("action");

        if (!in_array($action, $exclude_arrays)) {
            $fac = $this->getServiceLocator()->get("AplicacaoFachada");

            $xml = $fac->pegaQuantidadeUsuario();

            $array = \Marabaixo\Util::xml_to_array($xml);

            $dados = $array["data"];
            $errors = $array["errors"];

            if (isset($errors) && is_array($errors) && count($errors)) {
                foreach ($errors as $error) {
                    $this->flashMessenger()->addErrorMessage($error);
                }
                $this->redirect(null, array("controller" => "auth", "action" => "logout"));
            }

            if (!isset($dados["quantidade"]) || !$dados["quantidade"]) {
                $this->redirect(null, array("controller" => "auth", "action" => "novoadmin"));
            }
        }

        $this->layout("layout/nlogin");

        parent::onDispatch($e);
    }

    public function indexAction() {
        $view = new ViewModel();
        $config = false;
        $app = $this->getServiceLocator()->get("AplicacaoFachada");
        $xml = $app->getInfoSistema();
        if ($xml) {
            $info_system = \Marabaixo\Util::xml_to_array($xml);
        }

        if ($info_system["errors"] && count($info_system["errors"])) {
            foreach ($info_system["errors"] as $erro) {
                $this->flashMessenger()->addErrorMessage($erro);
            }
        }

        if (isset($info_system["data"]["config"])) {
            $config = $info_system["data"]["config"];
        }

        $form = new \Application\Form\LoginForm();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $dados = $request->getPost();
            $form->setData($dados);

            if ($form->isValid()) {
                $dados = $form->getData();

                $xml = $app->autenticar(\Marabaixo\Util::array_to_xml($dados));
                $dados = \Marabaixo\Util::xml_to_array($xml);

                if (isset($dados["errors"]) && is_array($dados["errors"]) && count($dados["errors"])) {
                    foreach ($dados["errors"] as $error) {
                        $this->flashMessenger()->addErrorMessage($error);
                    }
                } else {
                    $this->redirect(null, array("controller" => "index", "action" => "index"));
                }
            } else {
                $form->showErrorMessages($this);
            }
        }

        $view->setVariable("config", $config);
        $view->setVariable("form", $form);

        return $view;
    }

    public function novoadminAction() {
        $fac = $this->getServiceLocator()->get("AplicacaoFachada");

        $xml = $fac->pegaQuantidadeUsuario();

        $array = \Marabaixo\Util::xml_to_array($xml);

        $dados = $array["data"];

        if (isset($dados["quantidade"]) && $dados["quantidade"]) {
            $this->flashMessenger()->addErrorMessage("JÁ EXISTE UM USUÁRIO CADASTRADO NO SISTEMA!");
            $this->redirect(null, array("controller" => "index", "action" => "index"));
        }

        $form = new \Application\Form\NovoadminForm();

        $request = $this->getRequest();

        if ($request->isPost()) {
            $post = array_merge_recursive(
                    $request->getPost()->toArray(), $request->getFiles()->toArray()
            );

            $form->setData($post);

            if ($form->isValid()) {
                $dados = $form->getData();
                if ($dados["senha"] == $dados["confirma_senha"]) {

                    $fac = $this->getServiceLocator()->get("AplicacaoFachada");
                    $xml = $fac->novoUsuario(\Marabaixo\Util::array_to_xml($dados));
                    $array = \Marabaixo\Util::xml_to_array($xml);

                    $dados = $array["data"];
                    $errors = $array["errors"];

                    if (isset($errors) && is_array($errors) && count($errors)) {
                        foreach ($errors as $error) {
                            $this->flashMessenger()->addErrorMessage($error);
                        }
                    } else {
                        $this->flashMessenger()->addSuccessMessage("Administrador Cadastrado com Sucesso!");
                        $this->redirect(null, array("controller" => "auth", "action" => "index"));
                    }
                } else {
                    $this->flashMessenger()->addErrorMessage("** FALHA NO ENVIO DO FORMULÁRIO.");
                    $this->flashMessenger()->addErrorMessage("Senhas Informadas Diferentes!");
                }
            } else {
                $form->showErrorMessages($this);
            }
        }

        $view = new ViewModel();
        $view->setVariable("form", $form);

        return $view;
    }

    public function setcomponenteAction() {
        $view = new ViewModel();
        try {
            $fac = $this->getServiceLocator()->get("AplicacaoFachada");
            $xml = $fac->pegaUsuarioLogado();

            if (!$xml) {
                $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!");
            }

            $array = \Marabaixo\Util::xml_to_array($xml);

            $errors = $this->showMessages($array);

            if (!($array && isset($array["data"]["usuario"]))) {
                throw new \Exception("Falha ao Executar Operação, Nenhum Usuário Logado!");
            }

            $usuario = $array["data"]["usuario"];

            if (!(isset($usuario["componentes"]) && is_array($usuario["componentes"]) && count($usuario["componentes"]))) {
                throw new \Exception("Falha ao Executar o Login, Nenhum Componente Disponível!");
            }

            $id_componente_atual = $this->params("id");

            if ($id_componente_atual) {

                $flag = false;
                foreach ($usuario["componentes"] as $componente) {
                    if ($componente["id_componente"] == $id_componente_atual) {
                        $flag = true;
                        break;
                    }
                }

                if (!$flag) {
                    $id_componente_atual = 0;
                    throw new \Exception("Falha ao Executar Operação, Componente Não Disponível para o Usuário!");
                }
            }
            if ($id_componente_atual) {
                $container = new \Zend\Session\Container();
                $container->id_componente_atual = $id_componente_atual;

                $this->flashMessenger()->addSuccessMessage("Componente {$componente["descricao"]} Selecionado!");
                $this->redirect(null, array("controller" => "index", "action" => "index"), false);
            } else {
                if (count($usuario["componentes"]) == 1) {
                    $componente = current($usuario["componentes"]);
                    $id_componente_atual = $componente["id_componente"];
                }
                $view->setVariable("componentes", $usuario["componentes"]);
            }
        } catch (\Exception $ex) {
            $this->flashMessenger()->addErrorMessage($ex->getMessage());
            $this->redirect(null, array("controller" => "index", "action" => "index"));
        }

        return $view;
    }

    public function senhaAction() {
        $view = new ViewModel();

        $app = $this->getServiceLocator()->get("AplicacaoFachada");
        if (!$app) {
            $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!");
            $this->redirect(null, array("controller" => "auth", "action" => "index"));
        }
        $xml = $app->pegaUsuarioLogado();
        if (!$xml) {
            $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!!");
            $this->redirect(null, array("controller" => "auth", "action" => "index"));
        }
        $result = \Marabaixo\Util::xml_to_array($xml);

        $errors = $this->showMessages($result);
        if ($errors) {
            $this->redirect(null, array("controller" => "auth", "action" => "index"));
        }

        if (!(isset($result["data"]) && !empty($result["data"]))) {
            $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!!!");
            $this->redirect(null, array("controller" => "auth", "action" => "index"));
        }

        $result = $result["data"];
        if (!(isset($result["usuario"]) && !empty($result["usuario"]))) {
            $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!!!");
            $this->redirect(null, array("controller" => "auth", "action" => "index"));
        }

        $usuario = $result["usuario"];

        $view->setVariable("usuario", $usuario);

        $form = new \Application\Form\SenhaForm();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = $request->getPost();
            $form->setData($post);
            if ($form->isValid()) {
                $dados = $form->getData();
                $dados["altera_senha"] = "N";
                $dados["id_usuario"] = $usuario["id"];

                $xml = $app->salvarUsuario(\Marabaixo\Util::array_to_xml($dados));
                if ($xml) {
                    $result = \Marabaixo\Util::xml_to_array($xml);
                    $errors = $this->showMessages($result);
                    if (!$errors) {
                        $this->flashMessenger()->addSuccessMessage("Operação Efetuada com Sucesso!!");
                        $this->redirect(null, array("controller" => "auth", "action" => "index"));
                    }
                }
            } else {
                $form->showErrorMessages($this);
            }
        }

        $view->setVariable("form", $form);

        return $view;
    }

    public function recuperaAction() {
        $view = new ViewModel();

        $app = $this->getServiceLocator()->get("AplicacaoFachada");
        if (!$app) {
            $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!");
            $this->redirect(null, array("controller" => "auth", "action" => "index"));
        }

        $form = new \Application\Form\RecuperaForm();

        $view->setVariable("form", $form);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = $request->getPost();
            $form->setData($post);
            if ($form->isValid()) {
                $dados = $form->getData();

                $xml = $app->recuperaSenha(\Marabaixo\Util::array_to_xml($dados));
                if (!$xml) {
                    $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!!");
                    $this->redirect(null, array("controller" => "auth", "action" => "index"));
                }
                $result = \Marabaixo\Util::xml_to_array($xml);

                $errors = $this->showMessages($result);
                if (!$errors) {
                    $this->flashMessenger()->addSuccessMessage("Um E-mail será Enviado para Você com as Orientações para Alteração de Senha!");
                    $this->redirect(null, array("controller" => "auth", "action" => "index"));
                }
            } else {
                $form->showErrorMessages($this);
            }
        }

        return $view;
    }

}
