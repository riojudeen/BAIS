<style>

    .view {
    margin: auto;
    width: 600px;
    }
    tr:hover td
    { background: #F4F4F4;
    }
    .wrapper {
    position: relative;
    overflow: auto;
    border: 1px solid black;
    white-space: nowrap;
    }

    .sticky-col {
    position: -webkit-sticky;
    position: sticky;
    background-color: white;
    }

    .first-col {
    width: 100px;
    min-width: 50px;
    max-width: 100px;
    left: 0px;
    
    }

    .first-top-col {
    width: 50px;
    min-width: 50px;
    max-width: 150px;
    top: 0px;
    z-index: 600;
    }

    .second-col {
    width: 50px;
    min-width: 50px;
    max-width: 150px;
    left: 50px;
    }
    .second-top-col {
    width: 20px;
    min-width: 20px;
    max-width: 150px;
    top: 0px;
    z-index: 600;
    }

    .third-col {
    width: 70px;
    min-width: 70px;
    max-width: 300px;
    left: 100px;
    }
    .third-top-col {
    width: 70px;
    min-width: 70px;
    max-width: 300px;
    top: 0px;
    z-index: 600;
    }
    .fourth-col {
    width: 300px;
    min-width: 300px;
    max-width: 300px;
    left: 170px;
    }
    .fourth-top-col {
    width: 300px;
    min-width: 300px;
    max-width: 300px;
    top: 0px;
    z-index: 600;
    }

    .first-last-col {
    width: 50px;
    min-width: 50px;
    max-width: 50px;
    right: 0px;
    }
    .first-last-top-col {
    width: 50px;
    min-width: 50px;
    max-width: 50px;
    top: 0px;
    z-index: 600;
    }

    .second-last-col {
    width: 100px;
    min-width: 100px;
    max-width: 100px;
    right: 50px;
    }
    .second-last-top-col {
    width: 100px;
    min-width: 100px;
    max-width: 100px;
    top: 0px;
    z-index: 600;
    }
    th {
    background: white;
    position: sticky;
    top: 0;
    z-index: 500;
    }

</style>
<?php
$pencarian = (isset($_GET['cari']))?$_GET['cari']:"";
$deptAcc = (isset($_GET['deptAcc']))?$_GET['deptAcc']:"";
if(isset($_GET['deptAcc'])){
    $_SESSION['deptAcc'] = (isset($_GET['deptAcc']))?$_GET['deptAcc']:$_SESSION['deptAcc'];
}else{
    $_SESSION['deptAcc'] = (isset($_SESSION['deptAcc']))?$_SESSION['deptAcc']:"";
}

$_GET['deptAcc'] = $_SESSION['deptAcc'];
?>
<div class="collapse show" id="tambah">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <h6 class="col-md-6 text-left">TAMBAH DATA</h6>
                <div class="col-md-6 text-right">
                    <a  class="btn btn-sm btn-info " data-toggle="collapse" href=".tambah" role="button" aria-expanded="true" aria-controls="#tambah">Lihat Data Expatriat</a>
                </div>

            </div>
            <div class="card shadow-none border " style="background:rgba(201, 201, 201, 0.2)" >
                <div class="card-body  mt-2">
                    <form method="post" action="ajax/proses.php" id="form-add" class="form-data">
                        <div class="row">
                            <div class="col-sm-12 ">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="">NPK</label>
                                        <div class="form-group " style="background:rgba(255, 255, 255, 0.3)">
                                            <input type="number" class="form-control bg-transparent data-npk" id="data-npk" placeholder="input npk" autofocus/>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Nama </label>
                                        <div class="form-group " >
                                            <input disabled type="text" class="form-control bg-transparent data-nama" placeholder="Nama" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Jabatan</label>
                                        <div class="form-group " >
                                            <input disabled type="text" class="form-control bg-transparent data-jabatan" placeholder="jabatan" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Status</label>
                                        <div class="form-group " >
                                            <input disabled type="text" class="form-control bg-transparent data-stats" placeholder="Status Karyawan" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="reset" class="btn btn-sm btn-warning ">Reset</button>
                        <button type="button" id="save" class="btn btn-sm btn-primary pull-right d-none" name="add">Tambah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="collapse show tambah collapse-view" id="data-show">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6 text-left">
                    <h6 >Resource Data</h6>
                </div>
            </div>
            <form class="table-responsive" method="post">
                <div class="data-expatriat">

                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('.data-npk').keyup(function(){
        var npk = $(this).val();
        $.ajax({
            url: 'ajax/get_resource.php',
            method: 'get',
            data: {data:npk},
            success:function(data){
                var obj = $.parseJSON(data);
                var total = obj.msg[0].total;
                var msg = obj.msg[0].msg;
                if(total > 0){
                    var nama = obj.data[0].nama;
                    var status = obj.data[0].status;
                    var jabatan = obj.data[0].jabatan;
                    $('.data-nama').val(nama);
                    $('.data-jabatan').val(jabatan);
                    $('.data-stats').val(status);
                    $('#save').removeClass('d-none');
                }else if(total === 0){
                    var nama = obj.msg[0].msg;
                    var status = obj.msg[0].msg;
                    var jabatan = obj.msg[0].msg;
                    $('.data-nama').val(nama);
                    $('.data-jabatan').val(jabatan);
                    $('.data-stats').val(status);
                    $('#save').addClass('d-none');
                }else{
                    var nama = obj.msg[0].msg;
                    var status = obj.msg[0].msg;
                    var jabatan = obj.msg[0].msg;
                    $('.data-nama').val(nama);
                    $('.data-jabatan').val(jabatan);
                    $('.data-stats').val(status);
                    $('#save').addClass('d-none');
                }
            }
        })
    })
</script>
<script>
    $('.data-expatriat').load("ajax/data-expatriat.php");
    $('#save').click(function(){
        var npk = $('.data-npk').val();
        $.ajax({
            url: 'ajax/data-expatriat.php',
            method: 'get',
            data: {proses:"add", npk:npk},
            success:function(data){
                $('.data-expatriat').load("ajax/data-expatriat.php");
            }
        })
    })
</script>
