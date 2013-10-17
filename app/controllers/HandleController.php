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
    
    $frame = new EppCommand('check', 'domain');
    $frame->addObjectProperty('name', $data->name);
    $response = $this->epp->request($frame->saveXML());
    
    return EppHelper::unserialize($response, __FUNCTION__);
  }
  
  private function domainInfo($request)
  {
    $data = json_decode($request)->data;
    
    $frame = new EppCommand('info', 'domain');
    $frame->addObjectProperty('name', $data->name);
    $response = $this->epp->request($frame->saveXML());
    
    return EppHelper::unserialize($response, __FUNCTION__);
  }
  
}
