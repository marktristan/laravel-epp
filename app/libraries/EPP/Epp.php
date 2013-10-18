<?php

class Epp {
  
  public static function setParam($frame, $param, $value)
  {
    $frame->$param->appendChild($frame->createTextNode($value));
  }
  
  public static function addElement($frame, $name, $value, $parentNode)
  {
    $element = $frame->createElement($name);
    $element->appendChild($frame->createTextNode($value));
    $parentNode->appendChild($element);
  }
  
  public static function unserialize($packet, $method)
  {
    $opt = array(
      'complexType' => 'object',
      'contentName' => '_content',
      'parseAttributes' => true,
      'attributesArray' => '_attribute'
    );
    
    $unserializer = new XmlUnserializer($opt);
    
    $status = $unserializer->unserialize($packet);
		if ($unserializer->isError($status))
    {
			return Epp::invalidRequest();
		}
    
		$uData = $unserializer->getUnserializedData();
    
    $fn = $method.'Parse';
    $result = Epp::$fn($uData);
    
    return Response::json($result);
  }
  
  private static function domainCheckParse($data)
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
  
  private static function domainInfoParse($data)
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
      $result->data->ns = $resData->{'domain:ns'}->{'domain:hostObj'};
      
      if (isset($resData->{'domain:host'}))
      {
        $result->data->host = $resData->{'domain:host'};
      }
      
      $result->data->clID = $resData->{'domain:clID'};
      $result->data->crID = $resData->{'domain:crID'};
      $result->data->crDate = $resData->{'domain:crDate'};
      $result->data->upID = $resData->{'domain:upID'};
      $result->data->upDate = $resData->{'domain:upDate'};
      $result->data->exDate = $resData->{'domain:exDate'};
      $result->data->authInfo = $resData->{'domain:authInfo'}->{'domain:pw'};
      
      if (isset($data->response->extension->{'rgp:infData'}->{'rgp:rgpStatus'}))
      {
        $result->data->rgpStatus = $data->response->extension->{'rgp:infData'}->{'rgp:rgpStatus'}->_attribute['s'];
      }
    }
    
    return $result;
  }
  
  public static function invalidRequest()
  {
    $build = array(
      'code' => 2000,
      'msg' => 'Invalid request'
    );
    
    return Response::json($build, 400);
  }
  
  public static function undefinedMethod()
  {
    $build = array(
      'code' => 2000,
      'msg' => 'Undefined method'
    );
    
    return Response::json($build, 400);
  }
  
  public static function notAuthorized()
  {
    $build = array(
      'code' => 2000,
      'msg' => 'Not authorized'
    );
    
    return Response::json($build, 403);
  }
  
}
