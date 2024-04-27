
    function  UpImg() {
        if (document.getElementById("img-category")){
            console.log("ádfasd");
        document.getElementById("img-category").style.display = "none";
    }
        var fileSL = document.getElementById('image').files;
        if (fileSL.length > 0) {
            var imgUp = fileSL[0];
            var fileReader = new FileReader();
            fileReader.onload = function(fileLoaderEvent) {
                var srcI = fileLoaderEvent.target.result;
                var newImg = document.createElement('img');
                newImg.src = srcI;
                document.getElementById('displayIMG').innerHTML =  newImg.outerHTML;
            }
            fileReader.readAsDataURL(imgUp);   
        }

    }

  