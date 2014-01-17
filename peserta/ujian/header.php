<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="brand" href="">Selamat Mengerjakan</a>
<!--          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
          </a>-->
          <div  class="nav-collapse collapse">
              <ul class="nav">
<!--                  <li>
                      <a href="MenuUtama.php"><i class="icon-home icon-white"></i> Beranda</a>
                  </li>
                  <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                          <i class="icon-book icon-white"></i> Data Master <b class="caret"></b>
                      </a>
                      <ul class="dropdown-menu">
                          <li><a href="?master=user">Data User</a></li>
                          <li><a href="?master=peserta">Data Peserta</a></li>
                          <li><a href="?master=soal">Data Soal</a></li>
                      </ul>
                  </li>
                  <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                          <i class="icon-folder-open icon-white"></i> Setting<b class="caret"></b>
                      </a>
                      <ul class="dropdown-menu">
                          <li><a href="#" onclick="">Setting Jurusan</a></li>
                          <li><a href="#" onclick="">Setting Grade Lulus</a></li>
                          <li><a href="#" onclick="">Setting Kategori</a></li>
                      </ul>
                  </li>-->
              </ul>
              <?php
              if($current_kategori != null){
              ?>
              <div id="timework" class="brand2">00:07:30</div>
              <?php } ?>
              <div class="btn-group pull-right">
                  <button class="btn btn-primary">
                      <i class="icon-user icon-white"></i>
                      <?php echo "".$_SESSION['nama'].""; ?>
                  </button>
                  <button class="btn btn-primary dropdown-toggle" style="padding-bottom: 11px;" data-toggle="dropdown">
                      <span class="caret"></span>
                  </button>
                  <?php // if($current_kategori==null) { ?>
                  <ul class="dropdown-menu">
                      <li><a href="logout.php"><i class="icon-off"></i>Log Out</a></li>
                  </ul>
                  <?php // } ?>
              </div>
          </div><!--/.nav-collapse -->
        </div>
    </div>
</div>