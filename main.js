//modelo :) tm
const URL = 'https://teachablemachine.withgoogle.com/models/A3dOiWWUw/';
let model, webcam, labelContainer, maxPredictions,img,previewImg;
//description html
const descrition = {
    "pod_borer": "Esta es la descripción de la primera imagen. pod_borer",
    "healthy": "Esta es la descripción de la segunda imagen. healthy",
    "black_pod_rot": "Esta es la descripción de la tercera imagen. black_pod_rot"
}

document.getElementById('avatar').addEventListener('change',ModelFile) //leer el file
document.getElementById('avatars').addEventListener('change',ModelFile) //leer el file

// Caundo presiono el abri web can en html boton me hace que funcione esta funcion
async function init() {

    const modelURL = URL + "model.json";
    const metadataURL = URL + "metadata.json";

    // load the model and metadata
    // Refer to tmImage.loadFromFiles() in the API to support files from a file picker
    // or files from your local hard drive
    // Note: the pose library adds "tmImage" object to your window (window.tmImage)
    model = await tmImage.load(modelURL, metadataURL);
    maxPredictions = model.getTotalClasses();

    // Convenience function to setup a webcam
    const flip = true; // whether to flip the webcam
    webcam = new tmImage.Webcam(500, 450, flip); // width, height, flip
    await webcam.setup(); // request access to the webcam
    await webcam.play();
    window.requestAnimationFrame(loop);
    document.getElementById("MenuFile").style.display = "none";
    document.getElementById("preview-image").style.display = "none";
    document.getElementById("Presentation").style.display = "flex";
    // append elements to the DOM
    document.getElementById("webcam-container").appendChild(webcam.canvas);
    labelContainer = document.getElementById("label-container");
    for (let i = 0; i < maxPredictions; i++) { // and class labels
        labelContainer.appendChild(document.createElement("div"));
    }
}
//actualiza el la webcam por siempre
async function loop() {
    webcam.update(); // update the webcam frame
    await predict(webcam.canvas);
    window.requestAnimationFrame(loop);
}
async function ModelFile(){
    imagennn=document.getElementById('preview-image')
    document.getElementById("MenuFile").style.display = "none";
    document.getElementById("webcam-container").style.display = "none";
    document.getElementById("Presentation").style.display = "flex";
    var file = this.files[0];
    if (file) {
        var reader = new FileReader();
        reader.onload = function(event) {
          imagennn.setAttribute('src', event.target.result);
          imagennn.style.display = "block";
          
        };
        reader.readAsDataURL(file);
      } else {
        document.getElementById('preview-image').setAttribute('src', '#');
      }
    const modelURL = URL + "model.json";
    const metadataURL = URL + "metadata.json";
    model = await tmImage.load(modelURL, metadataURL);
    maxPredictions = model.getTotalClasses();

    labelContainer = document.getElementById("label-container");
    for (let i = 0; i < maxPredictions; i++) { // and class labels
        labelContainer.appendChild(document.createElement("div"));
    }
    await predict(imagennn);
}

async function predict(imgagess) {

   // predict can take in an image, video or canvas html element
    const prediction = await model.predict(imgagess);
    let classMaster = null
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
    descripcionElemento.innerHTML = descrition[classMaster];
}
