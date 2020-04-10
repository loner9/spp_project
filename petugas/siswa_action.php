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
			$sub_array[] = '<button type="button" name="check_student" class="btn btn-primary btn-sm check_student" id="' . $row["nisn"] . '" value="' . $row["id_spp"] . '">Cek</button>';
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

}
