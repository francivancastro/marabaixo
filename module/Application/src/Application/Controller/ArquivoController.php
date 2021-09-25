<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;

class ArquivoController extends \Marabaixo\Controller\DefaultController{
    
    public function viewAction() {
        $id_arquivo = $this->params("id");
        $width = $this->params("width");
        $height = $this->params("height");
        if (!$id_arquivo) {
            $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação!");
            $this->redirect("application", array("controller" => "index", "action" => "index"));
        }
        $dados = array("id_arquivo" => $id_arquivo);
        if ($width) { $dados["width"] = $width; }
        if ($height) { $dados["height"] = $height; }
        $app = $this->getServiceLocator()->get("AplicacaoFachada");
        $app->showArquivo(\Marabaixo\Util::array_to_xml($dados));
        
    }
    
    public function uploadAction() {
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
            $files = $request->getFiles();
            
            $dados_post = array_merge($post->toArray(), $files->toArray());
            
            if (isset($dados_post["id"])) {
                unset($dados_post["id"]);
            }
            
            $xml = $app->salvarArquivo(\Marabaixo\Util::array_to_xml($dados_post));
            $dados = \Marabaixo\Util::xml_to_array($xml);
            
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
            
            $sl = $this->getServiceLocator();
            
            if (!$sl) {
                throw new \Exception("Falha ao Carregar Sistema!");
            }
            
            $app = $sl->get("AplicacaoFachada");
            
            if (!$app) {
                throw new \Exception("Falha ao Carregar Sistema!");
            }

            $id = $request->getPost("id");
            if (!$id) {
                throw new \Exception("Falha ao Carregar Arquivo, Nenhum Registro Localizado!");
            }
            
            $xml = $app->getInfoArquivo(\Marabaixo\Util::array_to_xml(array("id" => $id)));
            $dados = \Marabaixo\Util::xml_to_array($xml);
            
        } catch (\Exception $ex) {
            $dados["errors"] = $ex->getMessage();
        }
        
        $response->setContent(\Zend\Json\Json::encode($dados));
        
        return $response;
    }
    
    public function baixarAction() {
        $id_arquivo = $this->params("id");
        if (!$id_arquivo) {
            $this->flashMessenger()->addErrorMessage("Falha ao Executar Operação!");
            $this->redirect("application", array("controller" => "index", "action" => "index"));
        }
        $app = $this->getServiceLocator()->get("AplicacaoFachada");
        $app->baixarArquivo(array("id" => $id_arquivo));
    }
}