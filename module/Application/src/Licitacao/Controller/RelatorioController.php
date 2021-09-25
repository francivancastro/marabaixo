<?php

namespace Licitacao\Controller;

use Zend\View\Model\ViewModel;

class RelatorioController extends \Marabaixo\Controller\AcessoController {

    public function indexAction() {
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
        
        return new ViewModel();
        
    }
    
    public function linhasAction() {
        return new ViewModel();
    }
    
    public function barrasAction() {
        return new ViewModel();
    }
}
