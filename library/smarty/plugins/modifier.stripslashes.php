<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage PluginsModifier
 */

/**
 * Smarty stripslashes modifier plugin
 * 
 * Type:     modifier<br>
 * Name:     stripslashes<br>
 * Purpose:  simple stripslashes
 * 
 * @author Thomas Efthyimiou
 * @param string $string  input string
 * @return string 
 */
function smarty_modifier_stripslashes($string)
{
    return stripslashes($string);
} 

?>