document.addEventListener("DOMContentLoaded", function() {
    const roleSelect = document.getElementById("role");

    roleSelect.addEventListener("change", function() {
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

    document.querySelector('form').addEventListener('submit', function(event) {
        const role = document.getElementById("role").value;
        let passwordField, confirmPasswordField;

        if (role === "jobseeker") {
            passwordField = document.querySelector('input[name="password"]');
            confirmPasswordField = document.querySelector('input[name="confirm_password"]');
        } else {
            passwordField = document.querySelector('input[name="password_company"]');
            confirmPasswordField = document.querySelector('input[name="confirm_password_company"]');
        }

        const errorMessageDiv = document.querySelector('.error-message');
        if (passwordField.value !== confirmPasswordField.value) {
            event.preventDefault();
            errorMessageDiv.textContent = "Passwords do not match. Please enter the same password in both fields.";
            errorMessageDiv.style.display = "block";
        } else {
            errorMessageDiv.style.display = "none";
        }
    });
});
