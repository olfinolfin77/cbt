<?php
function selected($t1, $t2) {
	if(trim($t1) == trim($t2))
		return "selected";
	else
		return "";
}
function combo_kategori($kode) {
	echo "<option value='' selected>- Pilih Kategori -</option>";
	$query = mysql_query("SELECT id_ujian,nama  FROM ujian u inner join kategori k on u.id_kategori=k.id_kategori");
	while ($data= mysql_fetch_object($query)) {
		if ($kode == "")
			echo "<option value='$data->id_ujian'> " . $data->nama . " </option>";
		else
echo "<option value='$data->id_ujian'" . selected($data->id_ujian, $kode) . "> " . $data->nama . " </option>";
	}
}

?>
