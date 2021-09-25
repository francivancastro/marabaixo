<?php

namespace DoctrineORMModule\Proxy\__CG__\Marabaixo\Seguranca\Dominio;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Arquivo extends \Marabaixo\Seguranca\Dominio\Arquivo implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = [];



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return ['__isInitialized__', '' . "\0" . 'Marabaixo\\Seguranca\\Dominio\\Arquivo' . "\0" . 'idArquivo', '' . "\0" . 'Marabaixo\\Seguranca\\Dominio\\Arquivo' . "\0" . 'legenda', '' . "\0" . 'Marabaixo\\Seguranca\\Dominio\\Arquivo' . "\0" . 'nomeOriginal', '' . "\0" . 'Marabaixo\\Seguranca\\Dominio\\Arquivo' . "\0" . 'tamanho', '' . "\0" . 'Marabaixo\\Seguranca\\Dominio\\Arquivo' . "\0" . 'dataUpload', '' . "\0" . 'Marabaixo\\Seguranca\\Dominio\\Arquivo' . "\0" . 'horaUpload', '' . "\0" . 'Marabaixo\\Seguranca\\Dominio\\Arquivo' . "\0" . 'arquivoTipo', '' . "\0" . 'Marabaixo\\Seguranca\\Dominio\\Arquivo' . "\0" . 'tmpFile', 'eventos', 'sm', 'em'];
        }

        return ['__isInitialized__', '' . "\0" . 'Marabaixo\\Seguranca\\Dominio\\Arquivo' . "\0" . 'idArquivo', '' . "\0" . 'Marabaixo\\Seguranca\\Dominio\\Arquivo' . "\0" . 'legenda', '' . "\0" . 'Marabaixo\\Seguranca\\Dominio\\Arquivo' . "\0" . 'nomeOriginal', '' . "\0" . 'Marabaixo\\Seguranca\\Dominio\\Arquivo' . "\0" . 'tamanho', '' . "\0" . 'Marabaixo\\Seguranca\\Dominio\\Arquivo' . "\0" . 'dataUpload', '' . "\0" . 'Marabaixo\\Seguranca\\Dominio\\Arquivo' . "\0" . 'horaUpload', '' . "\0" . 'Marabaixo\\Seguranca\\Dominio\\Arquivo' . "\0" . 'arquivoTipo', '' . "\0" . 'Marabaixo\\Seguranca\\Dominio\\Arquivo' . "\0" . 'tmpFile', 'eventos', 'sm', 'em'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Arquivo $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', []);
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', []);
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function getNomeOriginal()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNomeOriginal', []);

        return parent::getNomeOriginal();
    }

    /**
     * {@inheritDoc}
     */
    public function setNomeOriginal($nomeOriginal)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNomeOriginal', [$nomeOriginal]);

        return parent::setNomeOriginal($nomeOriginal);
    }

    /**
     * {@inheritDoc}
     */
    public function getTmpFile()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTmpFile', []);

        return parent::getTmpFile();
    }

    /**
     * {@inheritDoc}
     */
    public function setTmpFile(array $tmpFile)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTmpFile', [$tmpFile]);

        return parent::setTmpFile($tmpFile);
    }

    /**
     * {@inheritDoc}
     */
    public function setFromArray(array $dados)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFromArray', [$dados]);

        return parent::setFromArray($dados);
    }

    /**
     * {@inheritDoc}
     */
    public function getIdArquivo()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getIdArquivo();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIdArquivo', []);

        return parent::getIdArquivo();
    }

    /**
     * {@inheritDoc}
     */
    public function getLegenda()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLegenda', []);

        return parent::getLegenda();
    }

    /**
     * {@inheritDoc}
     */
    public function getTamanho()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTamanho', []);

        return parent::getTamanho();
    }

    /**
     * {@inheritDoc}
     */
    public function getDataUpload()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDataUpload', []);

        return parent::getDataUpload();
    }

    /**
     * {@inheritDoc}
     */
    public function getHoraUpload()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getHoraUpload', []);

        return parent::getHoraUpload();
    }

    /**
     * {@inheritDoc}
     */
    public function getArquivoTipo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getArquivoTipo', []);

        return parent::getArquivoTipo();
    }

    /**
     * {@inheritDoc}
     */
    public function setIdArquivo($idArquivo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIdArquivo', [$idArquivo]);

        return parent::setIdArquivo($idArquivo);
    }

    /**
     * {@inheritDoc}
     */
    public function setLegenda($legenda)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLegenda', [$legenda]);

        return parent::setLegenda($legenda);
    }

    /**
     * {@inheritDoc}
     */
    public function setTamanho($tamanho)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTamanho', [$tamanho]);

        return parent::setTamanho($tamanho);
    }

    /**
     * {@inheritDoc}
     */
    public function setDataUpload(\DateTime $dataUpload)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDataUpload', [$dataUpload]);

        return parent::setDataUpload($dataUpload);
    }

    /**
     * {@inheritDoc}
     */
    public function setHoraUpload(\DateTime $horaUpload)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setHoraUpload', [$horaUpload]);

        return parent::setHoraUpload($horaUpload);
    }

    /**
     * {@inheritDoc}
     */
    public function setArquivoTipo(\Marabaixo\Seguranca\Dominio\ArquivoTipo $arquivoTipo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setArquivoTipo', [$arquivoTipo]);

        return parent::setArquivoTipo($arquivoTipo);
    }

    /**
     * {@inheritDoc}
     */
    public function postPersist()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'postPersist', []);

        return parent::postPersist();
    }

    /**
     * {@inheritDoc}
     */
    public function getFilename()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFilename', []);

        return parent::getFilename();
    }

    /**
     * {@inheritDoc}
     */
    public function getWideImage()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getWideImage', []);

        return parent::getWideImage();
    }

    /**
     * {@inheritDoc}
     */
    public function resize($width, $height = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'resize', [$width, $height]);

        return parent::resize($width, $height);
    }

    /**
     * {@inheritDoc}
     */
    public function imagem()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'imagem', []);

        return parent::imagem();
    }

    /**
     * {@inheritDoc}
     */
    public function show(array $dados = array (
))
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'show', [$dados]);

        return parent::show($dados);
    }

    /**
     * {@inheritDoc}
     */
    public function toString()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'toString', []);

        return parent::toString();
    }

    /**
     * {@inheritDoc}
     */
    public function existe()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'existe', []);

        return parent::existe();
    }

    /**
     * {@inheritDoc}
     */
    public function toArray()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'toArray', []);

        return parent::toArray();
    }

    /**
     * {@inheritDoc}
     */
    public function html()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'html', []);

        return parent::html();
    }

    /**
     * {@inheritDoc}
     */
    public function persist()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'persist', []);

        return parent::persist();
    }

    /**
     * {@inheritDoc}
     */
    public function baixar()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'baixar', []);

        return parent::baixar();
    }

    /**
     * {@inheritDoc}
     */
    public function loadOriginal()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'loadOriginal', []);

        return parent::loadOriginal();
    }

    /**
     * {@inheritDoc}
     */
    public function init($event)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'init', [$event]);

        return parent::init($event);
    }

    /**
     * {@inheritDoc}
     */
    public function getOriginal()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getOriginal', []);

        return parent::getOriginal();
    }

    /**
     * {@inheritDoc}
     */
    public function setOriginal($original)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setOriginal', [$original]);

        return parent::setOriginal($original);
    }

    /**
     * {@inheritDoc}
     */
    public function getPrimaryKey()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPrimaryKey', []);

        return parent::getPrimaryKey();
    }

    /**
     * {@inheritDoc}
     */
    public function getId()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', []);

        return parent::getId();
    }

    /**
     * {@inheritDoc}
     */
    public function getRepository()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRepository', []);

        return parent::getRepository();
    }

    /**
     * {@inheritDoc}
     */
    public function findAll()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'findAll', []);

        return parent::findAll();
    }

    /**
     * {@inheritDoc}
     */
    public function getPorId($id)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPorId', [$id]);

        return parent::getPorId($id);
    }

    /**
     * {@inheritDoc}
     */
    public function getErrors()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getErrors', []);

        return parent::getErrors();
    }

    /**
     * {@inheritDoc}
     */
    public function getRemoveErrors()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRemoveErrors', []);

        return parent::getRemoveErrors();
    }

    /**
     * {@inheritDoc}
     */
    public function prePersist()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'prePersist', []);

        return parent::prePersist();
    }

    /**
     * {@inheritDoc}
     */
    public function getQuery($dados = array (
))
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getQuery', [$dados]);

        return parent::getQuery($dados);
    }

    /**
     * {@inheritDoc}
     */
    public function listar($dados = array (
))
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'listar', [$dados]);

        return parent::listar($dados);
    }

    /**
     * {@inheritDoc}
     */
    public function listarPorPagina($dados = array (
))
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'listarPorPagina', [$dados]);

        return parent::listarPorPagina($dados);
    }

    /**
     * {@inheritDoc}
     */
    public function registra_log_salvar()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'registra_log_salvar', []);

        return parent::registra_log_salvar();
    }

    /**
     * {@inheritDoc}
     */
    public function registra_log_excluir()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'registra_log_excluir', []);

        return parent::registra_log_excluir();
    }

    /**
     * {@inheritDoc}
     */
    public function remove()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'remove', []);

        return parent::remove();
    }

    /**
     * {@inheritDoc}
     */
    public function getObservador()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getObservador', []);

        return parent::getObservador();
    }

    /**
     * {@inheritDoc}
     */
    public function ativo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'ativo', []);

        return parent::ativo();
    }

    /**
     * {@inheritDoc}
     */
    public function getEventos()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEventos', []);

        return parent::getEventos();
    }

    /**
     * {@inheritDoc}
     */
    public function addObservador($evento, \Marabaixo\Abstrata\AbstractObservador $observador)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addObservador', [$evento, $observador]);

        return parent::addObservador($evento, $observador);
    }

    /**
     * {@inheritDoc}
     */
    public function getObservadores($evento)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getObservadores', [$evento]);

        return parent::getObservadores($evento);
    }

    /**
     * {@inheritDoc}
     */
    public function notificar($evento, $dados = array (
))
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'notificar', [$evento, $dados]);

        return parent::notificar($evento, $dados);
    }

    /**
     * {@inheritDoc}
     */
    public function set_em($em)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'set_em', [$em]);

        return parent::set_em($em);
    }

    /**
     * {@inheritDoc}
     */
    public function get_em()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'get_em', []);

        return parent::get_em();
    }

    /**
     * {@inheritDoc}
     */
    public function setServiceLocator(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setServiceLocator', [$serviceLocator]);

        return parent::setServiceLocator($serviceLocator);
    }

    /**
     * {@inheritDoc}
     */
    public function getServiceLocator()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getServiceLocator', []);

        return parent::getServiceLocator();
    }

}