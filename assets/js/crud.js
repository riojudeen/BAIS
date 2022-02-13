// fungsi load ajax
function loadAjax(kelas,keterangan,url){
    if(keterangan === 'kelas'){
        var target = '.'+kelas;
    }else{
        var target = '#'+kelas;
    }
    $(target).load(url);
}
// fungsi kirim form
function sendForm(id_form,target,keterangan,url,method,load_url){
    if(keterangan === 'kelas'){
        var elemen = '.'+target;
    }else{
        var elemen = '#'+target;
    }
    $.ajax({
        url: url,
        method: method,
        enctype: 'multipart/form-data',
        data: $("#"+id_form).serialize(),
        success:function(data){
            // $('#'+id_form)[0].reset();
            document.getElementById(id_form).reset();
            $(elemen).fadeOut('slow', function(){
                $(this).load(load_url, function() {
                    $(this).fadeIn('slow', function(){
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: 'data Berhasil',
                        });
                        
                    });
                });
                
            })
            
        }
    })
    
}
// fungsi delete
function deleteData(elemen,url,urlLoad,method,target,proses){
    $(elemen).on('click', function(e){
        e.preventDefault();
        var id = $(this).attr('data-id');
        // console.log(id)
        Swal.fire({
        title: 'Anda Yakin ?',
        text: "ingin menghapus data ini",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#FF5733',
        cancelButtonColor: '#B2BABB',
        confirmButtonText: 'Yes, delete!'
        
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: url,
                    method: method,
                    data: {data:id, proses:proses},
                    success:function(data){
                        $(target).fadeOut(1000, function(){
                            $(this).load(urlLoad, function() {
                                $(this).fadeIn(1000);
                            });

                        })
                        // $('.data-model').load("../ajax/model.php?tab=model"),function() {
                        //     $(this).fadeIn(1500);  // or another bigger number based on your load time
                        // };
                        // Swal.fire({
                        //     icon: 'success',
                        //     title: 'Sukses',
                        //     text: 'data Berhasil',
                        // })
                        
                    }
                })
            }
        })
        
    });
}