<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;

class PessoajuridicaController extends \Marabaixo\Controller\AcessoController {

    public function listarporpaginaAction() {
        try {
            $dados = array();
            
            $request = $this->getRequest();
            $response = $this->getResponse();

            $filtros = array("filtro_nome", "page");
            $pesquisa_dados = \Marabaixo\Util::atualizaFiltros($filtros, $this);
            $pesquisa_dados["dominio"] = "PessoaJuridica";
            
            $app = $this->getServiceLocator()->get("AplicacaoFachada");
            $result = $app->listarPorPagina($pesquisa_dados);

            if (isset($result["data"]) && !empty($result["data"])) {
                $dados = $result["data"];
            }
            
            if (isset($result["errors"]) && count($result["errors"])) {
                $dados["errors"] = "<p>" . implode("</p><p>", $result["errors"]) . "</p>";
            }
            
        } catch (\Exception $ex) {
            $dados["errors"] = $ex->getMessage();
        }
        
        $response->setContent(\Zend\Json\Json::encode($dados));
        
        return $response;
    }
    
    public function infoAction() {
        try {
            $dados = array();
            
            $request = $this->getRequest();
            $response = $this->getResponse();
            $app = $this->getServiceLocator()->get("AplicacaoFachada");
            
            $pj = false;

            $id_pessoa_juridica = $request->getPost("filtro_id_pessoa_juridica");
            if ($id_pessoa_juridica) {
                $result = $app->getInfo(array("id" => $id_pessoa_juridica, "dominio" => "PessoaJuridica"));
                if (isset($result["data"]) && !empty($result["data"])) {
                    $pj = $result["data"];
                }                
            } else {
                $filtros = array("filtro_cnpj");
                $pesquisa_dados = \Marabaixo\Util::atualizaFiltros($filtros, $this);
                $pesquisa_dados["dominio"] = "PessoaJuridica";
            }
            
            if (!$pj) {
                $result = $app->listar($pesquisa_dados);
                if (isset($result["data"]) && !empty($result["data"])) {
                    $objs = $result["data"];
                    if ($objs && is_array($objs) && !empty($objs)) {
                        $pj = current($objs);
                    }
                }
            }
            
            $dados = array("obj" => $pj);
            
        } catch (\Exception $ex) {
            $dados["errors"] = $ex->getMessage();
        }
        
        $response->setContent(\Zend\Json\Json::encode($dados));
        
        return $response;
    }
    
    public function salvarAction() {
        try {
            $dados = array();
            
            $request = $this->getRequest();
            $response = $this->getResponse();

            $pesquisa_dados = $request->getPost()->toArray();
            $pesquisa_dados["dominio"] = "PessoaJuridica";
            
            $app = $this->getServiceLocator()->get("AplicacaoFachada");
            $result = $app->salvar($pesquisa_dados);
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
