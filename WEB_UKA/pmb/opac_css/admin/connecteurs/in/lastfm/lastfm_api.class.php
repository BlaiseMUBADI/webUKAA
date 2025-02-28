<?php
// +-------------------------------------------------+
// © 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: lastfm_api.class.php,v 1.1.2.3 2012-03-29 09:36:20 arenou Exp $

if (stristr($_SERVER['REQUEST_URI'], ".class.php")) die("no access");

require_once("lastfmapi/lastfmapi.php");

//classe facilitant les appel depuis le connecteurs...
class lastfm_api{
	var $auth;			// objet gérant l'authentification
	var $api_class;		// objet gérant les appels
	var $notice_infos;	// tableau regroupant les infos utiles d'une notice
	
	/*
	 * Constructeur
	 */
	public function __construct($authVars){
		$this->auth = new lastfmApiAuth('getsession', $authVars);
		$this->api_class = new lastfmApi();
	}
	
	public function set_notice_infos($notice_infos){
		$this->notice_infos = $notice_infos;
	} 

	/*
	 * Récupère les infos d'un artiste
	 */
	public function get_artist_infos(){
		global $lang;
		
		$vars = array(
			'lang' => substr($lang,0,2),
			'artist' => $this->notice_infos['author']
		);
	//	highlight_string(print_r($vars,true));
		$package = $this->api_class->getPackage($this->auth, "artist");
		return $package->getInfo($vars);		
	}
	
	/*
	 * Récupère la biopgraphie d'un artiste
	 */
	public function get_artist_biography(){
		$infos = $this->get_artist_infos();
		return $infos['bio'];
	}

	/*
	 * Récupère une liste des artistes similaires d'un artiste
	 */
	public function get_similar_artists(){
		$infos = $this->get_artist_infos();
	//	highlight_string(print_r($infos,true));
		return $infos['similar'];
	}
	
	public function get_album_infos(){
		global $lang;
		
		$vars = array(
			'lang' => substr($lang,0,2),
			'album' => $this->notice_infos['title'],
			'artist' => $this->notice_infos['author']
		);
		$package = $this->api_class->getPackage($this->auth, "album");
		$infos = $package->getInfo($vars);
	//	highlight_string(print_r($infos,true));
		return $infos;				
	}
	
	public function get_pictures($page=1){
		$vars = array(
			'artist' => $this->notice_infos['author'],
			'page' => $page,
			'limit' => 20
		);
		$package = $this->api_class->getPackage($this->auth, "artist");
		return $package->getImages($vars);
	}
	
	public function get_tracks_infos(){
		$album_infos = $this->get_album_infos();
		foreach($album_infos['tracks'] as $track){
			$vars = array(
				'lang' => substr($lang,0,2),
				'artist' => $this->notice_infos['author'],
				'track' => $track['name']
			);
			$infos[]=$this->get_track_infos($vars);
		}
		return $infos;
	}
	
	public function get_track_infos($vars){
		$package = $this->api_class->getPackage($this->auth, "track");
		$infos = $package->getInfo($vars);
		return $infos;
	}
}