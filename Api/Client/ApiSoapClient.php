<?php
namespace Api\Client;

use Api\Client\Client;

class ApiSoapClient extends Client{

	protected $_client;
	protected $_session;
	
	public function __construct(){
	
		$this->_client = new \SoapClient("http://magento.dev/api/v2_soap/?wsdl=1", array('trace' => 1, 'cache_wsdl' => WSDL_CACHE_NONE));
		$this->connect();
	}
	
	public function setClient($client){
		$this->_client = $client;
		$this->connect();
	}

	protected function call($method,$args){
	
		$resp = false;

		try {
            $this->clearError();
			$resp = call_user_func_array(array($this->_client, $method), array_merge(array($this->_session), $args));
        } catch (\SoapFault $fault) {
            $this->setError(array('code'=>$fault->faultcode,'message'=>$fault->getMessage()));
        }
        return $resp;
	}
	
	protected function connect(){
		try {
            $this->clearError();
			$this->_session = $this->_client->login('frankleema', '123456');
		} catch (\SoapFault $fault) {
            $this->setError(array('code'=>$fault->faultcode,'message'=>$fault->getMessage()));
        }

	}
}