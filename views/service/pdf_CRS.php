<?php

$array = $this->pdfGen[0]; //data from service's controller
$array2 = $this->pdfJobs[0]; //datajobs from service's controller
$array3 = $this->pdfParts[0]; //dataparts from service's controller
#$array2 = $data2; //data from service's controller
require('public/FPDF/fpdf.php');

    /* echo "<pre>";
	echo var_dump($array);
	echo "</pre>";
	echo "<pre>";
	echo var_dump($array2);
	echo "</pre>";
	echo "<pre>";
	echo var_dump($array3);
	echo "</pre>";  */

$service_id = $array["service_id"];
$service_regdate = $array["service_regdate"];
$service_year = $array["service_year"];
$items_depart_name = $array["items_depart_name"];
$service_lastupdate = $array["service_lastupdate"];
$depart_name = $array["depart_name"];
$service_type = $array["service_type"];
$hardware_type_name = $array["hardware_type_name"];
$hardware_name = $array["hardware_name"];
$brand = $array["brand"];
$model = $array["model"];
$serial_number = $array["serial_number"];
$sn_scph = $array["sn_scph"];
$sym_sort = $array["sym_sort"];
$sym_name = $array["sym_name"];
$service_user = $array["service_user"];
$service_user_name = $array["service_user_name"];
$service_remark = $array["service_remark"];
$status_name = $array["status_name"];
$service_detail_detail = $array["service_detail_detail"];
$service_status_name = $array["service_status_name"];
$service_text = $array["service_text"];
$service_technician = $array["service_technician"];
$service_technician_name = $array["service_technician_name"];

$jobs_items_id = $array2[0]["jobs_items_id"];

$parts_items_id = $array3[0]["parts_items_id"];

/* for (var $i = 0; $i < $array['service_detail'].length; $i++) 
  {
  $service_detail_status_id2 = $array2[$i]["service_detail_status_id"];
  $status_name2 = $array2[$i]["status_name"];
  $service_detail_user2 = $array2[$i]["service_detail_user"];
  $service_detail_detail2 = $array2[$i]["service_detail_detail"];
  $service_detail_datetime2 = $array2[$i]["service_detail_datetime"];
  } */


/*  //Post -> Data Array in foreach[..]

  class PDF extends FPDF {
  function iconv_text($text) {
  return iconv('utf-8', 'tis-620', $text);
  }
  }

  $pdf = new PDF();
  $pdf->AddPage();
  $pdf->AddFont('THSarabun', '', 'THSarabun.php'); // AddFont('ชื่อฟอนต์','ตัวหน้า/เอียง ฯ','ไฟล์ฟอนต์ที่สร้าง');
  $pdf->SetFont('THSarabun', '', 16); // SetFont('ชื่อฟอนต์ที่ใช้งาน','ตัวหนา/เอียง ฯ','ขนาดฟอนต์');
  foreach ($array as $key => $value)
  {
  $pdf->Ln();
  $pdf->cell(40, 10, $pdf->iconv_text($value));
  }

  $pdf->Output(); */

/*  //Set Font THSarabun

  $pdf=new FPDF();
  $pdf->AddPage();

  $pdf->AddFont('THSarabun','','THSarabun.php');//ธรรมดา
  $pdf->SetFont('THSarabun','',30);
  $pdf->Cell(0,0,'ข้อความทดสอบ');
  $pdf->Ln(15);

  $pdf->AddFont('THSarabun','b','THSarabun Bold.php');//หนา
  $pdf->SetFont('THSarabun','b',30);
  $pdf->Cell(0,0,'ข้อความทดสอบ');
  $pdf->Ln(15);

  $pdf->AddFont('THSarabun','i','THSarabun Italic.php');//อียง
  $pdf->SetFont('THSarabun','i',30);
  $pdf->Cell(0,0,'ข้อความทดสอบ');
  $pdf->Ln(15);

  $pdf->AddFont('THSarabun','bi','THSarabun BoldItalic.php');//หนาเอียง
  $pdf->SetFont('THSarabun','bi',30);
  $pdf->Cell(0,0,'ข้อความทดสอบ');

  $pdf->Output(); */

class PDF extends FPDF {
	
    function iconv_text($text) {
        return iconv('utf-8', 'tis-620', $text);
    }
	
	
    // Page header	
    function Header() {
        // Logo
        $this->Image('public/FPDF/garuda.gif', 12, 8, 15);

        // THSarabun bold set font
        $this->AddFont('THSarabunIT9', 'b', 'THSarabunIT9 Bold.php');
        $this->SetFont('THSarabunIT9', 'b', 20);
        // Move to the right
        $this->Cell(80); // Title Center
        // Title
        //$this->Cell(30,10,$this->iconv_text('บันทึกข้อความ'),1,0,'C'); // title center in Rectengle box 
        $this->Cell(30, 10, $this->iconv_text('บันทึกข้อความ'));
			  $this->Cell(30, 10, $this->iconv_text($items_depart_name));
        // Line break
        $this->Ln(15);
    }

    // Page footer
    function Footer()
      {
      // Position at 1.5 cm from bottom
      $this->SetY(-80);
      // THSarabun font
		$this->AddFont('THSarabunIT9', '', 'THSarabunIT9.php');
		$this->SetFont('THSarabunIT9', '', 16);
      // Page number
	  //new line 
		$this->Cell(30, 8, $this->iconv_text('    ดังรายละเอียดคุณสมบัติที่แนบเรียนมาพร้อมนี้ จึงเรียนมาเพื่อโปรดทราบ และพิจารณาต่อไป'));
		$this->Ln();
		/* $this->Cell(94, 50, $this->iconv_text('ลงชื่อ..........................................(จพ.คอม)'), 1, 0, 'C', 0);
		$this->Cell(94, 50, $this->iconv_text('ลงชื่อ..........................................(ผช.ผอ.)'), 1, 0, 'C', 0);
		$this->Ln(); */
		
		// THSarabun font
		$this->AddFont('THSarabunIT9', '', 'THSarabunIT9.php');
		$this->SetFont('THSarabunIT9', '', 14);
		//signature Table
		$this->SetLineWidth(0);
		$this->Rect(18,225,87,60);
		$this->setXY(40,233);
		$this->MultiCell(0,0,iconv('UTF-8','cp874','ลงชื่อ........................................'));
		$this->setXY(40,238);
		$this->MultiCell(0,0,iconv('UTF-8','cp874','(................................................)'));
		
		$this->setXY(40,245);
		$this->MultiCell(0,0,iconv('UTF-8','cp874','เจ้าพนักงานเครื่องคอมพิวเตอร์'));
		$this->setXY(31,252);
		$this->MultiCell(0,0,iconv('UTF-8','cp874','..........................................................................'));
		$this->setXY(31,257);
		$this->MultiCell(0,0,iconv('UTF-8','cp874','..........................................................................'));
		$this->setXY(40,267);
		$this->MultiCell(0,0,iconv('UTF-8','cp874','ลงชื่อ........................................'));
		$this->setXY(46,272);
		$this->MultiCell(0,0,iconv('UTF-8','cp874','(นายสัญญา สุรารักษ์)'));
		$this->setXY(44,277);
		$this->MultiCell(0,0,iconv('UTF-8','cp874','หัวหน้าศูนย์คอมพิวเตอร์'));

		$this->SetLineWidth(0);
		$this->Rect(105,225,87,60);
		$this->setXY(116,231);
		$this->MultiCell(0,0,iconv('UTF-8','cp874','..........................................................................'));
		$this->setXY(125,238);
		$this->MultiCell(0,0,iconv('UTF-8','cp874','ลงชื่อ........................................'));
		$this->setXY(125,243);
		$this->MultiCell(0,0,iconv('UTF-8','cp874','(นางสาวเสาวณีย์ ยถาภูธานนท์)'));
		$this->setXY(126,248);
		$this->MultiCell(0,0,iconv('UTF-8','cp874','ผู้ช่วยผู้อำนวยการด้านวิชาการ'));
		$this->setXY(116,256);
		$this->MultiCell(0,0,iconv('UTF-8','cp874','..........................................................................'));
		$this->setXY(116,261);
		$this->MultiCell(0,0,iconv('UTF-8','cp874','..........................................................................'));
		$this->setXY(125,270);
		$this->MultiCell(0,0,iconv('UTF-8','cp874','ลงชื่อ........................................'));
		$this->setXY(128,276);
		$this->MultiCell(0,0,iconv('UTF-8','cp874','(นายสมศักดิ์ เชาว์ศิริกุล)'));
		$this->setXY(114,281);
		$this->MultiCell(0,0,iconv('UTF-8','cp874','ผู้อำนวยการโรงพยาบาลสมเด็จพระยุพราชสระแก้ว'));
      //$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C'); #เลขหน้า
      }
	   
    //Jobs table
    function JobsTable($header, $array2) {
		$this->AddFont('THSarabun', '', 'THSarabun.php');
		$this->SetFont('THSarabun', '', 16);
        //Column widths
        $w = array(8, 73, 22, 15, 20, 22, 32);
        //Header
        for ($i = 0; $i < count($header); $i++)
            $this->Cell($w[$i], 10, $this->iconv_text($header[$i]), 1, 0, 'C');
        $this->Ln();

        //Data
        #foreach($array2 as $key => $value)
        $num=1;
		foreach ($array2 as $row) {
			$this->Cell(8,6,$num,'LR',0,'C',0);
            #$this->Cell($w[0], 6, $this->iconv_text($row['service_detail_status_id']),'LR',0,'L',0);
            $this->Cell($w[1], 6, $this->iconv_text($row['jobs_name']),'LR',0,'L',0);
            $this->Cell($w[2], 6, $this->iconv_text($row['jobs_unit_price']),'LR',0,'L',0);
            $this->Cell($w[3], 6, $this->iconv_text($row['jobs_qty']),'LR',0,'C',0);
            $this->Cell($w[4], 6, $this->iconv_text($row['jobs_sum_price']),'LR',0,'L',0);
            $this->Cell($w[5], 6, $this->iconv_text($row['jobs_date']),'LR',0,'L',0);
            $this->Cell($w[6], 6, $this->iconv_text($row['jobs_staff_name']),'LR',0,'L',0);
            #$this->Cell($w[4],6,number_format($row[4][$service_detail_datetime2]),'LR',0,'R');
            #$this->cell(40, 10, $pdf->iconv_text($value));
			$this->Ln();
			if ($num++ == 5) break; 
			#$num++;
        }
			
        //Closure line
			$this->Cell(array_sum($w),0,'','T');
    }
	
	//Parts table
    function PartsTable($header, $array3) {
		$this->AddFont('THSarabun', '', 'THSarabun.php');
		$this->SetFont('THSarabun', '', 16);
        //Column widths
        #$w = array(8, 30, 13, 17, 15, 20, 13, 17, 25, 32);
        $w = array(8, 25, 35, 25, 20, 13, 17, 20, 30);
        //Header
        for ($i = 0; $i < count($header); $i++)
            $this->Cell($w[$i], 10, $this->iconv_text($header[$i]), 1, 0, 'C');
        $this->Ln();

        //Data
        #foreach($array2 as $key => $value)
        $num=1;
		foreach ($array3 as $row) {
			$this->Cell(8,6,$num,'LR',0,'C',0);
            #$this->Cell($w[0], 6, $this->iconv_text($row['service_detail_status_id']),'LR',0,'L',0);
            $this->Cell($w[1], 6, $this->iconv_text($row['store_type_name']),'LR',0,'L',0);
            $this->Cell($w[2], 6, $this->iconv_text($row['store_name']),'LR',0,'L',0);
            $this->Cell($w[3], 6, $this->iconv_text($row['serial_number']),'LR',0,'L',0);
			#$this->Cell($w[4], 6, $this->iconv_text($row['store_type_count']),'LR',0,'C',0);
            $this->Cell($w[4], 6, $this->iconv_text($row['store_unit_price']),'LR',0,'L',0);
            $this->Cell($w[5], 6, $this->iconv_text($row['parts_qty']),'LR',0,'C',0);
            $this->Cell($w[6], 6, $this->iconv_text($row['store_sum_price']),'LR',0,'L',0);
            $this->Cell($w[7], 6, $this->iconv_text($row['parts_date']),'LR',0,'L',0);
            $this->Cell($w[8], 6, $this->iconv_text($row['parts_staff_name']),'LR',0,'L',0);
            #$this->Cell($w[4],6,number_format($row[4][$service_detail_datetime2]),'LR',0,'R');
            #$this->cell(40, 10, $pdf->iconv_text($value));
			$this->Ln();
			if ($num++ == 5) break; 
        }
			
        //Closure line
			$this->Cell(array_sum($w),0,'','T');
    }
	
	//jobs history table
    /* function historyTable($header, $array4) {
        //Column widths
        $w = array(8, 30, 13, 17, 15, 20, 13, 17, 25, 32);
        //Header
        for ($i = 0; $i < count($header); $i++)
            $this->Cell($w[$i], 10, $this->iconv_text($header[$i]), 1, 0, 'C');
        $this->Ln();

        //Data
        #foreach($array2 as $key => $value)
        $num=1;
		foreach ($array4 as $row) {
			$this->Cell(8,6,$num,'LR',0,'C',0);
            #$this->Cell($w[0], 6, $this->iconv_text($row['service_detail_status_id']),'LR',0,'L',0);
            $this->Cell($w[1], 6, $this->iconv_text($row['store_type_name']),'LR',0,'L',0);
            $this->Cell($w[2], 6, $this->iconv_text($row['store_name']),'LR',0,'L',0);
            $this->Cell($w[3], 6, $this->iconv_text($row['serial_number']),'LR',0,'L',0);
            $this->Cell($w[4], 6, $this->iconv_text($row['store_type_count']),'LR',0,'C',0);
            $this->Cell($w[5], 6, $this->iconv_text($row['store_unit_price']),'LR',0,'L',0);
            $this->Cell($w[6], 6, $this->iconv_text($row['parts_qty']),'LR',0,'C',0);
            $this->Cell($w[7], 6, $this->iconv_text($row['store_sum_price']),'LR',0,'L',0);
            $this->Cell($w[8], 6, $this->iconv_text($row['parts_date']),'LR',0,'L',0);
            $this->Cell($w[9], 6, $this->iconv_text($row['parts_staff_name']),'LR',0,'L',0);
            #$this->Cell($w[4],6,number_format($row[4][$service_detail_datetime2]),'LR',0,'R');
            #$this->cell(40, 10, $pdf->iconv_text($value));
			$this->Ln();
			if ($num++ == 5) break; 
        }
			
        //Closure line
			$this->Cell(array_sum($w),0,'','T');
    } */

}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

//first line
		$pdf->AddFont('THSarabunIT9', 'b', 'THSarabunIT9 Bold.php');
		$pdf->SetFont('THSarabunIT9', 'b', 16);
		$pdf->Cell(20, 8, $pdf->iconv_text('ส่วนราชการ '));
		$pdf->AddFont('THSarabunIT9', '', 'THSarabunIT9.php');
		$pdf->SetFont('THSarabunIT9', '', 16);
		$pdf->Cell(77, 8, $pdf->iconv_text('โรงพยาบาลสมเด็จพระยุพราชสระแก้ว กลุ่มงาน...................................................'));
		$pdf->cell(50, 7, $pdf->iconv_text($items_depart_name));
		$pdf->AddFont('THSarabunIT9', '', 'THSarabunIT9.php');
		$pdf->SetFont('THSarabunIT9', '', 14);
		$pdf->MultiCell(35, 5, $pdf->iconv_text('เลขที่ ' . $service_id . '/' . $service_year . '         วันที่ ' . $service_regdate . ' '), 1, 'C', false);
		#$pdf->cell(8, 5 ,$pdf->iconv_text($service_id) ,0,'C',false);
		#$pdf->cell(8, 5 ,$pdf->iconv_text($service_year) ,0,'C',false);

		$pdf->Ln(-4);

		//new line
		$pdf->AddFont('THSarabunIT9', 'b', 'THSarabunIT9 Bold.php');
		$pdf->SetFont('THSarabunIT9', 'b', 16);
		$pdf->Cell(4, 8, $pdf->iconv_text('ที่ '));
		$pdf->AddFont('THSarabunIT9', '', 'THSarabunIT9.php');
		$pdf->SetFont('THSarabunIT9', '', 16);
		$pdf->Cell(77, 8, $pdf->iconv_text('สก ๐๐๓๒.๒๐๒/.................'));
		//line
		$pdf->AddFont('THSarabunIT9', 'b', 'THSarabunIT9 Bold.php');
		$pdf->SetFont('THSarabunIT9', 'b', 16);
		$pdf->cell(8, 8, $pdf->iconv_text('วันที่'));
		$pdf->AddFont('THSarabunIT9', '', 'THSarabunIT9.php');
		$pdf->SetFont('THSarabunIT9', '', 16);
		//$pdf->cell(8,7, $pdf->iconv_text($service_lastupdate));
		$pdf->cell(8, 8, $pdf->iconv_text('....................................................'));
		//set array of string by fn(explode)
		$crs_lastdate = explode(" ", $pdf->iconv_text($service_lastupdate));
		$pdf->cell(8, 7, $crs_lastdate[0]);
		$pdf->Ln(6);

		//new line
		$pdf->AddFont('THSarabunIT9', 'b', 'THSarabunIT9 Bold.php');
		$pdf->SetFont('THSarabunIT9', 'b', 16);
		$pdf->Cell(8, 8, $pdf->iconv_text('เรื่อง'));
		$pdf->AddFont('THSarabunIT9', '', 'THSarabunIT9.php');
		$pdf->SetFont('THSarabunIT9', '', 16);
		$pdf->Cell(77, 8, $pdf->iconv_text('ขออนุมัติซ่อมครุภัณฑ์คอมพิวเตอร์'));
		$pdf->Ln(8);
		//underline
		$pdf->Cell(185, ' ', ' ', 1, ' ', 'C');
		$pdf->Ln();
		
//new line (Start custom content)
$pdf->AddFont('THSarabunIT9', 'b', 'THSarabunIT9 Bold.php');
$pdf->SetFont('THSarabunIT9', 'b', 16);
$pdf->Cell(9, 8, $pdf->iconv_text('เรียน '));
$pdf->AddFont('THSarabunIT9', '', 'THSarabunIT9.php');
$pdf->SetFont('THSarabunIT9', '', 16);
$pdf->Cell(77, 8, $pdf->iconv_text('ผู้อำนวยการโรงพยาบาลสมเด็จพระยุพราชสระแก้ว (ผ่านศูนย์คอมพิวเตอร์)'));
$pdf->Ln();

//new line
$pdf->Cell(42, 8, $pdf->iconv_text('       	 ด้วยกลุ่มงาน/งาน....................................................... มีความประสงค์ที่จะทำการซ่อมคอมพิวเตอร์ และอุปกรณ์คอมพิวเตอร์'));
$pdf->cell(8, 7, $pdf->iconv_text($depart_name));
$pdf->Ln();

//new line
$pdf->Cell(15, 8, $pdf->iconv_text('โดยการ....................................... ตามรายการต่อไปนี้'));
if ($array["service_type"] == 'repair') {
    $pdf->cell(8, 7, $pdf->iconv_text('ขออนุมัติซ่อม '));
} else
    $pdf->cell(8, 7, $pdf->iconv_text('ขออนุมัติอื่นๆ '));
$pdf->Ln();

//new line
$pdf->cell(41, 8, $pdf->iconv_text('        	ประเภทอุปกรณ์.........................................'));
$pdf->cell(34, 7, $pdf->iconv_text($hardware_type_name));
$pdf->cell(15, 8, $pdf->iconv_text('อุปกรณ์.........................................'));
$pdf->cell(32, 7, $pdf->iconv_text($hardware_name));
$pdf->AddFont('THSarabun', '', 'THSarabun.php');
$pdf->SetFont('THSarabun', '', 16);
$pdf->cell(20, 8, $pdf->iconv_text('ชื่ออุปกรณ์.....................................................'));
$pdf->cell(8, 7, $pdf->iconv_text($brand . ' ' . $model));
$pdf->Ln();

$pdf->cell(28, 8, $pdf->iconv_text('Serial number...............................................'));
$pdf->cell(39, 7, $pdf->iconv_text($serial_number));
$pdf->cell(25, 8, $pdf->iconv_text('เลขครุภัณฑ์..................................................................................................................'));
$pdf->cell(28, 7, $pdf->iconv_text($sn_scph));
$pdf->Ln();
$pdf->cell(40, 8, $pdf->iconv_text('โดยมีการแจ้งซ่อมดังนี้...........................................................................................................................................................................'));
if ($array["sym_sort"] == '99') {
    $pdf->cell(10, 7, $pdf->iconv_text($sym_name . '  ระบุ ' . $service_symptom_text));
} else if ($array["sym_sort"] >= '1' && $array["sym_sort"] <= '98') {
    $pdf->cell(10, 7, $pdf->iconv_text($sym_name . '  หมายเหตุ ' . $service_symptom_text));
} else
    $pdf->cell(10, 7, $pdf->iconv_text(' '));
$pdf->Ln(13);

//new line
$pdf->cell(82, 8, $pdf->iconv_text('                 ลงชื่อ..........................................(ผู้ส่งซ่อม)'));
$pdf->cell(39, 8, $pdf->iconv_text('              ลงชื่อ..........................................(หัวหน้ากลุ่มงาน/งาน)'));
$pdf->Ln();

//new line
$pdf->cell(86, 8, $pdf->iconv_text('                      (...........................................)'));
 //$pdf->cell(56, 7, $pdf->iconv_text($service_user_name));
$pdf->cell(39, 8, $pdf->iconv_text('                (...........................................)'));
$pdf->Ln();

//new line
$pdf->cell(82, 8, $pdf->iconv_text('                 ตำแหน่ง.............................................'));
$pdf->cell(39, 8, $pdf->iconv_text('              ตำแหน่ง.............................................'));
$pdf->Ln(10);

//underline
$pdf->Cell(185, ' ', ' ', 1, ' ', 'C');
$pdf->Ln();

//new line
$pdf->AddFont('THSarabunIT9', 'b', 'THSarabunIT9 Bold.php');
$pdf->SetFont('THSarabunIT9', 'b', 16);
$pdf->Cell(30, 8, $pdf->iconv_text('       	 บันทึกของ'));
$pdf->AddFont('THSarabunIT9', '', 'THSarabunIT9.php');
$pdf->SetFont('THSarabunIT9', '', 16);
$pdf->Cell(40, 8, $pdf->iconv_text(' เจ้าหน้าที่คอมพิวเตอร์ เสนอ ผู้ช่วยผู้อำนวยการด้านวิชาการ'));
$pdf->Ln();

//new line
$pdf->AddFont('THSarabunIT9', '', 'THSarabunIT9.php');
$pdf->SetFont('THSarabunIT9', '', 16);
$pdf->Cell(30, 8, $pdf->iconv_text('       	 ศูนย์คอมพิวเตอร์ได้ทำการตรวจสอบและตรวจซ่อมบำรุงตามรายการข้างต้นแล้วมีสาเหตุเนื่องจาก'));
$pdf->Ln();

//new line
#$pdf->MultiCell(float w, float h, string txt [, mixed border [, string align [, boolean fill]]])  //--------------------- format multicell ----------------------------
$pdf->MultiCell(193, 5, $pdf->iconv_text('................................................................................................................................................................................................................'), 0, 'L', false);
$pdf->MultiCell(193, 7, $pdf->iconv_text('................................................................................................................................................................................................................'), 0, 'L', false);
$pdf->setXY(20,138);
$pdf->MultiCell(193,0,iconv('UTF-8','cp874',$service_remark));
$pdf->setXY(10,147);
$pdf->MultiCell(193, 8 ,$pdf->iconv_text('สถานะการดำเนินการ.............................................................หมายเหตุ.................................................................................................'));
$pdf->setXY(50,150);
$pdf->MultiCell(0,0,iconv('UTF-8','cp874',$status_name));
$pdf->setXY(120,150);
$pdf->MultiCell(0,0,iconv('UTF-8','cp874',$service_detail_detail));
#$pdf->MultiCell(193, 8, $pdf->iconv_text('................................' . $service_remark . '................................................................สถานะการดำเนินการ....' . $status_name . '..........................................................หมายเหตุ....' . $service_detail_detail . '...........................................................'), 0, 'L', false);
$pdf->Ln(4);

//new line
$pdf->Cell(23, 8, $pdf->iconv_text('วิธีการซ่อมโดย..................................................................................'));
$pdf->Cell(74, 7, $pdf->iconv_text($service_status_name));
$pdf->Cell(18, 8, $pdf->iconv_text('รายละเอียด...................................................................................'));
$pdf->Cell(40, 7, $pdf->iconv_text($service_text));
$pdf->Ln();

#if (!empty($jobs_items_id)) {
#if (isset($array2["jobs_items_id"]) || strlen($array2["jobs_items_id"]) > 0) {
if ($jobs_items_id <> '' && $jobs_items_id <> null){
//new line
$pdf->AddFont('THSarabunIT9', 'b', 'THSarabunIT9 Bold.php');
$pdf->SetFont('THSarabunIT9', 'b', 16);
$pdf->Cell(27, 8, $pdf->iconv_text('รายการงานซ่อม'));
$pdf->Ln();

//Title Jobs
$pdf->Cell(8, 5, $pdf->iconv_text('#'), 1, 0, 'C', 0);
$pdf->Cell(73, 5, $pdf->iconv_text('รายการ'), 1, 0, 'C', 0);
$pdf->Cell(22, 5, $pdf->iconv_text('ราคา/หน่วย'), 1, 0, 'C', 0);
$pdf->Cell(15, 5, $pdf->iconv_text('จำนวน'), 1, 0, 'C', 0);
$pdf->Cell(20, 5, $pdf->iconv_text('ราคารวม'), 1, 0, 'C', 0);
$pdf->Cell(22, 5, $pdf->iconv_text('วันที่'), 1, 0, 'C', 0);
$pdf->Cell(32, 5, $pdf->iconv_text('เจ้าหน้าที่'), 1, 0, 'C', 0);
$pdf->Ln(0); 

//Data Table Jobs
$pdf->AddFont('THSarabunIT9', '', 'THSarabunIT9.php');
$pdf->SetFont('THSarabunIT9', '', 16);
$pdf->JobsTable($header, $array2);
$pdf->Ln();
}

if ($parts_items_id<> '' && $parts_items_id <> null) {
//new line
$pdf->AddFont('THSarabunIT9', 'b', 'THSarabunIT9 Bold.php');
$pdf->SetFont('THSarabunIT9', 'b', 16);
$pdf->Cell(27, 8, $pdf->iconv_text('รายการอะไหล่'));
$pdf->Ln();

//Title Parts
$pdf->Cell(8, 5, $pdf->iconv_text('#'), 1, 0, 'C', 0);
$pdf->Cell(25, 5, $pdf->iconv_text('ประเภท'), 1, 0, 'C', 0);
$pdf->Cell(35, 5, $pdf->iconv_text('รุ่น'), 1, 0, 'C', 0);
$pdf->Cell(25, 5, $pdf->iconv_text('serial'), 1, 0, 'C', 0);
#$pdf->Cell(15, 5, $pdf->iconv_text('หน่วยนับ'), 1, 0, 'C', 0);
$pdf->Cell(20, 5, $pdf->iconv_text('ราคา/หน่วย'), 1, 0, 'C', 0);
$pdf->Cell(13, 5, $pdf->iconv_text('จำนวน'), 1, 0, 'C', 0);
$pdf->Cell(17, 5, $pdf->iconv_text('ราคารวม'), 1, 0, 'C', 0);
$pdf->Cell(20, 5, $pdf->iconv_text('วันที่'), 1, 0, 'C', 0);
$pdf->Cell(30, 5, $pdf->iconv_text('เจ้าหน้าที่'), 1, 0, 'C', 0);
$pdf->Ln(0);


//Data Table Parts
$pdf->AddFont('THSarabunIT9', '', 'THSarabunIT9.php');
$pdf->SetFont('THSarabunIT9', '', 16);
$pdf->PartsTable($header, $array3);
$pdf->Ln(); }

$pdf->SetFont('THSarabunIT9', '', 14);
$pdf->setXY(42,237);
$pdf->MultiCell(0,0,iconv('UTF-8','cp874',$service_technician_name));

// New Page ################################
				$pdf->AddPage();
				$pdf->AddFont('THSarabunIT9', '', 'THSarabunIT9.php');
				$pdf->SetFont('THSarabunIT9','',$fontLine);
				
		//first line
		$pdf->AddFont('THSarabunIT9', 'b', 'THSarabunIT9 Bold.php');
		$pdf->SetFont('THSarabunIT9', 'b', 16);
		$pdf->Cell(20, 8, $pdf->iconv_text('ส่วนราชการ '));
		$pdf->AddFont('THSarabunIT9', '', 'THSarabunIT9.php');
		$pdf->SetFont('THSarabunIT9', '', 16);
		$pdf->Cell(77, 8, $pdf->iconv_text('โรงพยาบาลสมเด็จพระยุพราชสระแก้ว กลุ่มงาน...................................................'));
		$pdf->cell(50, 7, $pdf->iconv_text($items_depart_name));
		$pdf->AddFont('THSarabunIT9', '', 'THSarabunIT9.php');
		$pdf->SetFont('THSarabunIT9', '', 14);
		$pdf->MultiCell(35, 5, $pdf->iconv_text('เลขที่ ' . $service_id . '/' . $service_year . '         วันที่ ' . $service_regdate . ' '), 1, 'C', false);
		#$pdf->cell(8, 5 ,$pdf->iconv_text($service_id) ,0,'C',false);
		#$pdf->cell(8, 5 ,$pdf->iconv_text($service_year) ,0,'C',false);

		$pdf->Ln(-4);

		//new line
		$pdf->AddFont('THSarabunIT9', 'b', 'THSarabunIT9 Bold.php');
		$pdf->SetFont('THSarabunIT9', 'b', 16);
		$pdf->Cell(4, 8, $pdf->iconv_text('ที่ '));
		$pdf->AddFont('THSarabunIT9', '', 'THSarabunIT9.php');
		$pdf->SetFont('THSarabunIT9', '', 16);
		$pdf->Cell(77, 8, $pdf->iconv_text('สก ๐๐๓๒.๒๐๒/.................'));
		//line
		$pdf->AddFont('THSarabunIT9', 'b', 'THSarabunIT9 Bold.php');
		$pdf->SetFont('THSarabunIT9', 'b', 16);
		$pdf->cell(8, 8, $pdf->iconv_text('วันที่'));
		$pdf->AddFont('THSarabunIT9', '', 'THSarabunIT9.php');
		$pdf->SetFont('THSarabunIT9', '', 16);
		//$pdf->cell(8,7, $pdf->iconv_text($service_lastupdate));
		$pdf->cell(8, 8, $pdf->iconv_text('....................................................'));
		//set array of string by fn(explode)
		$crs_lastdate = explode(" ", $pdf->iconv_text($service_lastupdate));
		$pdf->cell(8, 7, $crs_lastdate[0]);
		$pdf->Ln(6);

		//new line
		$pdf->AddFont('THSarabunIT9', 'b', 'THSarabunIT9 Bold.php');
		$pdf->SetFont('THSarabunIT9', 'b', 16);
		$pdf->Cell(8, 8, $pdf->iconv_text('เรื่อง'));
		$pdf->AddFont('THSarabunIT9', '', 'THSarabunIT9.php');
		$pdf->SetFont('THSarabunIT9', '', 16);
		$pdf->Cell(77, 8, $pdf->iconv_text('ขออนุมัติซ่อมครุภัณฑ์คอมพิวเตอร์'));
		$pdf->Ln(8);
		//underline
		$pdf->Cell(185, ' ', ' ', 1, ' ', 'C');
		$pdf->Ln();


$pdf->Output();
?>