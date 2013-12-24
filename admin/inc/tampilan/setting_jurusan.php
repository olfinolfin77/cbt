<script type="text/javascript">
    function showJurusan(url){
        var data = {
            where:"",
            limit:""
        }
        $.ajax({
            url: url+'/services/crudResource.php',
            data: {
                type:"jurusan",
                proses:"get",
                json:jQuery.toJSON(data)
            },
            cache: false,
            type: 'POST',
            success: function(data, status, xhr){
                var jurusans = $.parseJSON(data);
                fillDataJurusan(jurusans);
//                alert(data);
            },
            error: function(xhr, status, errorMsg){
                alert(errorMsg);
            }
        });
        return false;
    }
    function fillDataJurusan(jurusans){
        var isi_jurusan = $("#isi_jurusan");
        isi_jurusan.html("");
        if(jurusans!==null){
//            alert(jurusans[0].nama_jurusan)
            for(var i=0;i<jurusans.length;i++){
                var tr = document.createElement("tr");
                tr.setAttribute("id", "rowJur"+jurusans[i].id_jurusan);
                var td = "<td>"+jurusans[i].id_jurusan+"</td>"+
                "<td id='nama_jur"+jurusans[i].id_jurusan+"'>"+jurusans[i].nama_jurusan+"</td>"+
                "<td id='tampung_jur"+jurusans[i].id_jurusan+"'>"+jurusans[i].daya_tampung+"</td>"+
                "<td align='center'>"+
                    "<a href='' class='btn btn-warning'"+
                       "onclick='return showInputJurusan(\"ubah\","+jurusans[i].id_jurusan+",\""+jurusans[i].nama_jurusan+"\");'>"+
                        "<i class='icon-pencil'></i>Update"+
                    "</a>"+
                    "<a href='' class='btn btn-danger'"+
                       "onclick='return deleteJurusan("+jurusans[i].id_jurusan+");'>"+
                        "<i class='icon-trash'></i>Hapus"+
                    "</a>"+
                "</td>";
                tr.innerHTML=td;
                $(tr).appendTo(isi_jurusan);
            }
        }
        $("#frm-show-jurusan").dialog({
            title: "Data Jurusan",
            resizable: false,
            position: 'center',
            modal: true,
            width: 640,
            height: "auto",
            hide: 'fold',
            show: 'bounce'
        });
    }
//    function showInformation2(info, onClose){
//        $("#isi_info2").html(info);
//        $("#information2").dialog({
//            title: "Information",
//            height: 80,
//            modal: true,
//            show: 'fade',
//            hide: 'fade',
//            open: function(event, ui){
//                setTimeout("$('#information2').dialog('close')",1500);
//            },
//            close: onClose
//        });
//    }
    function showInputJurusan(){
        var proses = arguments[0];
        var isUbah = false;
        if(arguments.length>1){
            isUbah = true;
            var id_jurusan = arguments[1];
//            var nama_jurusan = arguments[2];
            var nama_jurusan = $("#nama_jur"+id_jurusan).html();
            var daya_tampung = $("#tampung_jur"+id_jurusan).html();
        }
        if(isUbah){
            $("#frm-input-jurusan").addClass("ubah");
            $("#temp_id_jurusan_jur").val(id_jurusan);
            $("#nama_jurusan_jur").val(nama_jurusan);
            $("#daya_tampung_jur").val(daya_tampung);
        } else {
            $("#form-input-jurusan").trigger("reset");
            $("#frm-input-jurusan").removeClass("ubah");
        }
        $("#frm-input-jurusan").dialog({
            title: (isUbah)?"Ubah Jurusan":"Tambah Jurusan",
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
    function submitInputJurusan(){
        var isUbah = false; var instance=this;
        if($("#frm-input-jurusan").hasClass("ubah")){
            isUbah = true;
        }
        var id_jurusan = (isUbah)?$("#temp_id_jurusan_jur").val():"";
        var nama_jurusan = $("#nama_jurusan_jur").val();
        var daya_tampung = $("#daya_tampung_jur").val();
        var data = {
            id_jurusan:id_jurusan,
            nama_jurusan:nama_jurusan,
            daya_tampung:daya_tampung
        };
        $.ajax({
            url: BASE_URL+'/services/crudResource.php',
            data: {
                type:"jurusan",
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
                if(json.status!=="1"){
                    showInformation(json.fullMessage, function(){
                        $("#frm-input-jurusan").dialog('close');
                    });
                    return;
                } else {
                    $("#frm-input-jurusan").dialog('close');
                    if(isUbah){
                        $("#nama_jur"+id_jurusan).html(nama_jurusan);
                        $("#tampung_jur"+id_jurusan).html(daya_tampung);
                    }else {
                        var fullMessage = json.fullMessage;
                        var id = fullMessage.substring(6, fullMessage.length);
                        var tr = document.createElement("tr");
                        tr.setAttribute("id", "rowJur"+id);
                        var td = "<td>"+id+"</td>"+
                        "<td id='nama_jur"+id+"'>"+nama_jurusan+"</td>"+
                        "<td id='tampung_jur"+id+"'>"+daya_tampung+"</td>"+
                        "<td align='center'>"+
                        "<a href='' class='btn btn-warning'"+
                        "onclick='return showInputJurusan(\"ubah\","+id+",\""+nama_jurusan+"\");'>"+
                        "<i class='icon-pencil'></i>Update"+
                        "</a>"+
                        "<a href='' class='btn btn-danger'"+
                        "onclick='return deleteJurusan("+id+");'>"+
                        "<i class='icon-trash'></i>Hapus"+
                        "</a>"+
                        "</td>";
                        tr.innerHTML=td;
                        $("#isi_jurusan").append(tr);
                    }
                }
            },
            error: function(xhr, status, errorMsg){
                alert(errorMsg);
            }
        });
        return false;
    }
    function deleteJurusan(id){
//        $("#rowJur"+id).remove()
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
                            id_jurusan:id
                        }
                        $.ajax({
                            url: BASE_URL+'/services/crudResource.php',
                            data: {
                                type:"jurusan",
                                proses:"hapus",
                                json:jQuery.toJSON(data)
                            },
                            cache: false,
                            type: 'POST',
                            success: function(data, status, xhr){
                                var result = $.parseJSON(data);
                                if(result.fullMessage=="sukses"){
                                    dialog.dialog('close');
                                    $("#rowJur"+id).remove();
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
<!--<div id="information2" style="display: none;">
    <center>
        <span id="isi_info2">Data Saved.</span>
    </center>
</div>-->
<div id="frm-show-jurusan" style="display: none;">
    <table class="table table-hover table-condensed">
        <thead>
            <tr>
                <th>ID Jurusan</th>
                <th>Nama Jurusan</th>
                <th>Daya Tampung</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="isi_jurusan">
            <tr>
                <td>1</td>
                <td>Teknik Informatika</td>
                <td align="center">
                    <a href="" class="btn btn-warning"
                       onclick="">
                        <i class="icon-pencil"></i>Update
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
        <button type="submit" class="btn btn-primary" onclick="return showInputJurusan('tambah')">
            <i class="icon icon-plus"></i> Tambah Jurusan
        </button>
    </center>
</div>
<div id="frm-input-jurusan" style="display: none;">
    <center>
        <form id="form-input-jurusan" class="form" method="post" action="" onsubmit="return submitInputJurusan();">
        <input id="temp_id_jurusan_jur" name="temp_id_jurusan_jur" type="hidden" value=""/>
        <table border="0">
            <tr>
                <td>Nama Jurusan</td>
                <td align="right"><input name="nama_jurusan_jur" id="nama_jurusan_jur" class="validate[required]" type="text"/></td>
            </tr>
            <tr>
                <td>Daya Tampung</td>
                <td align="right"><input name="daya_tampung_jur" id="daya_tampung_jur" class="validate[required]" type="text"/></td>
            </tr>
        </table>
        <button type="submit" class="btn btn-primary">
            <i class="icon icon-plus"></i> Simpan Data
        </button>
        <button type="reset" class="btn btn-warning" onclick="$('#frm-input-jurusan').dialog('close');">
            <i class="icon icon-refresh"></i> Batal
        </button>
    </form>
    </center>
</div>
