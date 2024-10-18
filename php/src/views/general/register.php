<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\..\public\styles\general\register-login.css">
    <title>Sign Up</title>
</head>
<body>
    <header>
        <div class="header-subtitle">
            Make the most of your professional life
        </div>
    </header>

    <section class="form-register-login">
        <div class="register-login-container">
            <h1>Register</h1>
            <form action="/register" method="POST">
                <label for="role">I am a</label>
                <select id="role" name="role">
                    <option value="jobseeker">Job Seeker</option>
                    <option value="company">Company</option>
                </select>

                <div id="jobseekerFields" class="jobseekerFields">
                    <label for="name">Name</label>
                    <input type="text" name="name" required>

                    <label for="email">Email</label>
                    <input type="email" name="email" required>

                    <label for="password">Password</label>
                    <input type="password" name="password" required>

                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" name="confirm_password" required>
                </div>

                <div id="companyFields" class="companyFields" style="display: none;">
                    <label for="name_company">Company Name</label>
                    <input type="text" name="name_company">

                    <label for="email_company">Email</label>
                    <input type="email" name="email_company">

                    <label for="location">Location</label>
                    <input type="text" name="location">

                    <label for="about">About</label>
                    <input name="about"></textarea>

                    <label for="password_company">Password</label>
                    <input type="password" name="password">

                    <label for="confirm_password_company">Confirm Password</label>
                    <input type="password" name="confirm_password">
                </div>

                <button type="submit">Agree & Join</button>

                <div class="redirect-register-login">
                    <p>Already on LinkedIn? <a href="/login">Sign in</a></p>
                </div>
            </form>
        </div>
    </section>

    <footer>
    </footer>

    <script src="../../public/scripts/general/register.js"></script>
</body>
</html>