<?php

class Parser {
  
  public static function domainCheck($data)
  {
    $result = new stdClass();
    
    $result->code = $data->response->result->_attribute['code'];
    $result->msg = $data->response->result->msg;
    
    if (isset($data->response->resData))
    {
      $result->data = new stdClass();
      $resData = $data->response->resData->{'domain:chkData'}->{'domain:cd'};
      
      $result->data->domain = $resData->{'domain:name'}->_content;
      $result->data->avail = $resData->{'domain:name'}->_attribute['avail'];
    }
    
    return $result;
  }
  
  public static function domainInfo($data)
  {
    $result = new stdClass();
    
    $result->code = $data->response->result->_attribute['code'];
    $result->msg = $data->response->result->msg;
    
    if (isset($data->response->resData))
    {
      $result->data = new stdClass();
      $resData = $data->response->resData->{'domain:infData'};
      
      $result->data->domain = $resData->{'domain:name'};
      $result->data->roid = $resData->{'domain:roid'};
      
      $domainStatus = $resData->{'domain:status'};
      $status = array();
      if (is_array($domainStatus))
      {
        foreach ($domainStatus as $st)
        {
          $status[$st->_attribute['s']] = $st->_content;
        }
      }
      else
      {
        $status[$domainStatus->_attribute['s']] = $domainStatus->_content;
      }
      
      $result->data->status = $status;
      $result->data->registrant = $resData->{'domain:registrant'};
      
      if (isset($resData->{'domain:contact'}))
      {
        $contacts = array();
        if (is_array($resData->{'domain:contact'}))
        {
          foreach ($resData->{'domain:contact'} as $ct)
          {
            $contacts[$ct->_attribute['type']] = $ct->_content;
          }
        }
        else
        {
          $contacts[$resData->{'domain:contact'}->_attribute['type']] = $resData->{'domain:contact'}->_content;
        }
        
        $result->data->contact = $contacts;
      }
      
      if (isset($resData->{'domain:ns'}))
      {
        $result->data->ns = $resData->{'domain:ns'}->{'domain:hostObj'};
      }
      
      if (isset($resData->{'domain:host'}))
      {
        $result->data->host = $resData->{'domain:host'};
      }
      
      $result->data->clID = $resData->{'domain:clID'};
      $result->data->crID = $resData->{'domain:crID'};
      $result->data->crDate = $resData->{'domain:crDate'};
      
      if (isset($resData->{'domain:upID'}))
      {
        $result->data->upID = $resData->{'domain:upID'};
        $result->data->upDate = $resData->{'domain:upDate'};
      }
      
      $result->data->exDate = $resData->{'domain:exDate'};
      
      if (isset($resData->{'domain:authInfo'}->{'domain:pw'}))
      {
        $result->data->authInfo = $resData->{'domain:authInfo'}->{'domain:pw'};
      }
      else
      {
        $result->data->authInfo = $resData->{'domain:authInfo'};
      }
      
      if (isset($data->response->extension->{'rgp:infData'}->{'rgp:rgpStatus'}))
      {
        $rgpStatus = $data->response->extension->{'rgp:infData'}->{'rgp:rgpStatus'};
        $stats = array();
        if (is_array($rgpStatus))
        {
          foreach ($rgpStatus as $rgpSt)
          {
            $stats[] = $rgpSt->_attribute['s'];
          }
          
          $result->data->rgpStatus = $stats;
        }
        else
        {
          $result->data->rgpStatus = $rgpStatus->_attribute['s'];
        }
      }
    }
    
    return $result;
  }
  
  public static function domainCreate($data)
  {
    $result = new stdClass();
    
    $result->code = $data->response->result->_attribute['code'];
    $result->msg = $data->response->result->msg;
    
    return $result;
  }
  
}
