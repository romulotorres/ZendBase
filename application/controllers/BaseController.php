<?php

class BaseController extends Zend_Controller_Action
{

    protected $_loggedUser;

    public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array())
    {
        parent::__construct($request, $response, $invokeArgs);
        $this->_initializeViewVariables();
    }

    protected final function _initializeViewVariables()
    {
        $this->view->loggedUser = Zend_Auth::getInstance()->getStorage()->read();
        $this->view->baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
    }

    protected function _allowProfiles($profiles)
    {
        $user = Zend_Auth::getInstance()->getStorage()->read();
        $this->_loggedUser = $user;
        if (is_array($profiles)) {
            foreach ($profiles as $profile) {
                if ($profile == $this->_loggedUser->profile_id) {
                    return true;
                }
            }
        } else {
            if ($profiles == $this->_loggedUser->profile_id) {
                return true;
            }
        }
        $this->_helper->flashMessenger('Você não tem Privilégios para acessar este conteúdo!');
        $this->_helper->redirector('index', 'index');
    }

    protected function _allowPremium()
    {
        $user = Zend_Auth::getInstance()->getStorage()->read();
        if ($user->profile_id == Service_Profile::ADMINISTRADOR) {
            return true;
        }
        
        if ($user->init_date == '') {
            $this->_helper->flashMessenger('Este conteúdo só pode ser acessado com uma conta ativa!');
            $this->_helper->redirector('perfil', 'user');
        }
    }

}

