<?php if (!defined('ALLOW_PAGSEGURO_CONFIG')) { die('No direct script access allowed'); }
/*
************************************************************************
PagSeguro Config File
************************************************************************
//$PagSeguroConfig['credentials']['email'] = "comercial@vgt.com.br";
//$PagSeguroConfig['credentials']['token'] = "94886DF76C8945328B4072FBF8BCD92E";
*/

$PagSeguroConfig = array();

$PagSeguroConfig['environment'] = Array();
$PagSeguroConfig['environment']['environment'] = "production";

$PagSeguroConfig['credentials'] = Array();
$PagSeguroConfig['credentials']['email'] = "conrado@profcerto.com.br";
$PagSeguroConfig['credentials']['token'] = "8F8AA2E3A5D94E209293FF90C5B1062F";

$PagSeguroConfig['application'] = Array();
$PagSeguroConfig['application']['charset'] = "UTF-8"; // UTF-8, ISO-8859-1

$PagSeguroConfig['log'] = Array();
$PagSeguroConfig['log']['active'] = TRUE;
$PagSeguroConfig['log']['fileLocation'] = "";

?>