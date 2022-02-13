$(document).ready(function(){
    $('#allcek').on('click', function() {
        if(this.checked){
            $('.cek').each(function() {
                this.checked = true;
            })
        } else {
            $('.cek').each(function() {
                this.checked = false;
            })
        }

    });

    $('.cek').on('click', function() {
        if($('.cek:checked').length == $('.cek').length){
            $('#allcek').prop('checked', true)
        } else {
            $('#allcek').prop('checked', false)
        }
    })
})     

