const modalCancelBtns = document.querySelectorAll(".modalCancelBtn");

function hideModal(modalId) {
  const modal = document.getElementById(modalId);
  if (modal) {
    modal.classList.remove("modal-active");
    modal.classList.add("hidden");
  }
}

modalCancelBtns.forEach((button) => {
  button.addEventListener("click", () => {
    const modalId = button.getAttribute("data-modal");
    hideModal(modalId);
  });
});
