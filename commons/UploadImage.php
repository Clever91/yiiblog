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

	const NO_IMAGE = 'no-image.jpg';
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
			if ($this->old_name) {
				$this->deleteImageWhenExists();
			}
			
			if ($this->image) {
				$this->new_name = $this->generateImageName();
				$this->image->saveAs($this->getImagePath() . $this->new_name);

				return true;
			}
		}

		return false;
	}

	public function getNewName()
	{
		return $this->new_name;
	}

	public function getImage()
	{
		$path = $this->getImagePath() . $this->old_name;

		if ($this->isExistsImage($path)) {
			return self::IMAGE_PATH . $this->old_name;
		}

		return self::IMAGE_PATH . self::NO_IMAGE;
	}

	public function deleteImage()
	{
		$this->deleteImageWhenExists();
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
        if (!empty($this->old_name) && $this->old_name != null) {
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