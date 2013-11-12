<?php

class Poll {
  
  public static function req()
  {
    $frame = new EppCommand('poll');
    $frame->command->setAttribute('op', 'req');
    return $frame->saveXML();
  }
  
  public static function ack($data)
  {
    $frame = new EppCommand('poll');
    $frame->command->setAttribute('op', 'ack');
    $frame->command->setAttribute('msgID', $data->msgID);
    return $frame->saveXML();
  }
  
}
