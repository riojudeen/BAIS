$('.remove').on('click', function(e){
    e.preventDefault();
    var getLink = $(this).attr('href');
        
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
            document.proses.action = getLink;
            document.proses.submit();
        }
    })
    
});
