<?php

	/**
	* @package Net_EPP
	*/
	abstract class Net_EPP_Frame_Command_Transfer extends EppCommand {

		function __construct($type) {
			parent::__construct('transfer', $type);
		}

		function setObject($object) {
			$type = strtolower(str_replace(__CLASS__.'_', '', get_class($this)));
			foreach ($this->payload->childNodes as $child) $this->payload->removeChild($child);
			$this->payload->appendChild($this->createElementNS(
				ObjectSpec::xmlns($type),
				$type.':'.ObjectSpec::id($type),
				$object
			));
		}

		function setOp($op) {
			$this->command->setAttribute('op', $op);
		}

		function setAuthInfo($authInfo) {
			$el = $this->createObjectPropertyElement('authInfo');
			$el->appendChild($this->createObjectPropertyElement('pw'));
			$el->firstChild->appendChild($this->createTextNode($authInfo));
			$this->payload->appendChild($el);
		}
	}
?>
