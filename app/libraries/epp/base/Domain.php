<?php

class Domain {

  public static function check($data)
  {
    $frame = new EppCommand('check', 'domain');

    if (is_array($data->handle))
    {
      foreach ($data->handle as $handle)
      {
        $frame->addObjectProperty('name', $handle);
      }
    }
    else
    {
      $frame->addObjectProperty('name', $data->handle);
    }

    return $frame->saveXML();
  }

  public static function info($data)
  {
    $frame = new EppCommand('info', 'domain');
    $frame->addObjectProperty('name', $data->handle);
    return $frame->saveXML();
  }

  public static function create($data)
  {
    $frame = new EppCommand('create', 'domain');
    $frame->addObjectProperty('name', $data->handle);
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

  public static function renew($data)
  {
    $frame = new EppCommand('renew', 'domain');
    $frame->addObjectProperty('name', $data->handle);
    $frame->addObjectProperty('curExpDate', $data->curExpDate);
    $frame->addObjectProperty('period', intval($data->period))->setAttribute('unit', 'y');
    return $frame->saveXML();
  }

  public static function update($data)
  {
    $frame = new EppCommand('update', 'domain');
    $frame->addObjectProperty('name', $data->handle);

    if (isset($data->add))
    {
      $addObj = $frame->addObjectProperty('add');

      if (isset($data->add->ns))
      {
        $nsObj = $frame->addObjectProperty('ns', NULL, $addObj);
        foreach ($data->add->ns as $hostObj)
        {
          $frame->addObjectProperty('hostObj', $hostObj, $nsObj);
        }
      }

      if (isset($data->add->contact))
      {
        foreach ($data->add->contact as $type => $handle)
        {
          $frame->addObjectProperty('contact', $handle, $addObj)->setAttribute('type', $type);
        }
      }

      if (isset($data->add->status))
      {
        foreach ($data->add->status as $s => $content)
        {
          $frame->addObjectProperty('status', $content, $addObj)->setAttribute('s', $s);
        }
      }
    }

    if (isset($data->rem))
    {
      $remObj = $frame->addObjectProperty('rem');

      if (isset($data->rem->ns))
      {
        $nsObj = $frame->addObjectProperty('ns', NULL, $remObj);
        foreach ($data->rem->ns as $hostObj)
        {
          $frame->addObjectProperty('hostObj', $hostObj, $nsObj);
        }
      }

      if (isset($data->rem->contact))
      {
        foreach ($data->rem->contact as $type => $handle)
        {
          $frame->addObjectProperty('contact', $handle, $remObj)->setAttribute('type', $type);
        }
      }

      if (isset($data->rem->status))
      {
        foreach ($data->rem->status as $s)
        {
          $frame->addObjectProperty('status', NULL, $remObj)->setAttribute('s', $s);
        }
      }
    }

    if (isset($data->chg))
    {
      $chgObj = $frame->addObjectProperty('chg');
      $frame->addObjectProperty('registrant', $data->chg->registrant, $chgObj);

      if (isset($data->chg->authInfo))
      {
        $authInfoObj = $frame->addObjectProperty('authInfo', NULL, $chgObj);
        $frame->addObjectProperty('pw', $data->chg->authInfo, $authInfoObj);
      }
    }

    return $frame->saveXML();
  }

  public static function delete($data)
  {
    $frame = new EppCommand('delete', 'domain');
    $frame->addObjectProperty('name', $data->handle);
    return $frame->saveXML();
  }

  public static function transfer($data)
  {
    $frame = new EppCommand('transfer', 'domain');
    $frame->command->setAttribute('op', $data->type);
    $frame->addObjectProperty('name', $data->handle);
    $frame->addObjectProperty('period', intval($data->period))->setAttribute('unit', 'y');

    if (isset($data->authInfo))
    {
      $authInfoObj = $frame->addObjectProperty('authInfo');
      $frame->addObjectProperty('pw', $data->authInfo, $authInfoObj);
    }

    return $frame->saveXML();
  }

}
