<?php
class WallpaperController extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->helper('url_helper');
		$this->load->helper(array('form', 'url'));
	
		// Load form validation library
		$this->load->library('form_validation');
		//Load session library
		$this->load->library('session');
	
		$this->load->model('Parallax_Model');
	}
	
	public function index(){
		$wall_list = $this->Parallax_Model->getWallpaperList();
		$data = array();
		$i = 0;
		foreach($wall_list as $wall){
			$data[$i]=array();
			$data[$i]['ID'] = $wall['ID'];
			$data[$i]['Title'] = $wall['Title'];
			$data[$i]['ThumbUrl'] = base_url("")."assets/img/".$wall['ThumbUrl'];
			$data[$i]['LikeCount'] = $wall['LikeCount'];
			$data[$i]['AddedBy'] = $wall['AddedBy'];
			$data[$i]['DirectoryName'] = $wall['DirectoryName'];
			$data[$i]['DownloadCount'] = $wall['DownloadCount'];
			$data[$i]['AddedOn'] = $wall['AddedOn'];
			$i++;
		}
		$list = array();
		$list["Gallery"] = $data;
		echo json_encode($list, JSON_UNESCAPED_SLASHES);
	}
	
	public function getLayers(){


		$wallID = $this->security->xss_clean(isset($_GET['wallID']) ? $_GET['wallID'] : "8");
		if($wallID == "0") $wallID = "8";
		$layer_list=$this->Parallax_Model->getLayers($wallID);
		$data = array();
		$i=0;
		foreach ($layer_list as $llist){
			$data[$i]=array();
			$data[$i]['LayerName']=$llist['LayerUrl'];
			$data[$i]['LayerOrder']=$llist['LayerOrder'];
			$data[$i]['LayerUrl']= base_url("")."assets/img/".$llist['LayerUrl'];
			$i++;
		}
		$layerdata['Layers'] = $data;
		echo json_encode($layerdata, JSON_UNESCAPED_SLASHES);
	}
	
	public function updateDownloadCount(){
		$wallID = $this -> security->xss_clean(isset($_GET['wallID']) ? $_GET['wallID'] : "1");
		if($wallID == "0") $wallID = "1";
		$this->Parallax_Model->updateDownloadCount($wallID);		
	}
	
	public function updateLikeCount(){
		$wallID = $this -> security->xss_clean(isset($_GET['wallID']) ? $_GET['wallID'] : "1");
		if($wallID == "0") $wallID = "1";
		$this->Parallax_Model->updateLikeCount($wallID);		
	}
	
	public function addWallpaperserversystem(){

		if(isset($this->session->userdata['logged_in']) ){
			$name = $this->session->userdata['logged_in'];
			if($name['username'] === "harsimran")
			{
				$data['error'] = "";
				$this->load->view('template/header.php');
				$this->load->view('template/breadcrumb.php');
				$this->load->view('pages/admin/createWallpaper',$data);
				$this->load->view('template/footer.php');
			}
			else{
				redirect(base_url(""));
			}
		}
		else{
			redirect(base_url(""));
		}
		
	}
	
	public function do_upload() {

		if(isset($this->session->userdata['logged_in']) ){
		
			//get current logged-in user from session
			$name = $this->session->userdata['logged_in'];
				
			//admin name here
			if($name['username'] === "harsimran")
			{
				
				//upload form validation rules
				$this -> form_validation -> set_rules('userfile0', 'userfile0', 'callback_file_test');
				$this -> form_validation -> set_rules('thumbnail', 'ThumbUrl', 'callback_thumb_test');
				$this -> form_validation -> set_rules('title', 'Title', 'trim|required|min_length[5]|max_length[100]|is_unique[wallpaper.Title]');
				$this -> form_validation -> set_rules('author', 'AddedBy', 'trim|required|min_length[5]|max_length[100]');
				$this -> form_validation -> set_rules('directory', 'DirectoryName', 'trim|required|min_length[5]|max_length[100]');

				//variables
				$data["upload_data"]="";
				$data["error"]="";
				$wallpaper_data="";
				$NOImg=0;
				$uploadOK=true;
				$thumbOK=true;
				if ($this->form_validation->run() == FALSE) {
					$data["upload_data"]="";
					$data["error"].= validation_errors();
					$this->load->view('template/header.php');
					$this->load->view('template/breadcrumb.php');
					$this->load->view('pages/admin/createWallpaper',$data);
					$this->load->view('template/footer.php');
					//end of validfail block
				}
				else{
					//validation succeds
					//upload config
					$config['upload_path']   = './assets/img/';
					$config['allowed_types'] = 'gif|jpg|png';
					$config['overwrite']     = FALSE;
					$config['max_size']      = 2048000;
					$this->load->library('upload', $config);
					
					//thumbnail upload
					if ( ! $this->upload->do_upload('thumbnail')) {
						$data["error"] = $this->upload->display_errors();
						if($i == 1){
							$uploadOK=false;
							break;
						}
					}
					else {
							$data['upload_data'] = $this->upload->data();
							$wallpaper_data['ThumbUrl'] = $data['upload_data']['file_name'];
							$NOImg++;
					}
					
					/*//layers upload
					$config['upload_path']   = './assets/img/layers/';
					$config['allowed_types'] = 'gif|jpg|png';
					$config['overwrite']     = TRUE;
					$config['max_size']      = 2048000;
					$this->load->library('upload', $config);*/
					
					//upload images
					for($i=0;$i<5;$i++){
						if ( ! $this->upload->do_upload('userfile'.$i)) {
							//$error = array('error' => $this->upload->display_errors());
							$data["error"] = $this->upload->display_errors();
							if($i < 2){
								$uploadOK=false;
								break;
							}
						}
						else {
							$data['upload_data'][] = $this->upload->data();
							$layer_data['Image'][$i] = $data['upload_data'][$i]['file_name'];
							$NOImg++;
						}
					}

					//files upload block end
					//insert data to db block
					if($uploadOK){

						$wallpaper_data['Title'] = $this -> security->xss_clean($this->input->post('title'));
						$wallpaper_data['AddedBy'] = $this -> security->xss_clean($this->input->post('author'));
						$wallpaper_data['DirectoryName'] = $this -> security->xss_clean($this->input->post('directory'));
					

						//add wallpaper to db
						//start transaction
						$this -> Parallax_Model -> startTrans();
						

						//insert wallpaper data
						if($success=$this -> Parallax_Model -> addWallpaper($wallpaper_data)){
							
							//get this insert wallpaper ID
							$wallID=$this->db->insert_id();
							
							$layer['GroupId'] = $wallID;
							
							//no of images is between 1-5
							for($i=0;$i < $NOImg - 1;$i++){
								
								$layer['LayerUrl'] = $data['upload_data'][$i]['file_name'];
								
								$layer['LayerOrder'] = $i;
								
								$this->Parallax_Model->insertLayer($layer);
								
							}
							
							//end transaction with success
							$this -> Parallax_Model -> endTrans();
							
							//this here cause error message will be null other wise and throw error.
							$data["error"]="success";//$this->db->error();
							
							//clear file upload message with below if u want
							$data['upload_data']="";
							$data['upload_data'][]=array("good work");
							
							//load success page
							$this->load->view('template/header.php');
							$this->load->view('template/breadcrumb.php');
							$this->load->view('pages/admin/createWallpaper',$data);
							$this->load->view('template/footer.php');
							
						}
						else{
							//end transaction in failure
							$this -> Parallax_Model -> endTrans();
							//no of images is between 1-5
							for($i=0;$i < $NOImg - 1;$i++){
							unlink('./assets/img/layers/'.$data['upload_data'][$i]['file_name']);
							}
							unlink('./assets/img/thumbs/'.$wallpaper_data['ThumbUrl']);

							//$data['error'] = "DB insert failed cleaned upload files.";
							//load upload form
							$this->load->view('template/header.php');
							$this->load->view('template/breadcrumb.php');
							$this->load->view('pages/admin/createWallpaper',$data);
							$this->load->view('template/footer.php');
						}
						//upload ok block end
					}
					else{
						unlink('./assets/img/thumbs/'.$wallpaper_data['ThumbUrl']);
						//$data['error'] = "upload failed";
						//load upload form
						$this->load->view('template/header.php');
						$this->load->view('template/breadcrumb.php');
						$this->load->view('pages/admin/createWallpaper',$data);
						$this->load->view('template/footer.php');
					}
					
					//end of validsuccess block
				}
				//end of admin logged in block
			}
			else{
				redirect(base_url(""));
			}
			//end of someone is logged in block
		}		
		else{
			redirect(base_url(""));
		}
		
	}
	//test for atleat userfile1 file exists.
	function file_test(){
	    $this->form_validation->set_message('file_test', 'Please select atleast 2 image layers.');
	    if (empty($_FILES['userfile0']['name']) || empty($_FILES['userfile1']['name'])) {
	            return false;
	        }else{
	            return true;
	    }
	}
	
	function thumb_test(){
	    $this->form_validation->set_message('file_test', 'Please provide a thumbnail.');
	    if (empty($_FILES['thumbnail']['name'])) {
	            return false;
	        }else{
	            return true;
	    }		
	}
}
?>