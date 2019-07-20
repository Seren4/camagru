<?php if (!isset($this)) { exit(header('HTTP/1.0 403 Forbidden'));}
if (!isset ($_SESSION['logged_user'])) {
    ?>
    <div id="login_form" class="modal"
         onsubmit="return login('<?= htmlspecialchars(URL_WITH_INDEX_FILE, ENT_QUOTES) ?>');">
        <div class="modal-background" onclick="closeModal('login_form')"></div>
        <form class="container" name="loginForm">
            <div class="field">
                <label class="label is-medium">Username</label>
                <div class="control">
                    <input class="input is-medium" type="text" placeholder="Enter Username" id="login"
                           title="Username must be betweeen 5 an 19 characters, and can contain uppercase, lowercase, numbers and underscore."
                           pattern="^[a-zA-Z0-9_]{5,20}$" required">
                </div>
            </div>
            <div class="field">
                <label class="label is-medium">Password</label>
                <div class="control">
                    <input class="input is-medium" type="password" placeholder="Enter Password" id="password" required>
                </div>
            </div>
            <div class="field is-grouped">
                <div class="control">
                    <button class="button is-link is-medium" type="submit">Submit</button>
                </div>

                <div class="control">
                    <button class=" forgot_btn button is-medium" type="button"
                            onclick="openFormModal('forgot_pw_form');closeFormModal('login_form');">Forgot
                        password?
                    </button>
                </div>
            </div>
            <div id="login_form_error" class="form_error">Login and/or password incorrect</div>
        </form>
        <button class="button modal-close is-dark" type="button" aria-label="close"
                onclick="closeModal('login_form')"></button>
    </div>


    <div id="register_form" class="modal"
         onsubmit="return register('<?= htmlspecialchars(URL_WITH_INDEX_FILE, ENT_QUOTES) ?>');">
        <div class="modal-background" onclick="closeFormModal('register_form')"></div>
        <form class="container" name="registerForm">
            <div class="field">
                <label class="label is-medium">Username</label>
                <div class="control">
                    <input class="input is-medium" type="text" placeholder="Enter Username" id="register_login"
                           title="Username must be betweeen 5 an 19 characters, and can contain uppercase, lowercase, numbers and underscore."
                           pattern="^[a-zA-Z0-9_]{5,20}$" required>
                </div>
            </div>
            <div class="field">
                <label class="label is-medium">Password</label>
                <div class="control">
                    <input class="input is-medium" type="password" placeholder="Enter Password" id="register_password"
                           required
                           title="Password must contain at least 8 characters, including uppercase, lowercase, numbers and special characters."
                           pattern="^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$">
                </div>
            </div>

            <div class="field">
                <label class="label is-medium">Email</label>
                <div class="control">
                    <input class="input is-medium " type="email" placeholder="Email input" id="register_email" required>
                </div>
            </div>
            <div class="field is-grouped">
                <div class="control">
                    <button class="button is-link is-medium" type="submit">Register</button>
                </div>
                <div class="control">
                    <button class="button is-medium" onclick="closeFormModal('register_form')" type="button">Cancel
                    </button>
                </div>
            </div>
            <div id="register_form_error" class="form_error">Invalid Credentials!</div>
        </form>
        <button class="button modal-close is-dark" aria-label="close"
                onclick="closeFormModal('register_form')" type="button"></button>

    </div>

    <div id="forgot_pw_form" class="modal"
         onsubmit="return forgot_pw('<?= htmlspecialchars(URL_WITH_INDEX_FILE, ENT_QUOTES) ?>');">
        <div class="modal-background" onclick="closeFormModal('forgot_pw_form')"></div>
        <form class="container" name="forgotPw_form">
            <div class="field">
                <label class="label is-medium">Email</label>
                <div class="control">
                    <input class="input is-medium " type="email" placeholder="Enter your email" id="forgot_email"
                           required>
                </div>
            </div>
            <div class="field">
                <label class="label is-medium">Confirm Email</label>
                <div class="control">
                    <input class="input is-medium " type="email" placeholder="Confirm your email"
                           id="confirm_forgot_email" required>
                </div>
            </div>
            <div class="field is-grouped">
                <div class="control">
                    <button class="button is-link is-medium" type="submit">Send Request</button>
                </div>
                <div class="control">
                    <button class="button is-medium" onclick="closeFormModal('forgot_pw_form')" type="button">Cancel
                    </button>
                </div>
            </div>
            <div id="different_email" class="form_error">Emails don't match</div>
        </form>

        <button class="button modal-close is-dark" aria-label="close"
                onclick="closeFormModal('forgot_pw_form')" type="button"></button>

    </div>


    <div id="reset_pw_form" class="modal"
         onsubmit="return reset_password('<?= htmlspecialchars(URL_WITH_INDEX_FILE, ENT_QUOTES) ?>');">
        <div class="modal-background" onclick="closeFormModal('reset_pw_form')"></div>
        <form class="container" name="resetPw_form">
            <input type="hidden" id="string" value="<?= isset($string) ? $string : "" ?>">
            <div class="field">
                <label class="label is-medium">New password</label>
                <div class="control">
                    <input class="input is-medium " type="password" placeholder="Enter New Password" id="new_password"
                           title="Password must contain at least 8 characters, including uppercase, lowercase, numbers and special characters."
                           pattern="^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$" required>
                </div>
            </div>
            <div class="field">
                <label class="label is-medium">Confirm new password</label>
                <div class="control">
                    <input class="input is-medium " type="password" placeholder="Confirm New Password"
                           id="conf_new_password"
                           title="Password must contain at least 8 characters, including uppercase, lowercase, numbers and special characters."
                           pattern="^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$" required>
                </div>
            </div>
            <div class="field is-grouped">
                <div class="control">
                    <button class="button is-link is-medium" type="submit">Confirm</button>
                </div>
            </div>
            <div id="different_password" class="form_error">Passwords don't match</div>
        </form>
    </div>

    <?php
}

    if (isset($_SESSION['log_error']) AND $_SESSION['log_error'] === 'wrong') {
        ?>
        <script>
            document.getElementById('login_form_error').style.display = "inline";
        </script>
        <?php
        unset($_SESSION['log_error']);
    } elseif (isset($_SESSION['log_error']) AND $_SESSION['log_error'] === 'register_wrong') {
        ?>
        <script>document.getElementById('register_form_error').style.display = "inline";</script>
        <?php
        unset($_SESSION['log_error']);
    }




