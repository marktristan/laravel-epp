<?php

	/**
	* @package Net_EPP
	*/
	class ObjectSpec {

		static $_spec = array(
			'domain' => array(
				'xmlns'		=> 'http://www.nic.cz/xml/epp/domain-1.4',
				'id'		=> 'name',
				'schema'	=> 'http://www.nic.cz/xml/epp/domain-1.4 domain-1.4.xsd',
			),
			'host' => array(
				'xmlns'		=> 'http://www.nic.cz/xml/epp/host-1.4',
				'id'		=> 'name',
				'schema'	=> 'http://www.nic.cz/xml/epp/host-1.4 host-1.4.xsd',
			),
			'contact' => array(
				'xmlns'		=> 'http://www.nic.cz/xml/epp/contact-1.4',
				'id'		=> 'id',
				'schema'	=> 'http://www.nic.cz/xml/epp/contact-1.4 contact-1.4.xsd',
			),
			'rgp' => array(
				'xmlns'		=> 'http://www.nic.cz/xml/epp/rgp-1.4',
				'id'		=> 'id',
				'schema'	=> 'http://www.nic.cz/xml/epp/rgp-1.4 rgp-1.4.xsd',
			),
		);

		static function id($object) {
			return self::$_spec[$object]['id'];
		}

		static function xmlns($object) {
			return self::$_spec[$object]['xmlns'];
		}

		static function schema($object) {
			return self::$_spec[$object]['schema'];
		}
	}
?>
