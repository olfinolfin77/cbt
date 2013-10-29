<script type="text/javascript">
    function showKategori(){
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
                fillDataKategori(kategoris);
//                alert(data);
            },
            error: function(xhr, status, errorMsg){
                alert(errorMsg);
            }
        });
        return false;
    }
    function fillDataKategori(kategoris){
        var isi_kategori = $("#isi_kategori");
        isi_kategori.html("");
        if(kategoris!==null){
            for(var i=0;i<kategoris.length;i++){
                var tr = document.createElement("tr");
                tr.setAttribute("id", "rowKat"+kategoris[i].id_kategori);
                var td = "<td>"+kategoris[i].id_kategori+"</td>"+
                "<td id='nama_kat"+kategoris[i].id_kategori+"'>"+kategoris[i].nama_kategori+"</td>"+
                "<td id='waktu_kat"+kategoris[i].id_kategori+"'>"+kategoris[i].waktu+"</td>"+
                "<td id='jum_kat"+kategoris[i].id_kategori+"'>"+kategoris[i].jumlah_soal+"</td>"+
                "<td align='center'>"+
                    "<a href='' class='btn btn-warning'"+
                       " onclick='return showInputKategori("+kategoris[i].id_kategori+");'>"+
                        "<i class='icon-pencil'></i>Ubah"+
                    "</a>"+
                    "<a href='' class='btn btn-danger'"+
                       " onclick='return deleteKategori("+kategoris[i].id_kategori+");'>"+
                        "<i class='icon-trash'></i>Hapus"+
                    "</a>"+
                "</td>";
                tr.innerHTML=td;
                $(tr).appendTo(isi_kategori);
            }
        }
        $("#frm-show-kategori").dialog({
            title: "Setting Kategori",
            resizable: false,
            position: 'center',
            modal: true,
            width: 740,
            height: "auto",
            hide: 'fold',
            show: 'bounce'
        });
    }
    function showInputKategori(){
        var isUbah = false;
        if(arguments.length>0){
            isUbah = true;
            var id_kategori = arguments[0];
            var nama_kategori = $("#nama_kat"+id_kategori).html();
            var waktu = $("#waktu_kat"+id_kategori).html();
            var jumlah_soal = $("#jum_kat"+id_kategori).html();
        }
        if(isUbah){
            $("#frm-input-kategori").addClass("ubah");
            $("#temp_id_kategori_kat").val(id_kategori);
            $("#nama_kategori_kat").val(nama_kategori);
            $("#waktu_kat").val(waktu);
            $("#jumlah_soal_kat").val(jumlah_soal);
        } else {
            $("#form-input-kategori").trigger("reset");
            $("#frm-input-kategori").removeClass("ubah");
        }
        $("#frm-input-kategori").dialog({
            title: (isUbah)?"Ubah Kategori":"Tambah Kategori",
            resizable: false,
            position: 'center',
            modal: true,
            width: 400,
            height: "auto",
            hide: 'fold',
            show: 'bounce'
        });
        return false;
    }
    function submitInputKategori(){
        if(!$("#form-input-kategori").validationEngine('validate')){
            return false;
        }
        var isUbah = false;
        if($("#frm-input-kategori").hasClass("ubah")){
            isUbah = true;
        }
        var id_kategori = (isUbah)?$("#temp_id_kategori_kat").val():"";
        var nama_kategori = $("#nama_kategori_kat").val();
        var waktu = $("#waktu_kat").val();
        var jumlah_soal = $("#jumlah_soal_kat").val();
        var data = {
            id_kategori:id_kategori,
            nama_kategori:nama_kategori,
            waktu:waktu,
            jumlah_soal:jumlah_soal
        };
        $.ajax({
            url: BASE_URL+'/services/crudResource.php',
            data: {
                type:"kategori",
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
                var json = $.parseJSON(data);
                if(json!=null)
                if(json.status!=="1"){
                    $("#frm-input-kategori").dialog('close');
                    showInformation(json.fullMessage, function(){});
                    return false;
                } else {
                    $("#frm-input-kategori").dialog('close');
                    if(isUbah){
                        $("#nama_kat"+id_kategori).html(nama_kategori);
                        $("#waktu_kat"+id_kategori).html(waktu);
                        $("#jum_kat"+id_kategori).html(jumlah_soal);
                    } else {
                        var fullMessage = json.fullMessage;
                        var id = fullMessage.substring(6, fullMessage.length);
                        var tr = document.createElement("tr");
                        tr.setAttribute("id", "rowKat"+id);
                        var td = "<td>"+id+"</td>"+
                "<td id='nama_kat"+id+"'>"+nama_kategori+"</td>"+
                "<td id='waktu_kat"+id+"'>"+waktu+"</td>"+
                "<td id='jum_kat"+id+"'>"+jumlah_soal+"</td>"+
                "<td align='center'>"+
                    "<a href='' class='btn btn-warning'"+
                       " onclick='return showInputKategori("+id+");'>"+
                        "<i class='icon-pencil'></i>Ubah"+
                    "</a>"+
                    "<a href='' class='btn btn-danger'"+
                       " onclick='return deleteKategori("+id+");'>"+
                        "<i class='icon-trash'></i>Hapus"+
                    "</a>"+
                "</td>";
                        tr.innerHTML=td;
                        $("#isi_kategori").append(tr);
                    }
                }
            },
            error: function(xhr, status, errorMsg){
                alert(errorMsg);
            }
        });
        return false;
    }
    function deleteKategori(id){
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
                            id_kategori:id
                        }
                        $.ajax({
                            url: BASE_URL+'/services/crudResource.php',
                            data: {
                                type:"kategori",
                                proses:"hapus",
                                json:jQuery.toJSON(data)
                            },
                            cache: false,
                            type: 'POST',
                            success: function(data, status, xhr){
                                var result = $.parseJSON(data);
                                if(result.fullMessage=="sukses"){
                                    dialog.dialog('close');
                                    $("#rowKat"+id).remove();
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
<div id="frm-show-kategori" style="display: none;">
    <table class="table table-hover table-condensed">
        <thead>
            <tr>
                <th>ID Kategori</th>
                <th>Nama Kategori</th>
                <th>Waktu</th>
                <th>Jumlah Soal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="isi_kategori">
            <tr>
                <td>1</td>
                <td>Ujian Gambar</td>
                <td>70</td>
                <td>5</td>
                <td align="center">
                    <a href="" class="btn btn-warning"
                       onclick="">
                        <i class="icon-pencil"></i>Ubah
                    </a>
                    <a href="" class="btn btn-danger"
                       onclick="">
                        <i class="icon-trash"></i>Hapus
                    </a>
                </td>
            </tr>
        </tbody>
    </table>
    <center>
        <button type="submit" class="btn btn-primary" onclick="return showInputKategori();">
            <i class="icon icon-plus"></i> Tambah Kategori
        </button>
    </center>
</div>
<div id="frm-input-kategori" style="display: none;">
    <center>
        <form id="form-input-kategori" class="form" method="post" action="" onsubmit="return submitInputKategori();">
        <input id="temp_id_kategori_kat" name="temp_id_kategori_kat" type="hidden" value=""/>
        <table border="0">
            <tr>
                <td>Nama Kategori</td>
                <td align="right"><input name="nama_kategori_kat" id="nama_kategori_kat" class="validate[required]" type="text"/></td>
            </tr>
            <tr>
                <td>Waktu(Menit)</td>
                <td align="right"><input name="waktu_kat" id="waktu_kat" class="validate[required,custom[onlyNumberSp]]" type="text"/></td>
            </tr>
            <tr>
                <td>Jumlah Soal</td>
                <td align="right"><input name="jumlah_soal_kat" id="jumlah_soal_kat" class="validate[required,custom[onlyNumberSp]]" type="text"/></td>
            </tr>
        </table>
        <button type="submit" class="btn btn-primary">
            <i class="icon icon-plus"></i> Simpan Data
        </button>
        <button type="reset" class="btn btn-warning" onclick="$('#frm-input-kategori').dialog('close');">
            <i class="icon icon-refresh"></i> Batal
        </button>
    </form>
    </center>
</div>