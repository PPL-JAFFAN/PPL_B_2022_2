<?php
require '../function.php';
session_start();
// isset not login
if (!isset($_SESSION['email'])) {
    header("location:../login.php");
}

$nim = $_SESSION['nim'];
$pklDetail = getPklDetail($nim);

if (isset($_POST['submit'])) {
    $status = $_POST['status'];
    $nilai = $_POST['nilai'];
    if ($status != 'LULUS' && $nilai != '') {
        echo "<script>alert('Nilai hanya boleh diisi jika status PKL LULUS');document.location.href='mhs_pkl_input.php';</script>";
    } else {
        if ($pklDetail) {
            $query = "UPDATE tb_pkl SET status_pkl = '$status', nilai_pkl = '$nilai' WHERE nim = '$nim'";
            $result = mysqli_query($conn, $query);
        } else {
            $query = "INSERT INTO tb_pkl VALUES(NULL, '$nim', '$status', '$nilai', NULL, NULL)";
            $result = mysqli_query($conn, $query);
        }
        if ($result) {
            echo "<script>alert('Data berhasil diubah!');document.location.href='mhs_pkl_input.php';</script>";
        } else {
            echo "<script>alert('Data gagal diubah!');document.location.href='mhs_pkl_input.php';</script>";
        }
    }
}


$color = '';

?>

<!DOCTYPE html>
<!-- Created by CodingLab |www.youtube.com/CodingLabYT-->
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <!--<title> Responsive Sidebar Menu  | CodingLab </title>-->
    <link rel="stylesheet" href="style.css">
    <!-- Boxicons CDN Link -->
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/x-icon" href="../asset/img/undip.png">
    <title>SiapIn</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

    <style>
    .home-section a .card-active {
        color: white;
        background-color: #8974FF;
    }
    </style>
    <style>
    #drop_zone {
        background-color: white;
        /* border: #B980F0 5px dashed; */
        border-radius: 20px;
        width: 100%;

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
    <title>Data Mahasiswa</title>
</head>

<body>
    <div class="sidebar">
        <div class="logo-details">
            <i> <img src="../asset/img/undip.png" style="width:40px ; padding-bottom:5px" alt=""></i>
            <div class="logo_name" style="padding-top: 5px;">
                <div style="font-size:10px ;">Departemen Informatika</div> Universitas Diponegoro
            </div>
        </div>
        <ul class="nav-list">

            <li>
                <a href="mhs_profil.php" class="nav-link  ">
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
                <a href="mhs_pkl.php" class="nav-link active">
                    <i class='bx bxs-graduation ' id="icon"></i>
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
            $pklDetail = getPklDetail($_SESSION['nim']);
            $mhsDetail = getMhsDetail($_SESSION['nim']);

            ?>
            <li class="profile">
                <div class="profile-details">
                    <!--<img src="profile.jpg" alt="profileImg">-->
                    <div class="name_job">
                        <div class="name"><?php echo $mhsDetail['nama']; ?></div>
                        <div class="email"><?php echo $mhsDetail['email']; ?></div>
                    </div>
                </div>
                <i class="fa fa-bars" id="bars"></i>>
            </li>
        </ul>
    </div>

    <section class="home-section">
        <div class="container-fluid">
            <div class="h4 mt-5 w-100 ">Input Progres Data PKL</div><br>
            <div>
                <a href="mhs_pkl.php" class="btn btn-primary">Lihat Data Progres PKL</a>
            </div>
            <div class="row row-cols-1 row-cols-md-1 g-4 mt-1" id="datadiri">
                <div class="col">
                    <div class="card rounded-4 ">
                        <div class="card-body">
                            <form action="" method="POST">
                                <label for="status" class="form-label">Status PKL</label>
                                <select name="status" id="status" class="form-select"
                                    aria-label="Default select example" onchange="changeOpsi(this.value)">
                                    <option value="BELUM MENGAMBIL"
                                        <?php if ($pklDetail['status_pkl'] == 'BELUM MENGAMBIL') echo 'selected'; ?>>
                                        BELUM MENGAMBIL</option>
                                    <option value="SEDANG MENGAMBIL"
                                        <?php if ($pklDetail['status_pkl'] == 'SEDANG MENGAMBIL') echo 'selected'; ?>>
                                        SEDANG MENGAMBIL</option>
                                    <option value="LULUS"
                                        <?php if ($pklDetail['status_pkl'] == 'LULUS') echo 'selected'; ?>>LULUS
                                    </option>
                                </select>
                                <div></div>
                                <label for="status" class="form-label">Nilai :</label>
                                <!-- ============================================ -->
                                <select name="nilai" id="nilai" class="form-select" aria-label="Default select example">
                                    <?php
                                    if ($pklDetail['status_pkl'] != 'LULUS') {
                                        echo '<option value="" disabled>Tidak Tersedia</option>';
                                    } else {
                                        echo '<option value="A"> A </option>';
                                        echo '<option value="B"> B </option>';
                                        echo '<option value="C"> C </option>';
                                    }
                                    ?>
                                </select>
                                <div class="d-flex justify-content-center">
                                    <button class="btn btn-primary mt-3" type="submit" id="submit"
                                        name="submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="h5 mt-4 mb-4 w-100">Laporan Progres PKL</div>

            <div id="drop_zone">
                <p>Drop file here</p>
                <p>or</p>
                <p><button type="button" id="btn_file_pick" class="btn btn-primary"><span
                            class="glyphicon glyphicon-folder-open"></span> Select File</button></p>
                <p id="file_info"></p>
                <p><button type="button" id="btn_upload" class="btn btn-primary"><span
                            class="glyphicon glyphicon-arrow-up"></span> Upload To Server</button></p>
                <input type="file" id="selectfile">
                <p id="message_info"></p>
            </div>
            <div class="text-center">
                <?php
                if ($pklDetail['scan_pkl']) {
                    echo "File terupload : " . $pklDetail['scan_pkl'];
                } else {
                    echo "Belum ada file yang diupload";
                }
                ?>
            </div>
        </div>
        </div>
    </section>

    <script src="../library/js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>

    <script>
    function changeOpsi(value1, value2) {
        var xmlhttp = getXMLHTTPRequest();
        var url = 'get_khs.php?semester=' + $smt;
        console.log(url);
        xmlhttp.open('GET', url, true);

        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById('khscontent').innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.send();
    }
    </script>

    <script>
    $(document).ready(function() {
        $('#example').DataTable();
    });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
    </script>

    <script>
    var fileobj;
    $(document).ready(function() {
        $("#drop_zone").on("dragover", function(event) {
            event.preventDefault();
            event.stopPropagation();
            return false;
        });
        $("#drop_zone").on("drop", function(event) {
            event.preventDefault();
            event.stopPropagation();
            fileobj = event.originalEvent.dataTransfer.files[0];
            var fname = fileobj.name;
            var fsize = fileobj.size;
            if (fname.length > 0) {
                document.getElementById('file_info').innerHTML = "File name : " + fname +
                    ' <br>File size : ' + bytesToSize(fsize);
            }
            document.getElementById('selectfile').files[0] = fileobj;
            document.getElementById('btn_upload').style.display = "inline";
        });
        $('#btn_file_pick').click(function() {
            /*normal file pick*/
            document.getElementById('selectfile').click();
            document.getElementById('selectfile').onchange = function() {
                fileobj = document.getElementById('selectfile').files[0];
                var fname = fileobj.name;
                var fsize = fileobj.size;
                if (fname.length > 0) {
                    document.getElementById('file_info').innerHTML = "File name : " + fname +
                        ' <br>File size : ' + bytesToSize(fsize);
                }
                document.getElementById('btn_upload').style.display = "inline";
            };
        });
        $('#btn_upload').click(function() {
            if (fileobj == "" || fileobj == null) {
                alert("Please select a file");
                return false;
            } else {
                ajax_file_upload(fileobj);
            }
        });
    });

    // ajax change nilai
    function changeOpsi(value1) {
        var xmlhttp = getXMLHTTPRequest();
        var url = 'get_nilai.php?status=' + value1;
        console.log(url);
        xmlhttp.open('GET', url, true);

        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById('nilai').innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.send();
    }

    function ajax_file_upload(file_obj) {
        if (file_obj != undefined) {
            var form_data = new FormData();
            form_data.append('upload_file', file_obj);
            $.ajax({
                type: 'POST',
                url: 'upload_pkl.php',
                contentType: false,
                processData: false,
                data: form_data,
                beforeSend: function(response) {
                    $('#message_info').html("Uploading your file, please wait...");
                },
                success: function(response) {
                    $('#message_info').html(response);
                    alert(response);
                    $('#selectfile').val('');
                }
            });
        }
    }

    function bytesToSize(bytes) {
        var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
        if (bytes == 0) return '0 Byte';
        var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
        return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
    }
    </script>
    <script src="../library/js/script.js"> </script>


</html>