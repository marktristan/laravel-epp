<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}
  
  /**
   * Handles undefined methods
   * 
   * @return string
   */
  public function missingMethod($parameters)
  {
    return Epp::undefinedMethod();
  }

}
