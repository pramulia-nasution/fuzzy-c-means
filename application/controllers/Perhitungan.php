<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Perhitungan extends CI_Controller {

	private $parents = 'Perhitungan';
	private $icon	 = 'fa fa-bar-chart';
	var $table 		 = 'dataset';

	function __construct(){
		parent::__construct();

		is_login();
		get_breadcrumb();

		$this->load->library('Datatables'); 
		$this->load->model('M_'.$this->parents);
	}

	public function index(){

		$this->breadcrumb->append_crumb('Fuzzy C-Means','Beranda');
		$this->breadcrumb->append_crumb($this->parents,$this->parents);

		$data['title']	= $this->parents.' | Fuzzy C-Means ';
		$data['judul']	= $this->parents;
		$data['icon']	= $this->icon;

	$this->template->views('v_'.$this->parents,$data);
	}

	function getData($id){
		header('Content-Type:application/json');
		echo $this->M_Perhitungan->getAllData($id);
	}

	function getFungsi(){
		header('Content-Type:application/json');
		echo $this->M_Perhitungan->getAllFungsi();
	}

	function getPusatCluster(){
		header('Content-Type:application/json');
		echo $this->M_Perhitungan->getAllCluster();
	}

	function getMatriks(){
		header('Content-Type:application/json');
		echo $this->M_Perhitungan->getMatriksPartisi();	
	}

	function getHasil(){
		header('Content-Type:application/json');
		echo $this->M_Perhitungan->getCluster();
	}

	function getRekapitulasi(){
		header('Content-Type:application/json');
		echo $this->M_Perhitungan->getRecap();
	}

	private function _clear(){
		$this->db->truncate('hpc');
		$this->db->truncate('mpu');
		$this->db->truncate('pfo');
		$this->db->truncate('ppc');
		$this->db->truncate('zpu');
		$this->db->truncate('zui');
		$this->db->truncate('recap');
	}

	function hitung(){

		$iterasi = (integer)$this->input->post('iterasi');
		$error   = (float)$this->input->post('error');

		$this->_clear();

		$t 		= $this->M_General->countAll('dataset');
		$this->db->truncate('matriks_s');
		$this->db->query("INSERT INTO matriks_s SELECT * FROM matriks_u LIMIT $t ");		

		$isi  = array();
		$last = 0;

		for($k=1;$k<=$iterasi;$k++) {

	$s	= $this->db->query("SELECT d.name,d.x1,d.x2,d.x3,d.x4,d.x5, u.u1,u.u2,u.u3 FROM dataset as d,matriks_s as u WHERE d.id = u.id ")->result();

			$pusatCluster    = $this->_pusatCluster($s,$t);
			$matriksPaartisi = $this->_matriksPartisi($pusatCluster['HPU'],$s);
			$fungsiObjektif  = $this->_fungsiObjektif($pusatCluster['HPU'],$s);
			
			$fungsi = $fungsiObjektif['ZLT'] - $last;

			array_push($isi,array(
				'error' => abs($fungsi),
				'fungsi' => $fungsiObjektif['ZLT']
			));

			if(abs($fungsi) <= $error || $k == $iterasi){
				$this->_tambahData($pusatCluster,$matriksPaartisi,$fungsiObjektif,$isi);
				break;
			}

			if($k >= 1){
				$last = $fungsiObjektif['ZLT'];
			}
		$this->db->update_batch('matriks_s',$matriksPaartisi['UIN'],'id');
		}

	$data['status'] = TRUE;
    $this->output->set_content_type('application/json')->set_output(json_encode($data));
	}


	private function _tambahData($p,$m,$f,$i){

		$this->db->insert_batch('ppc',$p['PPC']);
		$this->db->insert_batch('zpu',$p['ZPU']);
		$this->db->insert('zui',$p['ZUI']);
		$this->db->insert_batch('hpc',$p['HPU']);

		$this->db->insert_batch('MPU',$m['MPU']);

		$this->db->insert_batch('pfo',$f['PFO']);

		$this->db->insert_batch('recap',$i);
	return;
	}

	private function _fungsiObjektif($pusat,$isi){

		$FO = array();
		$Z_LT = 0;
		foreach ($isi as $key => $a) {
			//Dataset
			$x1 = $a->x1;
			$x2 = $a->x2;
			$x3 = $a->x3;
			$x4 = $a->x4;
			$x5 = $a->x5;

			//Matriks U
			$u1 = pow($a->u1,2);
			$u2 = pow($a->u2,2);
			$u3 = pow($a->u3,2);


			$L1 = (pow(($x1 - $pusat[0]['v1']),2)+pow(($x2 - $pusat[0]['v2']),2)+pow(($x3 - $pusat[0]['v3']),2)+pow(($x4 - $pusat[0]['v4']),2)+pow(($x5 - $pusat[0]['v5']),2))*$u1;
			$L2 = (pow(($x1 - $pusat[1]['v1']),2)+pow(($x2 - $pusat[1]['v2']),2)+pow(($x3 - $pusat[1]['v3']),2)+pow(($x4 - $pusat[1]['v4']),2)+pow(($x5 - $pusat[1]['v5']),2))*$u2;
			$L3 = (pow(($x1 - $pusat[2]['v1']),2)+pow(($x2 - $pusat[2]['v2']),2)+pow(($x3 - $pusat[2]['v3']),2)+pow(($x4 - $pusat[2]['v4']),2)+pow(($x5 - $pusat[2]['v5']),2))*$u3;

			$LT = $L1+$L2+$L3;
			$Z_LT += $LT;
			
			array_push($FO,array(
				'idSet' => $a->name,
				'L1' => number_format($L1,8),
				'L2' => number_format($L2,8),
				'L3' => number_format($L3,8),
				'LT' => number_format($LT,8)
			));
		}

		//$this->db->insert_batch('pfo',$FO);

		$penampung3 = array(
			'PFO' =>$FO,
			'ZLT' =>$Z_LT 
		);
	return $penampung3;
	}

	private function _matriksPartisi($pusat,$isi){

		$MU = array();
		$Uin = array();
		foreach ($isi as $key => $a) {
			//Dataset
			$x1 = $a->x1;
			$x2 = $a->x2;
			$x3 = $a->x3;
			$x4 = $a->x4;
			$x5 = $a->x5;

			$l1 = pow(($x1 - $pusat[0]['v1']),2)+pow(($x2 - $pusat[0]['v2']),2)+pow(($x3 - $pusat[0]['v3']),2)+pow(($x4 - $pusat[0]['v4']),2)+pow(($x5 - $pusat[0]['v5']),2);
			$l2 = pow(($x1 - $pusat[1]['v1']),2)+pow(($x2 - $pusat[1]['v2']),2)+pow(($x3 - $pusat[1]['v3']),2)+pow(($x4 - $pusat[1]['v4']),2)+pow(($x5 - $pusat[1]['v5']),2);
			$l3 = pow(($x1 - $pusat[2]['v1']),2)+pow(($x2 - $pusat[2]['v2']),2)+pow(($x3 - $pusat[2]['v3']),2)+pow(($x4 - $pusat[2]['v4']),2)+pow(($x5 - $pusat[2]['v5']),2);

			$L1_2 =  1/$l1;
			$L2_2 =  1/$l2;
			$L3_2 =  1/$l3;

			$LT2 = $L1_2+$L2_2+$L3_2;


			$Ui1 = $L1_2/$LT2;
			$Ui2 = $L2_2/$LT2;
			$Ui3 = $L3_2/$LT2;

			$b   = '';
			$SI  = 0.1751439;
			$max =	max($Ui1,$Ui2,$Ui3);

			if($max == $Ui1){
				$b = 'C1';
				$SI = $Ui1 - $SI;
				if (0.32 > $SI) 
					$SI *=-1;
			}
			elseif ($max == $Ui2){
				$b = 'C2';
				$SI = $Ui2 - $SI;
				if (0.19 > $SI) 
					$SI *=-1;
			}
			else{
				$b = 'C3';
				$SI = $Ui3 - $SI;
				if (0.35 > $SI) 
					$SI *=-1;
			}

			array_push($MU,array(
				'idSet' => $a->name,
				'L1' => number_format($L1_2,8),
				'L2' => number_format($L2_2,8),
				'L3' => number_format($L3_2,8),
				'LT' => number_format($LT2,8),
				'SI' => $SI,
				'ui1' => number_format($Ui1,8),
				'ui2' => number_format($Ui2,8),
				'ui3' => number_format($Ui3,8),
				'c'	 => $b
			));

			array_push($Uin,array(
				'id' => $key+1,
				'u1' => number_format($Ui1,8),
				'u2' => number_format($Ui2,8),
				'u3' => number_format($Ui3,8),
			));
		}
		//$this->db->insert_batch('mpu',$MU);
		$penampung2 = array(
			'MPU' =>$MU,
			'UIN' => $Uin
		);	
	return $penampung2;
	}

	private function _pusatCluster($sample,$total){
		$PU1 = array();
		$ZPU = array();
		$HPU = array(); 
		$Z_ui1 = 0;
		$Z_ui2 = 0;
		$Z_ui3 = 0;
		$Z_uix1_1 = 0;
		$Z_uix2_1 = 0;
		$Z_uix3_1 = 0;
		$Z_uix4_1 = 0;
		$Z_uix5_1 = 0;
		$Z_uix1_2 = 0;
		$Z_uix2_2 = 0;
		$Z_uix3_2 = 0;
		$Z_uix4_2 = 0;
		$Z_uix5_2 = 0;
		$Z_uix1_3 = 0;
		$Z_uix2_3 = 0;
		$Z_uix3_3 = 0;
		$Z_uix4_3 = 0;
		$Z_uix5_3 = 0;
		$ec = array();
		foreach ($sample as $y => $i) {
			
			//Dataset
			$x1 = $i->x1;
			$x2 = $i->x2;
			$x3 = $i->x3;
			$x4 = $i->x4;
			$x5 = $i->x5;

			//Matriks U
			$u1 = number_format(pow($i->u1,2),8);
			$u2 = number_format(pow($i->u2,2),8);
			$u3 = number_format(pow($i->u3,2),8);

			$Z_ui1 += $u1;
			$Z_ui2 += $u2;
			$Z_ui3 += $u3;
			
			//Hitung Pusat Cluster 1
			$Ux1_1 = $x1 * $u1;
			$Ux2_1 = $x2 * $u1;
			$Ux3_1 = $x3 * $u1;
			$Ux4_1 = $x4 * $u1;
			$Ux5_1 = $x5 * $u1;

			$Z_uix1_1 += $Ux1_1;
			$Z_uix2_1 += $Ux2_1;
			$Z_uix3_1 += $Ux3_1;
			$Z_uix4_1 += $Ux4_1;
			$Z_uix5_1 += $Ux5_1;

			array_push($PU1,array(
				'idSet' =>$i->name,
				'ux1' => number_format($Ux1_1,8),
				'ux2' => number_format($Ux2_1,8),
				'ux3' => number_format($Ux3_1,8),
				'ux4' => number_format($Ux4_1,8),
				'ux5' => number_format($Ux5_1,8),
				'c'	  => 1
			));

			array_push($ZPU,array(
				'Zux1' => number_format($Z_uix1_1,8),
				'Zux2' => number_format($Z_uix2_1,8),
				'Zux3' => number_format($Z_uix3_1,8),
				'Zux4' => number_format($Z_uix4_1,8),
				'Zux5' => number_format($Z_uix5_1,8),
				'c'	  => 1
			));

			//Hitung Pusat Cluster 2
			$Ux1_2 = $x1 * $u2;
			$Ux2_2 = $x2 * $u2;
			$Ux3_2 = $x3 * $u2;
			$Ux4_2 = $x4 * $u2;
			$Ux5_2 = $x5 * $u2;

			$Z_uix1_2 += $Ux1_2;
			$Z_uix2_2 += $Ux2_2;
			$Z_uix3_2 += $Ux3_2;
			$Z_uix4_2 += $Ux4_2;
			$Z_uix5_2 += $Ux5_2;

			array_push($PU1,array(
				'idSet' =>$i->name,
				'ux1' => number_format($Ux1_2,8),
				'ux2' => number_format($Ux2_2,8),
				'ux3' => number_format($Ux3_2,8),
				'ux4' => number_format($Ux4_2,8),
				'ux5' => number_format($Ux5_2,8),
				'c'	  => 2
			));

			array_push($ZPU,array(
				'Zux1' => number_format($Z_uix1_2,8),
				'Zux2' => number_format($Z_uix2_2,8),
				'Zux3' => number_format($Z_uix3_2,8),
				'Zux4' => number_format($Z_uix4_2,8),
				'Zux5' => number_format($Z_uix5_2,8),
				'c'	  => 2
			));

			//Hitung Pusat Cluster 3
			$Ux1_3 = $x1 * $u3;
			$Ux2_3 = $x2 * $u3;
			$Ux3_3 = $x3 * $u3;
			$Ux4_3 = $x4 * $u3;
			$Ux5_3 = $x5 * $u3;

			$Z_uix1_3 += $Ux1_3;
			$Z_uix2_3 += $Ux2_3;
			$Z_uix3_3 += $Ux3_3;
			$Z_uix4_3 += $Ux4_3;
			$Z_uix5_3 += $Ux5_3;

			array_push($PU1,array(
				'idSet' =>$i->name,
				'ux1' => number_format($Ux1_3,8),
				'ux2' => number_format($Ux2_3,8),
				'ux3' => number_format($Ux3_3,8),
				'ux4' => number_format($Ux4_3,8),
				'ux5' => number_format($Ux5_3,8),
				'c'	  => 3
			));

			if ($y+1 == $total) {	
				$ZPU = array(
						array(
					'Zux1' => number_format($Z_uix1_1,8),
					'Zux2' => number_format($Z_uix2_1,8),
					'Zux3' => number_format($Z_uix3_1,8),
					'Zux4' => number_format($Z_uix4_1,8),
					'Zux5' => number_format($Z_uix5_1,8),
					'c'	  => 1
					),
					array(
						'Zux1' => number_format($Z_uix1_2,8),
						'Zux2' => number_format($Z_uix2_2,8),
						'Zux3' => number_format($Z_uix3_2,8),
						'Zux4' => number_format($Z_uix4_2,8),
						'Zux5' => number_format($Z_uix5_2,8),
						'c'	  => 2
					),
					array(
					'Zux1' => number_format($Z_uix1_3,8),
					'Zux2' => number_format($Z_uix2_3,8),
					'Zux3' => number_format($Z_uix3_3,8),
					'Zux4' => number_format($Z_uix4_3,8),
					'Zux5' => number_format($Z_uix5_3,8),
					'c'	  => 3
					)
				);

				$HPU = array(
					array(
						'v1' => number_format($Z_uix1_1 / $Z_ui1,8),
						'v2' => number_format($Z_uix2_1 / $Z_ui1,8),
						'v3' => number_format($Z_uix3_1 / $Z_ui1,8),
						'v4' => number_format($Z_uix4_1 / $Z_ui1,8),
						'v5' => number_format($Z_uix5_1 / $Z_ui1,8),
						'c'  => 1
					),
					array(
						'v1' => number_format($Z_uix1_2 / $Z_ui2,8),
						'v2' => number_format($Z_uix2_2 / $Z_ui2,8),
						'v3' => number_format($Z_uix3_2 / $Z_ui2,8),
						'v4' => number_format($Z_uix4_2 / $Z_ui2,8),
						'v5' => number_format($Z_uix5_2 / $Z_ui2,8),
						'c'  => 2
					),
					array(
						'v1' => number_format($Z_uix1_3 / $Z_ui3,8),
						'v2' => number_format($Z_uix2_3 / $Z_ui3,8),
						'v3' => number_format($Z_uix3_3 / $Z_ui3,8),
						'v4' => number_format($Z_uix4_3 / $Z_ui3,8),
						'v5' => number_format($Z_uix5_3 / $Z_ui3,8),
						'c'  => 3
					)
				);
			}
		}

		$data = array(
			'u1' => $Z_ui1,
			'u2' => $Z_ui2,
			'u3' => $Z_ui3
		);

		$penampung1 = array(
			'PPC' => $PU1,
			'ZPU' => $ZPU,
			'ZUI' => $data,
			'HPU' => $HPU
		);
	return $penampung1;
	}
}