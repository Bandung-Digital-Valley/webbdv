
<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: multipart/form-data;");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once("../bdv-member/model/database.php");

    $data = json_decode(file_get_contents("php://input"));
    $obj = [];

    if (isset($data->fullName)) {
        $obj['fullName'] = $data->fullName;
        $nama = $data->fullName;
    } else {
        $obj['fullName'] = NULL;
        $nama = NULL;
    }
    if (isset($data->password)) {
        $obj['password'] = $data->password;
        $pass = $data->password;
    }
    if (isset($data->gender)) {
        $obj['gender'] = $data->gender;
        $gender = $data->gender;
    } else {
        $obj['gender'] = NULL;
        $gender = NULL;
    }
    if (isset($data->dateOfBirth)) {
        $obj['dateOfBirth']=$data->dateOfBirth;
        $tgl_lahir = $data->dateOfBirth;
    } else {
        $obj['dateOfBirth']=NULL;
        $tgl_lahir = NULL;
    }
    if (isset($data->domicile)) {
        $obj['domicile']=$data->domicile;
        $kota = $data->domicile;
    } else {
        $obj['domicile']=NULL;
        $kota = NULL;
    }
    if (isset($data->email)) {
        $obj['email']=$data->email;
        $email = $data->email;
    }
    if (isset($data->phoneNumber)) {
        $obj['phoneNumber']=$data->phoneNumber;
        $no_hp = $data->phoneNumber;
    } else {
        $obj['phoneNumber']=NULL;
        $no_hp = NULL;
    }
    if (isset($data->occupation)) {
        $obj['occupation']=$data->occupation;
        $profesi = $data->occupation;
    } else {
        $obj['occupation']=NULL;
        $profesi = NULL;
    }
    if (isset($data->institution)) {
        $obj['institution']=$data->institution;
        $perusahaan = $data->institution;
    } else {
        $obj['institution']=NULL;
        $perusahaan = NULL;
    }
	$visit=NULL;
    $instagram=NULL;
    $linkedln=NULL;
    $facebook=NULL;
    $hash=NULL;
    $active=1;
    $join_date=NULL;
    $foto=NULL;

    $query1 = "INSERT INTO tb_user(nama, pass, gender, tgl_lahir, kota, email, no_hp, profesi, perusahaan, visit, instagram, linkedln, facebook, hash, active, foto, join_date) VALUES ('$nama', '$pass', '$gender', '$tgl_lahir', '$kota', '$email', '$no_hp', '$profesi', '$perusahaan', '$visit', '$instagram', '$linkedln', '$facebook', '$hash', '$active', '', '$join_date')";

    if (mysqli_query($link, $query1)) {
        $data->oldId = mysqli_insert_id($link);
        $arr[] = array(
            'fullName' => $nama,
            'password' => $pass,
            'gender' => $gender,
            'dateOfBirth' => $tgl_lahir,
            'domicile' => $kota,
            'email' => $email,
            'phoneNumber' => $no_hp,
            'occupation' => $profesi,
            'institution' => $perusahaan,
            'oldId' => $data->oldId
        );
        echo json_encode($arr[0]);
    } else {
        echo "Error: " . $query1 . "<br>" . mysqli_error($link);
    }
?> 
