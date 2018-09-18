<?php


function currencyMask($fmt)
{

	$len = 0;
	$fmt = "$fmt";
	$nfmt = "";

	for ($i = strlen($fmt)-1; $i>=0; $i--) {
		if ($len == 2) {
			$nfmt = "," . $nfmt;
		}
		else {
			if ($len > 2) {
				if ( (($len-2) % 3) == 0 ) {
					$nfmt = "." . $nfmt;
				}
			}
		}
		$nfmt = $fmt[$i] . $nfmt;
		$len++;
	}

	if (strlen($nfmt) <= 2) {
		$pre = "0,";
		if (strlen($nfmt) <=1)
			$pre .= "0";

		$nfmt = $pre . $nfmt;
	}
	return $nfmt;
}

function as_money($val) {

	return "R\$ " . currencyMask((int)$val);
}

function formataBaixa($cod_baixa)
{
	global $NomesCodigosBaixa;
	return $NomesCodigosBaixa[$cod_baixa];
}

// simple formating with masks; # represents a char from the string;
// anything else in the mask is outputed as-is;
function maskFormat($to_format, $mask)
{
	$i=0; $j=0; $res="";
	for ($i=0; ($i < strlen($mask)) && ($j <= strlen($to_format)); $i++) {
		if ($mask[$i] == '#') {
		    $res .= $to_format[$j++];
		}
		else {
			$res .= $mask[$i];
		}
	}
	return $res;
}

function formataCNPJ($cnpj)
{
	return maskFormat($cnpj, "##.###.###/####-##");
}

function formataCPF($cnpj)
{
	return maskFormat($cnpj, "###.###.###-##");
}

function formataCEP($cep) {
	$cep = sprintf("%08s", trim($cep));
	return maskFormat($cep, "#####-###");
}

function preparaMoeda($valor) {
	$v2 = preg_replace("/[.,]/", "",  $valor);

	if ($v2 == $valor)
		$v2  .="00";
	return $v2;
}

function preparaMoedaPagSeguro($valor) {
	$v2 = currencyMask($valor);
	$v2 = preg_replace("/[.]/", "-",  $v2);
	$v2 = preg_replace("/[,]/", ".",  $v2);
	$v2 = preg_replace("/[-]/", "",  $v2);
	return $v2;
}

function as_phone_number($valor){
	if (empty($valor)) {
		return "";
	}
	return maskFormat($valor, "(##) ####-####");
}

function data_javascript($valor){
	$date = explode("/", $valor);
	
	if($date[1]==0)
		return '';
	$date[1]--;
	$valor = (int)$date[2].",". (int) $date[1].",". (int) $date[0];
	return $valor;
}

?>