

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
    function tampilkanKelas() {
      var tingkat = document.getElementById("tingkat").value;

      var xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
          var listKelas = JSON.parse(xhr.responseText);
          tampilkanDaftarKelas(listKelas);
        }
      };
      xhr.open("GET", "../actions/get_class.php?tingkat=" + tingkat, true);
      xhr.send();
    }

    function tampilkanDaftarKelas(listKelas) {
      var selectKelas = document.getElementById("daftarKelas");
      selectKelas.style.display = "block";
      selectKelas.innerHTML = "";

      listKelas.forEach(function(kelas) {
        var option = document.createElement("option");
        option.value = kelas.kelas;
        option.text = kelas.kelas;
        selectKelas.add(option);
      });
    }


      function validateForm() {
        var nis = document.forms["addForm"]["nis"].value;
        var nama = document.forms["addForm"]["nama"].value;
        var jenis = document.forms["addForm"]["jenis_kelamin"].value;
        var tingkat = document.forms["addForm"]["tingkat"].value;
        var kelas = document.forms["addForm"]["daftarKelas"].value;

        if (nis == "" || nama == "" || jenis == "" || tingkat == "" || kelas == "") {
            alert("Semua input harus diisi");
            return false;
        }
    }

    function validateeditForm() {
    var nim = document.forms["editForm"]["nim"].value;
    var nama = document.forms["editForm"]["nama"].value;
    var jenis = document.forms["edit"]["jenis_kelamin"].value;
    var tingkat = document.forms["editForm"]["tingkat"].value;
    var kelas = document.forms["editForm"]["daftarKelas"].value;

    if (nim === "" || nama === "" || jenis === "" || tingkat === "" || kelas === "") {
        alert("Semua input harus diisi");
        return false;
    }

    return true;
}


function Kelas(id) {
    var tingkat = document.getElementById("tingkat" + id).value;

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var listKelas = JSON.parse(xhr.responseText);
            tampilkanEditKelas(listKelas, id);
        }
    };
    xhr.open("GET", "../actions/get_class.php?tingkat=" + tingkat, true);
    xhr.send();
}

function tampilkanEditKelas(listKelas, id) {
    var selectKelas = document.getElementById("editKelas" + id);
    selectKelas.innerHTML = "";

    listKelas.forEach(function(kelas) {
        var option = document.createElement("option");
        option.value = kelas.kelas;
        option.text = kelas.kelas;
        selectKelas.add(option);
    });
}


document.addEventListener("DOMContentLoaded", function() {
    var table = document.getElementById("data-kelas");
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
