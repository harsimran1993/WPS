<?php
class WallpaperController extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->helper('url_helper');
		$this->load->helper(array('form', 'url'));
	
		/*// Load form validation library
		$this->load->library('form_validation');
		// Load session library
		$this->load->library('session');*/
	
		$this->load->model('wallpaper_db');
	}
	
	public function index(){
		$wall_list = $this->wallpaper_db->getWallpaperList();
		$data = array();
		$i = 0;
		foreach($wall_list as $wall){
			$data[$i]=array();
			$data[$i]['ID'] = $wall['ID'];
			$data[$i]['Title'] = $wall['Title'];
			$data[$i]['ThumbUrl'] = base_url("")."assets/img/thumbs/".$wall['ThumbUrl'].".jpg";
			$data[$i]['IsNew'] = $wall['IsNew'];
			$data[$i]['AddedBy'] = $wall['AddedBy'];
			$data[$i]['DirectoryName'] = $wall['DirectoryName'];
			$data[$i]['Downloads'] = $wall['Downloads'];
			$i++;
		}
		$list = array();
		$list["Gallery"] = $data;
		echo json_encode($list, JSON_UNESCAPED_SLASHES);
	}
	
	public function getLayers(){
		$wallID = isset($_GET['wallID']) ? $_GET['wallID'] : "1";
		if($wallID == "0") $wallID = "1";
		$layer_list=$this->wallpaper_db->getLayers($wallID);
		$data = array();
		$i=0;
		foreach ($layer_list as $llist){
			$data[$i]=array();
			$data[$i]['LayerName']=$llist['LayerUrl'];
			$data[$i]['LayerType']=$llist['Type'];
			$data[$i]['LayerOrder']=$llist['LayerOrder'];
			$data[$i]['LayerUrl']= base_url("")."assets/img/layers/".$llist['LayerUrl'].$llist['Type'];
			$i++;
		}
		$layerdata['Layers'] = $data;
		echo json_encode($layerdata, JSON_UNESCAPED_SLASHES);
	}
}
?>