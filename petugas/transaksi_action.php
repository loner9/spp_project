<?php

//transaksi_action.php
//file ini digunakan untuk bebrapa aksi di transaksi.php

include('../config/config.php');

session_start();

if (isset($_POST["action"])) {
	if ($_POST["action"] == "fetch") {
		$query = "
		SELECT * FROM pembayaran INNER JOIN petugas ON 
		petugas.id_petugas = pembayaran.id_petugas ORDER BY pembayaran.tahun_dibayar
		";

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
			// +" - "+$row["bulan_dibayar"]+" - "+$row["tahun_dibayar"]
			$sub_array[] = $row["tgl_bayar"];
			$sub_array[] = $row["bulan_dibayar"];
            $sub_array[] = $row["jumlah_bayar"];
            $sub_array[] = $row["username"];
			$data[] = $sub_array;
		}
		$output = array(
			"draw"				=>	intval($_POST["draw"]),
			"recordsTotal"		=> 	$filtered_rows,
			"recordsFiltered"	=>	get_total_records($connect, 'pembayaran'),
			"data"				=>	$data
		);

		echo json_encode($output);
	}

	if ($_POST["action"] == 'Add') {
		$staff_id = $_POST["staff_id"];
		$student_id = $_POST["student_id"];
		$paym_id = $_POST["paym_id"];
        $paym_year = '';
        $paym_month = '';
        $paym_date = '';
		$paym_amount = '';
        $error_paym_year = '';
        $error_paym_month = '';
        $error_paym_date = '';
		$error_paym_amount = '';
		$error = 0;
		if (empty($_POST["paym_year"])) {
			$error_paym_year = 'Tahun Dibayar diperlukan';
			$error++;
		} else {
			$paym_year = $_POST["paym_year"];
        }
        if (empty($_POST["paym_month"])) {
			$error_paym_month = 'Bulan Dibayar diperlukan';
			$error++;
		} else {
			$paym_month = $_POST["paym_month"];
        }
        if (empty($_POST["paym_date"])) {
			$error_paym_date = 'Tanggal Dibayar diperlukan';
			$error++;
		} else {
			$paym_date = $_POST["paym_date"];
		}
		if (empty($_POST["paym_amount"])) {
			$error_paym_amount = 'Nominal Pembayaran diperlukan';
			$error++;
		} else {
			$paym_amount = $_POST["paym_amount"];
		}
		if ($error > 0) {
			$output = array(
				'error'							=>	true,
                'error_paym_year'              =>  $error_paym_year,
                'error_paym_month'              =>  $error_paym_month,
                'error_paym_date'              =>  $error_paym_date,
				'error_paym_amount'				=>	$error_paym_amount
			);
		} else {
			if ($_POST["action"] == "Add") {
				$data = array(
                    ':staff_id'				    =>	$staff_id,
                    ':student_id'				=>	$student_id,
                    ':paym_id'				    =>	$paym_id,
                    ':paym_year'				=>	$paym_year,
                    ':paym_month'				=>	$paym_month,
                    ':paym_date'				=>	$paym_date,
					':paym_amount'				=>	$paym_amount
				);
				$query = "
				INSERT INTO pembayaran 
				(id_petugas, nisn,tgl_bayar, bulan_dibayar, tahun_dibayar, id_spp, jumlah_bayar) 
				VALUES(:staff_id, :student_id, :paym_date, :paym_month, :paym_year, :paym_id, :paym_amount)
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
		}
		// hmm
		echo json_encode($output);
	}
}
