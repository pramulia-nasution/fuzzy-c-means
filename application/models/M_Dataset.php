<?php
/**
 * @author P.S Nasution
 */
class M_Dataset extends CI_Model{

	function getAllData(){
		$this->datatables->select('id,x1,x2,x3,x4,x5,name');
		$this->datatables->from('dataset');
		// $this->datatables->add_column('View','$1 \d $2','id,x1');
		return $this->datatables->generate();
	}

	function upload_file($filename){
		$this->load->library('upload'); // Load librari upload
		
		$config['upload_path'] = './excel/';
		$config['allowed_types'] = 'xlsx';
		$config['max_size']	= '2048';
		$config['overwrite'] = true;
		$config['file_name'] = $filename;
	
		$this->upload->initialize($config); // Load konfigurasi uploadnya
		if($this->upload->do_upload('file')){ // Lakukan upload dan Cek jika proses upload berhasil
			// Jika berhasil :
			$return = array('status' => true, 'file' => $this->upload->data(), 'error' => '');
			return $return;
		}else{
			// Jika gagal :
			$return = array('status' => false, 'file' => '', 'error' => $this->upload->display_errors());
			return $return;
		}
	}
	
	// Buat sebuah fungsi untuk melakukan insert lebih dari 1 data
	public function insert_multiple($data){
		$this->db->insert_batch('dataset', $data);
	}

	public function fetch_data(){
		return $this->db->query("SELECT idSet,c,SI,ui1,ui2,ui3 FROM mpu")->result();
	}

}