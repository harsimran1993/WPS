<?php
class wallpaper_db extends CI_Model{
	
	public function __construct(){
		$this->load->database();
	}
	
	public function getWallpaperList(){
		$sql = "Select * from wallpaper";
		$query = $this->db->query($sql);
		if($query -> num_rows() > 0)
			return $query -> result_array();
		else
			return "";
	}
	public function addWallpaper($data){
		$wallpaper_data = array("Title"=>$data['Title'],"ThumbUrl"=>$data['ThumbUrl'],"IsNew"=>$data['IsNew'],"AddedBy"=>$data['AddedBy'],"DirectoryName"=>$data['DirectoryName']);
		$insert_Result=$this->db->insert('wallpaper',$wallpaper_data);
	}
	
	public function getLayers($wallID){
		$sql="Select LayerUrl,Type,LayerOrder from wallpapergroup where GroupId = ? ORDER BY LayerOrder DESC";
		$query = $this->db->query($sql,$wallID);
		if($query -> num_rows() > 0)
		{
			return $query->result_array();
		}
		else
			return"";
	}
	
}