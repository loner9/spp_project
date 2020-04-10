<?php

//siswa_action.php
//file ini digunakan untuk bebrapa aksi di index.php

include('../config/config.php');

session_start();

if (isset($_POST["action"])) {
	if ($_POST["action"] == "fetch") {
		$query = "
		SELECT * FROM pembayaran INNER JOIN petugas ON 
		petugas.id_petugas = pembayaran.id_petugas INNER JOIN spp ON spp.id_spp = pembayaran.id_spp
		WHERE nisn = '".$_SESSION['stud_id']."' ORDER BY pembayaran.tahun_dibayar
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
			$sub_array[] = $row["jumlah_bayar"];
			$sub_array[] = $row["tahun"];
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
}
