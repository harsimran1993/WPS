<?php
class Parallax_Model extends CI_Model{
	
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
		$wallpaper_data = array("Title"=>$data['Title'],"ThumbUrl"=>$data['ThumbUrl'],"AddedBy"=>$data['AddedBy'],"DirectoryName"=>$data['DirectoryName']);
		$insert_Result=$this->db->insert('wallpaper',$wallpaper_data);
		
		return $insert_Result;
	}
	
	public function updateDownloadCount($wallID){
		$this->db->where('ID',$wallID);
		$this->db->select('DownloadCount');
		$count = $this->db->get('wallpaper')->row();
		$this->db->where('ID',$wallID);
		$this->db->set('DownloadCount', $count->DownloadCount + 1);
		$this->db->update('wallpaper');
		
	}
	

	public function updateLikeCount($wallID){
		$this->db->where('ID',$wallID);
		$this->db->select('LikeCount');
		$count = $this->db->get('wallpaper')->row();
		$this->db->where('ID',$wallID);
		$this->db->set('LikeCount', $count->LikeCount + 1);
		$this->db->update('wallpaper');
	
	}
	
	public function getLayers($wallID){
		$sql="Select LayerUrl,LayerOrder from wallpapergroup where GroupId = ? ORDER BY LayerOrder DESC";
		$query = $this->db->query($sql,$wallID);
		if($query -> num_rows() > 0)
		{
			return $query->result_array();
		}
		else
			return"";
	}
	
	public function insertLayer($data){
		$layer_data = array("LayerUrl"=>$data['LayerUrl'],"LayerOrder"=>$data['LayerOrder'],"GroupId"=>$data['GroupId']);
		$insert_Result = $this->db->insert('wallpapergroup',$layer_data);
		
		return $insert_Result;
	
	}
	//atmoic transaction start
	public function startTrans(){
	
		//start transaction
		$this->db->trans_start();
	
	}
	
	//atomic transaction end
	public function endTrans(){
	
		//complete transaction
		$this->db->trans_complete();
	
		$trans_status = $this->db->trans_status();
	
		if ($trans_status == FALSE) {
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}
}