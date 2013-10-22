<?php

	/**
	* @package Net_EPP
	*/
	class EppCommand extends Frame {

		function __construct($command, $type="") {
			$this->type = $type;
			$command = strtolower($command);
			if (!in_array($command, array('check', 'info', 'create', 'update', 'delete', 'renew', 'transfer', 'poll', 'login', 'logout'))) trigger_error("Invalid argument value '$command' for \$command", E_USER_ERROR);
			parent::__construct('command');

			$this->command = $this->createElement($command);
			$this->body->appendChild($this->command);

			if (!empty($this->type)) {
				$this->payload = $this->createElementNS(
					ObjectSpec::xmlns($this->type),
					$this->type.':'.$command
				);

				$this->command->appendChild($this->payload);
			}

			$this->clTRID = $this->createElement('clTRID');
			$this->clTRID->appendChild($this->createTextNode('EPP'.time())); // lets add value to this node, EPP-time()
			$this->body->appendChild($this->clTRID);
		}

		function addObjectProperty($name, $value=NULL, $parentNode=NULL) {
			$element = $this->createObjectPropertyElement($name);
			$this->payload->appendChild($element);

			if ($value instanceof DomNode) {
				$element->appendChild($value);
			} elseif (isset($value)) {
				$element->appendChild($this->createTextNode($value));
        if (isset($parentNode)) $parentNode->appendChild($element);
			}
			return $element;
		}

		function createObjectPropertyElement($name) {
			return $this->createElementNS(
				ObjectSpec::xmlns($this->type),
				$this->type.':'.$name
			);
		}

		function createExtensionElement($ext, $command) {
			$this->extension = $this->createElement('extension');
			$this->body->appendChild($this->extension);

			$this->extension->payload = $this->createElementNS(
				ObjectSpec::xmlns($ext),
				$ext.':'.$command
			);

			$this->extension->appendChild($this->extension->payload);
		}
	}
?>
