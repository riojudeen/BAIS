<?php

//////////////////////////////////////////////////////////////////////
include("../../config/config.php"); 

//redirect ke halaman dashboard index jika sudah ada session
$halaman = "Time Lock Management";
if(isset($_SESSION['user'])){

		include("../header.php");
		

?>

<div class="row ">
    <div class="col-md-4">
        <h5 class="title">
            System Maintenance
        </h5>
        <div class="card">
            <div class="card-header">
                
            </div>
            <hr>
            <div class="card-body">

            </div>
        </div>
    </div>
    <div class="col-md-4">
        <h5 class="title">
            Daily Lock
        </h5>
        <div class="card">
            <div class="card-header">
                
            </div>
            <hr>
            <div class="card-body">
            <form method="get" action="/" class="form-horizontal">
                    <div class="table table-full-width">

                        <table class="table ">
                            <thead>
                                <tr class="py-1">
                                    <th>Scheme</th>
                                        <th colspan="1">Identifikasi</th>
                                        <th colspan="2">Start</th>
                                        <th colspan="2">End</th>
                                    <th ></th>
                                </tr>
                                
                            </thead>
                            <tbody>
                                <tr class="py-1">
                                    <td class="py-0">#1</td>
                                    <td class="py-1">
                                        <div class="form-group-sm" auto-complete="off">
                                            <input type="text" class="form-control border-0 bg-transparent px-0" value="2022-01-30">
                                        </div>
                                    </td>
                                    <td class="py-1">
                                        <div class="form-group-sm" auto-complete="off">
                                            <input type="text" class="form-control border-0 bg-transparent px-0" value="06:30">
                                        </div>
                                    </td>
                                    <td class="py-1">
                                        <div class="form-group-sm" auto-complete="off">
                                            <input type="text" class="form-control border-0 bg-transparent px-0" value="2022-01-30">
                                        </div>
                                    </td>
                                    <td class="py-1">
                                        <div class="form-group-sm" auto-complete="off">
                                            <input type="text" class="form-control border-0 bg-transparent px-0" value="06:30">
                                        </div>
                                    </td>
                                    <td class="py-1">
                                    <input class="bootstrap-switch" type="checkbox" data-toggle="switch" checked="" data-on-color="warning" data-off-color="warning" data-on-label="ON" data-off-label="OFF">
                                    </td>
                                </tr>
                                <tr class="py-1">
                                    <td class="py-0">#2</td>
                                    <td class="py-1">
                                        <div class="form-group-sm" auto-complete="off">
                                            <input type="text" class="form-control border-0 bg-transparent px-0" value="2022-01-30">
                                        </div>
                                    </td>
                                    <td class="py-1">
                                        <div class="form-group-sm" auto-complete="off">
                                            <input type="text" class="form-control border-0 bg-transparent px-0" value="06:30">
                                        </div>
                                    </td>
                                    <td class="py-1">
                                        <div class="form-group-sm" auto-complete="off">
                                            <input type="text" class="form-control border-0 bg-transparent px-0" value="2022-01-30">
                                        </div>
                                    </td>
                                    <td class="py-1">
                                        <div class="form-group-sm" auto-complete="off">
                                            <input type="text" class="form-control border-0 bg-transparent px-0" value="06:30">
                                        </div>
                                    </td>
                                    <td class="py-1">
                                    <input class="bootstrap-switch" type="checkbox" data-toggle="switch" checked="" data-on-color="warning" data-off-color="warning" data-on-label="ON" data-off-label="OFF">
                                    </td>
                                </tr>
                                <tr class="py-1">
                                    <td class="py-0">#3</td>
                                    <td class="py-1">
                                        <div class="form-group-sm" auto-complete="off">
                                            <input type="text" class="form-control border-0 bg-transparent px-0" value="2022-01-30">
                                        </div>
                                    </td>
                                    <td class="py-1">
                                        <div class="form-group-sm" auto-complete="off">
                                            <input type="text" class="form-control border-0 bg-transparent px-0" value="06:30">
                                        </div>
                                    </td>
                                    <td class="py-1">
                                        <div class="form-group-sm" auto-complete="off">
                                            <input type="text" class="form-control border-0 bg-transparent px-0" value="2022-01-30">
                                        </div>
                                    </td>
                                    <td class="py-1">
                                        <div class="form-group-sm" auto-complete="off">
                                            <input type="text" class="form-control border-0 bg-transparent px-0" value="06:30">
                                        </div>
                                    </td>
                                    <td class="py-1">
                                    <input class="bootstrap-switch" type="checkbox" data-toggle="switch" checked="" data-on-color="warning" data-off-color="warning" data-on-label="ON" data-off-label="OFF">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <h5 class="title">
            Yearly Lock
        </h5>
        <div class="card">
            <div class="card-header">
                07:00
            </div>
            <hr>
            <div class="card-body">

            </div>
        </div>
    </div>
</div>


			
			
<?php
//footer
		include_once("../footer.php");

} else{
		echo "<script>window.location='".base_url('auth/login.php')."';</script>";
	}
	

?>