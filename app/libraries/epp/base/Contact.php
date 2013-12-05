<?php

class Contact {
  
  public static function check($data)
  {
    $frame = new EppCommand('check', 'contact');
    
    if (is_array($data->handle))
    {
      foreach ($data->handle as $handle)
      {
        $frame->addObjectProperty('id', $handle);
      }
    }
    else
    {
      $frame->addObjectProperty('id', $data->handle);
    }
    
    return $frame->saveXML();
  }
  
  public static function info($data)
  {
    $frame = new EppCommand('info', 'contact');
    $frame->addObjectProperty('id', $data->handle);
    return $frame->saveXML();
  }
  
  public static function create($data)
  {
    $frame = new EppCommand('create', 'contact');
    $frame->addObjectProperty('id', $data->handle);
    
    if (isset($data->int))
    {
      $intObj = $frame->addObjectProperty('postalInfo');
      $intObj->setAttribute('type', 'int');
      $frame->addObjectProperty('name', $data->int->name, $intObj);
      
      if (isset($data->int->org))
      {
        $frame->addObjectProperty('org', $data->int->org, $intObj);
      }
      
      $addrObj = $frame->addObjectProperty('addr', NULL, $intObj);
      if (is_array($data->int->addr->street))
      {
        foreach ($data->int->addr->street as $st)
        {
          $frame->addObjectProperty('street', $st, $addrObj);
        }
      }
      
      $frame->addObjectProperty('city', $data->int->addr->city, $addrObj);
      $frame->addObjectProperty('sp', $data->int->addr->sp, $addrObj);
      $frame->addObjectProperty('pc', $data->int->addr->pc, $addrObj);
      $frame->addObjectProperty('cc', $data->int->addr->cc, $addrObj);
      
      $voiceObj = $frame->addObjectProperty('voice', $data->voice);
      if (isset($data->ext))
      {
        $voiceObj->setAttribute('x', $data->ext);
      }
      
      $frame->addObjectProperty('fax', $data->fax);
      $frame->addObjectProperty('email', $data->email);
      
      if (isset($data->authInfo))
      {
        $authInfoObj = $frame->addObjectProperty('authInfo');
        $frame->addObjectProperty('pw', $data->authInfo, $authInfoObj);
      }
    }
    
    return $frame->saveXML();
  }
  
  public static function update($data)
  {
    $frame = new EppCommand('update', 'contact');
    $frame->addObjectProperty('id', $data->handle);
    
    $chgObj = $frame->addObjectProperty('chg');
    
    if (isset($data->int))
    {
      $intObj = $frame->addObjectProperty('postalInfo', NULL, $chgObj);
      $intObj->setAttribute('type', 'int');
      $frame->addObjectProperty('name', $data->int->name, $intObj);
      
      if (isset($data->int->org))
      {
        $frame->addObjectProperty('org', $data->int->org, $intObj);
      }
      
      $addrObj = $frame->addObjectProperty('addr', NULL, $intObj);
      if (is_array($data->int->addr->street))
      {
        foreach ($data->int->addr->street as $st)
        {
          $frame->addObjectProperty('street', $st, $addrObj);
        }
      }
      
      $frame->addObjectProperty('city', $data->int->addr->city, $addrObj);
      $frame->addObjectProperty('sp', $data->int->addr->sp, $addrObj);
      $frame->addObjectProperty('pc', $data->int->addr->pc, $addrObj);
      $frame->addObjectProperty('cc', $data->int->addr->cc, $addrObj);
      
      $voiceObj = $frame->addObjectProperty('voice', $data->voice, $chgObj);
      if (isset($data->ext))
      {
        $voiceObj->setAttribute('x', $data->ext, $chgObj);
      }
      
      $frame->addObjectProperty('fax', $data->fax, $chgObj);
      $frame->addObjectProperty('email', $data->email, $chgObj);
    }
    
    return $frame->saveXML();
  }
  
}
