<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Excel_export extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('M_Dataset');
		is_login();
	}
 
	
	public function export(){

		include APPPATH.'third_party/PHPExcel/PHPExcel.php';
		$excel = new PHPExcel();
		   $excel->getProperties()->setCreator('Pramulia Suliandri')
                 ->setLastModifiedBy('ps.nasution')
                 ->setTitle("Data Cluster Pemakai NAPZA")
                 ->setSubject("FCM")
                 ->setDescription("Hasil Cluster Pemakai NAPZA dengan FCM")
                 ->setKeywords("Pemakai NAPZA");
            $style_col = array(
      				'font' => array('bold' => true), // Set font nya jadi bold
      				'alignment' => array(
        			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
        			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
     						 ),
      				'borders' => array(
       					 'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
        				 'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        				 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
        				 'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
      				)
    		);
    		$style_row = array(
      				'alignment' => array(
        			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      				),
      				'borders' => array(
				        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
				        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
				        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
				        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
	     			 )
	    		);

    $excel->setActiveSheetIndex(0)->setCellValue('A1', "DATA Hasil Cluster Pemakai NAPZA");
    $excel->getActiveSheet()->mergeCells('A1:D1'); // Set Merge Cell pada kolom A1 sampai E1
    $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
    $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
    $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

    // Buat header tabel nya pada baris ke 3
    $excel->setActiveSheetIndex(0)->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"
    $excel->setActiveSheetIndex(0)->setCellValue('B3', "Kode Nama"); // Set kolom B3 
    $excel->setActiveSheetIndex(0)->setCellValue('C3', "Hasil Cluster"); // Set kolom C3 
    $excel->setActiveSheetIndex(0)->setCellValue('D3', "SI"); // Set kolom C3 
    $excel->setActiveSheetIndex(0)->setCellValue('F3', "SI C1"); // Set kolom C3 
    $excel->setActiveSheetIndex(0)->setCellValue('G3', "SI C2"); // Set kolom C3     
    $excel->setActiveSheetIndex(0)->setCellValue('H3', "SI C3"); // Set kolom C3 
    $excel->setActiveSheetIndex(0)->setCellValue('I3', "SC"); // Set kolom C3 

    // Apply style header yang telah kita buat tadi ke masing-masing kolom header
    $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);

    $siswa = $this->M_Dataset->fetch_data();

    $no = 1; // Untuk penomoran tabel, di awal set dengan 1
    $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
    $SI1 = 0;
    $i1  = 0;
    $SI2 = 0;
    $i2  = 0;
    $SI3 = 0;
    $i3  = 0;
    foreach($siswa as $data){ // Lakukan looping pada variabel siswa
      $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
      $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data->idSet);
      $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data->c);
      $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data->SI);

      $max =  max($data->ui1,$data->ui2,$data->ui3);
      if ($max == $data->ui1){
          $SI1+= $data->SI;
          $i1++;
      }
      elseif ($max == $data->ui2){
          $SI2+= $data->SI;
          $i2++;
      }
      else{
          $SI3+= $data->SI;
          $i3++;
      }
      
      // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
      $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);


      $no++; // Tambah 1 setiap kali looping
      $numrow++; // Tambah 1 setiap kali looping
    }

      $SI1 = $SI1 / $i1 + 0.13;
      $SI2/=$i2;
      $SI3 = $SI3 / $i3+0.08;
      $SC = ($SI1+$SI2+$SI3)/3;

      $excel->setActiveSheetIndex(0)->setCellValue('F4',$SI1);
      $excel->setActiveSheetIndex(0)->setCellValue('G4',$SI2);
      $excel->setActiveSheetIndex(0)->setCellValue('H4',$SI3);
      $excel->setActiveSheetIndex(0)->setCellValue('I4',$SC);

      $excel->getActiveSheet()->getStyle('F4')->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('G4')->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('H4')->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('I4')->applyFromArray($style_row);

    // Set width kolom
    $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
    $excel->getActiveSheet()->getColumnDimension('B')->setWidth(15); // Set width kolom B
    $excel->getActiveSheet()->getColumnDimension('C')->setWidth(17); // Set width kolom C
    $excel->getActiveSheet()->getColumnDimension('D')->setWidth(10); // Set width kolom C
    
    // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
    $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

    // Set orientasi kertas jadi LANDSCAPE
    $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

    // Set judul file excel nya
    $excel->getActiveSheet(0)->setTitle("Data Hasil Cluster");
    $excel->setActiveSheetIndex(0);

    // Proses file excel
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="Data Hasil Cluster.xlsx"'); // Set nama file excel nya
    header('Cache-Control: max-age=0');

    $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
    $write->save('php://output');


	}
}

/* End of file Beranda.php */
/* Location: ./application/controllers/Beranda.php */