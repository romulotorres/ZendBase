<?php

/**
 * Sets up the Application
 * 
 * @author Rômulo Torres
 * @package base_application
 * @since 2012-06-23
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    protected function _initAppAutoload()
    {
        Zend_Loader::loadClass('BaseController', APPLICATION_PATH . '/controllers');

        $autoloader = new Zend_Application_Module_Autoloader(array(
                    'namespace' => '',
                    'basePath' => dirname(__FILE__),
                ));

        return $autoloader;
    }
    /**
     * Returns the View Object
     * 
     * @return Zend_View
     */
    private function _getView()
    {
        $this->bootstrap('view');
        return $this->getResource('view');
    }

    /**
     * Returns the base URL for the application
     * 
     * At this point, Zend doesn't know the baseUrl - yet.
     * 
     * @return string
     */
    private function _getBaseUrl()
    {
        $baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
        if (!$baseUrl) {
            $baseUrl = rtrim(preg_replace('/([^\/]*)$/', '', $_SERVER['PHP_SELF']), '/\\');
        }

        return $baseUrl;
    }

    /**
     * Sets up the application's Doctype
     */
    protected function _initDoctype()
    {
        $view = $this->_getView();
        $view->doctype(Zend_View_Helper_Doctype::HTML5);
    }

    /**
     * Initializes the Controller Plugins
     */
    protected function _initPlugins()
    {
        // We're getting the Front Controller here
        $front = Zend_Controller_Front::getInstance();

        // The plugins need to be registered with the Front Controller - or else they'll just be ignored
        $front->registerPlugin(new Plugin_Auth());
        $front->registerPlugin(new Plugin_FlashMessenger());
        
    }

    protected function _initNavigationConfig()
    {
        // Nome do Arquivo
        $filename = realpath(APPLICATION_PATH . '/configs/navigation.xml');
        // Carregamento de Configuração
        $config = new Zend_Config_Xml($filename);
 
        // Registrar Camada de Visualização
        $this->registerPluginResource('view');
        // Inicialização da Camada
        $view = $this->bootstrap('view')->getResource('view');
 
        // Captura do Auxiliar de Navegação
        $navigation = $view->navigation();
        // Incluir Conteúdo
        $navigation->addPages($config);
    }

}