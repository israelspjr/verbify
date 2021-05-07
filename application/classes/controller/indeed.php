<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Indeed extends Controller {

	public function action_index()
	{
		$vagas = ORM::factory("vaga")->where('active', '=', '1')->find_all();
		$writer = new XMLWriter();
		$writer->openURI('php://output');
		$writer->setIndent(4);
		$writer->startDocument("1.0", "UTF-8");
		$writer->startElement("source");
		$writer->writeElement("publisher", "PROFCERTO");
		$writer->writeElement("publisherurl", "http://www.profcerto.com.br");
		foreach($vagas as $vaga) {
			$cadastro = strtotime($vaga->dt_cadastro);
			$writer->startElement("job");
				$writer->startElement("title");
					$writer->writeCData($vaga->getTitle());
				$writer->endElement(); 
				$writer->startElement("date");
					$writer->writeCData(date("r", $cadastro));
				$writer->endElement(); 
				$writer->startElement("referencenumber");
					$writer->writeCData($vaga->id);
				$writer->endElement(); 
				$writer->startElement("url");
					$writer->writeCData($vaga->getURL());
				$writer->endElement(); 
				$writer->startElement("city");
					$writer->writeCData($vaga->cidade->vc_cidade);
				$writer->endElement(); 
				$writer->startElement("state");
					$writer->writeCData($vaga->estado_id);
				$writer->endElement(); 
				$writer->startElement("country");
					$writer->writeCData("BR");
				$writer->endElement(); 
				$writer->startElement("description");
					$writer->writeCData($vaga->getDescricao());
				$writer->endElement(); 
			$writer->endElement(); 
		}
		$writer->endElement(); 
		$writer->endDocument(); 
		$writer->flush();
	}
}
?>