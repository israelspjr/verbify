<?php defined('SYSPATH') or die('No direct access allowed.');



class Model_Referencia extends ORM {



	protected $_table_name = 'referencia';

	protected $_primary_key = 'id';



	protected $table_columns = array (

		'id' 			=> 	array('type'=>'int'),

		'candidato_id'	=> 	array('type'=>'int'),

		'status'		=> 	array('type'=>'int'),

		'nome'			=> 	array('type'=>'string'),

		'email'			=> 	array('type'=>'string'),

		'relacionamento_id' => array('type'=>'string'),

		'mensagem'		=> 	array('type'=>'string'),

		'key'			=> 	array('type'=>'string'),

		'ts_pedido'		=> 	array('type'=>'timestamp'),

		'ts_mensagem'	=> 	array('type'=>'timestamp'),

		'aprovado'		=> 	array('type'=>'int'),

	);



	protected $_belongs_to = array(

		'candidato' => array('model' => 'candidato', 'foreign_key' => 'candidato_id'),

		'relacionamento' => array('model' => 'referenciarelacionamento', 'foreign_key' => 'relacionamento_id'),

	);



	public function rules()

	{

		return array(

			'nome' => array(

				array('not_empty'),

			),

			'email' => array(

				array('not_empty'),

				array('email'),

				array(array($this, 'email_available')),

			),

		);

	}



	public function email_available($email)

	{

		if($this->loaded())

			return !ORM::factory('referencia')->where('email', '=', $email)->where('candidato_id', '=', $this->candidato_id)->loaded();

	}



	public function sendEmail()

	{

		$link = 'http://'.$_SERVER['SERVER_NAME'].URL::site("recomendacoes?key=".$this->key);

		$html = '

		<p>Prezado(a) <strong>'.$this->nome.'</strong>.</p>

		<p>

			<strong>'.$this->candidato->nome.'</strong> o indicou como referência pessoal e profissional para o portal Verbify.<br />

			Para incluir seus comentários, <a href="'.$link.'">clique aqui</a>.<br />

		</p>';

		$subject = 'Verbify - '.$this->candidato->nome.' solicitou sua referência';

		$mail = new Email;

		$mail->sendEmailToUser($this->email, $this->nome, $subject, $html);

	}



	public function sendEmailProfessor()

	{

		$html = '

		<p>Prezado(a) <strong>'.$this->candidato->nome.'</strong>.</p>

		<p>Respondendo à sua solicitação de referência, <strong>'.$this->nome.'</strong> escreveu uma mensagem sobre você no Verbify.<br />

		Entre na sua área restrita para ler e publicar!<br />

		</p>';

		$subject = 'Verbify- '.$this->nome.' escreveu sobre você';

		$mail = new Email;

		$mail->sendEmailToUser($this->candidato->email, $this->candidato->nome, $subject, $html);

	}

}

?>