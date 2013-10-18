<?php

	/**
	* @package Net_EPP
	*/
	abstract class Net_EPP_Frame_Command_Check extends EppCommand {

		function __construct($type) {
			parent::__construct('check', $type);
		}

		function addObject($object) {
			$type = strtolower(str_replace(__CLASS__.'_', '', get_class($this)));
			$this->payload->appendChild($this->createElementNS(
				ObjectSpec::xmlns($type),
				$type.':'.ObjectSpec::id($type),
				$object
			));
		}

	}
?>
