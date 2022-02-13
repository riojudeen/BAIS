$('.requestbtn').on('click', function(e){
    e.preventDefault();
    var getLink = $(this).attr('href');
    var id = $(this).attr("data-id");
        
    Swal.fire({
    title: 'Anda Yakin ?',
    text: "Data dengan Kode :" + id + " akan diteruskan untuk aproval",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#FF5733',
    cancelButtonColor: '#B2BABB',
    confirmButtonText: 'Yes, Teruskan!'
    }).then((result) => {
        if (result.value) {
            window.location.href = getLink;
        }
    })
});
$('.rejectbtn').on('click', function(e){
    e.preventDefault();
    var getLink = $(this).attr('href');
    var id = $(this).attr("data-id");
        
    Swal.fire({
    title: 'Anda Yakin ?',
    text: "Data dengan Kode : " + id + " akan dihentikan",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#EF8157',
    cancelButtonColor: '#B2BABB',
    confirmButtonText: 'Yes, Process!'
    }).then((result) => {
        if (result.value) {
            window.location.href = getLink;
        }
    })
});
$('.returnbtn').on('click', function(e){
    e.preventDefault();
    var getLink = $(this).attr('href');
    var id = $(this).attr("data-id");
        
    Swal.fire({
    title: 'Anda Yakin ?',
    text: "Data dengan Kode : " + id + " akan dikembalikan",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#FBC658',
    cancelButtonColor: '#B2BABB',
    confirmButtonText: 'Yes, Process!'
    }).then((result) => {
        if (result.value) {
            window.location.href = getLink;
        }
    })
});
$('.pausebtn').on('click', function(e){
    e.preventDefault();
    var getLink = $(this).attr('href');
    var id = $(this).attr("data-id");
        
    Swal.fire({
    title: 'Anda Yakin ?',
    text: "Data dengan Kode : " + id + " akan dikembalikan",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#52BCDA',
    cancelButtonColor: '#B2BABB',
    confirmButtonText: 'Yes, Process!'
    }).then((result) => {
        if (result.value) {
            window.location.href = getLink;
        }
    })
});
$('.approvebtn').on('click', function(e){
    e.preventDefault();
    var getLink = $(this).attr('href');
    var id = $(this).attr("data-id");
        
    Swal.fire({
    title: 'Anda Yakin ?',
    text: "Data dengan Kode : " + id + " akan diteruskan untuk diproses",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#51CBCE',
    cancelButtonColor: '#B2BABB',
    confirmButtonText: 'Yes, Process!'
    }).then((result) => {
        if (result.value) {
            window.location.href = getLink;
        }
    })
});
$('.arsipbtn').on('click', function(e){
    e.preventDefault();
    var getLink = $(this).attr('href');
    var id = $(this).attr("data-id");
        
    Swal.fire({
    title: 'Anda Yakin ?',
    text: "Data dengan Kode : " + id + " akan diarsipkan",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#6BD098',
    cancelButtonColor: '#B2BABB',
    confirmButtonText: 'Yes, Process!'
    }).then((result) => {
        if (result.value) {
            window.location.href = getLink;
        }
    })
});
$('.requestall').on('click', function(e){
    e.preventDefault();
    var getLink = 'mass_req.php';

    Swal.fire({
    title: 'Anda Yakin ?',
    text: "Semua data yang dicheck / centang akan disubmit",
    icon: 'info',
    showCancelButton: true,
    confirmButtonColor: '#6BD098',
    cancelButtonColor: '#B2BABB',
    confirmButtonText: 'Yes, Process!'
    }).then((result) => {
        if (result.value) {
            document.proses.action = getLink;
            document.proses.submit();
        }
    })
});
$('.approveall').on('click', function(e){
    e.preventDefault();
    var getLink = 'mass_approve.php';

    Swal.fire({
    title: 'Anda Yakin ?',
    text: "Semua data yang dicheck / centang akan diapprove",
    icon: 'info',
    showCancelButton: true,
    confirmButtonColor: '#6BD098',
    cancelButtonColor: '#B2BABB',
    confirmButtonText: 'Yes, Process!'
    }).then((result) => {
        if (result.value) {
            document.proses.action = getLink;
            document.proses.submit();
        }
    })
});
$('.rejectall').on('click', function(e){
    e.preventDefault();
    var getLink = 'mass_reject.php';

    Swal.fire({
    title: 'Anda Yakin ?',
    text: "Semua data yang dicheck / centang akan ditolak",
    icon: 'info',
    showCancelButton: true,
    confirmButtonColor: '#6BD098',
    cancelButtonColor: '#B2BABB',
    confirmButtonText: 'Yes, Process!'
    }).then((result) => {
        if (result.value) {
            document.proses.action = getLink;
            document.proses.submit();
        }
    })
});
$('.returnall').on('click', function(e){
    e.preventDefault();
    var getLink = 'mass_return.php';

    Swal.fire({
    title: 'Anda Yakin ?',
    text: "Semua data yang dicheck / centang akan dikembalikan",
    icon: 'info',
    showCancelButton: true,
    confirmButtonColor: '#6BD098',
    cancelButtonColor: '#B2BABB',
    confirmButtonText: 'Yes, Process!'
    }).then((result) => {
        if (result.value) {
            document.proses.action = getLink;
            document.proses.submit();
        }
    })
});
$('.pauseall').on('click', function(e){
    e.preventDefault();
    var getLink = 'mass_pause.php';

    Swal.fire({
    title: 'Anda Yakin ?',
    text: "Semua data yang dicheck / centang akan dihentikan",
    icon: 'info',
    showCancelButton: true,
    confirmButtonColor: '#6BD098',
    cancelButtonColor: '#B2BABB',
    confirmButtonText: 'Yes, Process!'
    }).then((result) => {
        if (result.value) {
            document.proses.action = getLink;
            document.proses.submit();
        }
    })
});
$('.arsipall').on('click', function(e){
    e.preventDefault();
    var getLink = 'mass_arsip.php';

    Swal.fire({
    title: 'Anda Yakin ?',
    text: "Semua data yang dicheck / centang akan diarsipkan",
    icon: 'info',
    showCancelButton: true,
    confirmButtonColor: '#6BD098',
    cancelButtonColor: '#B2BABB',
    confirmButtonText: 'Yes, Process!'
    }).then((result) => {
        if (result.value) {
            document.proses.action = getLink;
            document.proses.submit();
        }
    })
});