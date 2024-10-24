window.onload = function () {
    const toast = document.getElementById('toast');

    if (toast) {
        toast.classList.add('show');

        setTimeout(function () {
            toast.classList.remove('show');
        }, 4000);
    }
};
