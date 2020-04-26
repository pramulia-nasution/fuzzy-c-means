<?php
/**
 * @author P.S Nasution
 */
class M_Perhitungan extends CI_Model{

	function getAllData($id){
		$this->datatables->select("idSet,x1,x2,x3,x4,x5,u$id,round(pow(u$id,2),6) as U$id,ux1,ux2,ux3,ux4,ux5");
		$this->datatables->from('dataset as d');
		$this->datatables->join('matriks_s as u','d.id=u.id');
		$this->datatables->join("ppc as p","p.idSet=d.name AND p.c=$id");
	
	return $this->datatables->generate();  
	}

	function getAllFungsi(){
		$this->datatables->select('id,idSet,L1,L2,L3,LT');
		$this->datatables->from('pfo');
	return $this->datatables->generate();
	}

	function getAllCluster(){
		$this->datatables->select('id,c,v1,v2,v3,v4,v5');
		$this->datatables->from('hpc');
	return $this->datatables->generate();
	}

	function getMatriksPartisi(){
		$this->datatables->select('id,idSet,L1,L2,L3,LT,ui1,ui2,ui3');
		$this->datatables->from('mpu');
	return $this->datatables->generate();
	}

	function getRecap(){
		$this->datatables->select('id,fungsi,error');
		$this->datatables->from('recap');
		$this->datatables->edit_column('id','Iterasi $1','id');
	return $this->datatables->generate();
	}

	function getCluster(){
		$this->datatables->select('idSet,c');
		$this->datatables->from('mpu');
	return $this->datatables->generate();
	}

}