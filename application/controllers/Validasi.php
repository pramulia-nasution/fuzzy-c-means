<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Validasi extends CI_Controller {

	function __construct(){
		parent::__construct();
		is_login();
	}

	function Silhouette(){

		$data = $this->db->query("SELECT ui1,ui2,ui3 FROM mpu");

		$clusterInDist = 0;
		$clusterOutDist = 0;
		$cluster =array(); 
		$SI = array();

		foreach ($data->result() as $key => $value) {

			$cluster[$key] = $value;
			$nextCluster[] = $key+1  >= $data->num_rows() ? $cluster[0] : $cluster[$key+1];

			$clusterAvgInDist = 0;
			foreach ($cluster as $val1) {
			 	$avgInDist = 0;
			 	foreach ($cluster as $val2) {
			 		$avgInDist += $this->_enculide($val1,$val2);
			 	}
			 	$avgInDist = $avgInDist/$data->num_rows();
			 	$clusterAvgInDist +=$AvgInDist;
			 } 
			 $clusterAvgInDist = $clusterAvgInDist/$data->num_rows();
			 $clusterInDist += $clusterAvgInDist;

			$clusterAvgOutDist = 0;
			foreach ($cluster as $val2) {
			 	$avgInDist = 0;
			 	foreach ($cluster as $val2) {
			 		$avgOutDist += _enculide($val1,$val2);
			 	}
			 	$avgOutDist = $avgOutDist/$data->num_rows();
			 	$clusterAvgOutDist +=$AvgOutDist;
			 } 

			 $clusterAvgOutDist = $clusterAvgOutDist/$data->num_rows();
			 $clusterOutDist += $clusterAvgOutDist;

			 $clusterInDist = $clusterInDist / $data->num_rows();
			 $clusterOutDist = $clusterOutDist /$data->num_rows();
			 $maxDist = $clusterInDist > $clusterOutDist ? $clusterInDist : $clusterOutDist;
			 array_push($SI,array(
			 	'SI' => $maxDist,
			 	'id' => $value->id
			 ));
			 $SI = ($clusterOutDist - $clusterInDist) /$maxDist;
		}
		$this->db->update_batch('mpu','id');
	}

	private function _enculide($i1,$i2){

		$r = 0; 
		foreach ($i2 as $a => $v){
			$temp = $v[$a] - $i1;
			$r +=$temp * $temp;
		}
		return pow($r,2);
	}

	public function index(){
		return;

	}

}

/* End of file Beranda.php */
/* Location: ./application/controllers/Beranda.php */