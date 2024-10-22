const fileInput = document.getElementById("files");
const imagePreview = document.getElementById("image-preview");

fileInput.addEventListener("change", function () {
  imagePreview.innerHTML = "";

  const files = fileInput.files;

  for (let i = 0; i < files.length; i++) {
    const file = files[i];

    if (file.type.startsWith("image/")) {
      const img = document.createElement("img");
      img.src = URL.createObjectURL(file);
      img.classList.add("img-upload");

      imagePreview.appendChild(img);
    }
  }
});

const quill = new Quill('#deskripsi', {
  theme: 'snow'
});
const editForm = document.querySelector(".form-edit-lowongan");
const inputDesc = document.querySelector("#hiddenArea");
editForm.addEventListener("submit",function(e){
  inputDesc.value = quill.root.innerHTML;
})