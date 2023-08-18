<?php
include'../includes/connection.php';
include'../includes/sidebar.php';
?>
<?php
$host      = "localhost";
$user      = "root";
$pass      = "";
$db        = "scms";

$koneksi   = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
    die("tidak bisa terkoneksi ke database");
}


$nama_aplikasi              = "";
$gitlink           = "";
$penanggung_jawab  = "";
$deskripsi         = "";
$sukses            = "";
$error             = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

if ($op == 'delete') {
    $id     = $_GET['id'];
    $sql1      = "delete from input_aplikasi where id = '$id'";
    $q1        = mysqli_query($koneksi, $sql1);
    if ($q1) {
        $sukses = "Berhasil hapus data";
    } else {
        $error  = "gagal melakukan delete data";
    }
}

if ($op == 'edit') {
    $id                = $_GET['id'];
    $sql1              = "select * from input_aplikasi where id = '$id'";
    $q1                = mysqli_query($koneksi, $sql1);
    $r1                = mysqli_fetch_array($q1);
   $nama_aplikasi               = $r1['nama_aplikasi'];
    $gitlink           = $r1['gitlink'];
    $penanggung_jawab  = $r1['penanggung_jawab'];
    $deskripsi         = $r1['deskripsi'];

    if ($nama_aplikasi  == '') {
        $error = "Data tidak ditemukan";
    }
}

if (isset($_POST['simpan'])) {
    $nama_aplikasi              = $_POST['nama_aplikasi'];
    $gitlink           = $_POST['gitlink'];
    $penanggung_jawab  = $_POST['penanggung_jawab'];
    $deskripsi         = $_POST['deskripsi'];


    if ($nama_aplikasi && $gitlink && $penanggung_jawab && $deskripsi) {

        if ($op == 'edit') {
            $sql1     = "update input_aplikasi set nama_aplikasi = '$nama_aplikasi', gitlink= '$gitlink',penanggung_jawab= '$penanggung_jawab', deskripsi ='$deskripsi' where id = '$id'";
            $q1       = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil di update";
            } else {
                $error = "Data gagal diupdate";
            }
        } else {
            $sql1 = "insert into input_aplikasi(nama_aplikasi,gitlink,penanggung_jawab,deskripsi) values ('$nama_aplikasi','$gitlink','$penanggung_jawab','$deskripsi')";
            $q1 = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses   = "berhasil masukkan data baru";
            } else {
                $error = "gagal memasukkan data";
            }
        }
    } else {
        $error = "silakan massukkan semua data";
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Aplikasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 800px
        }

        .card {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <!-- untuk memasukkan data-->
    <div class="mx-auto">
        <div class="card">
            <div class="card-header bg-primary text-white">
                Input Aplikasi
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                   
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>

                <?php
                   
                }
                ?>

                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="nama_aplikasi" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama_aplikasi" name="nama_aplikasi" value="<?php echo $nama_aplikasi ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="gitlink" class="col-sm-2 col-form-label">GitLink</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="getlink" name="gitlink" value="<?php echo $gitlink ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="penanggung_jawab" class="col-sm-2 col-form-label">Penaggung Jawab</th> </label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="penanggung_jawab" name="penanggung_jawab" value="<?php echo $penanggung_jawab ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="deskripsi" class="col-sm-2 col-form-label">Deskripsi</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="deskripsi" name="deskripsi" value="<?php echo $deskripsi ?>">
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary">

                    </div> 
                </form>
            </div>

        </div>

        <!-- untuk mengeluarkan data-->

        <div class="mx-auto">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    Data
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Gitlink</th>
                                <th scope="col">Penanggung_jawab</th>
                                <th scope="col">Deskripsi</th>
                                <th scope="col">Aksi</th>
                                <p align="Right">
                    <a href="cetak.php?op=cetak&id=<?php echo $nama_aplikasi?>"> <button type="button" class="btn btn-secondary">Cetak</button></a>
                    </p>




                            </tr>
                        <tbody>
                            <?php
                            $sql2  = "select * from input_aplikasi order by id desc";
                            $q2   = mysqli_query($koneksi, $sql2);
                            $urut  = 1;
                            while ($r2 = mysqli_fetch_array($q2)) {
                                $id     = $r2['id'];
                                $nama_aplikasi   = $r2['nama_aplikasi'];
                                $gitlink = $r2['gitlink'];
                                $penanggung_jawab = $r2['penanggung_jawab'];
                                $deskripsi = $r2['deskripsi'];


                            ?>
                                <tr>
                                    <th scope="row">
                                        <?php echo $urut++ ?>
                                    </th>
                                    <td scope="row">
                                        <?php echo $nama_aplikasi ?>
                                    </td>
                                    <td scope="row">
                                        <?php echo $gitlink ?>
                                    </td>
                                    <td scope="row">
                                        <?php echo $penanggung_jawab ?>
                                    </td>
                                    <td scope="row">
                                        <?php echo $deskripsi ?>
                                    </td>
                                    <td scope="row">
                                        <a href="customer.php?op=edit&id=<?php echo $id?>"> <button type="button" class="btn btn-danger">Edit</button></a>
                                        <a href="customer.php?op=delete&id=<?php echo $id?>" onclick="return confirm('yakin mau delete data?')"> <button type="button" class="btn btn-warning">Delete</button></a>

                                       
                                    </td>

                                </tr>
                            <?php


                            }
                            ?>
                        </tbody>

                        </thead>
                    </table>
                </div>
                <form action="" method="POST">
                </form>
            </div>
        </div>
    </div>
</body>

</html>

</html>