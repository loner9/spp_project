<?php

//report.php
//file ini digunakan untuk mencetak laporan

if(isset($_GET["action"]))
{
	include('../config/config.php');
	require_once 'pdf.php';
	session_start();
	$output = '';
	if($_GET["action"] == 'class_report')
	{
		if(isset($_GET["grade_id"], $_GET["from_date"], $_GET["to_date"]))
		{
			$pdf = new Pdf();
			//query untuk mengambil data
			$query = "
			SELECT tbl_attendance.attendance_date FROM tbl_attendance 
			INNER JOIN tbl_student 
			ON tbl_student.student_id = tbl_attendance.student_id 
			WHERE tbl_student.student_grade_id = '".$_GET["grade_id"]."' 
			AND (tbl_attendance.attendance_date BETWEEN '".$_GET["from_date"]."' AND '".$_GET["to_date"]."')
			GROUP BY tbl_attendance.attendance_date 
			ORDER BY tbl_attendance.attendance_date ASC
			";

			//connect dan execute query
			$statement = $connect->prepare($query);
			$statement->execute();
			$result = $statement->fetchAll();
			$output .= '
				<style>
				@page { margin: 20px; }
				
				</style>
				<p>&nbsp;</p>
				<h3 align="center">Rekap Kehadiran</h3><br />';
			foreach($result as $row)
			{
				//render output untuk penataan layout
				$output .= '
				<table width="100%" border="0" cellpadding="5" cellspacing="0">
			        <tr>
			        	<td><b>Tanggal - '.$row["attendance_date"].'</b></td>
			        </tr>
			        <tr>
			        	<td>
			        		<table width="100%" border="1" cellpadding="5" cellspacing="0">
			        			<tr>
			        				<td><b>Nama siswa</b></td>
			        				<td><b>No. Absen</b></td>
			        				<td><b>Kelas</b></td>
			        				<td><b>Guru</b></td>
			        				<td><b>Status Kehadiran</b></td>
			        			</tr>
				';
				//query untuk ambil data user pada tabel
				$sub_query = "
				SELECT * FROM tbl_attendance 
			    INNER JOIN tbl_student 
			    ON tbl_student.student_id = tbl_attendance.student_id 
			    INNER JOIN tbl_grade 
			    ON tbl_grade.grade_id = tbl_student.student_grade_id 
			    INNER JOIN tbl_teacher 
			    ON tbl_teacher.teacher_grade_id = tbl_grade.grade_id 
			    WHERE tbl_student.student_grade_id = '".$_GET["grade_id"]."' 
				AND tbl_attendance.attendance_date = '".$row["attendance_date"]."'
				";
				
				//connect dan execute query
				$statement = $connect->prepare($sub_query);
				$statement->execute();
				$sub_result = $statement->fetchAll();
				foreach($sub_result as $sub_row)
				{
					$output .= '
					<tr>
						<td>'.$sub_row["student_name"].'</td>
						<td>'.$sub_row["student_roll_number"].'</td>
						<td>'.$sub_row["grade_name"].'</td>
						<td>'.$sub_row["teacher_name"].'</td>
						<td>'.$sub_row["attendance_status"].'</td>
					</tr>
					';
				}
				$output .= 
					'</table>
					</td>
					</tr>
				</table><br />';
			}
			//nama file
			$file_name = 'Attendance Report.pdf';
			$pdf->loadHtml($output);
			$pdf->render();
			$pdf->stream($file_name, array("Attachment" => false));
			exit(0);
		}
	}
	//jika user memilih untuk mencetak laporan satu siswa saja
	if($_GET["action"] == "student_report")
	{
		if(isset($_GET["student_id"])){
            $pdf = new Pdf();
			$query = "
			SELECT * FROM siswa 
			INNER JOIN kelas 
			ON kelas.id_kelas = siswa.id_kelas 
			WHERE siswa.nisn = '".$_GET["student_id"]."' 
			";
			$statement = $connect->prepare($query);
			$statement->execute();
			$result = $statement->fetchAll();
			foreach($result as $row)
			{
				$output .= '
				<style>
				@page { margin: 20px; }
				
				</style>
				<p>&nbsp;</p>
				<h3 align="center">Rekap pembayaran</h3><br /><br />
				<table width="100%" border="0" cellpadding="5" cellspacing="0">
			        <tr>
			            <td width="25%"><b>Nama Siswa</b></td>
			            <td width="75%">'.$row["nama"].'</td>
			        </tr>
			        <tr>
			            <td width="25%"><b>NISN</b></td>
			            <td width="75%">'.$row["nisn"].'</td>
			        </tr>
			        <tr>
			            <td width="25%"><b>Kelas</b></td>
			            <td width="75%">'.$row["nama_kelas"].'</td>
			        </tr>
			        <tr>
			        	<td colspan="2" height="5">
			        		<h3 align="center">Detail Pembayaran</h3>
			        	</td>
			        </tr>
			        <tr>
			        	<td colspan="2">
			        		<table width="100%" border="1" cellpadding="5" cellspacing="0">
			        			<tr>
			        				<td><b>Tanggal Bayar</b></td>
			        				<td><b>Nominal Bayar</b></td>
			        			</tr>
				';
				$sub_query = "
				SELECT * FROM pembayaran 
				WHERE nisn = '".$_GET["student_id"]."'";

				$statement = $connect->prepare($sub_query);
				$statement->execute();
				$sub_result = $statement->fetchAll();
				foreach($sub_result as $sub_row)
				{
					$output .= '
					<tr>
						<td>'.$sub_row["tgl_bayar"].'</td>
						<td>'.$sub_row["jumlah_bayar"].'</td>
					</tr>
					';
				}
				$output .= '
						</table>
					</td>
					</tr>
				</table>
				';

				$file_name = "paymentReport.pdf";
				$pdf->loadHtml($output);
				$pdf->render();
				$pdf->stream($file_name, array("Attachment" => false));
				exit(0);
			}
		}
	}
}

?>