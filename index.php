<?php  
	include 'upload.php';
	if (!empty($_POST['submit'])) {
		$upl = new up;
		$upl->upload('upl', '5', 'jpg', 'uploads/')->resize(200,200);
	}
	/**
	Readme
	*/
	/*
	untuk upload file
	=================
	$upl->upload(nama_var_post, max_size, format_yang_didukung, lokasi_penyimpanan)

	ket :
		nama_var_post : name dari input type file yang digunakan misal saya menggunakan <input name="upl" type="file"/>
						maka nama_var_post adalah upl
		max_size	  : ukuran file maksimal yang bisa du upload (satuan ukur dalam Mb)
		format_yang_didukung : jika hanya ingin upload image maka gunakan jpg , 
							   jika dapat mendukung beberapa jenis file maka gunakan jpg | pdf | dll | :D
		lokasi_penyimpanan   : tempat nyimpan file :D

	misal :
	// max size 5 Mb, format yang didukung jpg sama png
	$upl->upload('upl', '5', 'jpg | png', 'uploads/')


	resize file
	==============
	$upl->resize(width, height);

	digunakan untuk ngecilin ukuran berdasarkan rasio

	ket : 
		width  : lebar
		height : tinggi
	:D

	potong image
	==============
	$upl->thumb(width, height);

	digunakan untuk motong gambar

	ket : 
		width  : lebar
		height : tinggi
	:D

	kesimpulan 
	===============

	kalo mau upload
		$upl->upload(nama_var_post, max_size, format_yang_didukung, lokasi_penyimpanan);
	
	upload + resize
		$upl->upload(nama_var_post, max_size, format_yang_didukung, lokasi_penyimpanan)->resize(width, height);

	upload + potong
		$upl->upload(nama_var_post, max_size, format_yang_didukung, lokasi_penyimpanan)->thumb(width, height);

	semuanya
		$upl->upload(nama_var_post, max_size, format_yang_didukung, lokasi_penyimpanan)->thumb(width, height)->resize(width, height);

	pengen keliatan pro
	pake array
		$config = array(
			'name' => 'upl' ,
			'maxsize' => '5' ,
			'ext' => 'jpg|png' ,
			'path' => 'uploads/' ,
			'resize_width' => '300' ,
			'resize_height' => '100' ,
			'thumb_width' => '200' ,
			'thumb_height' => '350' ,
		);
		$upl->upload($config)->resize()->thumb();

	fork : github.com/agusdiyansyah/upload
	*/
?>

<form enctype="multipart/form-data" method="POST">
	Choose your file here: <br>
	<input name="upl" type="file"/><br><br>
	<input type="submit" name='submit' value="Upload It"/>
</form>