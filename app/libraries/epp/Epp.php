<?php

class Epp {
  
  public static $epp;
  
  public static function connect()
  {
    self::$epp = new EppClient();
    $registry = Config::get('epp.registry');
    $host = Config::get("epp.$registry.host");
    $port = Config::get("epp.$registry.port");
    $timeout = Config::get("epp.$registry.timeout");
    $ssl = Config::get("epp.$registry.ssl");
    $context = null;
    
    if ($registry == 'fred') // for fred
    {
      $context = stream_context_create();
      stream_context_set_option($context, 'ssl', 'local_cert', '/etc/ssl/certs/fred.pem');
    }
    
    self::$epp->connect($host, $port, $timeout, $ssl, $context);
    
    return self::$epp;
  }
  
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
  
  public static function login()
  {
    $registry = Config::get('epp.registry');
    
    $frame = new Login();
    Epp::setParam($frame, 'clID', Input::get('registrar'));
    Epp::setParam($frame, 'pw', Config::get("epp.$registry.pw"));
    Epp::setParam($frame, 'eppVersion', Config::get('epp.version'));
    Epp::setParam($frame, 'eppLang', Config::get('epp.lang'));
    Epp::addElement($frame, 'objURI', ObjectSpec::xmlns('domain'), $frame->svcs);
    Epp::addElement($frame, 'objURI', ObjectSpec::xmlns('contact'), $frame->svcs);
    Epp::addElement($frame, 'objURI', ObjectSpec::xmlns('host'), $frame->svcs);
    
    return Epp::$epp->request($frame->saveXML());
  }
  
  public static function logout()
  {
    $frame = new EppCommand('logout');
    return Epp::$epp->request($frame->saveXML());
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
