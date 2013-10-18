<?php

class HandleController extends EppController {
  
  public function processEppRequest($request)
  {
    $req = json_decode($request);
    $method = camel_case($req->method);
    return $this->$method($request);
  }
  
  private function domainCheck($request)
  {
    $data = json_decode($request)->data;
    
    $response = $this->epp->request(Domain::check($data));
    
    return Epp::unserialize($response, __FUNCTION__);
  }
  
  private function domainInfo($request)
  {
    $data = json_decode($request)->data;
    
    $response = $this->epp->request(Domain::info($data));
    
    return Epp::unserialize($response, __FUNCTION__);
  }
  
  private function domainCreate($request)
  {
    $data = json_decode($request)->data;
    
    //$response = $this->epp->request(Domain::create($data));
    return Domain::create($data);
    //return Epp::unserialize($response, __FUNCTION__);
  }
  
}
