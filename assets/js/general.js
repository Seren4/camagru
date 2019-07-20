/**
 * Modal
 */

function openFormModal(form_id)
{
    if (document.getElementById(form_id))
        document.getElementById(form_id).style.display='flex';
}

function closeFormModal(form_id)
{
    if (document.getElementById(form_id))
    {
        document.getElementById(form_id).style.display = 'none';
        if (document.getElementsByClassName('form_error'))
            var error =document.getElementsByClassName('form_error');
            for (var i = 0; i < error.length; i++)
                error[i].style.display = 'none';
    }

}


/**
 * httpRequest
 */

function alertContents(httpRequest,header_url)
{
    if (httpRequest.readyState === XMLHttpRequest.DONE)
    {
        if (httpRequest.status === 200 )
        {
            var response = httpRequest.responseText;
            location.assign(header_url);
        }
    }
}

function makeRequest(post_url, header_url, string_params)
{
    var httpRequest = new XMLHttpRequest();

    if (!httpRequest)
    {
        return false;
    }

    httpRequest.onreadystatechange= function(){alertContents(httpRequest, header_url);}; //action
    httpRequest.open('POST', post_url, true);
    httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    httpRequest.send(string_params);
}