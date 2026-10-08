
 document.getElementById('profile-pic').addEventListener('click', function() {
            var popup = document.getElementById('profile-popup');
            popup.classList.toggle('active');
            this.classList.toggle('active');
        });

        window.addEventListener('click', function(event) {
            var popup = document.getElementById('profile-popup');
            var profilePic = document.getElementById('profile-pic');
            if (!popup.contains(event.target) && event.target !== profilePic) {
                popup.classList.remove('active');
                profilePic.classList.remove('active');
            }
    
        });
    function hanyaAngka(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            evt.preventDefault();
        }
    }

    function formatNomorUrut(input) {
        var value = input.value.replace(/\D/g, '');

        if (value.length >= 2 && value.length <= 4) {
            input.value = value;
            document.getElementById('error-message').textContent = '';
        } else if (value.length > 4) {
            input.value = value.slice(0, 4);
            document.getElementById('error-message').textContent = '';
        } else {
            if (value.length === 0) {
                document.getElementById('error-message').textContent = 'Nomor urut tidak boleh kosong.';
            } else {
                document.getElementById('error-message').textContent = 'Nomor urut harus memiliki panjang minimal 2 digit.';
            }
            input.value = value;
        }
    }

       
document.addEventListener("DOMContentLoaded", function() {
    var table = document.getElementById("tabel");
    var tbody = table.getElementsByTagName("tbody")[0];
    var rowCount = tbody.rows.length;

    var slideLimit = 4;
    var currentSlide = 1;
    var totalSlides = Math.ceil(rowCount / slideLimit);

    var prevButton = document.getElementById("prevButton");
    var nextButton = document.getElementById("nextButton");
    var pageNumber = document.getElementById("pageNumber");
    var navigationContainer = document.querySelector('.navigation-container');

    function updateButtonState() {
        pageNumber.textContent = currentSlide;

        if (currentSlide === totalSlides || rowCount <= slideLimit) {
            nextButton.classList.remove('button-active');
            nextButton.classList.add('button-disabled');
            nextButton.disabled = true;
        } else {
            nextButton.classList.remove('button-disabled');
            nextButton.classList.add('button-active');
            nextButton.disabled = false;
        }

        if (currentSlide === 1 || rowCount <= slideLimit) {
            prevButton.classList.remove('button-active');
            prevButton.classList.add('button-disabled');
            prevButton.disabled = true;
        } else {
            prevButton.classList.remove('button-disabled');
            prevButton.classList.add('button-active');
            prevButton.disabled = false;
        }
    }

    function showCurrentSlide() {
        var startRowIndex = (currentSlide - 1) * slideLimit;
        var endRowIndex = Math.min(startRowIndex + slideLimit, rowCount);

        for (var i = 0; i < rowCount; i++) {
            tbody.rows[i].style.display = "none";
        }

        for (var i = startRowIndex; i < endRowIndex; i++) {
            tbody.rows[i].style.display = "";
        }

        updateButtonState();
    }

    if (rowCount <= slideLimit) {
        navigationContainer.style.display = 'none';
    } else {
        navigationContainer.style.display = 'flex';
    }

    prevButton.addEventListener("click", function() {
        if (currentSlide > 1) {
            currentSlide--;
            showCurrentSlide();
        }
    });

    nextButton.addEventListener("click", function() {
        if (currentSlide < totalSlides) {
            currentSlide++;
            showCurrentSlide();
        }
    });

    showCurrentSlide();
});

