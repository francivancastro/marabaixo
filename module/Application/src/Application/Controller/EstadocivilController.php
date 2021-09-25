<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;

class EstadocivilController extends \Marabaixo\Controller\AcessoController {

    public function listarAction() {
        try {
            $dados = array();
            
            $request = $this->getRequest();
            $response = $this->getResponse();
            
            $app = $this->getServiceLocator()->get("AplicacaoFachada");
            $xml = $app->listarEstadoCivil();

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
    
    public function addAction() {
        try {
            $dados = array();
            
            $request = $this->getRequest();
            $response = $this->getResponse();

            $filtros = array("chave", "descricao");
            $pesquisa_dados = \Marabaixo\Util::atualizaFiltros($filtros, $this);
            
            $app = $this->getServiceLocator()->get("AplicacaoFachada");
            $xml = $app->salvarEstadoCivil(\Marabaixo\Util::array_to_xml($pesquisa_dados));
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
}
