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
    $frame->addObjectProperty('name', $data->name);
    $frame->addObjectProperty('period', intval($data->period))->setAttribute('unit', 'y');
    
    if (isset($data->ns))
    {
      $nsObj = $frame->addObjectProperty('ns');
      foreach ($data->ns as $hostObj)
      {
        $frame->addObjectProperty('hostObj', $hostObj, $nsObj);
      }
    }
    
    $frame->addObjectProperty('registrant', $data->registrant);
    
    if (isset($data->contact))
    {
      foreach ($data->contact as $type => $handle)
      {
        $frame->addObjectProperty('contact', $handle)->setAttribute('type', $type);
      }
    }
    
    if (isset($data->authInfo))
    {
      $authInfoObj = $frame->addObjectProperty('authInfo');
      $frame->addObjectProperty('pw', $data->authInfo, $authInfoObj);
    }
    
    return $frame->saveXML();
  }
  
}
