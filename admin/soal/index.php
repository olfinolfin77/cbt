<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery("#form-tambah").validationEngine();
        bkLib.onDomLoaded(function() {
            new nicEditor({uploadURI:"<?php echo BASE_URL.'/services/nicUpload.php';?>",maxHeight : 100,iconsPath: "<?php echo base_url().'bootstrap/img/nicEditorIcons.gif';?>"}).panelInstance('isi_soal');
        })
    });
    /**
    * @name htmlClean
    * @description remove whitespace from html
    */
    jQuery.fn.htmlClean = function() {
        this.contents().filter(function() {
            if (this.nodeType != 3) {
                $(this).htmlClean();
                return false;
            }
            else {
                this.textContent = $.trim(this.textContent);
                return !/\S/.test(this.nodeValue);
            }
        }).remove();
        return this;
    }
    function tambah(){
        var data = {
            where:"",
            limit:""
        }
        $.ajax({
            url: BASE_URL+'/services/crudResource.php',
            data: {
                type:"kategori",
                proses:"get",
                json:jQuery.toJSON(data)
            },
            cache: false,
            type: 'POST',
            success: function(data, status, xhr){
                var kategoris = $.parseJSON(data);
                if(kategoris==null){
                    return false;
                }
                fillKategori(kategoris);
            },
            error: function(xhr, status, errorMsg){
                alert(errorMsg);
            }
        });
        return false;
    }
    function fillKategori(kategoris){
        $("#kategori_soal").empty();
        if(kategoris!==null){
            for(var i=0;i<kategoris.length;i++){
                $("#kategori_soal").append($('<option>',{
                    value:kategoris[i].id_kategori,
                    text:kategoris[i].nama_kategori
                }));
            }
            enableAllInput();
            $("#txt-btn-add").html(' Simpan Data')
            
            $("#form-tambah").trigger('reset');
            nicEditors.findEditor('isi_soal').setContent('');
            removeInstanceEditor();
            $("#frm-tambah").removeClass("ubah");
            $("#frm-tambah").dialog({
                title: "Tambah Soal",
                resizable: false,
                position: 'center',
                modal: true,
                width: 410,
                height: 500,//height: "auto",
                hide: 'fold',
                show: 'bounce'
            });
        }
    }
    function ubahData(idSoal,kategori){
        $isiSoal = $("#isi_soal"+idSoal).html();
        $("#frm-tambah").addClass("ubah");
        $("#temp_id_soal").val(idSoal);
        $nice = nicEditors.findEditor('isi_soal');
        $nice.setContent($isiSoal);
//        $("#isi_soal").html($isiSoal);
        var dataP = {
            where:"",
            limit:""
        }
        $.ajax({
            url: BASE_URL+'/services/crudResource.php',
            data: {
                type:"kategori",
                proses:"get",
                json:jQuery.toJSON(dataP)
            },
            cache: false,
            type: 'POST',
            success: function(data, status, xhr){
                var kategoris = $.parseJSON(data);
                if(kategoris==null){
                    return false;
                }
                dataP = {
                    where:[
                        "id_soal="+idSoal
                    ],
                    limit:""
                }
                $.ajax({
                    url: BASE_URL+'/services/crudResource.php',
                    data: {
                        type:"soal",
                        proses:"get_jawaban",
                        json:jQuery.toJSON(dataP)
                    },
                    cache: false,
                    type: 'POST',
                    success: function(data, status, xhr){
                        var jawabans = $.parseJSON(data);
                        if(jawabans==null){
                            return false;
                        }
                        fillKategoriAndJawaban(kategoris,jawabans,kategori);
                    },
                    error: function(xhr, status, errorMsg){
                        alert(errorMsg);
                    }
                });
            },
            error: function(xhr, status, errorMsg){
                alert(errorMsg);
            }
        });
        return false;
    }
    function fillKategoriAndJawaban(kategoris,jawabans,kategori){
        $("#kategori_soal").empty();
        if(kategoris!==null){
            for(var i=0;i<kategoris.length;i++){
                $("#kategori_soal").append($('<option>',{
                    value:kategoris[i].id_kategori,
                    text:kategoris[i].nama_kategori,
                    selected:(kategoris[i].nama_kategori==kategori)?true:false
                }));
            }
            removeInstanceEditor();
            if(jawabans!==null){
                for(var i=0;i<jawabans.length;i++){
                    $("#temp_id_jwb"+(i+1)).val(jawabans[i].id_jawaban);
                    $("#jwb"+(i+1)).val(jawabans[i].jawaban);
                    if(jawabans[i].benar=='1'){
                        $("#chk"+(i+1)).prop('checked',true);
                    } else $("#chk"+(i+1)).prop('checked',false);
                }
                disableAllInput();
                $("#txt-btn-add").html(' Ubah Data');
//                $("#kategori_soal").val(kategori);
                $("#kategori_soal option[value='"+kategori+"']").prop('selected',true);
                $("#frm-tambah").dialog({
                    title: "Detail Soal",
                    resizable: false,
                    position: 'center',
                    modal: true,
                    width: 410,
                    height: 500,//height: "auto",
                    hide: 'fold',
                    show: 'bounce'
                });
            }
        }
    }
    function submitForm(){
        if(!$("#form-tambah").validationEngine('validate')){
            return false
        }
        var isUbah = false;
        if($("#frm-tambah").hasClass("ubah")){
            isUbah = true;
        }
        $nice = nicEditors.findEditor('isi_soal');
        if($nice.getContent().trim()==''){
            showInformation("Soal belum diisi", function(){});
            return false;
        }
        if(!jawabanSudahDiisiSemua()){
            showInformation("Jawaban ada yang belum diisi", function(){});
            return false;
        }
        if( !$("#chk1").is(':checked') && !$("#chk2").is(':checked') &&
            !$("#chk3").is(':checked') && !$("#chk4").is(':checked') ){
            showInformation("Pilih salah satu jawaban yang benar", function(){});
            return false;
        }
        var data = {
            id_soal:$("#temp_id_soal").val(),
            id_kategori:$("#kategori_soal").val(),
//            isi_soal:$("#isi_soal").val(),
            isi_soal:$nice.getContent(),
            jawaban:[
                {
                    id_jawaban:$("#temp_id_jwb1").val(),
                    jawab:($nic)?nicEditors.findEditor('jwb1').getContent():$("#jwb1").val(),
                    benar:$("#chk1").is(':checked')?1:0
                },
                {
                    id_jawaban:$("#temp_id_jwb2").val(),
                    jawab:($nic2)?nicEditors.findEditor('jwb2').getContent():$("#jwb2").val(),
                    benar:$("#chk2").is(':checked')?1:0
                },
                {
                    id_jawaban:$("#temp_id_jwb3").val(),
                    jawab:($nic3)?nicEditors.findEditor('jwb3').getContent():$("#jwb3").val(),
                    benar:$("#chk3").is(':checked')?1:0
                },
                {
                    id_jawaban:$("#temp_id_jwb4").val(),
                    jawab:($nic4)?nicEditors.findEditor('jwb4').getContent():$("#jwb4").val(),
                    benar:$("#chk4").is(':checked')?1:0
                }
            ]
        }
        $.ajax({
            url: 'services/crudResource.php',
            data: {
                type:"soal",
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
                }else
                    if(result.status=='1') show_sukses();
                    else {
                        $("#frm-tambah").dialog('close');
                        showInformation(result.fullMessage, function(){});
                    }
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
    function deleteData(idSoal){
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
                            id_soal:idSoal
                        }
                        $.ajax({
                            url: 'services/crudResource.php',
                            data: {
                                type:"soal",
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
    function disableAllInput(){
        $("#kategori_soal").attr('disabled','disabled');
//        $("#isi_soal").attr('disabled','disabled');
//        nicEditors.findEditor("isi_soal").disable();
        jQuery('.nicEdit-main').attr('contenteditable','false');
        jQuery('.nicEdit-panel').hide();
        $("#jwb1").attr('disabled','disabled');
        $("#jwb2").attr('disabled','disabled');
        $("#jwb3").attr('disabled','disabled');
        $("#jwb4").attr('disabled','disabled');
        $("#chk1").attr('disabled','disabled');
        $("#chk2").attr('disabled','disabled');
        $("#chk3").attr('disabled','disabled');
        $("#chk4").attr('disabled','disabled');
        $("#ag1").addClass('disabled');
        $("#ag2").addClass('disabled');
        $("#ag3").addClass('disabled');
        $("#ag4").addClass('disabled');
    }
    function enableAllInput(){
        $("#kategori_soal").removeAttr('disabled');
//        $("#isi_soal").removeAttr('disabled');
//        nicEditors.findEditor("isi_soal").enable();
        jQuery('.nicEdit-main').attr('contenteditable','true');
        jQuery('.nicEdit-panel').show();
        $("#jwb1").removeAttr('disabled');
        $("#jwb2").removeAttr('disabled');
        $("#jwb3").removeAttr('disabled');
        $("#jwb4").removeAttr('disabled');
        $("#chk1").removeAttr('disabled');
        $("#chk2").removeAttr('disabled');
        $("#chk3").removeAttr('disabled');
        $("#chk4").removeAttr('disabled');
        $("#ag1").removeClass('disabled');
        $("#ag2").removeClass('disabled');
        $("#ag3").removeClass('disabled');
        $("#ag4").removeClass('disabled');
    }
    function actionButtonSimpan(){
        if($("#txt-btn-add").html()==' Simpan Data'){
            $("#form-tambah").submit();
        } else {
            $("#txt-btn-add").html(' Simpan Data')
            enableAllInput();
        }
        return false;
    }
    function actionCheckBox(id){
        if(id=='chk1'){
            $("#chk2").prop('checked',false);
            $("#chk3").prop('checked',false);
            $("#chk4").prop('checked',false);
        } else if(id=='chk2'){
            $("#chk1").prop('checked',false);
            $("#chk3").prop('checked',false);
            $("#chk4").prop('checked',false);
        } else if(id=='chk3'){
            $("#chk1").prop('checked',false);
            $("#chk2").prop('checked',false);
            $("#chk4").prop('checked',false);
        } else if(id=='chk4'){
            $("#chk1").prop('checked',false);
            $("#chk2").prop('checked',false);
            $("#chk3").prop('checked',false);
        }
    }
    $nic=null,$nic2=null,$nic3=null,$nic4=null;
    function actionTambahGambar(id){
        var isUbah = false;
        if($("#frm-tambah").hasClass("ubah")){
            isUbah = true;
        }
        if(id=='ag1'){
            if($nic!=null){
//                $('#jwb1').parent().find('br').remove();
                $nic.removeInstance('jwb1'); $nic=null;
//                $('#jwb1').parent().children().not('#jwb1').remove();
                $('#jwb1').parent().htmlClean();
                return false;
            }
            $nic = new nicEditor({uploadURI:"<?php echo BASE_URL.'/services/nicUpload.php';?>",maxHeight : 100,iconsPath: "<?php echo base_url().'bootstrap/img/nicEditorIcons.gif';?>"}).panelInstance('jwb1');
            if(!isUbah)nicEditors.findEditor('jwb1').setContent('');
        } else if(id=='ag2'){
            if($nic2){
                $nic2.removeInstance('jwb2'); $nic2=null;
                $('#jwb2').parent().htmlClean();
                return false;
            }
            $nic2 = new nicEditor({uploadURI:"<?php echo BASE_URL.'/services/nicUpload.php';?>",maxHeight : 100,iconsPath: "<?php echo base_url().'bootstrap/img/nicEditorIcons.gif';?>"}).panelInstance('jwb2');
            if(!isUbah)nicEditors.findEditor('jwb2').setContent('');
        } else if(id=='ag3'){
            if($nic3){
                $nic3.removeInstance('jwb3'); $nic3=null;
                $('#jwb3').parent().htmlClean();
                return false;
            }
            $nic3 = new nicEditor({uploadURI:"<?php echo BASE_URL.'/services/nicUpload.php';?>",maxHeight : 100,iconsPath: "<?php echo base_url().'bootstrap/img/nicEditorIcons.gif';?>"}).panelInstance('jwb3');
            if(!isUbah)nicEditors.findEditor('jwb3').setContent('');
        } else if(id=='ag4'){
            if($nic4){
                $nic4.removeInstance('jwb4'); $nic4=null;
                $('#jwb4').parent().htmlClean();
                return false;
            }
            $nic4 = new nicEditor({uploadURI:"<?php echo BASE_URL.'/services/nicUpload.php';?>",maxHeight : 100,iconsPath: "<?php echo base_url().'bootstrap/img/nicEditorIcons.gif';?>"}).panelInstance('jwb4');
            if(!isUbah)nicEditors.findEditor('jwb4').setContent('');
        }
        return false;
    }
    /**
    * @description Remove nicEditor from textarea
    */
    function removeInstanceEditor(){
       if($nic){
           nicEditors.findEditor('jwb1').setContent('');
           $nic.removeInstance('jwb1'); $nic=null;
       }
       if($nic2){
           nicEditors.findEditor('jwb2').setContent('');
           $nic2.removeInstance('jwb2'); $nic2=null;
       }
       if($nic3){
           nicEditors.findEditor('jwb3').setContent('');
           $nic3.removeInstance('jwb3'); $nic3=null;
       }
       if($nic4){
           nicEditors.findEditor('jwb4').setContent('');
           $nic4.removeInstance('jwb4'); $nic4=null;
       }
    }
    /**
     * @description Cek apakah input jawaban sudah diisi semua
     */
    function jawabanSudahDiisiSemua(){
       if($nic){
           if(nicEditors.findEditor('jwb1').getContent().trim()=='') return false;
       }
       if($nic2){
           if(nicEditors.findEditor('jwb2').getContent().trim()=='') return false;
       }
       if($nic3){
           if(nicEditors.findEditor('jwb3').getContent().trim()=='') return false;
       }
       if($nic4){
           if(nicEditors.findEditor('jwb4').getContent().trim()=='') return false;
       }
       return true;
    }
</script>
<div id="sukses" style="display: none;">
    <center>
        <span>Data Saved.</span>
    </center>
</div>
<div id="frm-tambah" style="display: none;">
    <center>
    <form id="form-tambah" class="form" method="post" action="" onsubmit="return submitForm();">
        <input id="temp_id_soal" name="temp_id_soal" type="hidden" value=""/>
        <input id="temp_id_jwb1" name="temp_id_soal" type="hidden" value=""/>
        <input id="temp_id_jwb2" name="temp_id_soal" type="hidden" value=""/>
        <input id="temp_id_jwb3" name="temp_id_soal" type="hidden" value=""/>
        <input id="temp_id_jwb4" name="temp_id_soal" type="hidden" value=""/>
        <table border="0" >
            <tr>
                <td>Kategori</td>
                <td align="right">
                    <select style="width: 300px;" name="kategori_soal" id="kategori_soal">
                        <option value="test">Test</option>
                    </select>
<!--                    <input name="username" id="username" class="validate[required]" type="text"/>-->
                </td>
            </tr>
<!--            <tr>
                <td>Nama</td>
                <td align="right"><input name="nama" id="nama" class="validate[required]" type="text"/></td>
            </tr>-->
            <tr>
                <td valign="top">Isi Soal</td>
                <td align="right">
                    <div align="left" style="padding-left: 20px;">
                        <textarea style="text-align: left;margin: 20px;height: 90px; width: 298px;" name="isi_soal" id="isi_soal" class="validate[required]"></textarea>
                    </div>
                </td>
            </tr>
            <tr>
                <td valign="top">Jawaban</td>
                <td align="left" style="padding-left: 10px;">
                    <table border="0" class="my_table">
                        <tr>
                            <td><b>a.</b></td>
                            <td><textarea style="width: 255px; height: 18px;" name="jwb1" id="jwb1" class="validate[required]" type="text"></textarea></td>
                            <td><a id="ag1" tabindex="-1" href="" title="Tambah Gambar" class="icon icon-plus" onclick="return actionTambahGambar(this.id)"></a></td>
                            <td><input id="chk1" type="checkbox" onclick="return actionCheckBox(this.id);"/></td>
                        </tr>
                        <tr>
                            <td><b>b.</b></td>
                            <td><textarea style="width: 255px; height: 18px;" name="jwb2" id="jwb2" class="validate[required]" type="text"></textarea></td>
                            <td><a id="ag2" tabindex="-1" href="" title="Tambah Gambar" class="icon icon-plus" onclick="return actionTambahGambar(this.id)"></a></td>
                            <td><input id="chk2" type="checkbox" onclick="return actionCheckBox(this.id);"/></td>
                        </tr>
                        <tr>
                            <td><b>c.</b></td>
                            <td><textarea style="width: 255px; height: 18px;" name="jwb3" id="jwb3" class="validate[required]" type="text"></textarea></td>
                            <td><a id="ag3" tabindex="-1" href="" title="Tambah Gambar" class="icon icon-plus" onclick="return actionTambahGambar(this.id)"></a></td>
                            <td><input id="chk3" type="checkbox" onclick="return actionCheckBox(this.id);"/></td>
                        </tr>
                        <tr>
                            <td><b>d.</b></td>
                            <td><textarea style="width: 255px; height: 18px;" name="jwb4" id="jwb4" class="validate[required]" type="text"></textarea></td>
                            <td><a id="ag4" tabindex="-1" href="" title="Tambah Gambar" class="icon icon-plus" onclick="return actionTambahGambar(this.id)"></a></td>
                            <td><input id="chk4" type="checkbox" onclick="return actionCheckBox(this.id);"/></td>
                        </tr>
                    </table><br/>
                </td>
            </tr>
        </table>
        <button type="submit" class="btn btn-primary" onclick="return actionButtonSimpan();">
            <i class="icon icon-plus"></i><span id="txt-btn-add"> Simpan Data</span>
        </button>
        <button type="reset" class="btn btn-warning" onclick="$('#frm-tambah').dialog('close');">
            <i class="icon icon-refresh"></i><span id="txt-btn-cancel"> Batal</span>
        </button>
    </form>
    </center>
</div>
<div class="well" style="width: 1200px; margin:10px auto;">
    <div class="navbar">
        <div class="navbar-inner">
            <div class="container">
                <a class="brand" href="#">Data Soal</a>
                <div class="nav-collapse">
                    <ul class="nav">
                        <li>
                            <a href="form_tambah.php" class="small-box" onclick="tambah(); return false;">
                                <i class="icon-plus-sign icon-white"></i> Tambah Soal
                            </a>
                        </li>
                    </ul>
                </div>
                <form name="user_form_search" action="" method="post" class="form-search">
                    <div class="navbar-form pull-right">
                        <input type="text" class="span3" name="username" placeholder="Masukkan Isi Soal Yang Dicari"/>
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
                <th>ID Soal</th>
                <th>Kategori</th>
                <th>Isi Soal</th>
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
$query="select soal.*,kategori.nama_kategori from soal, kategori
where soal.id_kategori=kategori.id_kategori ORDER BY id_soal LIMIT $batas OFFSET $posisi";
$query_page="SELECT isi_soal FROM soal";
if(isset($_POST['isi_soal'])){
$isi_soal=$_POST['isi_soal'];
$query="select soal.*,kategori.nama_kategori
from soal, kategori where soal.id_kategori=kategori.id_kategori
AND isi_soal LIKE '%$isi_soal%'";
	$query_page="SELECT isi_soal FROM soal WHERE isi_soal LIKE '%$isi_soal%'";
}
//$result=mysql_query($query) or die(mysql_error());
$result=pg_query($query);
$no=0;
//proses menampilkan data
//while($rows=mysql_fetch_array($result)){
while($rows=pg_fetch_array($result)){
$no+=1;
?>
            <tr>
		<!--<td><?php //echo $no; ?></td>-->
                <td><?php echo ($no+$posisi); ?></td>
		<td><?php echo $rows['id_soal']; ?></td>
                <td><?php echo $rows['nama_kategori']; ?></td>
                <td id="<?php echo 'isi_soal'.$rows['id_soal'];?>"><?php echo $rows['isi_soal']; ?></td>
		<td align="center">
                    <a href="from_update.php?id_admin=<?php echo $rows['id_admin']; ?>" class="btn btn-warning"
                       onclick="return ubahData(<?php echo "'{$rows['id_soal']}','{$rows['nama_kategori']}'"; ?>);">
                        <i class="icon-pencil"></i> Detail
                    </a>
                    <a href="delete.php?id_admin=<?php echo $rows['id_admin']; ?>"
                       onclick="return deleteData(<?php echo $rows['id_soal']; ?>);" class="btn btn-danger">
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
//$result_page = mysql_query($query_page);
$result_page = pg_query($query_page);
//$jmldata = mysql_num_rows($result_page);
$jmldata = pg_num_rows($result_page);
$jmlhalaman = ceil($jmldata / $batas);

echo "<div class='pagination'><ul>";
for($i=1;$i<=$jmlhalaman;$i++)
    echo "<li> <a href='$_SERVER[PHP_SELF]?master=soal&halaman=$i'>$i</a></li>";
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