<?php

	/**
	* @package Net_EPP
	*/
	final class Greeting extends Frame {
		function __construct() {
			parent::__construct('greeting');

			$this->svID = $this->createElement('svID');
			$this->body->appendChild($this->svID);

			$this->svDate = $this->createElement('svDate');
			$this->body->appendChild($this->svDate);

			$this->svcMenu = $this->createElement('svcMenu');
			$this->body->appendChild($this->svcMenu);

			$this->dcp = $this->createElement('dcp');
			$this->body->appendChild($this->dcp);

		}
	}
?>
