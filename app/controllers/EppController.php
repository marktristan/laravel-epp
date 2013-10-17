<?php

abstract class EppController extends BaseController {
  
  protected $epp;
  
  abstract protected function processEppRequest($request);
  
  public function __construct()
  {
    $this->epp = new EppClient();
    $host = Config::get('epp.host');
    $port = Config::get('epp.port');
    $timeout = Config::get('epp.timeout');
    $ssl = Config::get('epp.ssl');
    $context = null;
    
    if ($ssl && $host == '10.1.11.111') // for fred
    {
      $context = stream_context_create();
      stream_context_set_option($context, 'ssl', 'local_cert', '/etc/ssl/certs/fred.pem');
    }
    
    $this->epp->connect($host, $port, $timeout, $ssl, $context);
    
    $this->eppLogin();
  }
  
  public function postEpp()
  {
    $request = Input::get('request');
    return $this->processEppRequest($request);
  }
  
  private function eppLogin()
  {
    $frame = new Login();
    EppHelper::setParam($frame, 'clID', Input::get('registrar'));
    EppHelper::setParam($frame, 'pw', 'Qwerty123');
    EppHelper::setParam($frame, 'eppVersion', Config::get('epp.version'));
    EppHelper::setParam($frame, 'eppLang', Config::get('epp.lang'));
    EppHelper::addElement($frame, 'objURI', ObjectSpec::xmlns('domain'), $frame->svcs);
    EppHelper::addElement($frame, 'objURI', ObjectSpec::xmlns('contact'), $frame->svcs);
    EppHelper::addElement($frame, 'objURI', ObjectSpec::xmlns('host'), $frame->svcs);
    return $this->epp->request($frame->saveXML());
  }
  
}
