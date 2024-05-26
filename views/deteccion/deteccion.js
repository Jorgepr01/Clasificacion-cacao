//modelo :) tm
const URL = 'https://teachablemachine.withgoogle.com/models/MbKONURSD/';
let model, webcam, labelContainer, maxPredictions,img,previewImg,stopLoop,imagennn,camara;
let classMaster = null
const btncompra = document.getElementById('enviarData');
btncompra.disabled = true; 
const load = document.getElementById("loading")
const overlay = document.getElementById("overlay")
load.style.visibility  = "hidden"
overlay.style.visibility  = "hidden"

camara=document.getElementById("webcam-container")

// document.getElementById('avatar').addEventListener('change',ModelFile) //leer el file
const inputImg=document.getElementById("file-upload");

inputImg.addEventListener('change',ModelFile) //leer el file

// Caundo presiono el abri web can en html boton me hace que funcione esta funcion
async function init() {
    // document.getElementById("ContDeteccion").style.display = "flex";
    img=document.getElementById("preview-image")
    if (!camara.hasChildNodes()){
        stopLoop = false;
        const modelURL = URL + "model.json";
        const metadataURL = URL + "metadata.json";
        model = await tmImage.load(modelURL, metadataURL);
        maxPredictions = model.getTotalClasses();
        
        // Convenience function to setup a webcam
        const flip = true; // whether to flip the webcam
        webcam = new tmImage.Webcam(520, 450, flip); // width, height, flip
        await webcam.setup(); // request access to the webcam
        await webcam.play();
        window.requestAnimationFrame(loop);
        // append elements to the DOM
        camara.appendChild(webcam.canvas);
        img=document.getElementById("preview-image")
        img.style.display = "none";
        camara.style.display = "flex";
        labelContainer = document.getElementById("label-container");
        for (let i = 0; i < maxPredictions; i++) { // and class labels
            labelContainer.appendChild(document.createElement("div"));
        }
    }else{ 
        document.getElementById("preview-image").style.display = "flex";
        while (camara.firstChild) {
            img.src = "./DefaulFinal.png"
            camara.removeChild(camara.firstChild);
            camara.style.display = "none";
            webcam.stop()
          }
    }


}
//actualiza el la webcam por siempre
async function loop() {
    webcam.update(); // update the webcam frame
    await predict(webcam.canvas);
    if (!stopLoop){
        window.requestAnimationFrame(loop);
    }
}
async function ModelFile(){
    var file = this.files;
    
    if(file.length>0){
        overlay.style.visibility  = "visible"
        load.style.visibility  = "visible"
        imagennn=document.getElementById("preview-image")
        imagennn.style.display = "flex";
        if (camara.hasChildNodes()){
            webcam.stop()
            camara.removeChild(camara.firstChild);
        }
        stopLoop = true; 
        document.getElementById("webcam-container").style.display = "none";
        if (file[0]) {
            var reader = new FileReader();
            reader.onload = function(event) {
                imagennn.setAttribute('src', event.target.result);
                imagennn.style.display = "block";
            };
            reader.readAsDataURL(file[0]);
        } else {
            document.getElementById('preview-image').setAttribute('src', '#');
        }
        const modelURL = URL + "model.json";
        const metadataURL = URL + "metadata.json";
        model = await tmImage.load(modelURL, metadataURL);
        maxPredictions = model.getTotalClasses();
        document.getElementById("ContDeteccion").style.display = "grid";
        labelContainer = document.getElementById("label-container");
        for (let i = 0; i < maxPredictions; i++) { // and class labels
            labelContainer.appendChild(document.createElement("div"));
        }
        predict(imagennn);
    }else{
        // Swal.fire({
        //     position: "center",
        //     icon: "error",
        //     title: "Oops...",
        //     text: "Tienes que subir un archivo...",
        //     showCloseButton:true,
        //     timer: 4500
        //   });
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Tienes que subir un archivo...",
            showConfirmButton: false,
            showCloseButton:true,
            timer: 2000
          });
        return
    }
    overlay.style.visibility  = "hidden"
    load.style.visibility  = "hidden"


    

}




const classMax = document.createElement("span");
async function predict(imgagess) {
   // predict can take in an image, video or canvas html element
    const prediction = await model.predict(imgagess);
    let probabilityMax =0
    for (let i = 0; i < maxPredictions; i++) {
        clase=prediction[i].className
        probabilidad = prediction[i].probability
        if (probabilidad>=probabilityMax){
            probabilityMax=probabilidad
            classMaster=clase
        }
        const classPrediction = clase + ": " + probabilidad.toFixed(2);
        labelContainer.childNodes[i].innerHTML = classPrediction;
    }

    var descripcionElemento = document.getElementById("descripcionImagen");
    var descripcionTitle = document.getElementById("descripccion");
    descripcionElemento.innerHTML = descrition[classMaster][1];
    classMax.innerHTML=": "+descrition[classMaster][0];
    descripcionTitle.appendChild(classMax)
    btncompra.disabled = false; 
}






function enviar(){
    imagennn=document.getElementById('preview-image')
    var formDataI = new FormData();
    formDataI.append("imagen", imagennn);
    
    var datos={
        imag:formDataI,
        clase:classMaster
    }
    // $.ajax({
    //     type: "POST",
    //     data:datos,
    //     url: 'hay va el php creo :)',
    //     success:function(data){
    //         console.log(data);
    //     Swal.fire({
    //         position: "center",
    //         icon: "success",
    //         title: "Your work has been saved",
    //         showConfirmButton: false,
    //         timer: 1500
    //     });
    //      btncompra.disabled = true; 
    //     }
    // })
    // QUITAR CUANDO SE ACTULIZE EL CODIGO DE ENVIO DEL POST
    console.log(datos);
    Swal.fire({
        position: "center",
        icon: "success",
        title: "Your work has been saved",
        showConfirmButton: false,
        timer: 1500
      });
      btncompra.disabled = true;
}
