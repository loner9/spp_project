<?php

//spp_action.php
//file ini digunakan untuk seluruh aksi di spp.php

include('../config/config.php');

session_start();

if (isset($_POST["action"])) {
	if ($_POST["action"] == "fetch") {
		$query = "
		SELECT * FROM spp 
		";

		if (isset($_POST["search"]["value"])) {
			$query .= '
            WHERE tahun LIKE "%' . $_POST["search"]["value"] . '%"
            OR nominal LIKE "%' . $_POST["search"]["value"] . '%" 
			';
		}

		if (isset($_POST["order"])) {
			$query .= 'ORDER BY ' . $_POST['order']['0']['column'] . ' ' . $_POST['order']['0']['dir'] . ' ';
		} else {
			$query .= '
			ORDER BY tahun ASC ';
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
			$sub_array[] = $row["tahun"];
			$sub_array[] = $row["nominal"];
			$sub_array[] = '<button type="button" name="edit_paym" class="btn btn-primary btn-sm edit_paym" id="' . $row["id_spp"] . '">Edit</button>';
			$sub_array[] = '<button type="button" name="delete_paym" class="btn btn-danger btn-sm delete_paym" id="' . $row["id_spp"] . '">Delete</button>';
			$data[] = $sub_array;
		}
		$output = array(
			"draw"				=>	intval($_POST["draw"]),
			"recordsTotal"		=> 	$filtered_rows,
			"recordsFiltered"	=>	get_total_records($connect, 'spp'),
			"data"				=>	$data
		);

		echo json_encode($output);
	}

	if ($_POST["action"] == 'Add' || $_POST["action"] == "Edit") {
		$paym_year = '';
		$paym_amount = '';
		$error_paym_year = '';
		$error_paym_amount = '';
		$error = 0;
		if (empty($_POST["paym_year"])) {
			$error_paym_year = 'Nama Kelas diperlukan';
			$error++;
		} else {
			$paym_year = $_POST["paym_year"];
		}
		if (empty($_POST["paym_amount"])) {
			$error_paym_amount = 'Kompetensi diperlukan';
			$error++;
		} else {
			$paym_amount = $_POST["paym_amount"];
		}
		if ($error > 0) {
			$output = array(
				'error'							=>	true,
				'error_paym_year'              =>  $error_paym_year,
				'error_paym_amount'				=>	$error_paym_amount
			);
		} else {
			if ($_POST["action"] == "Add") {
				$data = array(
					':paym_year'				=>	$paym_year,
					':paym_amount'				=>	$paym_amount
				);
				$query = "
				INSERT INTO spp 
				(tahun, nominal) 
				SELECT * FROM (SELECT :paym_year, :paym_amount) as temp 
				WHERE NOT EXISTS (
					SELECT tahun FROM spp WHERE tahun = :paym_year
				) LIMIT 1
				";
				$statement = $connect->prepare($query);
				if ($statement->execute($data)) {
					if ($statement->rowCount() > 0) {
						$output = array(
							'success'		=>	'Data Berhasil ditambahkan',
						);
					} else {
						$output = array(
							'error'					=>	true,
							'error_paym_year'		=>	'Kelas Sudah Ada'
						);
					}
				}
			}
			if ($_POST["action"] == "Edit") {
				$data = array(
					':paym_year'				=>	$paym_year,
					':paym_amount'				=>	$paym_amount,
					':paym_id'				=>	$_POST["paym_id"]
				);
				$query = "UPDATE spp SET tahun = :paym_year, 
				nominal = :paym_amount 
				WHERE id_spp = :paym_id
				";
				$statement = $connect->prepare($query);
				if ($statement->execute($data)) {
					$output = array(
						'success'		=>	'Data Edited Successfully',
					);
				}
			}
		}
		// hmm
		echo json_encode($output);
	}

	if ($_POST["action"] == "edit_fetch") {
		$query = "
		SELECT * FROM spp WHERE id_spp = '" . $_POST["paym_id"] . "'
		";
		$statement = $connect->prepare($query);
		if ($statement->execute()) {
			$result = $statement->fetchAll();
			foreach ($result as $row) {
				$output["paym_year"] = $row["tahun"];
				$output["paym_amount"] = $row["nominal"];
				$output["paym_id"] = $row["id_spp"];
			}
			echo json_encode($output);
		}
	}
	if ($_POST["action"] == "delete") {
		$query = "
		DELETE FROM spp 
		WHERE id_spp = '" . $_POST["paym_id"] . "'
		";
		$statement = $connect->prepare($query);
		if ($statement->execute()) {
			echo 'Data Delete Successfully';
		}
	}
}
