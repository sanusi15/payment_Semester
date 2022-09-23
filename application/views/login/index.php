<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- box icons CDN -->
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>

    <!-- CSS -->
    <link rel="stylesheet" href="<?= base_url('asset/css/login.css'); ?>">

    <title>Hello, world!</title>
</head>

<body>

    <div class="container mt-5">
        <div class="card">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <img src="<?= base_url('asset/img/login/1.png'); ?>" class="img img-fluid" alt="1">
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div class="card-body">
                        <h5 class="card-title">Online Payment</h5>
                        <div class="socialMedia">
                            <ul>
                                <li>
                                    <a href="https://wa.me/6285813673382" target="_blank">
                                        <i class='bx bxl-whatsapp-square'></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.instagram.com/skuy.code/" target="_blank">
                                        <i class="bx bxl-instagram-alt"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" target="_blank">
                                        <i class="bx bxl-twitter"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://studio.youtube.com/channel/UCCyl7ZKfsBEzZw__OkPGOtA/videos" target="_blank">
                                        <i class="bx bxl-youtube"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <form action="<?= base_url('auth/cek_login'); ?>" method="post">
                            <div class="form-group">
                                <label for="nim">No Induk Mahasiswa</label>
                                <input type="text" class="form-control" id="nim" name="nim" placeholder="Input your NIM" autocomplete="off" autofocus>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Input your password" autocomplete="off">
                            </div>
                            <button type="submit" class="btn btn-primary" id="login">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
















    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- box Icon CDN -->
    <script src="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css"></script>
</body>

</html>