<?php

	/**
	* @package Net_EPP
	*/
	final class Response extends Frame {
		function __construct() {
			parent::__construct('response');
		}

		function code() {
			return $this->getElementsByTagName('result')->item(0)->getAttribute('code');
		}

		function message() {
			return $this->getElementsByTagName('msg')->item(0)->firstChild->textContent;
		}
	}
?>
