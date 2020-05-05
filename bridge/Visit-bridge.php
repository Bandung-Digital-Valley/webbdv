<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: multipart/form-data;");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once("../bdv-member/model/database.php");

    $data = json_decode(file_get_contents("php://input"));
	
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$checkIn = $data->checkIn; 	//mendapatkan jam checkIn dari Strapi
		$date = $data->tgl; 		//mendapatkan tgl checkIn dari Strapi
		$id = $data->oldId;			//mendapatkan oldId dari Strapi
        $sql_validation = "SELECT * FROM tb_user WHERE id_user ='$id'"; 	//query sql untuk mengambil data user dari database
		$rValidation = mysqli_query($link, $sql_validation);		//menjalankan query pengambilan data user
		$data_nama = mysqli_fetch_array($rValidation);			
		$getnama = $data_nama['nama'];
		$validating = mysqli_num_rows($rValidation);
        
		if ($validating == 0) {
			
		} else {
        	// cari no card
            $qCard = "SELECT no_card AS lastCard from tb_absensi WHERE tgl='$date'";
        	$rCard = mysqli_query($link, $qCard);
        	if (mysqli_num_rows($rCard) == 0) {
            	$no_card = 1;
            } else {
            	$no_card = mysqli_num_rows($rCard)+1;
         	}
        	$sql = "INSERT INTO `tb_absensi` (`no`, `no_card`, `id`, `tgl`, `jam_masuk`, `jam_keluar`) VALUES (NULL, '$no_card','$id', '$date', '$checkIn', NULL)";
        	mysqli_query($link, $sql);
    
        	$qFindData = "SELECT * FROM tb_absensi WHERE id='$id'";
        	$rFindData = mysqli_query($link, $qFindData);
        	$rowData = mysqli_num_rows($rFindData);
        
        	if ($rowData == 0) {
            	$qUpdateVisit = "UPDATE tb_user SET visit='0' where id_user='$id'";
            } else {
        		$qUpdateVisit = "UPDATE tb_user SET visit='$rowData' where id_user='$id'";
        		$rUpdateVisit = mysqli_query($link, $qUpdateVisit);
            }
    	}
	} else if ($_SERVER['REQUEST_METHOD']=='PUT'){
		$getcard = $data->cardNo;
		$getid = $data->oldId;
		$tglurl = $data->tgl;
		$jam_keluars = $data->checkOut;

		$sqlJamKeluar = "UPDATE `tb_absensi` SET `jam_keluar` = '$jam_keluars' WHERE `tb_absensi`.`no_card` = '$getcard' AND `tb_absensi`.`tgl` = '$tglurl' AND `tb_absensi`.`id` = '$getid'";
		$queryJamKeluar = mysqli_query($link,$sqlJamKeluar);

		$sqlSelisih = "UPDATE `tb_absensi` SET `selisih` = timediff(jam_keluar, jam_masuk) WHERE `tb_absensi`.`no_card` = '$getcard' AND `tb_absensi`.`tgl` = '$tglurl' AND `tb_absensi`.`id` = '$getid'";
		$querySelisih = mysqli_query($link,$sqlSelisih);
	}
?>