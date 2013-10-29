<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery("#form-tambah").validationEngine();
    });
    function tambah(){
        $("#pil_jurusan,#pil_jurusan2").empty();
        var data = {
            where:"",
            limit:""
        }
        $.ajax({
            url: BASE_URL+'/services/crudResource.php',
            data: {
                type:"jurusan",
                proses:"get",
                json:jQuery.toJSON(data)
            },
            cache: false,
            type: 'POST',
            success: function(data, status, xhr){
                var jurusans = $.parseJSON(data);
                if(jurusans!==null){
                    fillJurusanFromTambah(jurusans);
                }
            },
            error: function(xhr, status, errorMsg){
                alert(errorMsg);
            }
        });
        return false;
    }
    function fillJurusanFromTambah(jurusans){
        $("#pil_jurusan,#pil_jurusan2").append($('<option>',{
            value:"",
            text:"---Pilih Jurusan---"
        }));
        for(var i=0;i<jurusans.length;i++){
            $("#pil_jurusan,#pil_jurusan2").append($('<option>',{
                value:jurusans[i].id_jurusan,
                text:jurusans[i].nama_jurusan
            }));
        }
        $("#form-tambah").trigger('reset');
        $("#frm-tambah").removeClass("ubah");
        $("#frm-tambah").dialog({
            title: "Tambah Data Peserta",
            resizable: false,
            position: 'center',
            modal: true,
            width: 380,
            height: "auto",
            hide: 'fold',
            show: 'bounce'
        });
    }
    function ubahData(noPeserta,nama,alamat,telepon,keterangan,pilihanJurusan){
        $("#frm-tambah").addClass("ubah");
        $("#temp_no_peserta").val(noPeserta);
        $("#no_peserta").val(noPeserta);
        $("#nama").val(nama);
        $("#alamat").val(alamat);
        $("#telepon").val(telepon);
        $("#keterangan").val(keterangan);

        $("#pil_jurusan,#pil_jurusan2").empty();
        var data = {
            where:"",
            limit:""
        }
        $.ajax({
            url: BASE_URL+'/services/crudResource.php',
            data: {
                type:"jurusan",
                proses:"get",
                json:jQuery.toJSON(data)
            },
            cache: false,
            type: 'POST',
            success: function(data, status, xhr){
                var jurusans = $.parseJSON(data);
                if(jurusans!==null){
                    fillJurusanFromUbah(jurusans,pilihanJurusan);
                }
            },
            error: function(xhr, status, errorMsg){
                alert(errorMsg);
            }
        });
        
        return false;
    }
    function fillJurusanFromUbah(jurusans,pilihanJurusan){
        $("#pil_jurusan,#pil_jurusan2").append($('<option>',{
            value:"",
            text:"---Pilih Jurusan---"
        }));
        for(var i=0;i<jurusans.length;i++){
            $("#pil_jurusan,#pil_jurusan2").append($('<option>',{
                value:jurusans[i].id_jurusan,
                text:jurusans[i].nama_jurusan
            }));
        }

        var status = pilihanJurusan.split(',');
        for(var i=0;i<status.length;i++){
            var pilJurusan = status[i].split('=');
            if(i==0)
            $("#pil_jurusan option:contains('"+pilJurusan[0]+"')").prop('selected',true);
            else {
                $("#pil_jurusan2 option:contains('"+pilJurusan[0]+"')").prop('selected',true);
                break;
            }
        }

        $("#frm-tambah").dialog({
            title: "Ubah Data Peserta",
            resizable: false,
            position: 'center',
            modal: true,
            width: 380,
            height: "auto",
            hide: 'fold',
            show: 'bounce'
        });
    }
    function submitForm(){
        if(!$("#form-tambah").validationEngine('validate')){
            return false
        }
        var isUbah = false;
        if($("#frm-tambah").hasClass("ubah")){
            isUbah = true;
        }
        var pil = []
//        $("#pil_jurusan :selected").each(function(i, selected){
//            pil[i] = $(selected).val();
//        });
        if($("#pil_jurusan").val()!="") pil.push($("#pil_jurusan").val());
        if($("#pil_jurusan2").val()!="") pil.push($("#pil_jurusan2").val());
//        pil.push($("#pil_jurusan").val(), $("#pil_jurusan2").val());
        if(pil.length===0){
            showInformation("Pilih jurusan minimal 1", function(){});
            return;
        }
        if(pil.length>1){
            if(pil[0]==pil[1]){
                showInformation("Pilih jurusan 1 dan 2 tidak boleh sama", function(){});
                return;
            }
        }
        var data = {
            no_peserta_old:$("#temp_no_peserta").val(),
            no_peserta:$("#no_peserta").val(),
            nama:$("#nama").val(),
            alamat:$("#alamat").val(),
            telepon:$("#telepon").val(),
            keterangan:$("#keterangan").val(),
            pilihan_jurusan:pil
        }
        $.ajax({
            url: 'services/crudResource.php',
            data: {
                type:"peserta",
                proses:(isUbah)?"ubah":"tambah",
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
                var result = $.parseJSON(data);
                if(result==null){
                    $("#frm-tambah").dialog('close');
                    showInformation("Problem dengan server", function(){});
                }else{
                    if(result.status=='1') show_sukses();
                    else {
                        $("#frm-tambah").dialog('close');
                        showInformation(result.fullMessage, function(){});
                    }
                }
//                show_sukses();
            },
            error: function(xhr, status, errorMsg){
                alert(errorMsg);
            }
        });
        return false;
    }
    function show_sukses(){
        $("#sukses").dialog({
            title: "Sukses",
            height: 80,
            modal: true,
            show: 'fade',
            hide: 'fade',
            open: function(event, ui){
                setTimeout("$('#sukses').dialog('close')",1500);
            },
            close: function(){
                $("#frm-tambah").dialog('close');
                location.reload();
            }
        });
    }
    function deleteData(noPeserta){
        $("#konfirmasi").dialog({
            title: "Konfirmasi",
                resizable: false,
                position: 'center',
                modal: true,
                width: 360,
                height: 140,
                hide: 'fold',
                show: 'bounce',
                buttons:[
                    {
                        text:"Ok",
                        click:function(){
                            var dialog = $(this);
                            var data = {
                                no_peserta:noPeserta
                            }
                            $.ajax({
                                url: 'services/crudResource.php',
                                data: {
                                    type:"peserta",
                                    proses:"hapus",
                                    json:jQuery.toJSON(data)
                                },
                                cache: false,
                                type: 'POST',
                                success: function(data, status, xhr){
                                    var result = $.parseJSON(data);
                                    dialog.dialog('close');
                                    if(result!=null)
                                    if(result.fullMessage=="sukses"){
                                        location.reload();
                                    } else alert(data);
                                    else showInformation("Problem dengan server", function(){});
                                },
                                error: function(xhr, status, errorMsg){
                                    alert(errorMsg);
                                }
                            });
                        }
                    },
                    {
                        text:"Batal",
                        click:function(){
                            $(this).dialog("close");
                        }
                    }
                ]
        });
        return false;
    }
</script>
<div id="sukses" style="display: none;">
    <center>
        <span>Data Saved.</span>
    </center>
</div>
<div id="frm-tambah" style="display: none;">
    <center>
    <form id="form-tambah" class="form" method="post" action="" onsubmit="submitForm(); return false;">
        <input id="temp_no_peserta" name="temp_no_peserta" type="hidden" value=""/>
        <table border="0">
            <tr>
                <td>Nomor Peserta</td>
                <td align="right"><input name="no_peserta" id="no_peserta" class="validate[required]" type="text"/></td>
            </tr>
            <tr>
                <td>Nama</td>
                <td align="right"><input name="nama" id="nama" class="validate[required]" type="text"/></td>
            </tr>
            <tr>
                <td valign="top">Alamat</td>
                <td align="right">
                    <textarea name="alamat" id="alamat" cols="1" rows="3"></textarea>
                </td>
            </tr>
            <tr>
                <td>Telepon</td>
                <td align="right"><input name="telepon" id="telepon" type="text"/></td>
            </tr>
            <tr>
                <td valign="top">Keterangan</td>
                <td align="right">
                    <textarea name="keterangan" id="keterangan" cols="1" rows="3"></textarea>
                </td>
            </tr>
            <tr>
                <td>Pilihan Jurusan 1</td>
                <td align="right">
                    <!--<select name="pil_jurusan" id="pil_jurusan" multiple size="3" style="height: 60px;">-->
                    <select name="pil_jurusan" id="pil_jurusan" >
                        <option value="Admin IT">Teknik Informatika</option>
                        <option value="Operator">Teknik Sipil</option>
                        <option value="Sastra">Sastra Jepang</option>
                        <option value="Sastra Ind">Sastra Indonesia</option>
                        <option value="Hukum">Hukum</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Pilihan Jurusan 2</td>
                <td align="right">
                    <select name="pil_jurusan2" id="pil_jurusan2" >
                        <option value="Admin IT">Teknik Informatika</option>
                        <option value="Operator">Teknik Sipil</option>
                        <option value="Sastra">Sastra Jepang</option>
                        <option value="Sastra Ind">Sastra Indonesia</option>
                        <option value="Hukum">Hukum</option>
                    </select>
                </td>
            </tr>
        </table>
        <button type="submit" class="btn btn-primary">
            <i class="icon icon-plus"></i> Simpan Data
        </button>
        <button type="reset" class="btn btn-warning" onclick="$('#frm-tambah').dialog('close');">
            <i class="icon icon-refresh"></i> Batal
        </button>
    </form>
    </center>
</div>
<div class="well" style="width: 1200px; margin:10px auto;">
    <div class="navbar">
        <div class="navbar-inner">
            <div class="container">
                <a class="brand" href="#">Data Peserta</a>
                <div class="nav-collapse">
                    <ul class="nav">
                        <li>
                            <a href="form_tambah.php" class="small-box" onclick="return tambah();">
                                <i class="icon-plus-sign icon-white"></i> Tambah Data Peserta
                            </a>
                        </li>
                    </ul>
                </div>
                <form name="user_form_search" action="" method="post" class="form-search">
                    <div class="navbar-form pull-right">
                        <input type="text" class="span3" name="nama" placeholder="Masukkan Nama" value="<?php if(isset($_POST['nama'])) echo $_POST['nama'];?>"/>
                        <a href='' class="btn btn-primary" ><i class='icon-list'></i>All</a>
                    </div>
                </form>
            </div>
            <!-- END OF FORM PENCARIAN -->
        </div><!-- /navbar-inner -->
    </div><!-- /navbar -->
          <!-- Table -->
    <table class="table table-hover table-condensed">
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Peserta</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Telepon</th>
                <th>Nilai</th>
                <th>Keterangan</th>
                <th>Pilihan Jurusan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
<?php
$batas=5;
$halaman=$_GET['halaman'];
$posisi=null;
if(empty($halaman)){
$posisi=0;
$halaman=1;
}else{
$posisi=($halaman-1)* $batas;
}
//$query="SELECT *,
//(CASE
//WHEN nilai=-1 THEN 'Belum Ujian'
//ELSE nilai END) AS fill_nilai FROM
//peserta ORDER BY nama LIMIT $posisi,$batas";
$query="SELECT no_peserta,nama,alamat,telepon,nilai,keterangan,fill_nilai,
group_concat(d1.status SEPARATOR ','
) AS pilihan_jurusan from
(
SELECT d0.*,concat(nama_jurusan,'=' COLLATE utf8_unicode_ci,lulus) AS status from
(
SELECT p.*,
(CASE
WHEN nilai=-1 THEN 'Belum Ujian'
ELSE nilai END) AS fill_nilai,(
CASE WHEN nilai<g.batas_grade THEN 'Tidak Lulus'
ELSE 'Lulus' END
) as lulus,j.nama_jurusan FROM
peserta p,pilihan_jurusan pl,jurusan j,grade g WHERE
p.no_peserta=pl.no_peserta AND pl.id_jurusan=j.id_jurusan AND j.id_jurusan=g.id_jurusan ORDER BY nama
) as d0
) as d1 group by no_peserta ORDER BY nama LIMIT $posisi,$batas";
$query_page="SELECT nama FROM peserta";
if(isset($_POST['nama'])){
$nama=$_POST['nama'];
$query="SELECT no_peserta,nama,alamat,telepon,nilai,keterangan,fill_nilai,
group_concat(d1.status SEPARATOR ','
) AS pilihan_jurusan from
(
SELECT d0.*,concat(nama_jurusan,'=' COLLATE utf8_unicode_ci,lulus) AS status from
(
SELECT p.*,
(CASE
WHEN nilai=-1 THEN 'Belum Ujian'
ELSE nilai END) AS fill_nilai,(
CASE WHEN nilai<g.batas_grade THEN 'Tidak Lulus'
ELSE 'Lulus' END
) as lulus,j.nama_jurusan FROM
peserta p,pilihan_jurusan pl,jurusan j,grade g WHERE
p.no_peserta=pl.no_peserta AND pl.id_jurusan=j.id_jurusan AND j.id_jurusan=g.id_jurusan ORDER BY nama
) as d0
) as d1 WHERE nama LIKE '%$nama%' group by no_peserta";
	$query_page="SELECT nama FROM peserta WHERE nama LIKE '%$nama%'";
}
$result=mysql_query($query) or die(mysql_error());
$no=0;
//proses menampilkan data
while($rows=mysql_fetch_array($result)){
$no+=1;
?>
            <tr>
		<!--<td><?php //echo $no; ?></td>-->
                <td><?php echo ($no+$posisi); ?></td>
		<td><?php echo $rows['no_peserta']; ?></td>
                <td><?php echo $rows['nama']; ?></td>
                <td><?php echo $rows['alamat']; ?></td>
                <td><?php echo $rows['telepon']; ?></td>
                <td><?php echo $rows['fill_nilai']; ?></td>
                <td><?php echo $rows['keterangan']; ?></td>
                <td><?php echo $rows['pilihan_jurusan']; ?></td>
		<td align="center">
                    <a href="from_update.php?id_admin=<?php echo $rows['id_admin']; ?>" class="btn btn-warning"
                       onclick="return ubahData(<?php echo "'{$rows['no_peserta']}','{$rows['nama']}','{$rows['alamat']}','{$rows['telepon']}','{$rows['keterangan']}','{$rows['pilihan_jurusan']}'"; ?>);">
                        <i class="icon-pencil"></i> Update
                    </a>
                    <a href="delete.php?id_admin=<?php echo $rows['id_admin']; ?>"
                       onclick="return deleteData(<?php echo "'{$rows['no_peserta']}'"; ?>);" class="btn btn-danger">
                        <i class="icon-trash"></i> Hapus
                    </a>
                </td>
            </tr>
<?php
}
?>
        </tbody>
    </table>
<?php
$result_page = mysql_query($query_page);
$jmldata = mysql_num_rows($result_page);
$jmlhalaman = ceil($jmldata / $batas);

echo "<div class='pagination'><ul>";
for($i=1;$i<=$jmlhalaman;$i++)
    echo "<li> <a href='$_SERVER[PHP_SELF]?master=peserta&halaman=$i'>$i</a></li>";
echo "</div></ul>";
?>
<!--</ul>-->
</div>

<!-- MENAMPILKAN JUMLAH DATA -->
<div class="container">
	<div class="well">

	<?php
	echo "Jumlah Data : $jmldata";
	?>
	</div>
</div>