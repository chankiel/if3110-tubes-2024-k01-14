const profileForm = document.querySelector(".profile-form");
const divNama = document.getElementById("input-nama");
const divLokasi = document.getElementById("input-lokasi");
const divAbout = document.getElementById("input-about");

const inputNama = document.getElementById("nama");
const inputLokasi = document.getElementById("lokasi");
const inputAbout = document.querySelector("#hiddenArea");

const errNama = document.querySelector(".err-nama");
const errLokasi = document.querySelector(".err-lokasi");
const errAbout = document.querySelector(".err-about");

const backBtn = document.getElementById("back-btn");
const quill = new Quill("#input-about", {
  theme: "snow",
});

profileForm.addEventListener("submit", function (e) {
  e.preventDefault();
  let isError = false;

  isError = validateInput(inputNama, errNama, divNama) || isError;
  isError = validateInput(inputLokasi, errLokasi, divLokasi) || isError;
  isError = validateInput(inputAbout, errAbout, divAbout) || isError;
  if (isError) return;

  const xhr = new XMLHttpRequest();
  const formData = new FormData(this);
  const urlEncodedData = new URLSearchParams(formData).toString();

  xhr.open("PUT", "/profile/company");
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onload = function () {
    if (xhr.status === 200) {
      console.log(xhr.responseText);
    } else {
      console.log("Error", xhr.responseText);
    }
    location.reload();
  };

  xhr.onerror = function () {
    console.error("Request failed");
  };

  xhr.send(urlEncodedData);
});

removeError(inputNama, errNama, divNama);
removeError(inputLokasi, errLokasi, divLokasi);
removeError(inputAbout, errAbout, divAbout);
