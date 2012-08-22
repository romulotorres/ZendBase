<?php

class Plugin_FlashMessenger extends Zend_Controller_Plugin_Abstract
{
    /**
     * This method is executed after the action
     * 
     * We will "intercept" the requests and add the flashMessenger messages to the view object.
     * 
     * @link http://framework.zend.com/manual/en/zend.controller.action.html#zend.controller.action.prepostdispatch
     * @param Zend_Controller_Request_Abstract $request
     */
    public function postDispatch(Zend_Controller_Request_Abstract $request)
    {
        // Zend_Layout object
        $layout = Zend_Layout::getMvcInstance();
        
        // The Current View object
        $view = $layout->getView();
        
        // Flash Messenger plugin instance
        $flashMessenger = Zend_Controller_Action_HelperBroker::getStaticHelper('FlashMessenger');

        // Creates an empty messages array, if no message was defined so far
        if (!is_array($view->messages)) {
            $view->messages = array();
        }

        // Merge the already defined messages with the flashMessenger ones
        $messages = array_merge($view->messages, $flashMessenger->getMessages());

        // Sends the messages to the view
        $view->messages = $messages;
    }
}
