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
