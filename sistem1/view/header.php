<?php
if (!function_exists("menuAktif")) {
    function menuAktif($href) {
        $bagian = parse_url($href);
        if (basename($bagian["path"] ?? "") !== basename($_SERVER["SCRIPT_NAME"])) return "";
        parse_str($bagian["query"] ?? "", $q);
        if (isset($q["page"])) return (($_GET["page"] ?? "home") === $q["page"]) ? "active" : "";
        return "active";
    }
}
?>
<section id="sidebar" class="sidebar">
    <a href="#" class="brand">
        <i class='bx bxl-tailwind-css' style="color: #28a745;"></i>
        <span class="text" style="color: #28a745;">Suara
        <span class="highlight" style="font-weight: bold; color: yellow; text-shadow: 2px 4px 6px rgba(0, 128, 0, 0.75)">I</span>
        <span class="highlight" style="font-weight: bold; color: yellow; transform: rotate(10deg); text-shadow: 2px 2px 4px rgba(255, 0, 0, 0.75);display: inline-block; margin-right: 0px;">P</span>
        <span class="highlight" style="font-weight: bold; color: #28a745; text-shadow: 2px 2px 2px rgba(0,0,0,0.5); transform: rotate(-25deg);display: inline-block;  margin-left: -4px;">M</span>
    </span>
    </a>
    <ul class="side-menu top">
        <li class="<?php echo menuAktif('index.php?page=home'); ?>">
            <a href="<?php echo urlSistem('index.php?page=home'); ?>">
              <i class='bx bxs-dashboard'></i>
              <span class="text">Beranda</span>
            </a>
        </li>
        <?php if($_SESSION['level'] == 'admin'){ ?>
        <li class="<?php echo menuAktif('index.php?page=kelas'); ?>">
            <a href="<?php echo urlSistem('index.php?page=kelas'); ?>">
              <i class='bx bx-folder-open'   ></i>
              <span class="text">Data Kelas</span>
            </a>
        </li>
        <li class="<?php echo menuAktif('upload_dpt.php'); ?>">
            <a href="<?php echo urlSistem('pages/upload_dpt.php'); ?>">
            <i class='bx bxs-collection'></i>
                <span class="text">Data Pemilih</span>
            </a>
        </li>
        <li class="<?php echo menuAktif('input_data_paslon.php'); ?>">
            <a href="<?php echo urlSistem('pages/input_data_paslon.php'); ?>">
                <i class='bx bxs-group'></i>
                <span class="text">Kandidat</span>
            </a>
        </li>
        <li class="<?php echo menuAktif('dpt.php'); ?>">
            <a href="<?php echo urlSistem('pages/dpt.php'); ?>">
            <i class='bx bx-columns'></i>
                <span class="text">Data Suara</span>
            </a>
        </li>
        <li class="<?php echo menuAktif('hasil_suara.php'); ?>">
            <a href="<?php echo urlSistem('pages/hasil_suara.php'); ?>">
                <i class='bx bxs-doughnut-chart'></i>
                <span class="text">Hasil Suara</span>
            </a>
        </li>
        <li class="<?php echo menuAktif('index.php?page=pengaturan'); ?>">
            <a href="<?php echo urlSistem('index.php?page=pengaturan'); ?>">
                <i class='bx bxs-cog'></i>
                <span class="text">pengaturan</span>
            </a>
        </li>
        <?php } ?>
         <?php if($_SESSION['level'] == 'user'){ ?>
        <li class="<?php echo menuAktif('visi_misi.php'); ?>">
            <a href="<?php echo urlSistem('pages/visi_misi.php'); ?>">
                <i class='bx bxs-user'></i>
                <span class="text">Visi Misi</span>
            </a>
        </li>
        <?php } ?>
    </ul>
    <ul class="side-menu">
        <li>
            <a href="<?php echo urlProyek('logout.php'); ?>" class="logout">
                <i class='bx bxs-log-out-circle'></i>
                <span class="text">Keluar</span>
            </a>
        </li>
    </ul>
</section>


<style>
:root {
  --poppins: "Poppins", sans-serif;
  --lato: "Lato", sans-serif;

  --light: #f9f9f9;
  --green: #28a745;
  --light-green: #c3e6cb;
  --grey: #eee;
  --dark-grey: #aaaaaa;
  --dark: #342e37;
  --red: #db504a;
  --yellow: #ffce26;
  --light-yellow: #fff2c6;
  --orange: #fd7238;
  --light-orange: #ffe0d3;
}

#sidebar .brand .bx {
  min-width: 60px;
  display: flex;
  justify-content: center;
}
.brand .text {
  font-size: 40px;
  font-weight: bold;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
}


#sidebar .side-menu {
  width: 100%;
  margin-top: 48px;
}
#sidebar .side-menu li {
  height: 48px;
  background: transparent;
  margin-left: 6px;
  border-radius: 48px 0 0 48px;
  padding: 4px;
}
#sidebar .side-menu li.active {
  background: var(--grey);
  position: relative;
}
#sidebar .side-menu li.active::before {
  content: "";
  position: absolute;
  width: 40px;
  height: 40px;
  border-radius: 50%;
  top: -40px;
  right: 0;
  box-shadow: 20px 20px 0 var(--grey);
  z-index: -1;
}
#sidebar .side-menu li.active::after {
  content: "";
  position: absolute;
  width: 40px;
  height: 40px;
  border-radius: 50%;
  bottom: -40px;
  right: 0;
  box-shadow: 20px -20px 0 var(--grey);
  z-index: -1;
}
#sidebar .side-menu li a {
    width: 100%;
    height: 100%;
    background: var(--light);
    display: flex;
    align-items: center;
    border-radius: 48px;
    font-size: 16px;
    color: var(--dark);
    white-space: nowrap;
    overflow-x: hidden;
}
#sidebar .side-menu.top li.active a {
  color: var(--green);
}
#sidebar.hide .side-menu li a {
  width: calc(48px - (4px * 2));
  transition: width 0.3s ease;
}
#sidebar .side-menu li a.logout {
  color: var(--red);
}
#sidebar .side-menu.top li a:hover {
  color: var(--green);
}
#sidebar .side-menu li a .bx {
  min-width: calc(60px - ((4px + 6px) * 2));
  display: flex;
  justify-content: center;
}

.highlight {
    font-weight: bold;
    text-shadow: 2px 2px 2px rgba(0, 0, 0, 0.5);
}

.highlight:nth-child(1) {
    color: yellow;
    text-shadow: 2px 4px 6px rgba(0, 128, 0, 0.75);
}

.highlight:nth-child(2) {
    color: yellow;
    transform: rotate(10deg);
    text-shadow: 2px 2px 4px rgba(255, 0, 0, 0.75);
    display: inline-block;
    margin-right: 4px;
    margin-top: -2px;
}

.highlight:nth-child(3) {
    color: #28a745;
    text-shadow: 2px 2px 2px rgba(0, 0, 0, 0.5);
    transform: rotate(-25deg);
    display: inline-block;
    margin-right: -4px;
    margin-bottom: -2px;
}
@media (max-width: 768px) {
    .brand .text {
        font-size: 40px;
    }
    
    .brand  .text span: first-child{
      display: none;
    }

    .brand .text span:nth-child(1),
    .brand .text span:nth-child(2),
    .brand .text span:nth-child(3) {
        margin: 0;
        display: block;
    }

    .highlight:nth-child(1),
    .highlight:nth-child(2),
    .highlight:nth-child(3) {
        margin: 0;
    }
}

@media (max-width: 480px) {
    .highlight {
        margin: 0 4px;
    }
}

</style>

