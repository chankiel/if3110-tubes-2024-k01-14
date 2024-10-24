<form action="/register" method="POST">
    <label for="role">I am a</label>
    <select id="role" name="role">
        <option value="jobseeker">Job Seeker</option>
        <option value="company">Company</option>
    </select>

    <?php include dirname(__DIR__) . '/../components/register/jobseekerForm.php' ?>

    <?php include dirname(__DIR__) . '/../components/register/companyForm.php' ?>

    <button type="submit">Agree & Join</button>

    <div class="redirect-register-login">
        <p>Already on LinkInPurry? <a href="/login"><strong>Sign in</strong></a></p>
    </div>
</form>