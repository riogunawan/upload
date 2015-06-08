<?php  
	/**
	Upload
	*/
	

	class up
	{
		private $file_name;
		private $tmp_location;
		private $file_type;
		private $file_size;
		private $file_err_msg;
		private $fileExt;
		private $upload_folder;

		private $r_w;
		private $r_h;
		
		private $t_w;
		private $t_h;

		public function upload($in, $maxsize = '', $Ext_filter = '', $upload_folder = '')
		{
			if (is_array($in)) {
				$parse          = $in['name'];
				$maxsize        = $in['maxsize'];
				$Ext_filter     = $in['ext'];
				$upload_folder  = $in['path'];
				$this->r_w 		= $in['resize_width'];
				$this->r_h 		= $in['resize_height'];
				$this->t_w 		= $in['thumb_width'];
				$this->t_h 		= $in['thumb_height'];
				unset($in);
			} else {
				$parse = $in;
			}
			$maxsize = $maxsize*1048576;
			$this->file_name 	 = $_FILES[$parse]["name"];
			$this->tmp_location	 = $_FILES[$parse]["tmp_name"];
			$this->file_type 	 = $_FILES[$parse]["type"];
			$this->file_size 	 = $_FILES[$parse]["size"];
			$this->file_err_msg  = $_FILES[$parse]["error"];
			$ext         		 = explode(".", $this->file_name);
			$this->fileExt 		 = end($ext);
			$this->upload_folder = $upload_folder;

			if (!$this->tmp_location) { 
			    echo "ERROR: -_- pilih filenya dulu.";
			    exit();
			} else if($this->file_size > $maxsize) { 
			    echo "ERROR: ukuran filenya kegedean, file gx bolah lbh besar dari " . $maxsize . " Mb.";
			    exit();
			} else if (!preg_match("/.($Ext_filter)$/i", $this->file_name) ) {
			     echo "ERROR: extensi file upload gx didukung";
			     exit();
			} else if ($this->file_err_msg == 1) { 
			    echo "ERROR: !@#$%^&*(){}>?</:  ~(?_?)~  ";
			    exit();
			}

			$moveResult = move_uploaded_file($this->tmp_location, $upload_folder.$this->file_name);

			if ($moveResult != true) {
			    echo "ERROR: anda kurang beruntung :D | coba lagi <br> gagal upload";
			    exit();
			} else {
				return $this;
			}
		}

		public function resize($w = '', $h = '', $prefix = '', $ext = '') {
        	$w = empty($this->r_w) ? $w : $this->r_w;
        	$h = empty($this->r_h) ? $h : $this->r_h;
	        if ($w == '' || $h == '') {
	        	echo "ERROR: -_- lupa nyeting width atau height untuk resize";
	        	exit();
	        }
			$this->fileExt = empty($ext) ? $this->fileExt : $ext;
			$prefix = empty($prefix) ? 'syah_' : $prefix;
			$target = $this->upload_folder.$this->file_name;
			$newcopy = $this->upload_folder.$prefix.$this->file_name;
	        list($w_orig, $h_orig) = getimagesize($target);
	        $scale_ratio = $w_orig / $h_orig;
	        if (($w / $h) > $scale_ratio) {
               $w = $h * $scale_ratio;
	        } else {
               $h = $w / $scale_ratio;
	        }
	        $img = "";
	        $this->fileExt = strtolower($this->fileExt);
	        if ($this->fileExt == "gif"){ 
	        	$img = imagecreatefromgif($target);
	        } else if($this->fileExt =="png"){ 
	        	$img = imagecreatefrompng($target);
	        } else { 
	        	$img = imagecreatefromjpeg($target);
	        }
	        $tci = imagecreatetruecolor($w, $h);

	        imagecopyresampled($tci, $img, 0, 0, 0, 0, $w, $h, $w_orig, $h_orig);
	        if ($this->fileExt == "gif"){ 
	            imagegif($tci, $newcopy);
	        } else if($this->fileExt =="png"){ 
	            imagepng($tci, $newcopy);
	        } else { 
	            imagejpeg($tci, $newcopy, 84);
	        }

	        return $this;
	    }

	    public function thumb($w ='', $h = '', $prefix = '', $ext = '') {
	    	$w = empty($this->t_w) ? $w : $this->t_w;
        	$h = empty($this->t_h) ? $h : $this->t_h;
	        if ($w == '' || $h == '') {
	        	echo "ERROR: -_- lupa nyeting width atau height untuk motong";
	        	exit();
	        }
	    	$this->fileExt = empty($ext) ? $this->fileExt : $ext;
	    	$prefix        = empty($prefix) ? 'aDiyan_' : $prefix;
			$newcopy       = $this->upload_folder.$prefix.$this->file_name;
	    	$target        = $this->upload_folder.$this->file_name;

	        list($w_orig, $h_orig) = getimagesize($target);
	        $src_x = ($w_orig / 2) - ($w / 2);
	        $src_y = ($h_orig / 2) - ($h / 2);
	        $this->fileExt = strtolower($this->fileExt);
	        $img = "";
	        if ($this->fileExt == "gif"){ 
	        	$img = imagecreatefromgif($target);
	        } else if($this->fileExt =="png"){ 
	        	$img = imagecreatefrompng($target);
	        } else { 
	        	$img = imagecreatefromjpeg($target);
	        }

	        $tci = imagecreatetruecolor($w, $h);
	        imagecopyresampled($tci, $img, 0, 0, $src_x, $src_y, $w, $h, $w, $h);
	        if ($this->fileExt == "gif"){ 
	            imagegif($tci, $newcopy);
	        } else if($this->fileExt =="png"){ 
	            imagepng($tci, $newcopy);
	        } else { 
	            imagejpeg($tci, $newcopy, 84);
	        }
	        return $this;
	    }
	}
?>