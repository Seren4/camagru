(function()
{
    if (document.getElementById('video'))
        var width = document.getElementById('video').offsetWidth;
    var height = 0;
    var streaming = false;
    var video = null;
    var canvas = null;
    var photo = null;
    var startbutton = null;
    var save = document.getElementById("save");
    var discard = document.getElementById("discard");
    var pics_form = document.getElementById('pics_form');
    var radio_selected;
    var upload = null;
    var file = null;
    document.getElementById('fileToUpload').addEventListener('change', check_size , false);

    function startup()
    {
        video = document.getElementById('video');
        canvas = document.getElementById('canvas');
        photo = document.getElementById('photo');
        startbutton = document.getElementById('startbutton');
        upload = document.getElementById('upload');
        file = document.getElementById('fileToUpload');
        navigator.mediaDevices.getUserMedia({ video: true, audio: false })
            .then(function(stream)
            {
                if (video)
                {
                    video.srcObject = stream;
                    video.onloadedmetadata = function(e) {
                        video.play();
                    };
                }
            })
            .catch(function(err)
            {
                document.getElementById('no_camera').style.display = 'block';

            });
        var resize_func = function(ev)
        {
            if (!streaming)
            {
                height = video.videoHeight / (video.videoWidth/width);
                if (isNaN(height))
                    height = width / (4/3);
                video.setAttribute('width', width);
                video.setAttribute('height', height);
                canvas.setAttribute('width', width);
                canvas.setAttribute('height', height);
                streaming = true;
            }
        };
        if (video)
            video.addEventListener('canplay', resize_func, false);

        var takep_func = function(ev)
        {
            if (validate())
            {
                takepicture();
                ev.preventDefault();
            }
            else
                document.getElementById("errorTake").style.display = "block";
        };
        var upload_func = function()
        {
            if (validate())
                pics_form.submit()
            else
                document.getElementById("errorTake").style.display = "block";
            document.getElementById('no_camera').style.display = 'none';


        };
        if (startbutton)
            startbutton.addEventListener('click', takep_func , false);
        if (upload)
            upload.addEventListener('click', upload_func, false);
    }
    window.addEventListener('load', startup, false);

    function validate()
    {
        var radios = document.getElementsByName('select_super');
        for (var i = 0; i < radios.length; i++)
        {
            if (radios[i].checked)
            {
                radio_selected = radios[i].value;
                return true;
            }
        }
        return false;
    }

    function takepicture()
    {
        var context = canvas.getContext('2d');
        if (width && height)
        {
            canvas.width = width;
            canvas.height = height;
            context.drawImage(video, 0, 0, width, height);
            var data = canvas.toDataURL('image/png');
            document.getElementById('hidden').setAttribute('value', data);
            pics_form.submit();
        }
    }

    var back_to_camera = function(ev)
    {
        video.style.display = 'inline-block';
        startbutton.style.display = 'block';
        photo.style.display = 'none';
        file.style.display = 'block';
        discard.style.display = 'none';
        save.style.display = 'none';

    };
    if (discard)
        discard.addEventListener('click', back_to_camera, false);

    var save_shot = function(ev)
    {
        var save_form = document.getElementById('save_form');
        var img_tosave = document.getElementById('img_tosave');
        var photo = document.getElementById('photo').getAttribute('src');
        img_tosave.setAttribute('value', photo);
        save_form.submit();
    };
    if (save)
    {
        save.addEventListener('click', back_to_camera, false);
        save.addEventListener('click', save_shot, false);
    }

})();

function back() {
    document.getElementById('video').style.display = 'inline-block';
    document.getElementById('startbutton').style.display = 'block';
    document.getElementById('photo').style.display = 'none';
    document.getElementById('fileToUpload').style.display = 'block';
    document.getElementById("discard").style.display = 'none';
    document.getElementById("save").style.display = 'none';
}

function previewFile()
{
    var video = document.getElementById('video');
    var photo = document.getElementById('photo');
    var take = document.getElementById('startbutton');
    var up = document.getElementById('upload');
    var upload_button = document.getElementById('fileToUpload');

    video.style.display = 'none';
    take.style.display = 'none';
    upload_button.style.display = 'none';
    photo.style.display = 'block';
    up.style.display = 'block';
    var discard = document.getElementById("discard");
    discard.style.display = 'block';
    if (discard)
        discard.addEventListener('click', back, false);

    var preview = document.getElementById('photo');
    var file    = document.querySelector('input[type=file]').files[0];

    var reader  = new FileReader();

    reader.onloadend = function ()
    {
        preview.src = reader.result;
    };
    if (file)
        reader.readAsDataURL(file);
    else
    {
        preview.src = "";
        back();
    }
    document.getElementById('no_camera').style.display = 'none';
}

function check_size() {
    var a = document.getElementById("fileToUpload").files;
    var max_size = 5000000;
    if (a.length) {
        var a_type = a[0].type;
        if ((a_type !== "image/jpg" && a_type !== "image/png" && a_type !== "image/jpeg" && a_type !== "image/gif") || (a[0].size > max_size)) {
            document.getElementById('startbutton').style.display = 'none';
            document.getElementById('fileToUpload').style.display = 'none';
            document.getElementById('content').style.display = 'none';
            document.getElementById('errorUpload').style.display = 'block';
            document.getElementById('discard').style.display = 'block';
        } else
        {
            document.getElementById('no_camera').style.display = 'none';
            previewFile();
        }
    }
}
