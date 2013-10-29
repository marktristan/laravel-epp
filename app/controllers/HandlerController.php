<?php

class HandlerController extends EppController {
  
  public function processEppRequest($request)
  {
    $req = json_decode($request);
    $method = camel_case($req->method);
    return $this->$method($request);
  }
  
  private function pollReq($request)
  {
    $response = Epp::$epp->request(Poll::req());
    return $response;
    //return Epp::unserialize($response, __FUNCTION__);
  }
  
  private function domainCheck($request)
  {
    $data = json_decode($request)->data;
    
    $response = Epp::$epp->request(Domain::check($data));
    
    return Epp::unserialize($response, __FUNCTION__);
  }
  
  private function domainInfo($request)
  {
    $data = json_decode($request)->data;
    
    $response = Epp::$epp->request(Domain::info($data));
    
    return Epp::unserialize($response, __FUNCTION__);
  }
  
  private function domainCreate($request)
  {
    $data = json_decode($request)->data;
    
    $response = Epp::$epp->request(Domain::create($data));
    
    return Epp::unserialize($response, __FUNCTION__);
  }
  
  private function contactCheck($request)
  {
    $data = json_decode($request)->data;
    
    $response = Epp::$epp->request(Contact::check($data));
    
    return Epp::unserialize($response, __FUNCTION__);
  }
  
  private function contactInfo($request)
  {
    $data = json_decode($request)->data;
    
    $response = Epp::$epp->request(Contact::info($data));
    
    return Epp::unserialize($response, __FUNCTION__);
  }
  
}
