<?php

class Domain {
  
  public static function check($data)
  {
    $frame = new EppCommand('check', 'domain');
    $frame->addObjectProperty('name', $data->name);
    return $frame->saveXML();
  }
  
  public static function info($data)
  {
    $frame = new EppCommand('info', 'domain');
    $frame->addObjectProperty('name', $data->name);
    return $frame->saveXML();
  }
  
  public static function create($data)
  {
    $frame = new EppCommand('create', 'domain');
    $frame->addObjectProperty('name', 'new-epp-domain.ph');
    $frame->addObjectProperty('period', 1)->setAttribute('unit', 'y');
    
    $ns = $frame->addObjectProperty('ns');
    $frame->addObjectProperty('hostObj', 'ns1.test.ph', $ns);
    $frame->addObjectProperty('hostObj', 'ns2.test.ph', $ns);
    
    $frame->addObjectProperty('registrant', 'sample-registrant');
    $frame->addObjectProperty('contact', 'sample-admin')->setAttribute('type', 'admin');
    $frame->addObjectProperty('contact', 'sample-billing')->setAttribute('type', 'billing');
    $frame->addObjectProperty('contact', 'sample-tech')->setAttribute('type', 'tech');
    
    $authInfo = $frame->addObjectProperty('authInfo');
    $frame->addObjectProperty('pw', 'test-authinfo', $authInfo);
    
    return $frame->saveXML();
  }
  
}
