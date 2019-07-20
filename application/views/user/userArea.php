<?php if (!isset($this)) { exit(header('HTTP/1.0 403 Forbidden'));}
if (!empty($_SESSION['logged_user'])):?>
<section class="section user_area_container">
    <div>
        <ul class="nav_bar user_nav_bar" >
            <li><a class="title navbar-item" href="#" id="changeLogin" onclick="openFormModal('new_login_form')">Change login</a></li>
            <li><a class="title navbar-item" href="#" id="changePassword" onclick="openFormModal('new_pw_form')">Change password</a></li>
            <li><a class="title navbar-item" href="#" id="changeMail" onclick="openFormModal('new_mail_form')">Change mail</a></li>
            <li><a class="title navbar-item" id="unsubscribeMail" href="#" onclick="return unsubscribe('<?= htmlspecialchars(URL_WITH_INDEX_FILE, ENT_QUOTES)?>');" style="display: <?php $x = (isset($_SESSION['mail_status']) AND $_SESSION['mail_status'] == 1) ? 'block' :  'none';echo $x;?>">Unsubscribe mail</a></li>
            <li><a class="title navbar-item" id="subscribeMail" href="#" onclick="return subscribe('<?= htmlspecialchars(URL_WITH_INDEX_FILE, ENT_QUOTES)?>');"  style="display: <?php $x = (isset($_SESSION['mail_status']) AND $_SESSION['mail_status'] == 0) ? 'block' :  'none';echo $x;?>">Subscribe mail</a></li>
        </ul>
    </div>
</section>


    <div id="new_pw_form" class="modal" onsubmit="return change_password('<?= htmlspecialchars(URL_WITH_INDEX_FILE, ENT_QUOTES)?>');">
        <div class="modal-background" onclick="closeFormModal('new_pw_form')" ></div>
    <form class="container" name="change_pw_form">
        <input type="hidden" id="string" value="<?= isset($string)? $string : ""?>" >
        <input type="hidden" name="form" value="new_pw_form">
        <div class="field">
            <label class="label is-medium">Username</label>
            <div class="control">
                <input class="input is-medium" type="text" placeholder="Enter Username"  id="login1"
                       required>
            </div>
        </div>
        <div class="field">
            <label class="label is-medium">Password</label>
            <div class="control">
                <input class="input is-medium " type="password" placeholder="Enter Actual Password" id="old_password"
                      required>
            </div>
        </div>
        <div class="field">
            <label class="label is-medium">New password</label>
            <div class="control">
                <input class="input is-medium "  type="password" placeholder="New Password" id="new_password"
                       title="Password must contain at least 8 characters, including uppercase, lowercase, numbers and special characters."
                       pattern="^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$" required>
            </div>
        </div>
        <div class="field">
            <label class="label is-medium">Confirm new password</label>
            <div class="control">
                <input class="input is-medium "  type="password" placeholder="Confirm New Password" id="conf_new_password"
                       title="Password must contain at least 8 characters, including uppercase, lowercase, numbers and special characters."
                       pattern="^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$" required>
            </div>
        </div>
        <div class="field is-grouped">
            <div class="control">
                <button class="button is-link is-medium">Confirm</button>
            </div>
            <div class="control">
                <button class="button is-medium" onclick="closeFormModal('new_pw_form')">Cancel</button>
            </div>
        </div>
        <div id="different_password" class="form_error">Passwords don't match </div>
        <div id="new_pw_form_error" class="form_error" >Wrong Credentials!!</div>
    </form>
        <button class="button modal-close is-dark" aria-label="close" onclick="closeFormModal('new_pw_form')"></button>
    </div>

<div id="new_login_form" class="modal" onsubmit="return change_login('<?= htmlspecialchars(URL_WITH_INDEX_FILE, ENT_QUOTES)?>');">
    <div class="modal-background" onclick="closeFormModal('new_login_form')" ></div>
    <form class="container" name="change_login_form">
        <input type="hidden" name="form" value="new_login_form">

        <div class="field">
            <label class="label is-medium">Username</label>
            <div class="control">
                <input class="input is-medium" type="text" placeholder="Enter Username"  id="login2"
                       required>
            </div>
        </div>
        <div class="field">
            <label class="label is-medium">New Username</label>
            <div class="control">
                <input class="input is-medium " type="text" placeholder="Enter New Username" id="new_login"
                       required>
            </div>
        </div>
        <div class="field">
            <label class="label is-medium">Password</label>
            <div class="control">
                <input class="input is-medium "  type="password" placeholder="Enter Password" id="password2"
                       required>
            </div>
        </div>
        <div class="field is-grouped">
            <div class="control">
                <button class="button is-link is-medium">Confirm</button>
            </div>
            <div class="control">
                <button class="button is-medium" onclick="closeFormModal('new_login_form')">Cancel</button>
            </div>
        </div>
        <div id="new_login_form_error" class="form_error" >Wrong Credentials!</div>
        <div id="new_login_form_error2" class="form_error" >Existing user!</div>
    </form>
    <button class="button modal-close is-dark" aria-label="close" onclick="closeFormModal('new_login_form')"></button>

</div>


<div id="new_mail_form" class="modal" onsubmit="return change_mail('<?= htmlspecialchars(URL_WITH_INDEX_FILE, ENT_QUOTES)?>');">
    <div class="modal-background" onclick="closeFormModal('new_mail_form')" ></div>

    <form class="container" name="change_mail_form">
        <input type="hidden" name="form" value="new_mail_form">

        <div class="field">
            <label class="label is-medium">Username</label>
            <div class="control">
                <input class="input is-medium" type="text" placeholder="Enter Username"  id="login3"
                       required>
            </div>
        </div>
        <div class="field">
            <label class="label is-medium">New Email</label>
            <div class="control">
                <input class="input is-medium " type="text" placeholder="Enter New Email" id="new_mail"
                       required>
            </div>
        </div>
        <div class="field">
            <label class="label is-medium">Password</label>
            <div class="control">
                <input class="input is-medium "  type="password" placeholder="Enter Password" id="password3"
                       required>
            </div>
        </div>

        <div class="field is-grouped">
            <div class="control">
                <button class="button is-link is-medium">Confirm</button>
            </div>
            <div class="control">
                <button class="button is-medium" onclick="closeFormModal('new_mail_form')">Cancel</button>
            </div>
        </div>
        <div id="new_mail_form_error" class="form_error" >Wrong Credentials!</div>
        <div id="new_login_form_error2" class="form_error" >Existing user!</div>
    </form>
    <button class="button modal-close is-dark" aria-label="close" onclick="closeFormModal('new_mail_form')"></button>
</div>
<?php endif;

