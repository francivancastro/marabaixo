<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'index',
                    ),
                ),
            ),
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'application' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '[]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Index',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:controller[/:action[/page[/:page]][/id[/:id]]]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                "action" => "index",
                            ),
                        ),
                    ),
                ),
            ),
            'arquivo' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/arquivo',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Arquivo',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '[/:action[/id[/:id]][/width[/:width]][/height[/:height]]]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                "id" => 0,
                                "width" => 0,
                                "height" => 0,
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    ),
    'translator' => array(
        'locale' => 'pt_BR',
        'translation_file_patterns' => array(
            array(
                'type' => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            /*
              APP
             */
            'Application\Controller\Index' => 'Application\Controller\IndexController',
            'Application\Controller\Auth' => 'Application\Controller\AuthController',
            'Application\Controller\Arquivo' => 'Application\Controller\ArquivoController',
            'Application\Controller\Componente' => 'Application\Controller\ComponenteController',
            'Application\Controller\Modulo' => 'Application\Controller\ModuloController',
            'Application\Controller\Grupo' => 'Application\Controller\GrupoController',
            'Application\Controller\Usuario' => 'Application\Controller\UsuarioController',
            'Application\Controller\Pessoafisica' => 'Application\Controller\PessoafisicaController',
            'Application\Controller\Pessoajuridica' => 'Application\Controller\PessoajuridicaController',
            'Application\Controller\Municipio' => 'Application\Controller\MunicipioController',
            'Application\Controller\Estadocivil' => 'Application\Controller\EstadocivilController',
            'Application\Controller\Bairro' => 'Application\Controller\BairroController',
            'Application\Controller\Config' => 'Application\Controller\ConfigController',
            'Application\Controller\Menu' => 'Application\Controller\MenuController',
            'Application\Controller\Icone' => 'Application\Controller\IconeController',
            'Application\Controller\Widget' => 'Application\Controller\WidgetController',
            'Application\Controller\Uf' => 'Application\Controller\UfController',
            'Application\Controller\Endereco' => 'Application\Controller\EnderecoController',
            'Application\Controller\Arquivotipo' => 'Application\Controller\ArquivotipoController',
            'Application\Controller\Observadortipo' => 'Application\Controller\ObservadortipoController',
            'Application\Controller\Observador' => 'Application\Controller\ObservadorController',
            'Application\Controller\Log' => 'Application\Controller\LogController',
            'Application\Controller\Email' => 'Application\Controller\EmailController',
            /*
             SAÚDE
             */
            'Application\Controller\Equipe' => 'Saude\Controller\EquipeController',
            'Application\Controller\Equipetipo' => 'Saude\Controller\EquipetipoController',
            'Application\Controller\Equipestatus' => 'Saude\Controller\EquipestatusController',
            'Application\Controller\Equipearea' => 'Saude\Controller\EquipeareaController',
            'Application\Controller\Equipezona' => 'Saude\Controller\EquipezonaController',
            'Application\Controller\Segmentoterritorial' => 'Saude\Controller\SegmentoterritorialController',
            'Application\Controller\Desativacaotipo' => 'Saude\Controller\DesativacaotipoController',
            'Application\Controller\Motivodesativacao' => 'Saude\Controller\MotivodesativacaoController',
            'Application\Controller\Populacaoassistida' => 'Saude\Controller\PopulacaoassistidaController',
            'Application\Controller\Regiao' => 'Saude\Controller\RegiaoController',
            'Application\Controller\Estabelecimentosaudetipo' => 'Saude\Controller\EstabelecimentosaudetipoController',
            'Application\Controller\Estabelecimentogestao' => 'Saude\Controller\EstabelecimentogestaoController',
            'Application\Controller\Estabelecimentosaude' => 'Saude\Controller\EstabelecimentosaudeController',
            'Application\Controller\Fornecedores' => 'Licitacao\Controller\FornecedoresController',
            'Application\Controller\Relatorio' => 'Licitacao\Controller\RelatorioController',
            'Application\Controller\Licitacao' => 'Licitacao\Controller\LicitacaoController',
           
            /* RECURSOS HUMANOS */
            'Application\Controller\Servidor' => 'Rh\Controller\ServidorController',
            'Application\Controller\Servidorclasse' => 'Rh\Controller\ServidorclasseController',
            'Application\Controller\Servidorcargo' => 'Rh\Controller\ServidorcargoController',
            'Application\Controller\Servidorfuncao' => 'Rh\Controller\ServidorfuncaoController',
            'Application\Controller\Servidorsituacao' => 'Rh\Controller\ServidorsituacaoController',
            'Application\Controller\Servidornivel' => 'Rh\Controller\ServidornivelController',
            'Application\Controller\Regimejuridico' => 'Rh\Controller\RegimejuridicoController',
            'Application\Controller\Orgao' => 'Rh\Controller\OrgaoController',            
            'Application\Controller\Servidorencaminhamento' => 'Rh\Controller\ServidorencaminhamentoController',
            'Application\Controller\Servidorencaminhamentotipo' => 'Rh\Controller\ServidorencaminhamentotipoController',
            'Application\Controller\Servidorrecebimento' => 'Rh\Controller\ServidorrecebimentoController',
           
            'Application\Controller\Servidorocorrenciatipo' => 'Rh\Controller\ServidorocorrenciatipoController',
            'Application\Controller\Servidorocorrencia' => 'Rh\Controller\ServidorocorrenciaController',
            
            
            'Application\Controller\Documentotipo' => 'Ged\Controller\DocumentotipoController',
            'Application\Controller\Documento' => 'Ged\Controller\DocumentoController',
            'Application\Controller\Documentocampotipo' => 'Ged\Controller\DocumentocampotipoController',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'layout/layoutsistema' => __DIR__ . '/../view/layout/layoutsistema.phtml',
            'layout/topo' => __DIR__ . '/../view/layout/topo.phtml',
            'layout/topologin' => __DIR__ . '/../view/layout/topologin.phtml',
            'layout/login' => __DIR__ . '/../view/layout/login.phtml',
            'layout/nlogin' => __DIR__ . '/../view/layout/nlogin.phtml',
            'layout/pagination' => __DIR__ . '/../view/layout/pagination.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
            'index/info_usuario' => __DIR__ . '/../view/application/index/partial/info_usuario.phtml',
            'index/mensagem' => __DIR__ . '/../view/application/index/partial/mensagem.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
