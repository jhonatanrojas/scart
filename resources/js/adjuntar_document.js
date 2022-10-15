

function printErrorMsg (msg) {
    $(".print-error-msg").find("ul").html('');
    $(".print-error-msg").css('display','block');
    $.each( msg, function( key, value ) {
        $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
    });
}

document.getElementById("file").onchange=function(e){
    let readi = new FileReader()

    readi.readAsDataURL(e.target.files[0])
    readi.onload = function(){
        let preview = document.getElementById("preview")
        let img  = document.createElement("img")
        img.style.width = "20%"
        img.src =  readi.result

        preview.appendChild(img)


    }

}
document.getElementById("file2").onchange=function(e){
    let readi = new FileReader()

    readi.readAsDataURL(e.target.files[0])
    readi.onload = function(){
        let preview = document.getElementById("preview2")
        let img  = document.createElement("img")
        img.style.width = "20%"
        img.src =  readi.result

        preview.appendChild(img)


    }

}


