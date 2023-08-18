<?php
include'../includes/connection.php';

include'../includes/sidebar.php';
?><?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "scms";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //koneksi
    die("Tidak bisa terkoneksi ke database");
}

$aplikasi = "";
$nama ="";
$lama_pengerjaan = "";
$deskripsi = "";
$progress = "";
$sukses = "";
$error = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if ($op == 'delete') {
    $id = $_GET['id'];
    $sql1 = "delete from data_aplikasi where id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    if ($q1) {
        $sukses = "Berhasil delete data";
    } else {
        $error = "Gagal delete data";
    }
}
if ($op == 'edit') {
    $id = $_GET['id'];
    $sql1 = "select * from data_aplikasi where id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    $r1 = mysqli_fetch_array($q1);
    $aplikasi = $r1['aplikasi'];
    $nama = $r1['nama'];
    $lama_pengerjaan = $r1['lama_pengerjaan'];
    $deskripsi = $r1['deskripsi'];
    $progress = $r1['progress'];

    if ($nama == '') {
        $error = "Data tidak ditemukan";
    }
}
if (isset($_POST['simpan'])) {
    $aplikasi =  $_POST['aplikasi'];
    $nama = $_POST['nama'];
    $lama_pengerjaan = $_POST['lama_pengerjaan'];
    $deskripsi = $_POST['deskripsi'];
    $progress = $_POST['progress'];

    if ($aplikasi && $nama && $lama_pengerjaan && $deskripsi && $progress) {
        if ($op == 'edit') { // untuk update
            $sql1 = "update data_aplikasi set nama= '$nama',lama_pengerjaan= '$lama_pengerjaan',deskripsi= '$deskripsi',progress= '$progress' where id = '$id'";
            $q1 = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error = "Data gagal diupdate";
            }
        } else {
            $sql1 = "insert into data_aplikasi(aplikasi,nama,lama_pengerjaan,deskripsi,progress) values ('$aplikasi','$nama','$lama_pengerjaan','$deskripsi','$progress')";
            $q1 = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Berhasil memasukkan data";
            } else {
                $error = "Gagal memasukkan data";
            }
        }

    } else {
        $error = "Silahkan masukkan semua data";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Aplikasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 800px;
        }

        .card {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <!-- untuk memasukkan data -->
    <div class="mx-auto">
        <div class="card">
            <div class="card-header bg-primary text-white">
            <p class="fw-bold">Input Menu Aplikasi</p>   
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
                        <label for="aplikasi" class="col-sm-2 col-form-label">Aplikasi</label>
                        <div class="col-sm-10">
                        <select name="aplikasi" style="width:160px;">
                       
                <?php
                include "koneksi.php";
                //query menampilkan nama unit kerja ke dalam combobox
                $query    =mysqli_query($koneksi, "SELECT * FROM input_aplikasi");
                while ($data = mysqli_fetch_array($query)) {
                ?>
               
                <option value="<?=$data['nama_aplikasi'];?>"><?php echo $data['nama_aplikasi'];?></option>
                <?php
                }
                ?>
            </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="estimasi" class="col-sm-2 col-form-label">Lama Pengerjaan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="lama_pengerjaan" name="lama_pengerjaan"
                                value="<?php echo $lama_pengerjaan ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="deskripsi" class="col-sm-2 col-form-label">Deskripsi</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="deskripsi" name="deskripsi"
                                value="<?php echo $deskripsi ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="progress" class="col-sm-2 col-form-label">Progress</label>
                        <div class="col-sm-2">
                            <input type="number" class="form-control" id="progress" name="progress"
                                value="<?php echo $progress ?>">
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                    </div>
                </form>
            </div>
        </div>

        <!-- untuk mengeluarkan data -->
        <div class="mx-auto">
            <div class="card">
                <div class="card-header bg-primary text-white">
                <p class="fw-bold">Data aplikasi</p>    
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Aplikasi</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Lama Pengerjaan</th>
                                <th scope="col">Deskripsi</th>
                                <th scope="col">Progress</th>
                            </tr>
                        <tbody>
                            <?php
                            $sql2 = "select * from data_aplikasi order by id desc";
                            $q2 = mysqli_query($koneksi, $sql2);
                            $urut = 1;
                            while ($r2 = mysqli_fetch_array($q2)) {
                             
                                $nama = $r2['nama'];
                                $lama_pengerjaan = $r2['lama_pengerjaan'];
                                $deskripsi = $r2['deskripsi'];
                                $progress = $r2['progress'];

                                ?>
                                <tr>
                                    <th scope="row">
                                        <?php echo $urut++ ?>
                                    </th>
                                    <td scope="row">
                                        <?php echo $aplikasi ?>
                                    </td>
                                    <td scope="row">
                                        <?php echo $nama ?>
                                    </td>
                                    <td scope="row">
                                        <?php echo $lama_pengerjaan ?>
                                    </td>
                                    <td scope="row">
                                        <?php echo $deskripsi ?>
                                    </td>
                                    <td scope="row">
                                        <?php echo $progress ?>
                                    </td>
                                    <td scope="row">
                                        <a href="employee.php?op=persen&id=<?php echo $id?>"><button type="button"
                                                class="btn btn-info">%</button></a>
                                        <a href="employee.php?op=edit&id=<?php echo $id ?>"><button type="button"
                                                class="btn btn-warning">Edit</button></a>
                                                <a href="employee.php?op=delete&id=<?php echo $id?>" onclick="return confirm('yakin mau delete data?')"> <button type="button" class="btn btn-warning">Delete</button></a>

</td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>

                        <thead>
                    </table>
                </div>
                <form action="" method="POST">
                </form>
            </div>
        </div>
    </div>

</body>

</html>