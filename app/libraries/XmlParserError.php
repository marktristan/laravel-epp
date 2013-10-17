<?php

/**
 * error class, replaces PEAR_Error
 *
 * An instance of this class will be returned
 * if an error occurs inside XML_Parser.
 *
 * There are three advantages over using the standard PEAR_Error:
 * - All messages will be prefixed
 * - check for XML_Parser error, using is_a( $error, 'XML_Parser_Error' )
 * - messages can be generated from the xml_parser resource
 *
 * @category  XML
 * @package   XML_Parser
 * @author    Stig Bakken <ssb@fast.no>
 * @author    Tomas V.V.Cox <cox@idecnet.com>
 * @author    Stephan Schmidt <schst@php.net>
 * @copyright 2002-2008 The PHP Group
 * @license   http://opensource.org/licenses/bsd-license New BSD License
 * @version   Release: @package_version@
 * @link      http://pear.php.net/package/XML_Parser
 * @see       PEAR_Error
 */
class XmlParserError extends PEAR_Error
{
    // {{{ properties

    /**
    * prefix for all messages
    *
    * @var      string
    */
    var $error_message_prefix = 'XmlParser: ';

    // }}}
    // {{{ constructor()
    /**
    * construct a new error instance
    *
    * You may either pass a message or an xml_parser resource as first
    * parameter. If a resource has been passed, the last error that
    * happened will be retrieved and returned.
    *
    * @param string|resource $msgorparser message or parser resource
    * @param integer         $code        error code
    * @param integer         $mode        error handling
    * @param integer         $level       error level
    *
    * @access   public
    * @todo PEAR CS - can't meet 85char line limit without arg refactoring
    */
    function XmlParserError($msgorparser = 'unknown error', $code = 0, $mode = PEAR_ERROR_RETURN, $level = E_USER_NOTICE)
    {
        if (is_resource($msgorparser)) {
            $code        = xml_get_error_code($msgorparser);
            $msgorparser = sprintf('%s at XML input line %d:%d',
                xml_error_string($code),
                xml_get_current_line_number($msgorparser),
                xml_get_current_column_number($msgorparser));
        }
        $this->PEAR_Error($msgorparser, $code, $mode, $level);
    }
    // }}}
}
