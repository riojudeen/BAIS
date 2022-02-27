
var sesi =  $(body).attr('class');;

if(sesi == "sidebar-mini"){
    
}else if(notifikasi == "Gagal Disimpan" || notifikasi=="Gagal Dihapus"){
    Swal.fire({
    icon: 'error',
    title: 'GAGAL',
    text: 'Data '+notifikasi,
    })
}else if(notifikasi == "Kosong"){

}
$('.hapus').on('click', function(e){
    e.preventDefault();
    var getLink = $(this).attr('href');
    var id = $(this).parents("tr").attr("id");
        
    Swal.fire({
    title: 'Anda Yakin ?',
    text: "SPL dengan No Surat : " + id +" akan dihapus secara permanent",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#FF5733',
    cancelButtonColor: '#B2BABB',
    confirmButtonText: 'Yes, delete!'
    }).then((result) => {
        if (result.value) {
            window.location.href = getLink;
        }
    })
    
});
    
