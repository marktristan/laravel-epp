<?php

abstract class EppController extends BaseController {
  
  abstract protected function processEppRequest($request);
  
  public function getEppTest()
  {
    $domains = array('local-address1.ph', 'heisenberg.ph', 'premierwine.com.ph', 'joren1.ph', 'cartier.com.ph');
    $picker = array_rand($domains);
    $request = '{"method":"domain_info","data":{"handle":"'. $domains[$picker] .'"}}';
    return $this->processEppRequest($request);
  }
  
  public function postEpp()
  {
    $request = Input::get('request');
    return $this->processEppRequest($request);
  }
  
  public function eppBenchmark()
  {
    $domains = array('local-address1.ph', 'heisenberg.ph', 'premierwine.com.ph', 'joren1.ph', 'cartier.com.ph');
    $picker = array_rand($domains);
    $request = '{"method":"domain_info","data":{"handle":"'. $domains[$picker] .'"}}';
    return $this->processEppRequest($request);
  }
  
}
