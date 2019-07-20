function like(idImg, url_index)
{
    var post_url = url_index+'gallery/add_like';
    var header_url = url_index+'gallery/index';
    var string_params = 'idImg='+encodeURIComponent(idImg);
    makeRequest(post_url, header_url, string_params);
}

function add_comment(url_index)
{
    var post_url = url_index+'userArea/user_form_validate';
    var header_url = url_index+'gallery';
    var comment = document.getElementById('id_text_area').value;
    var idImg = document.getElementById('hidden_id_img').value;
    if (comment)
    {
        var string_params = 'form=add_comment&idImg='+encodeURIComponent(idImg)+'&comment='+encodeURIComponent(comment);
        makeRequest(post_url, header_url, string_params);
    }
}
