<?php

defined('SYSPATH') or die('No direct script access.');

class Helper {



	public static function upper($texto) {

		return strtoupper(strtr($texto,"áéíóúâêôãõàèìòùç","ÁÉÍÓÚÂÊÔÃÕÀÈÌÒÙÇ"));

	}



	public static function orm_to_array($records, $id) {

		$return = array();

		foreach($records as $row)

			$return[] = $row->$id;

		return $return;

	}



	public static function is_cpf($cpf) {

		// Verifiva se o número digitado contém todos os digitos

		$cpf = str_pad(preg_replace('/[^0-9]/', '', $cpf), 11, '0', STR_PAD_LEFT);

		// Verifica se nenhuma das sequências abaixo foi digitada, caso seja, retorna falso

		if (strlen($cpf) != 11 || $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999') {

			return false;

		} else {

			// Calcula os números para verificar se o CPF é verdadeiro

			for ($t = 9; $t < 11; $t++) {

				for ($d = 0, $c = 0; $c < $t; $c++) {

					$d += $cpf{$c} * (($t + 1) - $c);

				}

				$d = ((10 * $d) % 11) % 10;

				if ($cpf{$c} != $d) {

					return false;

				}

			}

			return true;

		}

	}



	public static function is_cnpj($cnpj) {

		$cnpj     = preg_replace('/[^0-9]/', '', $cnpj);

		if(strlen($cnpj) <> 14){

			return false;

		}

		$sum1 = 0;

		$sum2 = 0;

		$sum3 = 0;

		$calc1 = 5;

		$calc2 = 6;



		for ($i=0; $i <= 12; $i++) {

			$calc1 = $calc1 < 2 ? 9 : $calc1;

			$calc2 = $calc2 < 2 ? 9 : $calc2;



			if ($i <= 11)

				$sum1 += $cnpj[$i] * $calc1;



			$sum2 += $cnpj[$i] * $calc2;

			$sum3 += $cnpj[$i];

			$calc1--;

			$calc2--;

		}



		$sum1 %= 11;

		$sum2 %= 11;



		return ($sum3 && $cnpj[12] == ($sum1 < 2 ? 0 : 11 - $sum1) && $cnpj[13] == ($sum2 < 2 ? 0 : 11 - $sum2)) ? $cnpj : false;

	}



	public static function onlyNumeric($string){

		return preg_replace('/[^0-9]/', '', $string);

	}



	public static function is_date($str){

		$stamp = strtotime($str);

		if (!is_numeric($stamp))

			return FALSE;

		//checkdate(month, day, year)

		if ( checkdate(date('m', $stamp), date('d', $stamp), date('Y', $stamp)) )

		{

			return TRUE;

		}

		return FALSE;

	}



	public static function format_date_db($date){

		try {

			$dt = explode("/", $date);

			return "$dt[2]-$dt[1]-$dt[0]";

		} catch(Exception $e){

			return false;

		}

	}



	public static function format_date($date){

		try {

			$dt = explode("-", $date);

			return "$dt[2]/$dt[1]/$dt[0]";

		} catch(Exception $e){

			return false;

		}

	}



	public static function format_timestamp($date, $format = 'd/m/Y'){

		try {

			$time = strtotime($date);

			return date($format, $time);

		} catch(Exception $e){

			return false;

		}

	}



	public static function format_date_to_mes($date){

		try {

			$dt = explode("-", $date);

			return "$dt[1]/$dt[0]";

		} catch(Exception $e){

			return false;

		}

	}



	public static function format_month_to_datedb($date){

		$datacompleta = Helper::format_date_db('01/'.$date);

		if( ! Valid::date($datacompleta)){

			return '0';

		} else {

			return $datacompleta;

		}

	}



	public static function format_cpf($cpf){

		return substr($cpf, 0,3).'.'.substr($cpf, 3,3).'.'.substr($cpf, 6,3).'-'.substr($cpf, 9,2);

	}



	public static function format_cnpj($cnpj){

		return substr($cnpj, 0,2).'.'.substr($cnpj, 2,3).'.'.substr($cnpj, 5,3).'/'.substr($cnpj, 8,4).'-'.substr($cnpj, 12,2);

	}



	public static function is_sexo($str){

		return ($str == 'F' or $str == 'M' or $str == 'O');

	}



	public static function arr_semana(){

		return array(1 => "Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado", "Domingo");

	}



	public static function number_format($number){

		return number_format($number, 2, ',', '.');

	}



	public static function number_format_invert($number){

		$number = Helper::onlyNumeric($number) / 100;

		return number_format($number, 2, '.', '');

	}



	public static function format_tel($tel){

		if(strlen($tel) == 12 or strlen($tel) == 13){

			return '+('.substr($tel, 0, 2).') ('.substr($tel, 2, 2).') '.substr($tel, 4, 4).'-'.substr($tel, 8);

		}

	}



	public static function hello()

	{

		$html = '';

		$cand = Session::instance()->get("talen_user", NULL);

		$cont = Session::instance()->get("contrat_user", NULL);

		if(!is_null($cand) AND $cand->id <> ""){

			$html = '<span class="txt-verde">'.__('Olá').', '.$cand->nome.'!</span><br />

			<span><a href="'.URL::site("candidato").'">'.__('Área Restrita').'</a> . <a href="'.URL::site("candidato/login/logout").'">'.ucfirst(__('sair')).'</a></span>';

		} elseif(!is_null($cont) AND $cont->id <> ""){

			$html = '<span class="txt-vermelho">'.__('Olá').', '.$cont->getNome().'!</span><br />

			<span><a href="'.URL::site("contratante").'">'.__('Área Restrita').'</a> . <a href="'.URL::site("contratante/login/logout").'">'.ucfirst(__('sair')).'</a></span>';

		}

		return $html;

	}



	public static function objectToArray($rows, $field){

		$arr = array();

		foreach($rows as $row){

			$arr[] = $row->$field;

		}

		return $arr;

	}



	public static function intToChar($i){

		$letras = array(

			1=>"a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z"

		);

		if(array_key_exists($i, $letras)){

			return $letras[$i];

		}

		return $i;

	}



	public static function isProfessorLogged(){

		$user = Session::instance()->get("talen_user", NULL);

		if(is_null($user)){

			return false;

		} elseif ($user->id == ""){

			return false;

		}

		return true;

	}



	public static function isEscolaLogged(){

		$user = Session::instance()->get("contrat_user", NULL);

		if(is_null($user)){

			return false;

		} elseif ($user->id == ""){

			return false;

		}

		return true;

	}



	public function geraSenha($min = 8, $max = 8){

		$pwd="";

		for($i=0;$i<rand($min,$max);$i++){

			$num=rand(48,122);

			if(($num > 97 && $num < 122)){

			 $pwd.=chr($num);

			}else if(($num > 65 && $num < 90)){

			 $pwd.=chr($num);

			}else if(($num >48 && $num < 57)){

			 $pwd.=chr($num);

			}else if($num==95){

			 $pwd.=chr($num);

			}else{

			 $i--;

			}

		}

		$lista_negada = array("1", "O", "l", "_");

		return strtoupper(str_replace($lista_negada,"@",$pwd));

	}

}