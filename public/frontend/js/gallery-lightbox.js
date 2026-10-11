(function () {
    'use strict';
    var dialog = document.getElementById('gallery-lightbox');
    if (!dialog) return;
    var photos = Array.from(document.querySelectorAll('.gallery-grid-image'));
    if (!photos.length) return;
    var image = document.getElementById('glb-img');
    var counter = document.getElementById('glb-counter');
    var index = 0;
    var previousOverflow;
    dialog.setAttribute('role', 'dialog');
    dialog.setAttribute('aria-label', 'Photo viewer');
    counter.setAttribute('role', 'status');
    function showPhoto() {
        image.src = photos[index].getAttribute('data-full') || photos[index].src;
        image.alt = photos[index].alt;
        counter.textContent = (index + 1) + ' / ' + photos.length;
    }
    photos.forEach(function (photo, position) {
        photo.addEventListener('click', function () {
            index = position;
            showPhoto();
            previousOverflow = document.body.style.overflow;
            dialog.classList.add('active');
            document.body.style.overflow = 'hidden';
            VillaAccessibility.openDialog(dialog);
        });
    });
    function close() {
        dialog.classList.remove('active');
        document.body.style.overflow = previousOverflow;
        VillaAccessibility.closeDialog();
    }
    dialog.querySelector('.glb-close').addEventListener('click', close);
    dialog.querySelector('.glb-prev').addEventListener('click', function () { index = (index - 1 + photos.length) % photos.length; showPhoto(); });
    dialog.querySelector('.glb-next').addEventListener('click', function () { index = (index + 1) % photos.length; showPhoto(); });
    dialog.addEventListener('click', function (event) { if (event.target === dialog) close(); });
})();
