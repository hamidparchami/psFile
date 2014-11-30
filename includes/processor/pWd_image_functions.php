<?php
/********************************
* Image Process Class
* Written by Hamid Parchami
* Email: hamidparchami@gmail.com
* V0.2 29/09/2014
********************************/

$Path = dirname(realpath(__FILE__));
if(substr($Path,-1)!="/") $Path .= "/";
@require_once("pWd_file_functions.php");
class pWd_image extends PsFile{
	var $setFolder		 		  = "";		   //destination folder
	var $getWatermarkImage		  = "";		   //Watermark Image File
	var $setWatermarkHAlign	 	 = "left";	   //vertical align
	var $setWatermarkVAlign	 	 = "bottom";	 //horizontal align
	var $setOpacity        		 = 100;		  //image opacity for watermark
	var $setQuality	    		 = 100;		  //quality of output image
	var $setWatermarkPaddingTop     = 0;	 	  	//distance to border in pixels for watermark image
	var $setWatermarkPaddingLeft    = 0;	 		//distance to border in pixels for watermark image
	var $thumbnailedImage  		   = "";
	var $imageFullDestination	   = "";
	var $HPosition	  			  = 0;		  	//watermark x posiotion
	var $VPosition	  			  = 0;		  	//watermark y posiotion

    /**
    *set destination folder
    *@access public
    *@param string destination path
    **/
	function setFolder($Path){
		if(substr($Path,-1)!="/") $Path .= "/";
		$this->setFolder = $Path;
		return true;
	}
    /**
    *get watermark image file
    *@access public
    *@param string path of the watermark image file
    **/
	function getWatermarkImage($file){
		$this->getWatermarkImage = $file;
		return true;
	}
    /**
    *set horizontal and vertical align
    *@access public
    *@param string horizontal align of the watermark image
    *@param string vertical align of the watermark image
    **/
	function setWatermarkAlignment($halign="left", $valign="bottom"){
		$this->setWatermarkHAlign = $halign;
		$this->setWatermarkVAlign = $valign;
		return true;
	}
    /**
    *set watermark opacity
    *@access public
    *@param integer opacity amount
    **/
	function setOpacity($opacity){
		if(is_int($opacity) && $opacity > 0 && $opacity <= 100){
		  $this->setOpacity = ceil($opacity);
		  return true;
		}
	}
    /**
    *set watermark to an image file
    *@access public
    *@param string path of the main image file
    *@param string path of the destination image file
	*@param integer width of the destination image file
	*@param integer height of the destination image file
    **/
	function setWatermark($mainImage, $rename="", $width="", $height="", $thumbnailFolder="thumbnails/"){
		$watermark_img       = $this->getWatermarkImage; // use GIF or PNG, JPEG has no tranparency support//
		$rename != "" ? $newImage = $rename : $newImage = $mainImage;
		$mainImage = $this->setFolder . $mainImage;
		if ($thumbnailFolder != "" && substr($thumbnailFolder, -1) != "/") $thumbnailFolder .= "/";
		
		if($thumbnailFolder != "") PsFile::fakeIndexCheck($this->setFolder . $thumbnailFolder, 1);
		$main_img = $mainImage;
		if($width != "" && $height != ""){
			pWd_image::thumbnail($mainImage, $newImage, $width, $height);
			$main_img	= $this->thumbnailedImage;
			$newImage	= $this->thumbnailedImage;
		}
		//check watermark format
		$watermarkFormat = substr($watermark_img, -3);
		$mainImageFormat = substr($main_img, -3);
		
		if($watermarkFormat == "png"){
			$watermark	= imagecreatefrompng($watermark_img); // create watermark
		}elseif($watermarkFormat == "gif"){
			$watermark	= imagecreatefromgif($watermark_img); // create watermark
		}else{
			$watermark	= imagecreatefromjpeg($watermark_img); // create watermark
		}
		//check main image format
		if($mainImageFormat == "png"){
			$image		= imagecreatefrompng($main_img); // create main graphic
		}elseif($mainImageFormat == "gif"){
			$image		= imagecreatefromgif($main_img); // create main graphic
		}else{
			$image		= imagecreatefromjpeg($main_img); // create main graphic
		}

		imagefill($watermark,0,0,0xFFFFFFFF);

		if(!$image || !$watermark) die("Error: main image or watermark could not be loaded!");
		$watermark_size      = getimagesize($watermark_img);
		$watermark_width     = $watermark_size[0]; 
		$watermark_height    = $watermark_size[1]; 
		$image_size		  = getimagesize($main_img);
		$image_width		 = $image_size[0];
		$image_height		= $image_size[1];

		//Check Hotizontal Position
        switch ($this->setWatermarkHAlign) {
             case 'center':
                 $this->HPosition = $image_width/2-$watermark_width/2;
                 break;
             case 'right':
                 $this->HPosition = $image_width-$watermark_width;
                 break;
             default:
             case 'left':
                $this->HPosition = 0;
                 break;
         }
		//Check Vertical Position
        switch ($this->setWatermarkVAlign) {
             case 'center':
                 $this->VPosition = $image_height/2-$watermark_height/2;
                 break;
             case 'bottom':
                 $this->VPosition = $image_height-$watermark_height;
                 break;
             default:
             case 'top':
                $this->VPosition = 0;
                 break;
         }

		$dest_x              = $this->HPosition + $this->setWatermarkPaddingLeft;
		$dest_y              = $this->VPosition + $this->setWatermarkPaddingTop;
		// copy watermark on main image
		imagecopymerge($image, $watermark, $dest_x, $dest_y, 0, 0, $watermark_width, $watermark_height, $this->setOpacity); 

		pWd_image::save($image, $newImage);
		$this->imageFullDestination = $newImage;
		imagedestroy($image); 
		imagedestroy($watermark);
	}
    /**
    *save your thumbnail to file
    *@access public
    *@param string source file name
	*@param string output file name
    *@return boolean
    **/
	function save($source, $destination){
		$fileFormat	= @substr($source, -3);
        if($fileFormat == "png"){
    	    imagepng($source, $destination);
    	}elseif($fileFormat == "gif"){
			imagegif($source, $destination);
    	}else{
           //imageinterlace( $this->img["des"], $this->jpeg_progressive);
           imagejpeg($source,$destination, $this->setQuality);
        }
        return true;
	}
	
	function thumbnail($src, $dest="", $desired_width, $desired_height, $thumbnailFolder="thumbnails/") {
		if($dest == "") $dest = $src;
		//check main image format
		$mainImageFormat = substr($src, -3);
		if($mainImageFormat == "png"){
			$source_image		= imagecreatefrompng($src); // create main graphic
		}elseif($mainImageFormat == "gif"){
			$source_image		= imagecreatefromgif($src); // create main graphic
		}else{
			$source_image		= imagecreatefromjpeg($src); // create main graphic
		}
		$width = imagesx($source_image);
		$height = imagesy($source_image);
		if ($thumbnailFolder != "" && substr($thumbnailFolder, -1) != "/" ) $thumbnailFolder .= "/";
		
		/* create a new, "virtual" image */
		$virtual_image = imagecreatetruecolor($desired_width, $desired_height);
		
		/* copy source image at a resized size */
		imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
		
		/* create the physical thumbnail image to its destination */
		$dest = $this->setFolder.$thumbnailFolder.substr($dest,0, -4)."_".$desired_width."x".$desired_height.substr($dest, -4);
		$this->thumbnailedImage = $dest;
		if($thumbnailFolder != "") PsFile::fakeIndexCheck($this->setFolder . $thumbnailFolder, 1);
		pWd_image::save($virtual_image, $dest);
		$this->imageFullDestination = $dest;
	}

}
?>
