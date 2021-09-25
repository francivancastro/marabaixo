<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;

class EnderecoController extends \Marabaixo\Controller\AcessoController {

    public function consultacepAction() {
        try {
            $dados = array();
            
            $request = $this->getRequest();
            $response = $this->getResponse();
            
            $sl = $this->getServiceLocator();
            
            if (!$sl) {
                throw new \Exception("Falha ao Carregar Sistema!");
            }
            
            $app = $sl->get("AplicacaoFachada");
            
            if (!$app) {
                throw new \Exception("Falha ao Carregar Sistema!");
            }

            $post = $request->getPost();
            
            $cep = $post->get("cep");
            
            if (!$cep) {
                throw new \Exception("Falha ao Executar Operação, CEP Inválido!");
            }
            
            $filter = new \Zend\Filter\Digits();
            $cep = $filter->filter($cep);
            
            $url = "http://viacep.com.br/ws/{$cep}/json/";
            
            $content = file_get_contents($url);
            
            $content = \Zend\Json\Json::decode($content);
            
            $content->id_uf = 0;
            $content->id_municipio = 0;
            $content->id_bairro = 0;
            
            if (isset($content->uf) && $content->uf) {
                $xml = $app->listarUf(\Marabaixo\Util::array_to_xml(array("filtro_codigo" => $content->uf)));
                
                $dados = \Marabaixo\Util::xml_to_array($xml);
                
                if (isset($dados["data"]) && $dados["data"]) {
                    $result = $dados["data"];
                    if (is_array($result) && count($result)) {
                        $obj = current($result);
                        $content->id_uf = $obj["id"];
                    }
                }
            }
            if ($content->id_uf) {
                if (isset($content->localidade) && $content->localidade) {
                    $dados = array();
                    $dados["filtro_id_uf"] = $content->id_uf;
                    $dados["filtro_descricao"] = $content->localidade;
                    
                    $xml = $app->listarMunicipio(\Marabaixo\Util::array_to_xml($dados));

                    $dados = \Marabaixo\Util::xml_to_array($xml);
                    
                    $dados_mun = array();

                    if (isset($dados["data"]) && $dados["data"]) {
                        $result = $dados["data"];
                        
                        if (is_array($result) && count($result)) {
                            $obj = current($result);
                            $dados_mun["id"] = $obj["id"];
                        }
                    } else {
                        $dados_mun["id_uf"] = $content->id_uf;
                        $dados_mun["descricao"] = $content->localidade;
                    }
                    
                    $dados_mun["ibge"] = $content->ibge;
                    
                    $xml = $app->salvarMunicipio(\Marabaixo\Util::array_to_xml($dados_mun));
                    $dados = \Marabaixo\Util::xml_to_array($xml);

                    if (isset($dados["data"]) && $dados["data"]) {
                        $result = $dados["data"];
                        $content->id_municipio = $result["id"];
                    }
                }
                if ($content->id_municipio) {
                    if (isset($content->bairro) && $content->bairro) {
                        $dados = array();
                        $dados["filtro_id_municipio"] = $content->id_municipio;
                        $dados["filtro_descricao"] = $content->bairro;

                        $xml = $app->listarBairro(\Marabaixo\Util::array_to_xml($dados));

                        $dados = \Marabaixo\Util::xml_to_array($xml);

                        if (isset($dados["data"]) && $dados["data"]) {
                            $result = $dados["data"];

                            if (is_array($result) && count($result)) {
                                $obj = current($result);
                                $content->id_bairro = $obj["id"];
                            }
                        } else {
                            $dados = array();
                            $dados["id_municipio"] = $content->id_municipio;
                            $dados["descricao"] = $content->bairro;

                            $xml = $app->salvarBairro(\Marabaixo\Util::array_to_xml($dados));
                            $dados = \Marabaixo\Util::xml_to_array($xml);

                            if (isset($dados["data"]) && $dados["data"]) {
                                $result = $dados["data"];
                                $content->id_bairro = $result["id"];
                            }                            
                        }
                    }
                }
            }
            
            $dados["conteudo"] = $content;
            
        } catch (\Exception $ex) {
            $dados["errors"] = $ex->getMessage();
        }
        
        $response->setContent(\Zend\Json\Json::encode($dados));
        
        return $response;
    }
}
