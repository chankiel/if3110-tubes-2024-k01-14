document.getElementById("role").addEventListener("change", function() {
    const role = this.value;

    if (role === "jobseeker") {
        document.getElementById("jobseekerFields").style.display = "block";
        Array.from(document.querySelectorAll('#jobseekerFields input')).forEach(input => {
            input.required = true;
        });

        document.getElementById("companyFields").style.display = "none";
        Array.from(document.querySelectorAll('#companyFields input, #companyFields textarea')).forEach(input => {
            input.required = false;
        });

    } else if (role === "company") {
        document.getElementById("companyFields").style.display = "block";
        Array.from(document.querySelectorAll('#companyFields input, #companyFields textarea')).forEach(input => {
            input.required = true;
        });

        document.getElementById("jobseekerFields").style.display = "none";
        Array.from(document.querySelectorAll('#jobseekerFields input')).forEach(input => {
            input.required = false;
        });
    }
});