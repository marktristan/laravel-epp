<?php

  /**
  * @package Net_EPP
  */
  class ObjectSpec {

    static $_spec = array(
      'domain' => array(
        'xmlns' => 'urn:ietf:params:xml:ns:domain-1.0',
        'id' => 'name',
        'schema' => 'urn:ietf:params:xml:ns:domain-1.0 domain-1.0.xsd',
      ),
      'host' => array(
        'xmlns' => 'urn:ietf:params:xml:ns:host-1.0',
        'id' => 'name',
        'schema' => 'urn:ietf:params:xml:ns:host-1.0 host-1.0.xsd',
      ),
      'contact' => array(
        'xmlns' => 'urn:ietf:params:xml:ns:contact-1.0',
        'id' => 'id',
        'schema' => 'urn:ietf:params:xml:ns:contact-1.0 contact-1.0.xsd',
      ),
      'rgp' => array(
        'xmlns' => 'urn:ietf:params:xml:ns:rgp-1.0',
        'id' => 'id',
        'schema' => 'urn:ietf:params:xml:ns:rgp-1.0 rgp-1.0.xsd',
      ),
    );

    static $_specFred = array(
      'domain' => array(
        'xmlns' => 'http://www.nic.cz/xml/epp/domain-1.4',
        'id' => 'name',
        'schema' => 'http://www.nic.cz/xml/epp/domain-1.4 domain-1.4.xsd',
      ),
      'host' => array(
        'xmlns' => 'http://www.nic.cz/xml/epp/domain-1.4',
        'id' => 'name',
        'schema' => 'http://www.nic.cz/xml/epp/domain-1.4 domain-1.4.xsd',
      ),
      'contact' => array(
        'xmlns' => 'http://www.nic.cz/xml/epp/domain-1.4',
        'id' => 'id',
        'schema' => 'http://www.nic.cz/xml/epp/domain-1.4 domain-1.4.xsd',
      ),
      'rgp' => array(
        'xmlns' => 'http://www.nic.cz/xml/epp/domain-1.4',
        'id' => 'id',
        'schema' => 'http://www.nic.cz/xml/epp/domain-1.4 domain-1.4.xsd',
      ),
    );

    static function id($object) {
      if (Config::get('epp.registry') == 'fred')
      {
        return self::$_specFred[$object]['id'];
      }

      return self::$_spec[$object]['id'];
    }

    static function xmlns($object) {
      if (Config::get('epp.registry') == 'fred')
      {
        return self::$_specFred[$object]['xmlns'];
      }

      return self::$_spec[$object]['xmlns'];
    }

    static function schema($object) {
      if (Config::get('epp.registry') == 'fred')
      {
        return self::$_specFred[$object]['schema'];
      }

      return self::$_spec[$object]['schema'];
    }
  }
?>
