<?php

class Parser {
  
  public static function pollReq($data)
  {
    $result = new stdClass();
    
    $result->code = $data->response->result->_attribute['code'];
    $result->msg = $data->response->result->msg;
    
    if (isset($data->response->msgQ))
    {
      $result->data = new stdClass();
      $msgQ = $data->response->msgQ;
      
      $result->data->count = $msgQ->_attribute['count'];
      $result->data->id = $msgQ->_attribute['id'];
      $result->data->qDate = $msgQ->qDate;
      
      if (strpos($msgQ->msg->_content, '<![CDATA[') == 0)
      {
        $result->data->msg = Epp::unserialize($msgQ->msg->_content);
      }
      else
      {
        $result->data->msg = $msgQ->msg->_content;
      }
    }
    
    return $result;
  }
  
  public static function pollAck($data)
  {
    $result = new stdClass();
    
    $result->code = $data->response->result->_attribute['code'];
    $result->msg = $data->response->result->msg;
    
    return $result;
  }
  
  public static function domainCheck($data)
  {
    $result = new stdClass();
    
    $result->code = $data->response->result->_attribute['code'];
    $result->msg = $data->response->result->msg;
    
    if (isset($data->response->resData))
    {
      $result->data = new stdClass();
      $resData = $data->response->resData->{'domain:chkData'}->{'domain:cd'};
      
      if (is_array($resData))
      {
        $resTmp = array();
        foreach ($resData as $res)
        {
          $resTmp[] = array(
            'domain' => $res->{'domain:name'}->_content,
            'avail' => $res->{'domain:name'}->_attribute['avail']
          );
        }
        
        $result->data = $resTmp;
      }
      else
      {
        $result->data->domain = $resData->{'domain:name'}->_content;
        $result->data->avail = $resData->{'domain:name'}->_attribute['avail'];
      }
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
        if (isset($domainStatus->_content))
        {
          $content = $domainStatus->_content;
        }
        else
        {
          $content = $domainStatus->_attribute['s'];
        }
        
        $status[$domainStatus->_attribute['s']] = $content;
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
    
    if (isset($data->response->resData))
    {
      $result->data = new stdClass();
      $resData = $data->response->resData->{'domain:creData'};
      
      $result->data->name = $resData->{'domain:name'};
      $result->data->crDate = $resData->{'domain:crDate'};
      $result->data->exDate = $resData->{'domain:exDate'};
    }
    
    return $result;
  }
  
  public static function domainRenew($data)
  {
    $result = new stdClass();
    
    $result->code = $data->response->result->_attribute['code'];
    $result->msg = $data->response->result->msg;
    
    if (isset($data->response->resData))
    {
      $result->data = new stdClass();
      $resData = $data->response->resData->{'domain:renData'};
      
      $result->data->name = $resData->{'domain:name'};
      $result->data->exDate = $resData->{'domain:exDate'};
    }
    
    return $result;
  }
  
  public static function domainUpdate($data)
  {
    $result = new stdClass();
    
    $result->code = $data->response->result->_attribute['code'];
    $result->msg = $data->response->result->msg;
    
    return $result;
  }
  
  public static function contactCheck($data)
  {
    $result = new stdClass();
    
    $result->code = $data->response->result->_attribute['code'];
    $result->msg = $data->response->result->msg;
    
    if (isset($data->response->resData))
    {
      $result->data = new stdClass();
      $resData = $data->response->resData->{'contact:chkData'}->{'contact:cd'};
      
      if (is_array($resData))
      {
        $resTmp = array();
        foreach ($resData as $res)
        {
          $resTmp[] = array(
            'contact' => $res->{'contact:id'}->_content,
            'avail' => $res->{'contact:id'}->_attribute['avail']
          );
        }
        
        $result->data = $resTmp;
      }
      else
      {
        $result->data->contact = $resData->{'contact:id'}->_content;
        $result->data->avail = $resData->{'contact:id'}->_attribute['avail'];
      }
    }
    
    return $result;
  }
  
  public static function contactInfo($data)
  {
    $result = new stdClass();
    
    $result->code = $data->response->result->_attribute['code'];
    $result->msg = $data->response->result->msg;
    
    if (isset($data->response->resData))
    {
      $result->data = new stdClass();
      $resData = $data->response->resData->{'contact:infData'};
      
      $result->data->id = $resData->{'contact:id'};
      $result->data->roid = $resData->{'contact:roid'};
      
      $contactStatus = $resData->{'contact:status'};
      $status = array();
      if (is_array($contactStatus))
      {
        foreach ($contactStatus as $st)
        {
          $status[$st->_attribute['s']] = $st->_content;
        }
      }
      else
      {
        if (isset($contactStatus->_content))
        {
          $content = $contactStatus->_content;
        }
        else
        {
          $content = $contactStatus->_attribute['s'];
        }
        
        $status[$contactStatus->_attribute['s']] = $content;
      }
      
      $result->data->status = $status;
      
      $postalInfo = $resData->{'contact:postalInfo'};
      $address = array();
      if (is_array($postalInfo))
      {
        foreach ($postalInfo as $pi)
        {
          $address[$pi->_attribute['type']]['name'] = $pi->{'contact:name'};
          
          if (isset($pi->{'contact:org'}))
          {
            $address[$pi->_attribute['type']]['org'] = $pi->{'contact:org'};
          }
          
          $street = $pi->{'contact:addr'}->{'contact:street'};
          $tmpStreet = array();
          if (is_array($street))
          {
            foreach ($street as $st)
            {
              $tmpStreet['street'][] = $st;
            }
            
            $address[$pi->_attribute['type']]['addr'] = $tmpStreet;
          }
          else
          {
            $address[$pi->_attribute['type']]['addr']['street'] = $street;
          }
          
          $address[$pi->_attribute['type']]['addr']['city'] = $pi->{'contact:addr'}->{'contact:city'};
          
          if (isset($pi->{'contact:addr'}->{'contact:sp'}))
          {
            $address[$pi->_attribute['type']]['addr']['sp'] = $pi->{'contact:addr'}->{'contact:sp'};
          }
          
          if (isset($pi->{'contact:addr'}->{'contact:pc'}))
          {
            $address[$pi->_attribute['type']]['addr']['pc'] = $pi->{'contact:addr'}->{'contact:pc'};
          }
          
          $address[$pi->_attribute['type']]['addr']['cc'] = $pi->{'contact:addr'}->{'contact:cc'};
        }
      }
      else
      {
        $address[$postalInfo->_attribute['type']]['name'] = $postalInfo->{'contact:name'};
        
        if (isset($postalInfo->{'contact:org'}))
        {
          $address[$postalInfo->_attribute['type']]['org'] = $postalInfo->{'contact:org'};
        }
        
        $street = $postalInfo->{'contact:addr'}->{'contact:street'};
        $tmpStreet = array();
        if (is_array($street))
        {
          foreach ($street as $st)
          {
            $tmpStreet['street'][] = $st;
          }
          
          $address[$postalInfo->_attribute['type']]['addr'] = $tmpStreet;
        }
        else
        {
          $address[$postalInfo->_attribute['type']]['addr']['street'] = $street;
        }
        
        $address[$postalInfo->_attribute['type']]['addr']['city'] = $postalInfo->{'contact:addr'}->{'contact:city'};
        
        if (isset($postalInfo->{'contact:addr'}->{'contact:sp'}))
        {
          $address[$postalInfo->_attribute['type']]['addr']['sp'] = $postalInfo->{'contact:addr'}->{'contact:sp'};
        }
        
        if (isset($postalInfo->{'contact:addr'}->{'contact:pc'}))
        {
          $address[$postalInfo->_attribute['type']]['addr']['pc'] = $postalInfo->{'contact:addr'}->{'contact:pc'};
        }
        
        $address[$postalInfo->_attribute['type']]['addr']['cc'] = $postalInfo->{'contact:addr'}->{'contact:cc'};
      }
      
      $result->data->postalInfo = $address;
      $result->data->voice = $resData->{'contact:voice'};
      
      if (isset($resData->{'contact:fax'}))
      {
        $result->data->fax = $resData->{'contact:fax'};
      }
      
      $result->data->email = $resData->{'contact:email'};
      $result->data->clID = $resData->{'contact:clID'};
      $result->data->crID = $resData->{'contact:crID'};
      $result->data->crDate = $resData->{'contact:crDate'};
      
      if (isset($resData->{'contact:upID'}))
      {
        $result->data->upID = $resData->{'contact:upID'};
        $result->data->upDate = $resData->{'contact:upDate'};
      }
    }
    
    return $result;
  }
  
}
