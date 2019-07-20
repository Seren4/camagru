function openModal()
{
    document.getElementById('GalleryModal').style.display = "grid";
}

function closeModal(modal_id)
{

    document.getElementById(modal_id).style.display = "none";
}

/*var slideIndex = 1;

showSlides(slideIndex);*/


function currentSlide(n)
{
    showSlides(slideIndex = n);
}

function showSlides(n)
{
    var slides = document.getElementsByClassName("GalleryModalSlides");

    if (slides)
    {
        if (n > slides.length)
            slideIndex = 1;

        if (n < 1)
            slideIndex = slides.length;

        for (var i = 0; i < slides.length; i++)
            slides[i].style.display = "none";

        slides[slideIndex-1].style.display = "block";
    }

}

function DisplayCommModal(imgIndex)
{
    document.getElementById('hidden_id_img').value = imgIndex;
    document.getElementById('CommentModal').style.display = "grid";
    document.getElementById("mySlidesComm").style.display = "block";
}