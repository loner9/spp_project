<?php

//siswa_action.php
//file ini digunakan untuk seluruh aksi di siswa.php

include('../config/config.php');

session_start();

if (isset($_POST["action"])) {
	if ($_POST["action"] == "fetch") {
		$query = "
		SELECT * FROM siswa 
		INNER JOIN kelas 
		ON kelas.id_kelas = siswa.id_kelas 
		";

		if (isset($_POST["search"]["value"])) {
			$query .= '
            WHERE siswa.nisn LIKE "%' . $_POST["search"]["value"] . '%"
            OR siswa.nama LIKE "%' . $_POST["search"]["value"] . '%" 
			OR siswa.nis LIKE "%' . $_POST["search"]["value"] . '%" 
            OR siswa.alamat LIKE "%' . $_POST["search"]["value"] . '%" 
            OR siswa.no_telp LIKE "%' . $_POST["search"]["value"] . '%"
			OR kelas.nama_kelas LIKE "%' . $_POST["search"]["value"] . '%" 
			';
		}
		if (isset($_POST["order"])) {
			$query .= 'ORDER BY ' . $_POST['order']['0']['column'] . ' ' . $_POST['order']['0']['dir'] . ' ';
		} else {
			$query .= 'ORDER BY siswa.id_kelas DESC ';
		}
		if ($_POST["length"] != -1) {
			$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}

		$statement = $connect->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		$data = array();
		$filtered_rows = $statement->rowCount();
		foreach ($result as $row) {
			$sub_array = array();
			$sub_array[] = $row["nisn"];
			$sub_array[] = $row["nama"];
			$sub_array[] = $row["nis"];
			$sub_array[] = $row["alamat"];
			$sub_array[] = $row["no_telp"];
			$sub_array[] = $row["nama_kelas"];
			$sub_array[] = '<button type="button" name="check_student" class="btn btn-info btn-sm check_student" id="' . $row["nisn"] . '" value="' . $row["id_spp"] . '">Cek</button>';
			$sub_array[] = '<button type="button" name="edit_student" class="btn btn-primary btn-sm edit_student" id="' . $row["nisn"] . '">Edit</button>';
			$sub_array[] = '<button type="button" name="delete_student" class="btn btn-danger btn-sm delete_student" id="' . $row["nisn"] . '">Delete</button>';
			$data[] = $sub_array;
		}
		$output = array(
			"draw"				=>	intval($_POST["draw"]),
			"recordsTotal"		=> 	$filtered_rows,
			"recordsFiltered"	=>	get_total_records($connect, 'siswa'),
			"data"				=>	$data
		);

		echo json_encode($output);
	}

	if ($_POST["action"] == 'Add' || $_POST["action"] == "Edit") {
		$student_id = '';
		$student_name = '';
		$student_school_id = '';
		$student_address = '';
		$student_phone = '';
		$student_grade_id = '';
		$student_paym_id = '';
		$error_student_id = '';
		$error_student_name = '';
		$error_student_school_id = '';
		$error_student_address = '';
		$error_student_phone = '';
		$error_student_grade_id = '';
		$error_student_paym_id = '';
		$error = 0;
		if (empty($_POST["student_id"])) {
			$error_student_id = 'NISN diperlukan';
			$error++;
		} else {
			$student_id = $_POST["student_id"];
		}
		if (empty($_POST["student_name"])) {
			$error_student_name = 'Nama Siswa diperlukan';
			$error++;
		} else {
			$student_name = $_POST["student_name"];
		}
		if (empty($_POST["student_school_id"])) {
			$error_student_school_id = 'No. Induk siswa diperlukan';
			$error++;
		} else {
			$student_school_id = $_POST["student_school_id"];
		}
		if (empty($_POST["student_address"])) {
			$error_student_address = 'Alamat siswa diperlukan';
			$error++;
		} else {
			$student_address = $_POST["student_address"];
		}
		if (empty($_POST["student_phone"])) {
			$error_student_phone = 'No. Hp siswa diperlukan';
			$error++;
		} else {
			$student_phone = $_POST["student_phone"];
		}
		if (empty($_POST["student_grade_id"])) {
			$error_student_grade_id = "Kelas siswa diperlukan";
			$error++;
		} else {
			$student_grade_id = $_POST["student_grade_id"];
		}
		if (empty($_POST["student_paym_id"])) {
			$error_student_paym_id = "Id SPP diperlukan";
			$error++;
		} else {
			$student_paym_id = $_POST["student_paym_id"];
		}
		if ($error > 0) {
			$output = array(
				'error'							=>	true,
				'error_student_id'              =>  $error_student_id,
				'error_student_name'			=>	$error_student_name,
				'error_student_school_id'		=>	$error_student_school_id,
				'error_student_address'			=>	$error_student_address,
				'error_student_phone'			=>	$error_student_phone,
				'error_student_grade_id'		=>	$error_student_grade_id
			);
		} else {
			if ($_POST["action"] == 'Add') {
				$data = array(
					':student_id'		=>	$student_id,
					':student_name'		=>	$student_name,
					':student_school_id'	=>	$student_school_id,
					':student_address'		=>	$student_address,
					':student_phone'		=>	$student_phone,
					':student_grade_id'	=>	$student_grade_id,
					':student_paym_id'	=>	$student_paym_id
				);
				$query = "
				INSERT INTO siswa 
				(nisn ,nama, nis, alamat, no_telp, id_kelas, id_spp) 
				VALUES (:student_id,:student_name, :student_school_id, :student_address, :student_phone, :student_grade_id, :student_paym_id)
				";

				$statement = $connect->prepare($query);
				if ($statement->execute($data)) {
					$output = array(
						'success'		=>	'Data Added Successfully',
					);
				}
			}
			if ($_POST["action"] == "Edit") {
				$data = array(
					':student_name'		=>	$student_name,
					':student_school_id'	=>	$student_school_id,
					':student_address'		=>	$student_address,
					':student_phone'		=>	$student_phone,
					':student_grade_id'		=>	$student_grade_id,
					':student_paym_id'		=>	$student_paym_id,
					':student_id'			=>	$_POST["student_id"]
				);
				$query = "
				UPDATE siswa 
				SET nama = :student_name, 
				nis = :student_school_id, 
                alamat = :student_address,
                no_telp = :student_phone, 
				id_kelas = :student_grade_id ,
				id_spp = :student_paym_id
				WHERE nisn = :student_id
				";
				$statement = $connect->prepare($query);
				if ($statement->execute($data)) {
					$output = array(
						'success'		=>	'Data Edited Successfully',
					);
				}
			}
		}
		echo json_encode($output);
	}

	if ($_POST["action"] == "edit_fetch") {
		$query = "
		SELECT * FROM siswa 
		WHERE nisn = '" . $_POST["student_id"] . "'
		";
		$statement = $connect->prepare($query);
		if ($statement->execute()) {
			$result = $statement->fetchAll();
			foreach ($result as $row) {
				$output["student_school_id"] = $row["nis"];
				$output["student_name"] = $row["nama"];
				$output["student_address"] = $row["alamat"];
				$output["student_phone"] = $row["no_telp"];
				$output["student_grade_id"] = $row["id_kelas"];
				$output["student_paym_id"] = $row["id_spp"];
				$output["student_id"] = $row["nisn"];
			}
			echo json_encode($output);
		}
	}
	if ($_POST["action"] == "delete") {
		$query = "
		DELETE FROM siswa 
		WHERE nisn = '" . $_POST["student_id"] . "'
		";
		$statement = $connect->prepare($query);
		if ($statement->execute()) {
			echo 'Data Delete Successfully';
		}
	}
}
