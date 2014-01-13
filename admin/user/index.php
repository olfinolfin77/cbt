<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery("#form-tambah").validationEngine();
    });
    function tambah(){
        try{
            $("#form-tambah").trigger('reset');
            $("#frm-tambah").removeClass("ubah");
            $("#frm-tambah").dialog({
                title: "Tambah Data User",
                resizable: false,
                position: 'center',
                modal: true,
                width: 340,
                height: "auto",
//                hide: {effect: 'fade', duration: 350,
                hide: 'fold',
//                show: 'fade',
                show: 'bounce'//,
//                buttons:[
//                    {
//                        text:"Simpan",
//                        click:function(){
//                            $(this).dialog("close");
//                        }
//                    },
//                    {
//                        text:"Batal",
//                        click:function(){
//                            $(this).dialog("close");
//                        }
//                    }
//                ]
            });
        }catch(e){
            alert(e);
        }
        return false;
    }
    function ubahData(idAdmin,username,nama,telepon,alamat,role){
        $("#frm-tambah").addClass("ubah");
        $("#temp_id_admin").val(idAdmin);
        $("#username").val(username);
        $("#nama").val(nama);
        $("#telepon").val(telepon);
        $("#alamat").val(alamat);
        $("#role").val(role);
        $("#frm-tambah").dialog({
            title: "Ubah Data User",
            resizable: false,
            position: 'center',
            modal: true,
            width: 340,
            height: "auto",
            hide: 'fold',
            show: 'bounce'
        });
        return false;
    }
    function submitForm(){
        if(!$("#form-tambah").validationEngine('validate')){
            return false
        }
        var isUbah = false;
        if($("#frm-tambah").hasClass("ubah")){
            isUbah = true;
        }
        var data = {
            id_admin:$("#temp_id_admin").val(),
            username:$("#username").val(),
            nama:$("#nama").val(),
            telepon:$("#telepon").val(),
            alamat:$("#alamat").val(),
            role:$("#role").val()
        }
        $.ajax({
            url: 'services/crudResource.php',
            data: {
                type:"user",
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
                show_sukses();
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
//                $("#frm-tambah").dialog('close');
            },
            close: function(){
                $("#frm-tambah").dialog('close');
                location.reload();
            }
        });
    }
    function refreshTable(){
        var data = {
//            where:[
//                "username='admin'"
//            ],
            where:"",
            limit:{
                posisi:"0",
                batas:"5"
            }
        }
        $.ajax({
            url: 'services/crudResource.php',
            data: {
                type:"user",
                proses:"get",
                json:jQuery.toJSON(data)
            },
            cache: false,
            type: 'POST',
            success: function(data, status, xhr){
                alert(data);
            },
            error: function(xhr, status, errorMsg){
                alert(errorMsg);
            }
        });
    }
    function deleteData(idAdmin){
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
                                id_admin:idAdmin
                            }
                            $.ajax({
                                url: 'services/crudResource.php',
                                data: {
                                    type:"user",
                                    proses:"hapus",
                                    json:jQuery.toJSON(data)
                                },
                                cache: false,
                                type: 'POST',
                                success: function(data, status, xhr){
                                    var result = $.parseJSON(data);
                                    if(result.fullMessage=="sukses"){
                                        dialog.dialog('close');
                                        location.reload();
                                    } else alert(data);
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
        <input id="temp_id_admin" name="temp_id_admin" type="hidden" value=""/>
        <table border="0">
            <tr>
                <td>Username</td>
                <td align="right"><input name="username" id="username" class="validate[required]" type="text"/></td>
            </tr>
            <tr>
                <td>Nama</td>
                <td align="right"><input name="nama" id="nama" class="validate[required]" type="text"/></td>
            </tr>
            <tr>
                <td>Telepon</td>
                <td align="right"><input name="telepon" id="telepon" type="text"/></td>
            </tr>
            <tr>
                <td valign="top">Alamat</td>
                <td align="right">
                    <textarea name="alamat" id="alamat" cols="1" rows="3"></textarea>
                </td>
            </tr>
            <tr>
                <td>Role</td>
                <td align="right">
                    <select name="role" id="role">
                        <option value="Admin IT">Admin IT</option>
                        <option value="Operator">Operator</option>
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
                <a class="brand" href="#">Data User</a>
                <div class="nav-collapse">
                    <ul class="nav">
                        <li>
                            <a href="form_tambah.php" class="small-box" onclick="tambah(); return false;">
                                <i class="icon-plus-sign icon-white"></i> Tambah Data User
                            </a>
                        </li>
                    </ul>
                </div>
                <form name="user_form_search" action="" method="post" class="form-search">
                    <div class="navbar-form pull-right">
                        <input type="text" class="span3" name="username" placeholder="Masukkan Username"/>
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
                <th>User Name</th>
                <th>Nama</th>
                <th>Telepon</th>
                <th>Alamat</th>
                <th>Role</th>
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
//$query="SELECT id_admin,username,nama,telepon,alamat,role FROM admin ORDER BY username LIMIT $posisi,$batas";
$query="SELECT id_admin,username,nama,telepon,alamat,role FROM admin ORDER BY username LIMIT $batas OFFSET $posisi";
$query_page="SELECT username FROM admin";
if(isset($_POST['username'])){
$username=$_POST['username'];
$query="SELECT id_admin,username,nama,telepon,alamat,role FROM admin WHERE username LIKE '%$username%'";
	$query_page="SELECT username FROM admin WHERE username LIKE '%$username%'";
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
		<td><?php echo $rows['username']; ?></td>
                <td><?php echo $rows['nama']; ?></td>
                <td><?php echo $rows['telepon']; ?></td>
                <td><?php echo $rows['alamat']; ?></td>
                <td><?php echo $rows['role']; ?></td>
		<td align="center">
                    <a href="from_update.php?id_admin=<?php echo $rows['id_admin']; ?>" class="btn btn-warning"
                       onclick="return ubahData(<?php echo "'{$rows['id_admin']}','{$rows['username']}','{$rows['nama']}','{$rows['telepon']}','{$rows['alamat']}','{$rows['role']}'"; ?>);">
                        <i class="icon-pencil"></i> Update
                    </a>
                    <a href="delete.php?id_admin=<?php echo $rows['id_admin']; ?>"
                       onclick="return deleteData(<?php echo $rows['id_admin']; ?>);" class="btn btn-danger">
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
    echo "<li> <a href='$_SERVER[PHP_SELF]?master=user&halaman=$i'>$i</a></li>";
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
<!-- END OF MENAMPILKAN JUMLAH DATA -->
