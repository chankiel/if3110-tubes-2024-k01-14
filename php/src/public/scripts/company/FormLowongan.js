const fileInput = document.getElementById("files");
const previewContainer = document.getElementById("preview-container");

fileInput.addEventListener("change", handleFiles);

function handleFiles() {
  previewContainer.innerHTML = "";
  Array.from(fileInput.files).forEach((file, index) => {
    const imagePreview = document.createElement('div');
    imagePreview.classList.add('preview-img-container');
    const img = document.createElement("img");
    img.src = URL.createObjectURL(file);
    img.classList.add("img-upload");

    const removeButton = document.createElement('button');
    removeButton.classList.add('remove-btn');
    removeButton.textContent = 'X';
    removeButton.onclick = ()=> removeImage(index);

    imagePreview.appendChild(img);
    imagePreview.appendChild(removeButton);
    previewContainer.appendChild(imagePreview);
  });
}

function removeImage(index){
  const dataTransfer = new DataTransfer();
  Array.from(fileInput.files).forEach((file,i) => {
    if(i !== index) dataTransfer.items.add(file);
  });
  fileInput.files = dataTransfer.files;
  handleFiles();
}

const quill = new Quill("#quil-deskripsi", {
  theme: "snow",
});

const lowonganForm = document.getElementById("form-lowongan");
const divPosisi = document.getElementById("div-posisi");
const divDeskripsi = document.getElementById("div-deskripsi");
const divPekerjaan = document.getElementById("div-pekerjaan");
const divLokasi = document.getElementById("div-lokasi");

const inputPosisi = document.getElementById("posisi");
const inputDeskripsi = document.getElementById("deskripsi");
const inputPekerjaan = document.getElementById("jenis_pekerjaan");
const inputLokasi = document.getElementById("jenis_lokasi");

const errPosisi = document.querySelector(".err-posisi");
const errLokasi = document.querySelector(".err-lokasi");
const errDeskripsi = document.querySelector(".err-deskripsi");
const errPekerjaan = document.querySelector(".err-pekerjaan");

lowonganForm.addEventListener("submit", function (e) {
  e.preventDefault();
  let isError = false;
  isError = validateInput(inputPosisi, errPosisi, divPosisi) || isError;
  isError = validateQuil(inputDeskripsi, errDeskripsi, divDeskripsi) || isError;
  if (lowonganForm.dataset.mode === "tambah") {
    isError = validateInput(inputLokasi, errLokasi, divLokasi) || isError;
    isError =
      validateInput(inputPekerjaan, errPekerjaan, divPekerjaan) || isError;
  }

  console.log(isError);

  if (!isError) {
    lowonganForm.submit();
  }
});

removeError(inputPosisi, errPosisi, divPosisi);
removeError(inputLokasi, errLokasi, divLokasi);
removeError(inputDeskripsi, errDeskripsi, divDeskripsi);
removeError(inputPekerjaan, errPekerjaan, divPekerjaan);
