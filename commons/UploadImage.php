<?php

namespace app\commons;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
* @author Clever
*/
class UploadImage extends Model
{
	public $image;
	private $old_name;
	private $new_name;

	const NO_IMAGE = '/images/no-image.jpg';
	const IMAGE_PATH = '/uploads/images/'; // Yii::getAlias('@web')

	function __construct($old_name = null)
	{
		$this->old_name = $old_name;
	}

	public function rules()
	{
		return [
			[["image"], "required"],
			[["image"], "file", "extensions" => "jpg, png"]
		];
	}

	public function uploadImage()
	{
		$this->image = UploadedFile::getInstance($this, 'image');
		
		if ($this->validate()) {

			$this->deleteImageWhenExists();

			$this->setNewImageName();
			
			$this->saveImage();

			return true;
		}

		return false;
	}

	public function getImageWithPath()
	{
		$path = $this->getImagePath() . $this->old_name;

		if (is_null($this->old_name))
			return self::NO_IMAGE;

		if ($this->isExistsImage($path)) {
			return self::IMAGE_PATH . $this->old_name;
		}

		return self::NO_IMAGE;
	}

	public function saveImage()
	{
		$image = $this->getImagePath() . $this->getNewImageName();
		
		$this->image->saveAs($image);
	}

	public function getNewImageName()
	{
		return $this->new_name;
	}

	// ~~~~~~~~~~~~~~ PRIVATE ~~~~~~~~~~~~~~


	public function setNewImageName() 
	{
		$this->new_name = $this->generateImageName();
	} 	

	private function getImagePath()
	{
		return Yii::getAlias('@webroot') . '/uploads/images/';
	}

	private function generateImageName()
	{
		return strtolower(md5(uniqid($this->image->baseName))) . "." . $this->image->extension;
	}

	private function deleteImageWhenExists() 
    {
        if (!empty($this->old_name) && !is_null($this->old_name)) {
	        $path = $this->getImagePath() . $this->old_name;
			
	        if ($this->isExistsImage($path))
	            unlink($path);
        }
    }

    private function isExistsImage($path)
    {
    	return file_exists($path);
    }
}

?>