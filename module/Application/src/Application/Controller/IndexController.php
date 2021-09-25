<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;

class IndexController extends \Marabaixo\Controller\LogadoController {
    
    public function indexAction() {
        $view = new ViewModel();
        
        $sm = $this->getServiceLocator();
        $app = $sm->get("AplicacaoFachada");
        
        if (!$app) {
            $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação, Dados Inválidos!");
        } else {
            $xml = $app->getWidgetHTML();
            if ($xml) {
                $result = \Marabaixo\Util::xml_to_array($xml);
                
                $errors = $this->showMessages($result);
                
                if (isset($result["data"]) && $result["data"]) {
                    $result = $result["data"];
                    if (isset($result["html"])) {
                        $view->setVariable("widget", $result["html"]);
                    }
                }
            }
        }
        
        return $view;
    }
    
    public function logoutAction() {
        $fac = $this->getServiceLocator()->get("AplicacaoFachada");
        $fac->logout();
        
        $this->flashMessenger()->addErrorMessage("Usuário Deslogado com Sucesso!");
        $this->redirect(null, array("controller" => "index", "action" => "index"));
    }
    
}
