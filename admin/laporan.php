<?php
$query = "select * from jurusan";
$result = mysql_query($query);

if(isset($_POST['pilihan_jurusan'])){
    $query = "select daya_tampung from jurusan where nama_jurusan='{$_POST['pilihan_jurusan']}'";
    $result_daya_tampung = mysql_query($query);
    $row = mysql_fetch_array($result_daya_tampung);
    $daya_tampung = $row['daya_tampung'];

    $query = "SELECT no_peserta,nama,alamat,telepon,nilai,keterangan,fill_nilai,pilihan_jurusan1,pilihan_jurusan2,
group_concat(d5.nilai_per_kategori SEPARATOR ',') as nilai_kategori from (
SELECT d4.*,concat(nama_kategori,'=' COLLATE utf8_unicode_ci,nilai_kategori) as nilai_per_kategori from (
SELECT d3.*,k.nama_kategori from (
SELECT d2.*,npk.id_kategori,npk.nilai as nilai_kategori from (
SELECT no_peserta,nama,alamat,telepon,nilai,keterangan,fill_nilai,pilihan_jurusan1,pilihan_jurusan2 from
(
SELECT d0.* from
(
SELECT p.*,
(CASE
WHEN nilai=-1 THEN 'Belum Ujian'
ELSE nilai END) AS fill_nilai,j.nama_jurusan,
(select nama_jurusan from jurusan where id_jurusan = (select id_jurusan from pilihan_jurusan where no_peserta=p.no_peserta limit 0,1)) as pilihan_jurusan1,
(select nama_jurusan from jurusan where id_jurusan = (select id_jurusan from pilihan_jurusan where no_peserta=p.no_peserta limit 1,1)) as pilihan_jurusan2
FROM
peserta p,pilihan_jurusan pl,jurusan j WHERE
p.no_peserta=pl.no_peserta AND pl.id_jurusan=j.id_jurusan ORDER BY nama
) as d0
) as d1 group by no_peserta ORDER BY nama
) as d2, nilai_per_kategori npk where d2.no_peserta=npk.no_peserta
) as d3 right join kategori k on d3.id_kategori=k.id_kategori
) as d4
) as d5 where pilihan_jurusan1='{$_POST['pilihan_jurusan']}' or pilihan_jurusan2='{$_POST['pilihan_jurusan']}' group by no_peserta
ORDER BY nilai DESC limit $daya_tampung";

    $result2 = mysql_query($query);
}
?>
<div class="well" style="width: 1200px; margin:10px auto;">
    <div class="navbar">
        <div class="navbar-inner">
            <div class="container">
                <a class="brand" href="#">Siswa yang diterima</a>
                <div class="nav-collapse">
                    <ul class="nav">
                        <li>
                            <form style="margin: 0" name="form_submit" method="post" action="">
                            <select name="pilihan_jurusan" style="margin: 6px;">
                                <?php while ($row = mysql_fetch_array($result)) {
                                    $id_jurusan = $row['id_jurusan'];
                                    $nama_jurusan = $row['nama_jurusan'];
                                ?>
                                <option value="<?=$nama_jurusan?>" <?php echo $_POST['pilihan_jurusan']==$nama_jurusan ? 'selected' : ''; ?>><?=$nama_jurusan?></option>
                                <?php } ?>
                            </select>
                            </form>
                        </li>
                        <li>
                            <a href="#" class="small-box" onclick="document.form_submit.submit(); return false;">
                                <i class="icon-chevron-right icon-white"></i> Tampilkan
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <table class="table table-hover table-condensed">
        <?php if(isset($_POST['pilihan_jurusan'])) {
            $row = mysql_fetch_array($result2);
            $nilai_k = $row['nilai_kategori'];
            $split_k = explode(',', $nilai_k);
        ?>
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Peserta</th>
                <th>Nama</th>
                <th>Pilihan Jurusan 1</th>
                <th>Pilihan Jurusan 2</th>
                <?php for($i=0;$i<count($split_k);$i++) {
                    $split_k2 = explode('=', $split_k[$i]);
                ?>
                <th><?=$split_k2[0]?></th>
                <?php } mysql_data_seek($result2, 0); ?>
                <th>Nilai Akhir</th>
            </tr>
        </thead>
        
        <tbody>
            <?php
            $no = 0;
            while ($row1 = mysql_fetch_array($result2)) { ?>
            <tr>
                <td><?=$no+1?></td>
                <td><?=$row1['no_peserta']?></td>
                <td><?=$row1['nama']?></td>
                <td><?=$row1['pilihan_jurusan1']?></td>
                <td><?=$row1['pilihan_jurusan2']?></td>
                <?php
                $nilai_k = $row1['nilai_kategori'];
                $split_k = explode(',', $nilai_k);
                for($i=0;$i<count($split_k);$i++) {
                    $split_k2 = explode('=', $split_k[$i]);
                ?>
                <td><?=$split_k2[1]?></td>
                <?php } ?>
                <td><?=$row1['nilai']?></td>
            </tr>
            <?php $no++; } ?>
        </tbody>
        <?php } ?>
    </table>
</div>