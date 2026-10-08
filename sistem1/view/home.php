
<style>
:root {
    --hijauMuda: #c3e6cb;
    --hijauTua: #155724;
    --grey: #eee;
    --blue: #007bff;
    --yellow: #ffc107;
    --orange: #fd7e14;
    --green: #28a745;
    --light-blue: #d0ebff;
    --light-yellow: #fff3cd;
    --light-orange: #ffe8cc;
    --light-green: #d4edda;
    --dark: #343a40;
}

.table-data {
    background-color: rgba(255, 255, 255, 0.3);
    padding: 20px;
    border-radius: 20px;
}

.order > * {
    background-color: rgba(0, 128, 0, 0.1);
    padding: 20px;
    border-radius: 10px;
}

.order .head {
    text-align: center;
}

.order .head h2 {
    margin-top: 0;
    color: var(--dark);
}

.order .head p {
    margin-bottom: 10px;
    color: var(--dark);
}

.order .head marquee {
    color: black;
}

#content main .box-info {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 20px;
    padding: 0;
    list-style: none;
}

#content main .box-info li {
    background: var(--grey);
    border-radius: 10px;
    padding: 15px;
    flex: 1 1 calc(15% - 10px);
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

#content main .box-info li .bx {
    font-size: 30px;
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
}

#content main .box-info li:nth-child(1) .bx {
    background: var(--light-blue);
    color: var(--blue);
}

#content main .box-info li:nth-child(2) .bx {
    background: var(--light-yellow);
    color: var(--yellow);
}

#content main .box-info li:nth-child(3) .bx {
    background: var(--light-orange);
    color: var(--orange);
}

#content main .box-info li:nth-child(4) .bx {
    background: var(--light-green);
    color: var(--green);
}

#content main .box-info li .inner {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

#content main .box-info li h3 {
    margin: 0;
    font-size: 20px;
    color: var(--dark);
}

#content main .box-info li p {
    margin: 5px 0 0;
    font-size: 14px;
    color: var(--dark);
}

@media (max-width: 768px) {
    #content main .box-info li {
        flex: 1 1 calc(30% - 10px);
    }
}

@media (max-width: 480px) {
    #content main .box-info li {
        flex: 1 1 calc(45% - 10px);
    }
}

#swaying-i {
    display: inline-block;
    animation: swayI 1s infinite alternate;
}

#swaying-p {
    display: inline-block;
    animation: swayP 1s infinite alternate;
}

@keyframes swayI {
    0%, 100% { transform: rotateZ(-9deg); }
    50% { transform: rotateZ(5deg); }
}

@keyframes swayP {
    0%, 100% { transform: rotateZ(5deg); }
    50% { transform: rotateZ(-9deg); }
}

#falling-m {
    display: inline-block;
    animation: swayM 1s infinite alternate;
}

@keyframes glow-i {
    0%, 100% {
        color: red;
    }
    33% {
        color: yellow;
    }
    66% {
        color: green;
    }
}

@keyframes glow-p {
    0%, 75  % {
        color: yellow;
    }
    100% {
        color: green;
    }
    50% {
        color: red;
    }
}

@keyframes glow-m {
    0%, 100% {
        color: green;
    }
    33% {
        color: red;
    }
    66% {
        color: yellow;
    }
}

#swaying-i {
    animation: swayIP 3s infinite, swayI 2s infinite, glow-i 2s infinite;
}

#swaying-p {
    animation: swayIP 3s infinite, swayP 2s infinite, glow-p 2s infinite;
}

#falling-m {
    animation: swayM 3s infinite, swayM 1s infinite, glow-m 2s infinite;
}

@keyframes swayM {
    0%, 100% { transform: translateY(0); }
    25% { transform: translateY(-5px); }
    50% { transform: translatesZ(10px); }
    75% { transform: translateY(-5px); }
}

@keyframes jumpDot {
    0%, 100% { transform: translateZ(0); }
    25% { transform: translateY(-10px); }
    50% { transform: translateZ(5px); }
    75% { transform: translateY(-5px); }
}

@keyframes jumpDot1 {
    0%, 100% { transform: translateY(0); }
    25% { transform: translateY(-25px); }
    50% { transform: translatesZ(10px); }
    75% { transform: translateY(-5px); }
}

#jumping-dots {
    display: inline-block;
    animation: jumpDot 1s infinite;
}
#jumping-dots1 {
    display: inline-block;
    animation: jumpDot 2s infinite;
}


</style>

	<main>
		<div class="head-title">
			<div class="left">
				<h1>Beranda</h1>
				<ul class="breadcrumb">
					<li>
						<a href="#">Beranda</a>
					</li>
					<li><i class='bx bx-chevron-right'></i></li>
					<li>
						<a class="active" href="#">Halaman Utama</a>
					</li>
				</ul>
			</div>
		</div>                                                                                                                                                                          
		<div class="table-data">
			<div class="order">
				<div class="head">
                    <h2><strong><b>Selamat Datang <span style="color: #4CAF50;"><?php echo $_SESSION['nama']; ?></span></b></strong></h2>
                    <p>di Pemilihan Ketua IPM <?php echo $title; ?></p>
                    <marquee>
                        <i style="color: grey;">"Mari kita bersama-sama membangun <span class="ipm" id="swaying-i">I</span><span class="ipm" id="swaying-p">P</span><span class="ipm" id="falling-m" >M</span><span id="jumping-dots"> .</span>
<span id="jumping-dots1">. </span> yang lebih baik!"</i></marquee>				</div>
			</div>
		</div>
        <?php if($_SESSION['level'] == 'user'){ ?>

			<div class="col-lg-12">
				<center>
					<?php
					 $nim = $_SESSION['nim'];
					 if (!sudahMemilih($nim)){
					     echo "<a class='btn btn-warning btn-circle' href='pages/vote.php'>Buka Kertas Suara</a>";
					 } else {
					     echo "<h3>~Terima Kasih atas partisipasi Anda~</h3>";
					 }
				    ?>
				</center>
			</div>
        <?php
		     }else{ 
		    ?>
		<ul class="box-info">
			<li>
				<i class='bx bxs-collection'></i> <span class="text"></span>
                <div class="inner">
				<h3><span class="text"><?php echo $total_dpt; ?></span></h3>
				<p><span class="text">jumlah Pemilih</span></p>
                </div>
			</li>
			<li>
				<i class='bx bxs-group'></i> <span class="text"></span>
				<div class="inner">
					<span class="text"></span>
					<h3><span class="text"><?php echo $total_kandidat; ?></span></h3>
					<p><span class="text">Kandidat</span></p>
				</div>
			</li>
			<li>
				<i class='bx bx-user-minus'></i> <span class="text"></span>
				<div class="inner">
					<span class="text"></span>
					<h3><span class="text"><?php echo $total_dpt - $total_memilih; ?></span></h3>
					<p><span class="text">Belum Memilih</span></p>
				</div>
			</li>
			<li>
				<i class='bx bx-user-check'></i> <span class="text"></span>
				<div class="inner">
					<span class="text"></span>
					<h3><span class="text"><?php echo $total_memilih; ?></span></h3>
					<p><span class="text">Sudah Memilih</span></p>
				</div>
			</li>
		</ul><?php
		    }
		    ?>
	</main>