
function register(url)
{
    var login = document.getElementById("register_login").value;
    var email = document.getElementById("register_email").value;
    var password = document.getElementById("register_password").value;
    var post_url = url+'userArea/user_form_validate';
    var header_url = url+'home';
    var string_params = 'form=register&login='+encodeURIComponent(login)+'&email='+encodeURIComponent(email)+'&password='+encodeURIComponent(password);
    makeRequest(post_url, header_url, string_params);
    return false;
}

function login(url)
{
    var login = document.getElementById("login").value;
    var password = document.getElementById("password").value;
    var post_url = url+'userArea/user_form_validate';
    var header_url = url+'home';
    var string_params = 'form=login&login='+encodeURIComponent(login)+'&password='+encodeURIComponent(password);
    makeRequest(post_url, header_url, string_params);
    return false;
}

/**
 * forgotten password
 */
function forgot_pw(url)
{
    var email = document.getElementById('forgot_email').value;
    var confirm_email = document.getElementById('confirm_forgot_email').value;
    if (email === confirm_email)
    {
        var post_url = url+'userArea/user_form_validate';
        var header_url = url;
        var string_params = 'form=mail_reset_pw&email='+email;
        makeRequest(post_url, header_url, string_params);
    }
    else
        document.getElementById('different_email').style.display = 'block';
    return false;

}

function reset_password(url)
{
    var new_password = document.getElementById("new_password").value;
    var conf_new_password = document.getElementById("conf_new_password").value;
    if (new_password === conf_new_password)
    {
        var post_url = url+'userArea/user_form_validate';
        var header_url = url+'home';
        var string = document.getElementById("string").value;
        var string_params = 'form=reset_pw&password='+encodeURIComponent(new_password)+'&string='+encodeURIComponent(string);
        makeRequest(post_url, header_url, string_params);
    }
    else
        document.getElementById('different_password').style.display = 'block';
    return false;
}

/**
 * User Area
 */
function change_password(url)
{
    var login = document.getElementById("login1").value;
    var old_password = document.getElementById("old_password").value;
    var new_password = document.getElementById("new_password").value;
    var conf_new_password = document.getElementById("conf_new_password").value;
    var post_url = url+'userArea/user_form_validate';
    var header_url = url+'userArea';
    if (new_password === conf_new_password)
    {
        var string_params = 'form=change_pw&login='+encodeURIComponent(login)+'&old_password='+encodeURIComponent(old_password)+'&new_password='+encodeURIComponent(new_password);
        makeRequest(post_url, header_url, string_params);
    }
    return false;
}

function change_login(url)
{
    var login = document.getElementById("login2").value;
    var password = document.getElementById("password2").value;
    var new_login = document.getElementById("new_login").value;
    var post_url = url+'userArea/user_form_validate';
    var header_url = url+'userArea';
    var string_params = 'form=change_login&login='+encodeURIComponent(login)+'&new_login='+encodeURIComponent(new_login)+'&password='+encodeURIComponent(password);
    makeRequest(post_url, header_url, string_params);
    return false;
}

function change_mail(url)
{
    var login = document.getElementById("login3").value;
    var new_mail = document.getElementById("new_mail").value;
    var password = document.getElementById("password3").value;
    var post_url = url+'userArea/user_form_validate';
    var header_url = url+'userArea';
    var string_params = 'form=change_mail&login='+encodeURIComponent(login)+'&new_mail='+new_mail+'&password='+encodeURIComponent(password);
    makeRequest(post_url, header_url, string_params);
    return false;
}

function unsubscribe(url)
{
    var post_url = url+'userArea/unsubscribe';
    var header_url = url+'userArea';
    var string_params = '';
    makeRequest(post_url, header_url, string_params);
    return false;
}

function subscribe(url)
{
    var post_url = url+'userArea/subscribe';
    var header_url = url+'userArea';
    var string_params = '';
    makeRequest(post_url, header_url, string_params);
    return false;
}