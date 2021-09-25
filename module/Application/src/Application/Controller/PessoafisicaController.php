<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;

class PessoafisicaController extends \Marabaixo\Controller\AcessoController {

    public function listarporpaginaAction() {
        try {
            $dados = array();
            
            $request = $this->getRequest();
            $response = $this->getResponse();

            $filtros = array("pesquisa_nome", "pesquisa_email", "page");
            $pesquisa_dados = \Marabaixo\Util::atualizaFiltros($filtros, $this);
            
            $app = $this->getServiceLocator()->get("AplicacaoFachada");
            $xml = $app->listarPessoaFisicaPorPagina(\Marabaixo\Util::array_to_xml($pesquisa_dados));

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
    
    public function infoAction() {
        try {
            $dados = array();
            
            $request = $this->getRequest();
            $response = $this->getResponse();
            $app = $this->getServiceLocator()->get("AplicacaoFachada");
            
            $nacionalidade = $pf = false;

            $id_pessoa_fisica = $request->getPost("filtro_id_pessoa_fisica");
            if ($id_pessoa_fisica) {
                $xml = $app->getInfoPessoaFisica(\Marabaixo\Util::array_to_xml(array("id" => $id_pessoa_fisica)));
                $result = \Marabaixo\Util::xml_to_array($xml);
                if (isset($result["data"]) && !empty($result["data"])) {
                    $pf = $result["data"];
                    if (isset($pf["nacionalidade"])) {
                        $nacionalidade = $pf["nacionalidade"];
                    }
                }                
            } else {
                $filtros = array("filtro_id_nacionalidade", "filtro_cpf", "filtro_passaporte");
                $pesquisa_dados = \Marabaixo\Util::atualizaFiltros($filtros, $this);
                
                if (!$pesquisa_dados["filtro_id_nacionalidade"]) {
                    throw new \Exception("Falha ao Executar Operação, Informe a Nacionalidade!");
                }
                $xml = $app->pegaInfoNacionalidade(\Marabaixo\Util::array_to_xml(array("id" => $pesquisa_dados["filtro_id_nacionalidade"])));
                $result = \Marabaixo\Util::xml_to_array($xml);

                if (!$result["data"] && empty($result["data"])) {
                    throw new \Exception("Falha ao Executar Operação, Dados Inválidos!");
                }
                $nacionalidade = $result["data"];
            }
            
            $brasileiro = $naturalizado = $estrangeiro = false;
            
            if (!$nacionalidade) {
                throw new \Exception("Falha ao Executar Operação, Dados Inválidos!!");
            }
            
            if (isset($nacionalidade["brasileiro"]) && $nacionalidade["brasileiro"]) {
                $brasileiro = true;
            } elseif (isset($nacionalidade["naturalizado"]) && $nacionalidade["naturalizado"]) {
                $naturalizado = true;
            } elseif (isset($nacionalidade["estrangeiro"]) && $nacionalidade["estrangeiro"]) {
                $estrangeiro = true;
            }
            
            if (!$pf) {
                if (($brasileiro || $naturalizado) && !$pesquisa_dados["filtro_cpf"]) {
                    throw new \Exception("Falha ao Executar Operação, Campo C.P.F. Não Informado!");
                } elseif (($brasileiro || $naturalizado) && !\Marabaixo\Util::validarCPF ($pesquisa_dados["filtro_cpf"])) {
                    throw new \Exception("Falha ao Executar Operação, Campo C.P.F. Não é Válido!");
                } elseif ($estrangeiro && !$pesquisa_dados["filtro_passaporte"]) {
                    throw new \Exception("Falha ao Executar Operação, Campos Passaporte Não Informados!");
                }

                if ($brasileiro || $naturalizado) {
                    $xml = $app->listarPessoaFisica(\Marabaixo\Util::array_to_xml(array("filtro_cpf" => $pesquisa_dados["filtro_cpf"])));

                    $result = \Marabaixo\Util::xml_to_array($xml);

                    if (isset($result["data"]) && !empty($result["data"])) {
                        $pfs = $result["data"];
                        if ($pfs && is_array($pfs) && !empty($pfs)) {
                            $pf = current($pfs);
                        }
                    }
                }
                if ($estrangeiro) {
                    $xml = $app->listarPessoaFisica(\Marabaixo\Util::array_to_xml(array("filtro_passaporte" => $pesquisa_dados["filtro_passaporte"])));

                    $result = \Marabaixo\Util::xml_to_array($xml);

                    if (isset($result["data"]) && !empty($result["data"])) {
                        $pfs = $result["data"];
                        if ($pfs && is_array($pfs) && !empty($pfs)) {
                            $pf = current($pfs);
                        }
                    }
                }
            }
            
            $dados = array("obj" => $pf);
            
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
            
            $app = $this->getServiceLocator()->get("AplicacaoFachada");
            $xml = $app->salvarPessoaFisica(\Marabaixo\Util::array_to_xml($pesquisa_dados));
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
