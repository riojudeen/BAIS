
    <div class=".container">
        <!------------Header navigasi------------->
        <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #76D7C4;">
            <a class="navbar-brand" href="#">
                <img src="img/logo.png" width="30" height="30" class="d-inline-block align-top" alt="" loading="lazy">
                BAIS
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Absensi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">General Information</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            HR-Site
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="#">Personal Site</a>
                            <a class="dropdown-item" href="#">HRIS</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        <!------------------ setting button (tanggal, shift, section) --------------------->
        <div class="row">
            <!------tab untuk mengatur dispay absensi ---->
            <div class="col-sm-5">

                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab"
                            aria-controls="pills-home" aria-selected="true">Absensi</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab"
                            aria-controls="pills-profile" aria-selected="false">Apresiasi</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab"
                            aria-controls="pills-contact" aria-selected="false">Eff MP</a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                        aria-labelledby="pills-home-tab">...</div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        ...</div>
                    <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                        ...</div>
                </div>
                <!------tab untuk mengatur tanggal, shift & section---->
            </div>
            <div class="col-sm-7">
                Button section
            </div>

        </div>

        <!------------------ Monitoring Dashboard -------------------->
        <div class="row">
            <div class="col-sm-2">
                Summary & Management Monitor

                <div class="card">
                    <h5 class="card-header">SUMMARY</h5>
                    <div class="card-body">
                        <p class="card-text">###.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>

                <div class="card">
                    <img src="img/logo.png" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Divisi/dept/sect</h5>

                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Nama</li>
                        <li class="list-group-item">NPK</li>
                        <li class="list-group-item">Divisi/Dept/Sect</li>
                    </ul>
                    <div class="card-body">
                        <a href="#" class="card-link">Card link</a>
                        <a href="#" class="card-link">Another link</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-10">


                <!---table---->
                Monitoring Jalur
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">First</th>
                            <th scope="col">Last</th>
                            <th scope="col">Handle</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td>Jacob</td>
                            <td>Thornton</td>
                            <td>@fat</td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td>Larry</td>
                            <td>the Bird</td>
                            <td>@twitter</td>
                        </tr>
                    </tbody>
                </table>
                <!---table end---->



            </div>

        </div>





    </div>

