<?php
require '../function.php';
require '../db_login.php';
session_start();
// isset not login
if (!isset($_SESSION['email'])) {
    header("location:../login.php");
}

$error = '';
if(isset($_POST['submit'])){
    $semester = $_POST['semester'];
    $nim = $_SESSION['nim'];
    $sks = $_POST['sks'];
    if($sks > 24){
        $error = 'sks tidak boleh lebih dari 24';
    }
    else if ($sks < 0){
        $error = 'sks tidak boleh negatif';
    }
    else{
        $querycheck = "SELECT * FROM tb_irs WHERE nim='$nim' AND semester=$semester";
        $connectcheck = mysqli_query($conn,$querycheck);
        if(mysqli_fetch_row($connectcheck) == 0){
            $querybuat = "INSERT INTO tb_irs VALUES ($semester,$nim,$sks,'','','belum')";
            $connect = mysqli_query($conn, $querybuat);
            header("location:mhs_irs.php?semester=$semester");
        }
        else{
            $queryupdate = "UPDATE tb_irs SET sks=$sks , verif_irs='belum' WHERE nim='$nim' AND semester=$semester";
            $connectupdate = mysqli_query($conn, $queryupdate);
            header("location:mhs_irs.php?semester=$semester");
        }
    }
    
}

$color = '';
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <!--<title> Responsive Sidebar Menu  | CodingLab </title>-->
    <link rel="stylesheet" href="../library/css/style.css">
    <link rel="stylesheet" href="mhs.css">
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    body {
        padding: 20px;
    }

    #drop_zone {
        background-color: #eae5e5;
        /* border: #B980F0 5px dashed; */
        border-radius: 20px;
        width: 50%;

        padding: 60px 0;
    }

    #drop_zone p {
        font-size: 20px;
        text-align: center;
    }

    #btn_upload,
    #selectfile {
        display: none;
    }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="logo-details">
            <img src="" alt="" class="logo-undip">
            <div class="logo_name">Universitas Diponegoro</div>
            <i class='bx bx-menu' id="btn"></i>
        </div>
        <ul class="nav-list">

            <li>
                <a href="mhs_profil.php">
                    <i class='bx bx-home' id="icon"></i>
                    <span class="links_name">Profil</span>
                </a>
                <span class="tooltip">Profil</span>
            </li>
            <li>
                <a href="mhs_irs.php">
                    <i class='bx bxs-bar-chart-alt-2' id="icon"></i>
                    <span class="links_name">Data IRS</span>
                </a>
                <span class="tooltip">Data IRS</span>
            </li>
            <li>
                <a href="mhs_khs.php">
                    <i class='bx bx-pie-chart-alt-2' id="icon"></i>
                    <span class="links_name">
                        <Datag>Data KHS</Datag>
                    </span>
                </a>
                <span class="tooltip">Data KHS</span>
            </li>
            <li>
                <a href="mhs_pkl.php">
                    <i class='bx bxs-graduation' id="icon"></i>
                    <span class="links_name">Data PKL</span>
                </a>
                <span class="tooltip">Data PKL</span>
            </li>
            <li>
                <a href="mhs_skripsi.php">
                    <i class='bx bxs-bar-chart-alt-2' id="icon"></i>
                    <span class="links_name">Data Skripsi</span>
                </a>
                <span class="tooltip">Data Skripsi</span>
            </li>
            <li>
                <a href="../logout.php">
                    <i class='bx bx-log-out' id="log_out"></i>
                    <span class="links_name">Keluar</span>
                </a>
                <span class="tooltip">Keluar</span>
            </li>
            <?php
            // get detail mahasiswa
            $mhsDetail = getMhsDetail($_SESSION['nim']);

            ?>
            <li class="profile">
                <div class="profile-details">
                    <!--<img src="profile.jpg" alt="profileImg">-->
                    <div class="name_job">
                        <div class="name"><?php echo $mhsDetail['nama']; ?></div>
                        <div class="job"><?php echo $mhsDetail['email']; ?></div>
                    </div>
                </div>
                <i class="fa fa-bars" id="bars"></i>>
            </li>
        </ul>
    </div>
    <section class="home-section">
        <form method="POST">
        
            <label for="semester">Pilih Semester IRS </label>
            <select id="semester" name="semester" class="form-control">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
            </select>

            <div class="form-group">
                <label for="nama">Jumlah SKS :</label>
                <input type="number" class="form-control" id="sks" name="sks" maxlength="50"/>
            </div>
            <div>
                <p style="color:red;"><?php echo $error?></p>
</div>
            <button type="submit" class="btn btn-primary" name="submit" value="submit">Upload File IRS</button>

        </form>
    </section>