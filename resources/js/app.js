import './bootstrap';

import.meta.glob([
    '../images/**',
    '../font/**',
    ]);


    //foto profilo
    document.getElementById('profile-photo').addEventListener('click', function() {
        var lightbox = document.getElementById('lightbox');
        var lightboxImage = document.getElementById('lightbox-image');
        lightboxImage.src = this.src;
        lightbox.style.display = 'flex';
    });

    document.getElementById('lightbox-close').addEventListener('click', function() {
        document.getElementById('lightbox').style.display = 'none';
    });

    document.getElementById('change-photo-btn').addEventListener('click', function() {
        document.getElementById('photo-form').style.display = 'block';
        this.style.display = 'none';
    });

    document.getElementById('cancel-change-btn').addEventListener('click', function() {
        document.getElementById('photo-form').style.display = 'none';
        document.getElementById('change-photo-btn').style.display = 'block';
    });
