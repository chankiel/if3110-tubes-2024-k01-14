const approveTrigger = document.getElementById("approve-trigger");
const approveModal = document.getElementById("approve-modal");
approveTrigger.addEventListener("click",function(){
  approveModal.classList.add("modal-active");
  approveModal.classList.remove("hidden");
})

const deleteTrigger = document.getElementById("reject-trigger");
const rejectModal = document.getElementById("reject-modal");
deleteTrigger.addEventListener("click",function(){
  rejectModal.classList.add("modal-active");
  rejectModal.classList.remove("hidden");
})


const approveForm = document.querySelector(".approve-form");
const rejectForm = document.querySelector(".reject-form");
const statusApprove = document.querySelector("#approve-input");
const statusReject = document.querySelector("#reject-input");
const statusLamaran = document.getElementById("status").value;

if(statusLamaran=="waiting"){
  const lamaran_id = document.getElementById("lamaran_id").value;
  const quill = new Quill("#status_reason", {
    theme: "snow",
  });
  approveForm.addEventListener("submit", function (e) {
    e.preventDefault();
    statusApprove.value = quill.root.innerHTML;
    const xhr = new XMLHttpRequest();
    const formData = new FormData(this);
    const urlEncodedData = new URLSearchParams(formData).toString();
  
    xhr.open("PUT", `/applications/${lamaran_id}/approve`);
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
  
    xhr.open("PUT", `/applications/${lamaran_id}/reject`);
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
}

