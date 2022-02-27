<?php

?>
<!-- tombol konfirmasi -->
<a disabled href="proses.php?del=<?=$data_reqAbsensi['id_absen']?>"
    class="btn-round btn-outline-danger btn btn-danger btn-link btn-icon btn-sm remove" 
    data-id="form_absensi"><i class="fa fa-times"></i></a>
<!-- jquery uttuk tombol konfirmasi -->
<script>
    $('.remove').on('click', function(e){
        e.preventDefault();
        var getLink = $(this).attr('href'); //penting
            
        Swal.fire({
        title: 'Anda Yakin ?',
        text: "Data Akan Dihapus Permanent",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#FF5733',
        cancelButtonColor: '#B2BABB',
        confirmButtonText: 'Yes, delete!'
        }).then((result) => {
            if (result.value) {
                document.location.href=getLink; //penting , nanti akan menuju halaman proses
            }
        })
    });
</script>
<!-- ditangkap di halaman proses -->
<?php
if(isset($_GET['del'])){
    mysqli_query($link , "DELETE FROM req_absensi WHERE id = '$_GET[del]' ");

    $_SESSION['info'] = 'Dihapus'; //session yang harus dibuat yang nanti ditangkap 
    echo "<script>document.location.href='req_absensi.php'</script>";
}
?>

<!-- buat nangkep session yang dibuat saat proses -->
<div class="info-data" data-infodata="<?php if(isset($_SESSION['info'])){ echo $_SESSION['info']; } unset($_SESSION['info']); ?>" ></div>
<div class="message" data-infodata="<?php if(isset($_SESSION['pesan'])){ echo $_SESSION['pesan']; } unset($_SESSION['pesan']); ?>" ></div>
<!-- menangkap element hrml untuk notifikasi -->
<script>
    $(document).ready(function(){
        const notifikasi = $('.info-data').data('infodata');
        const pesan = $('.message').data('infodata');
        if(notifikasi == "Disimpan" || notifikasi=="Dihapus" ){
            Swal.fire({
            icon: 'success',
            title: 'Sukses',
            text: ''+pesan+' data Berhasil '+notifikasi,
            })
        }else if(notifikasi == "Gagal Disimpan" || notifikasi=="Gagal Dihapus"){
            Swal.fire({
            icon: 'error',
            title: 'GAGAL',
            text: ''+pesan+' data '+notifikasi,
            })
        }else if(notifikasi == "Kosong"){
            Swal.fire({
            icon: 'error',
            title: 'GAGAL',
            text: ''+pesan+' data Dipilih '+notifikasi+' atau tidak ada',
            })
        }else if(notifikasi == "Request"){
            Swal.fire({
            icon: 'success',
            title: 'Requested',
            text: ''+pesan+' data '+notifikasi+' telah diteruskan',
            })
        }else if(notifikasi == "Return"){
            Swal.fire({
            icon: 'success',
            title: 'Returned',
            text: ''+pesan+' Pengajuan telah di'+notifikasi+' ',
            })
        }else if(notifikasi == "Reject"){
            Swal.fire({
            icon: 'success',
            title: 'Rejected',
            text: ''+pesan+' Pengajuan telah di'+notifikasi+' ',
            })
        }else if(notifikasi == "Stop"){
            Swal.fire({
            icon: 'success',
            title: 'Stopped',
            text: ''+pesan+' Pengajuan telah di'+notifikasi+' ',
            })
        }else if(notifikasi == "Arsipkan"){
            Swal.fire({
            icon: 'success',
            title: 'Archieved',
            text: ''+pesan+' Pengajuan telah di'+notifikasi+' ',
            })
        }else if(notifikasi == "Approve"){
            Swal.fire({
            icon: 'success',
            title: 'Approved',
            text: ''+pesan+' Pengajuan telah di'+notifikasi+' ',
            })
        }else if(notifikasi == "Import Gagal" || notifikasi == "Error" ){
            Swal.fire({
            icon: 'error',
            title: 'Kesalahan',
            text: ''+pesan+'',
            })
        }
    });
</script>