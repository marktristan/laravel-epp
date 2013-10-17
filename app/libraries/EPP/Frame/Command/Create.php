<?php

	/**
	* @package Net_EPP
	*/
	class Net_EPP_Frame_Command_Create extends EppCommand {

		function __construct($type) {
			$this->type = $type;
			parent::__construct('create', $type);
		}
	}
?>
