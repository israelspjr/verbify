<?php defined('SYSPATH') or die('No direct access allowed.');



class Model_Candidato extends ORM {



	protected $_table_name = 'candidato';

	protected $_primary_key = 'id';



	protected $table_columns = array (

		'id' 				=> 	array('type'=>'int'),

		'email'				=> 	array('type'=>'string'),

		'senha'				=> 	array('type'=>'string'),

		'senhatxt'			=> 	array('type'=>'string'),

		'nome'				=> 	array('type'=>'string'),

		'doctype'			=> 	array('type'=>'string'),

		'cpf'					=> 	array('type'=>'string'),

		'sexo'				=> 	array('type'=>'string'),

		'dtnasc'				=> 	array('type'=>'date'),

		'nacionalidade'	=> 	array('type'=>'string'),

		'tel1'					=> 	array('type'=>'string'),

		'tel2'					=> 	array('type'=>'string'),

		'email2'				=> 	array('type'=>'string'),

		'skype'				=> 	array('type'=>'string'),

		'outrosim'			=> 	array('type'=>'string'),

		'blog'				=> 	array('type'=>'string'),

		'facebook'			=> 	array('type'=>'string'),

		'outrars'			=> 	array('type'=>'string'),



		'endereco'			=> 	array('type'=>'string'),

		'numero'				=> 	array('type'=>'string'),

		'compl'				=> 	array('type'=>'string'),

		'bairro'				=> 	array('type'=>'string'),

		'cep'					=> 	array('type'=>'string'),

		'cidade'				=> 	array('type'=>'string'),

		'estado'				=> 	array('type'=>'string'),

		'pais'					=> 	array('type'=>'string'),



		'dtcadastro'		=>	array('type'=>'datetime'),

		'dt_ultimoacesso'	=>	array('type'=>'datetime'),

		'forgotkey'			=>	array('type'=>'string'),

		'interesse'			=>	array('type'=>'boolean'),

		'expformacao'		=>	array('type'=>'boolean'),

		'disponibilidade'	=>	array('type'=>'boolean'),

		'codigo'			=>	array('type'=>'string'),



		'rg'				=>	array('type'=>'string'),

		'comoconheceu'		=>	array('type'=>'string'),


		'valorHora' 		=>	array('type'=>'int'),
		'conveniado_id'		=>	array('type'=>'int'),

	);



	protected $_has_many = array(

		'candidatoidiomas' => array(

			'model'   => 'candidatoidioma',

			'foreign_key' => 'candidato_id',

		),

		'idiomas' => array(

			'model'   => 'idioma',

			'through' => 'candidato_idioma',

		),

		'locomocao' => array(

			'model'   => 'locomocao',

			'through' => 'candidato_locomocao',

		),

		'candidatoexperiencias' => array(

			'model'       => 'candidatoexperiencia',

			'foreign_key' => 'candidato_id',

		),

		'viagens' => array(

			'model'       => 'candidatoviagem',

			'foreign_key' => 'candidato_id',

		),

		'certificacoes' => array(

			'model'       => 'candidatocertificacao',

			'foreign_key' => 'candidato_id',

		),

		'graduacoes' => array(

			'model'       => 'candidatograduacao',

			'foreign_key' => 'candidato_id',

		),

		'expprofissionais' => array(

			'model'       => 'candidatoexpprofissional',

			'foreign_key' => 'candidato_id',

		),

		'expidiomas' => array(

			'model'       => 'candidatoexpidioma',

			'foreign_key' => 'candidato_id',

		),

		'candidatocursos' => array(

			'model'       => 'candidatocursoslivres',

			'foreign_key' => 'candidato_id',

		),

		'disponibilidades' => array(

			'model'       => 'candidatodisponibilidade',

			'foreign_key' => 'candidato_id',

		),

		'candidaturas' => array(

			'model'       => 'candidatura',

			'foreign_key' => 'candidato_id',

		),

		'testesexecutados' => array(

			'model'       => 'testeexecutado',

			'foreign_key' => 'candidato_id',

		),

		'convites' => array(

			'model'   => 'convite',

			'foreign_key' => 'candidato_id',

		),

		'referencias' => array(

			'model'   => 'referencia',

			'foreign_key' => 'candidato_id',

		),

		'regiao' => array(

			'model'   => 'regiaosp',

			'foreign_key' => 'candidato_id',

			'through' => 'candidato_regiao'

		),

		'conveniado' => array(

			'model'   => 'contratante',

			'foreign_key' => 'conveniado_id',

		),

	);





	protected $_has_one = array(

		'localidade' => array(

			'model'       => 'candidatolocalidade',

			'foreign_key' => 'candidato_id',

		),

		'conta' => array(

			'model'       => 'conta',

			'foreign_key' => 'candidato_id',

		),

	);



	public function rules()

	{

		return array(

			'nome' => array(

				array('not_empty'),

				array('min_length', array(':value', 4)),

				array('max_length', array(':value', 120)),

				array('regex', array(':value', '/^[a-zA-ZÀ-Üà-ü]+( [a-zA-ZÀ-Üà-ü]+)+$/')),

			),

			'cpf' => array(

				array('not_empty'),

				array(array($this, 'is_valid_cpf')),

				array(array($this, 'cpf_available')),

			),

			'sexo' => array(

				array('not_empty'),

				array(array('Helper', 'is_sexo')),

			),

			'dtnasc' => array(

				array('not_empty'),

				array('date'), // Helper::is_date

			),

			'nacionalidade' => array(

				array('not_empty'),

			),

			'tel1' => array(

				array('not_empty'),

			),

			'email' => array(

				array('not_empty'),

				array('max_length', array(':value', 120)),

				array('email'),

				array(array($this, 'email_available')),

			),

			'email2' => array(

				array('max_length', array(':value', 120)),

				array('email'),

			),

			'blog' => array(

				array('url'),

			),

			'facebook' => array(

				array('url'),

			),

			'outrars' => array(

				array('url'),

			),

			'senha' => array(

				array('not_empty'),

			),

		);

	}



	public function filters()

	{

		return array(

			TRUE => array( array('trim') ),

			'cpf' => array(array( array('Helper', 'onlyNumeric') )),

			'email' => array( array('strtolower') ),

			'email2' => array( array('strtolower') ),

			'dtnasc' => array(array( array('Helper', 'format_date_db') )),

			'cep' => array(array( array('Helper', 'onlyNumeric') )),

			//'tel1' => array(array( array('Helper', 'onlyNumeric') )),

			//'tel2' => array(array( array('Helper', 'onlyNumeric') )),

			'senha' => array(array( array($this, 'hash_password') )),

		);

	}



	public function is_valid_cpf($cpf)

	{

		if($this->doctype == 'B')

			return Helper::is_cpf($cpf);

		else

			return true;

	}



	public function cpf_available($cpf)

	{

		if($this->doctype == "B") {

			if($this->loaded()){

				$count = ORM::factory('candidato')->where('cpf', '=', $this->cpf)->where('id', '<>', $this->id)->count_all();

				return ($count == 0);

			} else {

				return !ORM::factory('candidato', array('cpf' => $cpf))->loaded();

			}

		}

	}



	public function email_available($email)

	{

		if($this->loaded()){

			$count = ORM::factory('candidato')->where('email', '=', $email)->where('id', '<>', $this->id)->where('active', '=', '1')->count_all();

			return ($count == 0);

		} else {

			return !ORM::factory('candidato', array('email' => $email, 'active' => '1'))->loaded();

		}

	}



	public function hash_password($senha)

	{

		if(strlen($senha) < 6)

			return FALSE;

		return Auth::instance()->hash($senha);

	}



	public function hash_codigo()

	{

		$CaracteresAceitos = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

		$max = strlen($CaracteresAceitos)-1;

		do{

			$password = null;

			for($i=0; $i < 8; $i++) {

				$password .= $CaracteresAceitos{mt_rand(0, $max)};

			}

		} while(ORM::factory('candidato')->where('codigo', '=', $password)->where('id', '<>', $this->id)->loaded());

		$this->codigo = $password;

	}



	public function add_outro($alias, ORM $model, $data = NULL)

	{

		$columns = array($this->_has_many[$alias]['foreign_key'], $this->_has_many[$alias]['far_key']);

		$values = array($this->pk(), $model->pk());

		if ( ! empty($data))

		{

			foreach ($data as $column => $value)

			{

				$columns[] = $column;

				$values[] = $value;

			}

		}



		DB::insert($this->_has_many[$alias]['through'])

				->columns($columns)

				->values($values)

				->execute($this->_db);

		return $this;

	}



	public static function validaoutro($arr, $field, $outro="")

	{

		foreach($arr as $key => $value){

			$item = ORM::factory($field, $key);

			if($item->is_outro AND $outro == "")

				return FALSE;

		}

	}



	public function saveIdiomas($cand_idiomas, $outroidioma = "")

	{

		$this->remove("idiomas");

		foreach($cand_idiomas as $key => $value){

			$idi = ORM::factory("idioma", $key);

			if($idi->is_outro) {

				$this->add_outro("idiomas", $idi, array('outro' => $outroidioma));

			} else {

				$this->add("idiomas", $idi);

			}

		}

		

	}



	public function saveLocomocao($cand_locomocao, $outralocomocao = "")

	{

		$this->remove("locomocao");

		foreach($cand_locomocao as $key => $value){

			$loc = ORM::factory("locomocao", $key);

			if($loc->is_outro)

				$this->add_outro("locomocao", $loc, array('outro' => $outralocomocao));

			else

				$this->add("locomocao", $loc);

		}

	}



	public function delete_all_interesses(){

		DB::delete('candidato_experiencia')

			->where('candidato_id','=', $this->id)

			->execute();

	}



	public function delete_all_viagens(){

		DB::delete('candidato_viagens')

			->where('candidato_id','=', $this->id)

			->execute();

	}



	public function delete_all_certificacoes(){

		DB::delete('candidato_certificacao')

			->where('candidato_id','=', $this->id)

			->execute();

	}



	public function delete_all_graduacoes(){

		DB::delete('candidato_graduacao')

			->where('candidato_id','=', $this->id)

			->execute();

	}



	public function delete_all_expprofissionais(){

		DB::delete('candidato_expprofissional')

			->where('candidato_id','=', $this->id)

			->execute();

	}



	public function delete_all_expidiomas(){

		DB::delete('candidato_expidioma')

			->where('candidato_id','=', $this->id)

			->execute();

	}



	public function delete_all_cursos(){

		DB::delete('candidato_cursos')

			->where('candidato_id','=', $this->id)

			->execute();

	}



	public function delete_all_disponibilidade(){

		DB::delete('candidato_disponibilidade')

			->where('candidato_id','=', $this->id)

			->execute();

	}



	public function sendMeEmail($subject, $texto, $semhtml = null){

		$mail = new Email;

		$mail->sendEmailToUser($this->email, $this->nome, $subject, $texto);

	}



	public function acesso_update(){

		DB::update('candidato')->set(array('dt_ultimoacesso' => date('Y-m-d H:i:s')))->where('id', '=', $this->id)->execute();

	}



	public function forgot_key($key = null) {

		DB::update('candidato')->set(array('forgotkey' => $key))->where('id', '=', $this->id)->execute();

	}



	public function alterasenha($senha) {

		DB::update('candidato')->set(array('senha' => Auth::instance()->hash($senha), 'senhatxt' => $senha))->where('id', '=', $this->id)->execute();

	}



	public function is_completed(){

		return $this->status;

	}



	public function atualizastatus(){

		if($this->interesse == 1 AND $this->expformacao == 1 AND $this->disponibilidade == 1)

			$this->status =1;

		$this->save();

	}



	public function getTestesDisponiveis(){

		$arr = $this->idiomas->find_all()->as_array('id','id');

		$arr[] = 0;

		return ORM::factory("teste")

			->where("active", "=", "1")

			->where("idioma_id", "IN", $arr)

			->order_by("tipo", "ASC")

			->find_all();

	}



	public function getTestesDivulgadosEscola(){

		// testes divulgados por idioma

		$sql_testes_divulgados = '

		SELECT t.* FROM tb_testes t

		INNER JOIN tb_teste_executado te on(t.id = te.teste_id)

		WHERE te.id in(

			SELECT MAX(a.id) as id

			FROM tb_teste_executado a

			INNER JOIN tb_testes b on(a.teste_id = b.id)

			WHERE candidato_id='.$this->id.' AND divulgar = 1 AND idioma_id<>0

			GROUP BY idioma_id, tipo

			UNION

			SELECT a.id as id

			FROM tb_teste_executado a

			INNER JOIN tb_testes b on(a.teste_id = b.id)

			WHERE candidato_id='.$this->id.' AND divulgar = 1 AND idioma_id=0

		) ORDER BY te.dt_execucao;';

		$testes = DB::query(Database::SELECT, $sql_testes_divulgados)->execute()->as_array("id", "id");



		if(count($testes) > 0)

			return ORM::factory("teste")->where("id", "IN", $testes)->find_all();

	}



	public function getTestesConviteDisponivel(){

		$sql_semidioma_naopublicado = '

		SELECT t3.id FROM tb_testes t3

		WHERE idioma_id=0

		AND id not in(SELECT teste_id FROM tb_teste_executado WHERE candidato_id='.$this->id.' AND divulgar = 1)

		AND active = 1 AND publicado=1';



		$sql_random_t2 = '

		SELECT t2.id

		FROM tb_testes t2

		WHERE t2.idioma_id = t1.idioma_id

		AND t2.tipo = t1.tipo

		AND active = 1 AND publicado = 1

		ORDER BY RAND()

		LIMIT 1';



		$sql_idiomas = '

		SELECT idioma_id

		FROM tb_candidato_idioma

		WHERE candidato_id='.$this->id;



		$sql_idioma_e_tipo1 = '

		SELECT teste1.idioma_id

		FROM tb_teste_executado te1

		INNER JOIN tb_testes teste1 on(teste1.id = te1.teste_id)

		WHERE candidato_id='.$this->id.' AND divulgar=1 AND tipo = 1

		AND te1.dt_execucao > DATE_SUB(CURDATE(), INTERVAL 1 YEAR)';



		$sql_idioma_e_tipo2 = '

		SELECT teste2.idioma_id

		FROM tb_teste_executado te2

		INNER JOIN tb_testes teste2 on(teste2.id = te2.teste_id)

		WHERE candidato_id='.$this->id.' AND divulgar=1 AND tipo = 2

		AND te2.dt_execucao > DATE_SUB(CURDATE(), INTERVAL 1 YEAR)';



		// seleciona aleatóriamente um teste do idioma lecionado pelo candidato

		// que nao tenha sido publicado nenhum teste ainda do idioma e do mesmo tipo no período de um nao

		$sql_convite_disponivel = 'SELECT ('.$sql_random_t2.') as teste_id

		FROM tb_testes t1

		WHERE idioma_id IN('.$sql_idiomas.') AND (

			(tipo = 1 AND idioma_id not in('.$sql_idioma_e_tipo1.')) OR

			(tipo = 2 AND idioma_id not in('.$sql_idioma_e_tipo2.'))

		)

		UNION

		'.$sql_semidioma_naopublicado;

		$testes = DB::query(Database::SELECT, $sql_convite_disponivel)->execute()->as_array("teste_id", "teste_id");



		if(count($testes) > 0)

			return ORM::factory("teste")->where("id", "IN", $testes)->find_all();

	}



	public function getTestesNaoExecutados(){

		// idiomas que ainda nao executou teste

		$sqlidiomas = '

		SELECT DISTINCT a.idioma_id

		FROM tb_testes a

		INNER JOIN tb_candidato_idioma b on(a.idioma_id = b.idioma_id AND candidato_id='.$this->id.')

		WHERE active =1 AND publicado =1

		AND a.idioma_id not in(

			SELECT d.idioma_id

			FROM tb_teste_executado c

			INNER JOIN tb_testes d on(c.teste_id = d.id)

			WHERE c.candidato_id='.$this->id.' AND d.idioma_id <> 0 AND d.tipo = 1

			AND c.dt_execucao > DATE_SUB(CURDATE(), INTERVAL 1 YEAR)

		)';



		// idiomas que ainda nao executou teste oral

		$sqlidiomas2 = '

		SELECT DISTINCT a.idioma_id

		FROM tb_testes a

		INNER JOIN tb_candidato_idioma b on(a.idioma_id = b.idioma_id AND candidato_id='.$this->id.')

		WHERE active =1 AND publicado =1

		AND a.idioma_id not in(

			SELECT d.idioma_id

			FROM tb_teste_executado c

			INNER JOIN tb_testes d on(c.teste_id = d.id)

			WHERE c.candidato_id='.$this->id.' AND d.idioma_id <> 0 AND d.tipo = 2

			AND c.dt_execucao > DATE_SUB(CURDATE(), INTERVAL 1 YEAR)

		)';



		// teste que nao executou aleatório

		$sqltestes = '

		SELECT

		(SELECT id FROM tb_testes a

		  WHERE b.idioma_id = a.idioma_id

		  AND active =1 AND publicado =1

		  AND a.tipo = 1

		  AND id not in	(

			SELECT d.teste_id

			FROM tb_teste_executado d

			WHERE d.candidato_id='.$this->id.'

		  )

		  ORDER BY rand() LIMIT 1) as teste_id

		FROM tb_testes b

		WHERE active =1 AND publicado =1

		AND idioma_id in('.$sqlidiomas.')

		AND b.tipo = 1

		GROUP BY idioma_id



		UNION



		SELECT

		(SELECT id FROM tb_testes a

		  WHERE b.idioma_id = a.idioma_id

		  AND active =1 AND publicado =1

		  AND a.tipo = 2

		  AND id not in	(

			SELECT d.teste_id

			FROM tb_teste_executado d

			WHERE d.candidato_id='.$this->id.'

		  )

		  ORDER BY rand() LIMIT 1) as teste_id

		FROM tb_testes b

		WHERE active =1 AND publicado =1

		AND b.tipo = 2

		AND idioma_id in('.$sqlidiomas2.')

		GROUP BY idioma_id;';

		$testes = DB::query(Database::SELECT, $sqltestes)->execute()->as_array("teste_id", "teste_id");



		// outros

		$sqltestes = 'SELECT id as teste_id FROM tb_testes

		WHERE active =1 AND publicado =1 AND idioma_id =0

		AND id not in	(

			SELECT d.teste_id

			FROM tb_teste_executado d

			WHERE d.candidato_id='.$this->id.'

			AND d.dt_execucao > DATE_SUB(CURDATE(), INTERVAL 1 YEAR)

		)';

		$testes2 = DB::query(Database::SELECT, $sqltestes)->execute()->as_array("teste_id", "teste_id");

		return ORM::factory("teste")

			->where("id", "in", array_merge($testes, $testes2))

			->order_by("idioma_id", "DESC")

			->order_by("tipo", "ASC")

			->find_all();

	}



	public function getTestesExecutados(){

		return $this->testesexecutados->find_all();

	}



	public function getTestesDivulgados(){

		return $this->testesexecutados->where("divulgar", "=", "1")->find_all();

	}



	public function getTestesConvites(){

		$arr = array();

		$rows = $this->convites->find_all();

		foreach($rows as $row){

			$arr[] = $row->teste_id;

		}

		return $arr;

	}



	public function getDescricaoIdiomas(){

		$idiomas_desc = array();

		$idiomas = $this->idiomas->find_all();

		foreach($idiomas as $row){

			$idiomas_desc[] = $row->descricao;

		}

		return ucwords(implode(", ", $idiomas_desc));

	}



	public function getArrayIdiomas(){

		$idiomas_desc = array();

		$idiomas = $this->idiomas->find_all();

		foreach($idiomas as $row){

			$idiomas_desc[] = $row->descricao;

		}

		return $idiomas_desc;

	}



	public function getLocalidade(){

		$localidade = $this->localidade;

		if($localidade->loaded())

			return ucwords($localidade->cidade->vc_cidade)." - ".$localidade->cidade->vc_uf;

		else

			return '';

	}



	public function getEndereco(){

		return '<div>

			'.$this->endereco.', '.$this->numero.' '.$this->compl.'<br />

			'.$this->bairro.'<br />

			'.$this->cidade.' - '.$this->estado.'<br />

			CEP: '.$this->cep.'<br />

			'.$this->pais.'

		</div>';

	}



	public function avisaPublicacaoConveniado($teste)

	{

		$contratante = ORM::factory("contratante", $this->conveniado_id);

		$candidato = $this->nome;

		if($contratante->loaded())

		{

			$toemail = $contratante->email;

			$toname = $contratante->getNome();

			$subject = 'BUP - Candidato publicou um teste';

			$html = '<p>O candidato de código <strong>'.$candidato.'</strong>, cadastrado no ProfCerto através de seu site, divulgou o resultado do teste <strong>'.$teste->getNome().'</strong>.</p>

			<p>Entre na sua área restrita em <a href="http://www.vagasdeprofessores.com.br/bup/'.URL::base().'">www.vagasdeprofessores.com.br</a> e confira o resultado.</p>';

			$email = new Email();

			$email->sendEmailToUser($toemail, $toname, $subject, $html);

		}

	}

}

?>