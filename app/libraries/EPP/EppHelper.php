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
  
}
