<?php
function selected($t1, $t2) {
	if(trim($t1) == trim($t2))
		return "selected";
	else
		return "";
}
function combo_kategori($kode) {
	echo "<option value='' selected>- Pilih Kategori -</option>";
	$query = mysql_query("SELECT id_kategori,nama  FROM kategori");
	while ($data= mysql_fetch_object($query)) {
		if ($kode == "")
			echo "<option value='$data->id_kategori'> " . $data->nama . " </option>";
		else
echo "<option value='$data->id_kategori'" . selected($data->id_kategori, $kode) . "> " . $data->nama . " </option>";
	}
}

?>
