<script type="text/javascript">
    function showGrade(){
        var data = {
            where:"",
            limit:""
        }
        $.ajax({
            url: BASE_URL+'/services/crudResource.php',
            data: {
                type:"jurusan",
                proses:"get_grade",
                json:jQuery.toJSON(data)
            },
            cache: false,
            type: 'POST',
            success: function(data, status, xhr){
                var jurusans = $.parseJSON(data);
                if(jurusans.length==0){
                    showInformation("Belum ada jurusan", function(){});
                    return false;
                }
                fillDataGrade(jurusans);
//                alert(data);
            },
            error: function(xhr, status, errorMsg){
                alert(errorMsg);
            }
        });
        return false;
    }
    function fillDataGrade(jurusans){
        var isi_grade = $("#isi_grade");
        isi_grade.html("");
        if(jurusans!==null){
            for(var i=0;i<jurusans.length;i++){
                var tr = document.createElement("tr");
                tr.setAttribute("id", "rowGr"+jurusans[i].id_grade);
                var td = "<td>"+jurusans[i].id_jurusan+"</td>"+
                "<td>"+jurusans[i].nama_jurusan+"</td>"+
                "<td id='GR"+jurusans[i].id_jurusan+"'>"+jurusans[i].batas_grade+"</td>"+
                "<td align='center'>"+
                    "<a href='' id='btnGR"+jurusans[i].id_jurusan+"' class='btn btn-warning'"+
                       "onclick='return showInputGrade(\""+jurusans[i].nama_jurusan+"\","+jurusans[i].id_jurusan+",\""+jurusans[i].id_grade+"\");'>"+
                        "<i class='icon-pencil'></i>Ubah Grade"+
                    "</a>"+
                "</td>";
                tr.innerHTML=td;
                $(tr).appendTo(isi_grade);
            }
        }
        $("#frm-show-grade").dialog({
            title: "Setting Grade",
            resizable: false,
            position: 'center',
            modal: true,
            width: 540,
            height: "auto",
            hide: 'fold',
            show: 'bounce'
        });
    }
    function showInputGrade(nama_jurusan,id_jurusan,id_grade){
//        alert(id_grade);
        var batas_grade = $("#GR"+id_jurusan).html();
        $("#temp_id_jurusan_grade").val(id_jurusan);
        $("#temp_nama_jurusan_grade").val(nama_jurusan);
        $("#temp_id_grade_grade").val(id_grade);
        $("#batas_grade").val(batas_grade);
        $("#frm-input-grade").dialog({
            title: "Ubah Grade "+nama_jurusan,
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
    function submitInputGrade(){
        if(!$("#form-input-grade").validationEngine('validate')){
            return false;
        }
        var id_jurusan = $("#temp_id_jurusan_grade").val();
        var nama_jurusan = $("#temp_nama_jurusan_grade").val();
        var id_grade = $("#temp_id_grade_grade").val();
        var batas_grade = $("#batas_grade").val();
        var data = {
            id_jurusan:id_jurusan,
            id_grade:id_grade,
            batas_grade:batas_grade
        };
        $.ajax({
            url: BASE_URL+'/services/crudResource.php',
            data: {
                type:"jurusan",
                proses:"simpan_grade",
                json:jQuery.toJSON(data)
            },
            cache: false,
            type: 'POST',
            success: function(data, status, xhr){
                var json = $.parseJSON(data);
                if(json!==null){
                    if(json.status!=="1"){
                        $("#frm-input-grade").dialog('close');
                        showInformation(json.fullMessage, function(){});
                        return;
                    }else {
                        $("#frm-input-grade").dialog('close');
                        $("#GR"+id_jurusan).html(batas_grade);
                        var fullMessage = json.fullMessage;
                        var id = fullMessage.substring(6, fullMessage.length);
                        if(""!=id){
//                            alert(id);
                            var tr = $("#rowGr"+id_grade);
                            tr.attr("id", "rowGr"+id);
                            var $btnGR = $("#btnGR"+id_jurusan);
                            $btnGR.click(function(){
                                return showInputGrade(nama_jurusan, id_jurusan, id);
                            });
                        }
                    }
                }
//                alert(data);
            },
            error: function(xhr, status, errorMsg){
                alert(errorMsg);
            }
        });
        return false;
    }
</script>
<div id="frm-show-grade" style="display: none;">
    <table class="table table-hover table-condensed">
        <thead>
            <tr>
                <th>ID Jurusan</th>
                <th>Nama Jurusan</th>
                <th>Grade</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="isi_grade">
            <tr>
                <td>1</td>
                <td>Teknik Informatika</td>
                <td>70</td>
                <td align="center">
                    <a href="" class="btn btn-warning"
                       onclick="">
                        <i class="icon-pencil"></i>Ubah Grade
                    </a>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div id="frm-input-grade" style="display: none;">
    <center>
        <form id="form-input-grade" class="form" method="post" action="" onsubmit="return submitInputGrade();">
        <input id="temp_id_jurusan_grade" name="temp_id_jurusan_grade" type="hidden" value=""/>
        <input id="temp_nama_jurusan_grade" name="temp_nama_jurusan_grade" type="hidden" value=""/>
        <input id="temp_id_grade_grade" name="temp_id_grade_grade" type="hidden" value=""/>
        <table border="0">
            <tr>
                <td>Grade Kelulusan</td>
                <td align="right"><input name="batas_grade" id="batas_grade" class="validate[required,custom[onlyNumberSp]]" type="text"/></td>
            </tr>
        </table>
        <button type="submit" class="btn btn-primary">
            <i class="icon icon-plus"></i> Simpan Data
        </button>
        <button type="reset" class="btn btn-warning" onclick="$('#frm-input-grade').dialog('close');">
            <i class="icon icon-refresh"></i> Batal
        </button>
    </form>
    </center>
</div>