const profileForm = document.querySelector(".profile-form");
const divNama = document.getElementById("input-nama");
const divLokasi = document.getElementById("input-lokasi");
const divAbout = document.getElementById("input-about");

const inputNama = document.getElementById("nama");
const inputLokasi = document.getElementById("lokasi");
const inputAbout = document.querySelector('#hiddenArea');

const errNama = document.querySelector(".err-nama");
const errLokasi = document.querySelector(".err-lokasi");
const errAbout = document.querySelector(".err-about");

const backBtn = document.getElementById("back-btn");
const quill = new Quill('#quill-editor', {
    theme: 'snow'
});

profileForm.addEventListener("submit",function(e){
    e.preventDefault();
    inputAbout.value = quill.root.innerHTML
    if(inputNama.value === "" ){
        errNama.classList.remove("hidden");
        divNama.classList.add("error-state");
    }
    if(inputLokasi.value === ""){
        errLokasi.classList.remove("hidden");
        divLokasi.classList.add("error-state");
    }
    if(inputAbout.value === ""){
        errAbout.classList.remove("hidden");
        divAbout.classList.add("error-state");
    }
})

inputNama.addEventListener("change", function(e){
    if(!errNama.classList.contains("hidden")){
        errNama.classList.add("hidden");
        divNama.classList.remove("error-state");
    }
})

inputLokasi.addEventListener("change", function(e){
    if(!errLokasi.classList.contains("hidden")){
        errLokasi.classList.add("hidden");
        divLokasi.classList.remove("error-state");
    }
})

inputAbout.addEventListener("change", function(e){
    if(!errAbout.classList.contains("hidden")){
        errAbout.classList.add("hidden");
        divAbout.classList.remove("error-state");
    }
})

if(window.history.length>1){
    backBtn.classList.remove("hidden");
}

backBtn.addEventListener("click",function(){
    if(window.history.length>1){
        window.history.back();
    }
})