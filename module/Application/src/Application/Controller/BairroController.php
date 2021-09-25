<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;

class BairroController extends \Marabaixo\Controller\AcessoController {

    public function listarAction() {
        try {
            $dados = array();
            
            $request = $this->getRequest();
            $response = $this->getResponse();

            $filtros = array("filtro_id_uf");
            $pesquisa_dados = \Marabaixo\Util::atualizaFiltros($filtros, $this);
            
            $app = $this->getServiceLocator()->get("AplicacaoFachada");
            $xml = $app->listarBairro(\Marabaixo\Util::array_to_xml($pesquisa_dados));

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

            $filtros = array("id_uf", "descricao");
            $pesquisa_dados = \Marabaixo\Util::atualizaFiltros($filtros, $this);
            
            $app = $this->getServiceLocator()->get("AplicacaoFachada");
            $xml = $app->salvarBairro(\Marabaixo\Util::array_to_xml($pesquisa_dados));
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
