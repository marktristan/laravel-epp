<?php

class Epp {
  
  public static function setParam($frame, $param, $value)
  {
    $frame->$param->appendChild($frame->createTextNode($value));
  }
  
  public static function addElement($frame, $name, $value, $parentNode = null)
  {
    $element = $frame->createElement($name);
    $element->appendChild($frame->createTextNode($value));
    if (isset($parentNode)) $parentNode->appendChild($element);
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
    
    $result = Parser::$method($uData);
    
    return Response::json($result);
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
  
}
