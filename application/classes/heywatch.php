<?php
defined('SYSPATH') or die('No direct script access.');
class HeyWatch {
	public static function converter($videotmp){
		require_once 'HTTP/Request2.php';
		$video_url = "http://profcerto.com.br".HeyWatch::getUploadTmpFolder()."/".$videotmp->url;
		$format_id = "31";
		$ftp = 'ftp://proftob2:V3Y4$BxLrJ@profcerto.com.br/';
		$ping_after_encode = "http://profcerto.com.br".URL::site("hwretorno/success");
		$ping_if_error = "http://profcerto.com.br".URL::site("hwretorno/error"); 
		$my_site_user_id = $videotmp->candidato_id;
		$my_site_video_id = $videotmp->id;
		
		$filename = HeyWatch::getFileNameNoExt($videotmp->url);
		
		$req = new HTTP_Request2("http://heywatch.com/download.xml");
		$req->setAuth("PROFCERTO", "prof1234");
		$req->setMethod(HTTP_Request2::METHOD_POST);
		$req->addPostParameter("url", $video_url);
		$req->addPostParameter("format_id", $format_id);
		$req->addPostParameter("automatic_encode", "true");
		$req->addPostParameter("ftp_directive", $ftp);
		$req->addPostParameter("ping_url_after_encode", $ping_after_encode);
		$req->addPostParameter("ping_url_if_error", $ping_if_error);
		$req->addPostParameter("my_site_user_id", $my_site_user_id);
		$req->addPostParameter("my_site_video_id", $my_site_video_id);
		$req->addPostParameter("title", $filename);
		return $req->send()->getBody();
	}

	public static function getFinalName($before){
		$root = $_SERVER["DOCUMENT_ROOT"];
		$beforepath = $root . HeyWatch::getUploadFolder().'/'.$before;
		if(file_exists($beforepath)){
			return HeyWatch::getUploadFolder().'/'.$before;
		} else {
			return HeyWatch::getUploadFolder().'/'.HeyWatch::getConvertedName($before);
		}
	}
	
	public static function getFinalThumb($before){
		return HeyWatch::getUploadFolder().'/'.HeyWatch::getConvertedThumbName($before);
	}
	
	public static function getConvertedName($before){
		$arr = explode(".", $before);
		return basename($before,'.'.end($arr)) . '.flv';
	}

	public static function getConvertedThumbName($before){
		return $before.'.jpg';
	}

	public static function getFileNameNoExt($before){
		$arr = explode(".", $before);
		return basename($before,'.'.end($arr));
	}
	
	public static function getUploadTmpFolder(){
		return URL::site("uploads/videostmp");
	}

	public static function getUploadFolder(){
		return URL::site("uploads/videos");
	}
}
?>