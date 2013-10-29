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
  
}
