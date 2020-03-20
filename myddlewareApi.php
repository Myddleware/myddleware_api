<?php

class myddlewareApi {
	
	protected $token;
	protected $url;
	
	public function __construct($url) {
		$this->url = $url;
	}
	
	public function login($login, $password) {
		try {

			// Buid parameter for login call
			$login_paramaters = array( 
					'username' => $login, 
					'password' => $password
			); 

			// Login to Myddleware
			$result = $this->call('login_check', $login_paramaters); 
			// Manage results
			if($result != false) {
				if (empty($result->token) ) {
				   throw new \Exception($result->message);
				}
				else {
					$return['success'] = true;
					$return['token'] = $result->token;
					$this->token = $result->token;
				}				
			}
			else {
				throw new \Exception('Failed to connect to Myddleware.');
			}
		} 
		catch (\Exception $e) {
			$return['success'] = false;
			$return['message'] = $e->getMessage();
		} 		
		return $return;
	}
	
	
	public function call($method, $parameters){
		try {
			$data_string = json_encode($parameters);                                                                                   																															 
			$ch = curl_init($this->url.$method);                                                                      
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
			// Login call
			if (empty($this->token)) {
				curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($parameters));                                                                  
				$headers[] = 'Content-Type: application/json';
				$headers[] = 'Content-Length: '.strlen($data_string);
			// Other calls
			} else {
				curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);                                                                  
				$headers[] = 'Authorization: Bearer '.$this->token;
			}
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 				
			$result = curl_exec($ch);	
			if (!empty($result)) {
				$response = json_decode($result);			
				return $response;
			}
		}
		catch(\Exception $e) {
			return array('error' => true, 'message' => $e->getMessage());	
		}	
		return false;	
	}
}