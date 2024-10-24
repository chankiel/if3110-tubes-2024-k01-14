const deleteTrigger = document.getElementById("delete-trigger");
const deleteModal = document.getElementById("delete-modal");
deleteTrigger.addEventListener("click",function(){
  deleteModal.classList.add("modal-active");
  deleteModal.classList.remove("hidden");
})