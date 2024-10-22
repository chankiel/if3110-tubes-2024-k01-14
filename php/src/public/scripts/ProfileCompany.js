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
        return;
    }
    if(inputLokasi.value === ""){
        errLokasi.classList.remove("hidden");
        divLokasi.classList.add("error-state");
        return;
    }
    if(inputAbout.value === ""){
        errAbout.classList.remove("hidden");
        divAbout.classList.add("error-state");
        return;
    }

    const xhr = new XMLHttpRequest();
    const formData = new FormData(this);
    const urlEncodedData = new URLSearchParams(formData).toString();

    xhr.open('PUT','/profile/company');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (xhr.status === 200) {
            console.log(xhr.responseText);
        } else {
            console.log('Error',xhr.responseText);
        }
        location.reload();
    };

    xhr.onerror = function() {
        console.error('Request failed');
    };

    xhr.send(urlEncodedData);
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

const modal = document.getElementById("modal");
const modalOkBtn = document.getElementById("modalOkBtn");

function hideModal() {
  modal.classList.remove("modal-active");
  modal.classList.add("hidden");

}

if (modalOkBtn) {
  modalOkBtn.addEventListener("click", hideModal);
}

if (modal) {
  modal.classList.add("modal-active");
}