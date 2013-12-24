<!--<div class="modal"> Place at bottom of page </div>-->
<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
          </a>
          <div  class="nav-collapse collapse">
              <ul class="nav">
                  <li>
                      <a href="MenuUtama.php"><i class="icon-home icon-white"></i> Beranda</a>
                  </li>
                  <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                          <i class="icon-book icon-white"></i> Data Master <b class="caret"></b>
                      </a>
                      <ul class="dropdown-menu">
                          <?php if($_SESSION['role']=="Admin IT"){?>
                          <li><a href="?master=user">Data User</a></li>
                          <?php } ?>
                          <li><a href="?master=peserta">Data Peserta</a></li>
                          <li><a href="?master=soal">Data Soal</a></li>
                      </ul>
                  </li>
                  <?php if($_SESSION['role']=="Admin IT"){?>
                  <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                          <i class="icon-folder-open icon-white"></i> Setting<b class="caret"></b>
                      </a>
                      <ul class="dropdown-menu">
                          <li><a href="#" onclick="return showJurusan('<?php echo getUrlForAjax();?>');">Setting Jurusan</a></li>
                          <!--<li><a href="#" onclick="return showGrade();">Setting Grade Lulus</a></li>-->
                          <li><a href="#" onclick="return showKategori();">Setting Kategori</a></li>
<!--                          <li><a href="soal/index.php?halaman=1">Setting Soal Text</a></li>
                          <li><a href="soalgambar/index.php?halaman=1">Setting Soal Gambar</a></li>
                          <li><a href="ujian/index.php?halaman=1">Setting Ujian</a></li>-->
                      </ul>
                  </li>
                  <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                          <i class="icon-folder-open icon-white"></i> Laporan<b class="caret"></b>
                      </a>
                      <ul class="dropdown-menu">
                          <li><a href="?master=laporan" >Siswa Diterima</a></li>
                      </ul>
                  </li>
                  <?php } ?>
              </ul>
              <div class="btn-group pull-right">
                  <button class="btn btn-primary">
                      <i class="icon-user icon-white"></i>
                      <?php echo "".$_SESSION['username'].""; ?>
                  </button>
                  <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                      <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu">
                      <li><a href="logout.php"><i class="icon-off"></i> Log Out</a></li>
                      <li>
                          <a href="<?php echo getUrlForAjax();?>" onclick="return changePassword();">
                              <i class="icon-pencil"></i> Change Password
                          </a>
                      </li>
                  </ul>
              </div>
          </div><!--/.nav-collapse -->
        </div>
    </div>
</div>
<script type="text/javascript">
    var BASE_URL = '<?php echo getUrlForAjax();?>';
    jQuery(document).ready(function () {
        jQuery("#form-change-password").validationEngine();
        jQuery("#form-input-grade").validationEngine();
        jQuery("#form-input-kategori").validationEngine();
    });
//    $("body").on({
//        ajaxStart: function() { 
//            $(this).addClass("loading"); 
//        },
//        ajaxStop: function() { 
//            $(this).removeClass("loading"); 
//        }    
//    });
    function showInformation(info, onClose){
        $("#isi_info").html(info);
        $("#information").dialog({
            title: "Information",
            height: 80,
            modal: true,
            show: 'fade',
            hide: 'fade',
            open: function(event, ui){
                setTimeout("$('#information').dialog('close')",1500);
            },
            close: onClose
        });
    }
    function changePassword(){
        $("#form-change-password").trigger('reset');
        $("#frm-change-password").dialog({
                title: "Ubah Password",
                resizable: false,
                position: 'center',
                modal: true,
                width: 440,
                height: "auto",
                hide: 'fold',
                show: 'bounce'
        });
        return false;
    }
    function submitUbahPassword(url){
        if(!$("#form-change-password").validationEngine('validate')){
            return false;
        }
        if($("#password_baru").val() != $("#konfirmasi_password").val()){
            showInformation("Konfirmasi password tidak cocok", function(){});
            return false;
        }
        var data = {
            id_admin:$("#temp_id").val(),
            password_lama:$("#password_lama").val(),
            password_baru:$("#password_baru").val(),
            konfirmasi_password:$("#konfirmasi_password").val()
        }
        $.ajax({
            url: url+'/services/crudResource.php',
            data: {
                type:"user",
                proses:"change_password",
                json:jQuery.toJSON(data)
            },
            cache: false,
            type: 'POST',
            statusCode: {
                404: function() {
                    alert("page not found");
                }
            },
            success: function(data, status, xhr){
                var json = $.parseJSON(data);
                if(json.status!=="1"){
                    showInformation(json.fullMessage, function(){});
                    return;
                }
                showInformation("Password Saved.", function(){
                    $("#frm-change-password").dialog('close');
                });
            },
            error: function(xhr, status, errorMsg){
                alert(errorMsg);
            }
        });
        return false;
    }
</script>
<div id="konfirmasi" style="display: none;">
    <center>
        <span>Apakah anda yakin akan menghapus data ini?</span>
    </center>
</div>
<div id="information" style="display: none;">
    <center>
        <span id="isi_info">Data Saved.</span>
    </center>
</div>
<div id="frm-change-password" style="display: none;">
    <center>
        <form id="form-change-password" class="form" method="post" action="" onsubmit="return submitUbahPassword('<?php echo getUrlForAjax();?>');">
        <input id="temp_id" name="temp_id" type="hidden" value="<?php echo $_SESSION['id_admin'];?>"/>
        <table border="0">
            <tr>
                <td>Password lama</td>
                <td align="right"><input name="password_lama" id="password_lama" class="validate[required]" type="password"/></td>
            </tr>
            <tr>
                <td>Password baru</td>
                <td align="right"><input name="password_baru" id="password_baru" class="validate[required]" type="password"/></td>
            </tr>
            <tr>
                <td>Konfirmasi password baru</td>
                <td align="right"><input name="konfirmasi_password" id="konfirmasi_password" class="validate[required]" type="password"/></td>
            </tr>
        </table>
        <button type="submit" class="btn btn-primary">
            <i class="icon icon-plus"></i> Simpan Password
        </button>
        <button type="reset" class="btn btn-warning" onclick="$('#frm-change-password').dialog('close');">
            <i class="icon icon-refresh"></i> Batal
        </button>
    </form>
    </center>
</div>
<?php include 'inc/tampilan/setting_jurusan.php';?>
<?php //include 'inc/tampilan/setting_grade.php';?>
<?php include 'inc/tampilan/setting_kategori.php';?>