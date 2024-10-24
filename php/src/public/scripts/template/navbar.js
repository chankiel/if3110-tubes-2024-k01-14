const iconTrigger = document.getElementById("iconTrigger");
const popover = document.getElementById("popover");
iconTrigger.addEventListener("click", function () {
    popover.classList.toggle("hidden");
});

document.addEventListener("click", function (e) {
    if (!iconTrigger.contains(e.target)) {
        popover.classList.add("hidden");
    }
});
