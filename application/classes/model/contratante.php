<?php defined('SYSPATH') or die('No direct access allowed.');



class Model_Contratante extends ORM {



	protected $_table_name = 'contratante';

	protected $_primary_key = 'id';



	protected $table_columns = array (

		'id' 					=> 	array('type'=>'int'),

		'email'			=> 	array('type'=>'string'),

		'senha'			=> 	array('type'=>'string'),

		'senhatxt'			=> 	array('type'=>'string'),

		'tppessoa'		=> 	array('type'=>'string'),

		'endereco'		=> 	array('type'=>'string'),

		'numero'		=> 	array('type'=>'string'),

		'compl'			=> 	array('type'=>'string'),

		'bairro'		=> 	array('type'=>'string'),

		'cidade_id'		=> 	array('type'=>'int'),

		'estado_id'		=> 	array('type'=>'int'),

		'cep'			=> 	array('type'=>'string'),

		'conveniado'	=> 	array('type'=>'boolean'),

        'comoconheceu'  =>  array('type'=>'string')

	);



	protected $_has_many = array(

		'vagas' => array(

			'model'   => 'vaga',

			'foreign_key' => 'contratante_id',

		),

		'conveniados' => array(

			'model'   => 'candidato',

			'foreign_key' => 'conveniado_id',

		),

	);



	protected $_has_one = array(

		'contratantepf' => array(

			'model'       => 'contratantepf',

			'foreign_key' => 'contratante_id',

		),

		'contratantepj' => array(

			'model'       => 'contratantepj',

			'foreign_key' => 'contratante_id',

		),

		'conta' => array(

			'model'       => 'conta',

			'foreign_key' => 'contratante_id',

		),

	);



	protected $_belongs_to = array(

		'cidade' => array('model' => 'cidade', 'foreign_key' => 'cidade_id'),

		'estado' => array('model' => 'estado', 'foreign_key' => 'estado_id'),

	);



	public function filters()

	{

		return array(

			TRUE => array( array('trim') ),

			'email' => array( array('strtolower') ),

			'senha' => array(array( array($this, 'hash_password') )),

		);

	}



	public function rules()

	{

		return array(

			'email' => array(

				array('not_empty'),

				array('max_length', array(':value', 120)),

				array('email'),

				array(array($this, 'email_available')),

			),

			'senha' => array(

				array('not_empty'),

			),

			'endereco' => array(

				array('not_empty'),

				array('min_length', array(':value', 3)),

			),

			'numero' => array(

				array('not_empty'),

			),

			'bairro' => array(

				array('not_empty'),

			),

			'cidade_id' => array(

				array('not_empty'),

			),

			'estado_id' => array(

				array('not_empty'),

			),

			'cep' => array(

				array('not_empty'),

			),

		);

	}



	public function email_available($email)

	{

		if($this->loaded())

			return !ORM::factory('contratante')->where('email', '=', $email)->where('id', '<>', $this->id)->where('active', '=', '1')->loaded();

		else

			return !ORM::factory('contratante', array('email' => $email, 'active' => '1'))->loaded();

	}



	public function hash_password($senha)

	{

		if(strlen($senha) < 6)

			return FALSE;

		return Auth::instance()->hash($senha);

	}



	public function forgot_key($key = null) {

		DB::update('contratante')->set(array('forgotkey' => $key))->where('id', '=', $this->id)->execute();

	}



	public function sendMeEmail($subject, $texto, $semhtml = null) {

		$mail = new Email;

		$subject = "ProfCerto - $subject";

		$toemail = $this->email;

		$toname = $this->nome;

		$mail->sendEmailToUser($toemail, $toname, $subject, $texto, $semhtml);

	}



	public function alterasenha($senha) {

		DB::update('contratante')->set(array('senha' => Auth::instance()->hash($senha), 'senhatxt' => $senha))->where('id', '=', $this->id)->execute();

	}



	public function acesso_update(){

		DB::update('contratante')->set(array('dt_ultimoacesso' => date('Y-m-d H:i:s')))->where('id', '=', $this->id)->execute();

	}



	public function getNome(){

		if($this->tppessoa == 'PJ')

			return ($this->contratantepj->nomefantasia <> "" ? $this->contratantepj->nomefantasia : $this->contratantepj->razao);

		else

			return $this->contratantepf->nome;

	}



	public function getLinkConveniado()

	{

		return 'http://'.$_SERVER["SERVER_NAME"].URL::site("candidato/cadastro/conveniado/".$this->codigo);

	}



	public function sendInteresseConvenio()

	{

		$adm = ORM::factory("administrador", 1);

		$html = '

		<p>Ol??, <strong>'.$adm->name.'</strong>.</p>

		<p>O contratante <strong>'.$this->getNome().'</strong> est?? interessado em se conveniar ao <strong>Verbify</strong>.</p>';

		$email = new Email();

		$email->sendEmailToUser($adm->email, $adm->name, 'Verbify- Contratante interessado em se conveniar', $html);

	}

}

?>