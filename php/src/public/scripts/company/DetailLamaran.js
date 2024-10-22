const quill = new Quill("#status_reason", {
  theme: "snow",
});

const approveForm = document.querySelector(".approve-form");
const rejectForm = document.querySelector(".reject-form");
const statusApprove = document.querySelector("#approve-input");
const statusReject = document.querySelector("#reject-input");
const lowongan_id = document.getElementById("lowongan_id").value;

approveForm.addEventListener("submit", function (e) {
  e.preventDefault();
  statusApprove.value = quill.root.innerHTML;
  const xhr = new XMLHttpRequest();
  const formData = new FormData(this);
  const urlEncodedData = new URLSearchParams(formData).toString();

  xhr.open("PUT", `/applications/${lowongan_id}/approve`);
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

rejectForm.addEventListener("submit", function (e) {
  e.preventDefault();
  statusReject.value = quill.root.innerHTML;
  const xhr = new XMLHttpRequest();
  const formData = new FormData(this);
  const urlEncodedData = new URLSearchParams(formData).toString();

  xhr.open("PUT", `/applications/${lowongan_id}/reject`);
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
