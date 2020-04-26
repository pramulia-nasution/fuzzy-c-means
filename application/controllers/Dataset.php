<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Dataset extends CI_Controller {

	private $parents = 'Dataset';
	private $icon	 = 'fa fa-table';
	var $table 		 = 'dataset';
	private $filename = "import_data"; 

	function __construct(){
		parent::__construct();
		is_login();
		get_breadcrumb();
		
		$this->load->library('Datatables'); 
		$this->load->model('M_Dataset');
	}

	public function index(){

		$this->breadcrumb->append_crumb('Fuzzy C-Means','Beranda');
		$this->breadcrumb->append_crumb($this->parents,$this->parents);

		$data['title']	= $this->parents.' | Fuzzy C-Means ';
		$data['judul']	= $this->parents;
		$data['icon']	= $this->icon;

	$this->template->views('v_'.$this->parents,$data);
	}

	function getData (){
		header('Content-Type:application/json');
		echo $this->M_Dataset->getAllData();
	}

	public function edit($id){
		$data = $this->M_General->getByID($this->table,'id',$id,'id')->row();
		echo json_encode($data);
	}

	function Ubah(){
        $insert = array(
                    'name'	=> $this->input->post('nama',TRUE),
                    'x1' 	=> $this->input->post('x1',TRUE),
                    'x2' 	=> $this->input->post('x2',TRUE),
                    'x3' 	=> $this->input->post('x3',TRUE),
                    'x4' 	=> $this->input->post('x4',TRUE),
                    'x5' 	=> $this->input->post('x5',TRUE)
                );

        $insert = $this->M_General->update($this->table,$insert,'id',$this->input->post('id'));
        $data['status'] = TRUE;
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	function Simpan(){
        $insert = array(
                    'name'	=> $this->input->post('nama',TRUE),
                    'x1' 	=> $this->input->post('x1',TRUE),
                    'x2' 	=> $this->input->post('x2',TRUE),
                    'x3' 	=> $this->input->post('x3',TRUE),
                    'x4' 	=> $this->input->post('x4',TRUE),
                    'x5' 	=> $this->input->post('x5',TRUE)
                );

        $insert = $this->M_General->insert($this->table,$insert);
        $data['status'] = TRUE;
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	function import(){

		$upload = $this->M_Dataset->upload_file($this->filename);
	
		if ($upload['status'] == true){  
		include APPPATH.'third_party/PHPExcel/PHPExcel.php';
		$excelreader = new PHPExcel_Reader_Excel2007();
		$loadexcel = $excelreader->load('excel/'.$this->filename.'.xlsx');
		$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
		
		$data = array();
		$numrow = 1;
		foreach($sheet as $row){
			if($numrow > 1){
				// Kita push (add) array data ke variabel data
				array_push($data, array(
					'name'=>$row['A'],
					'x1'=>$row['B'],
					'x2'=>$row['C'],
					'x3'=>$row['D'],
					'x4'=>$row['E'],
					'x5'=>$row['F'],
				));
			}
			
			$numrow++;
		}
		$this->M_Dataset->insert_multiple($data);
		
        $data['status'] = TRUE;
    	}
    	else{
    		$data['status'] = FALSE;
    	}
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function Hapus($id){
		$data = $this->M_General->getByID($this->table,'id',$id,'id')->row_array();

		$this->M_General->delete($this->table,'id',$id);
		$data['status'] = TRUE;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	function Kosong(){
		$this->M_General->truncate($this->table);
		$data['status'] = TRUE;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
}
