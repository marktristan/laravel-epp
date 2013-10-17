<?php

class EppHelper {
  
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
			return self::invalidRequest();
		}
    
		$uData = $unserializer->getUnserializedData();
    
    $fn = $method.'Parse';
    $result = self::$fn($uData);
    
    return Response::json($result);
  }
  
  private static function domainCheckParse($data)
  {
    $result = new stdClass();
    
    $result->code = $data->response->result->{'_attribute'}['code'];
    $result->msg = $data->response->result->msg;
    
    if (isset($data->response->resData))
    {
      $result->domain = $data->response->resData->{'domain:chkData'}->{'domain:cd'}->{'domain:name'}->_content;
      $result->avail = $data->response->resData->{'domain:chkData'}->{'domain:cd'}->{'domain:name'}->_attribute['avail'];
    }
    
    return $result;
  }
  
  private static function domainInfoParse($data)
  {
    $result = new stdClass();
    
    $result->code = $data->response->result->{'_attribute'}['code'];
    $result->msg = $data->response->result->msg;
    
    if (isset($data->response->resData))
    {
      $result->domain = $data->response->resData->{'domain:infData'}->{'domain:name'};
      $result->roid = $data->response->resData->{'domain:infData'}->{'domain:roid'};
      $result->raw = $data->response->resData->{'domain:infData'};
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
