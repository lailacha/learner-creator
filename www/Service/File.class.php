<?php


namespace App\Service;
use App\Model\File as FileModel;
use App\Core\Session;

class File
{

    private $path;
    private $extension;
    private $name;
    private $tmp_name;
    private $size;


    public function __construct($file)
    {
        $this->path = $file["name"];
        $this->tmp_name = $file["tmp_name"];
        $this->size = $file["size"];
        $this->extension = pathinfo($this->path, PATHINFO_EXTENSION);
        $this->name = pathinfo($this->path, PATHINFO_FILENAME);
    }

    public function upload(string $directory = "assets", int $category, bool $isVideo = false)
    {
        $session = new Session();

        //verify if the file is an image
        if(!$isVideo && !getimagesize($this->tmp_name)){
            throw new \RuntimeException("The file is not an image");
        }

        //verify file size is less than 5MB
        if($this->size > (5*MB)){
            throw new \RuntimeException('The file is to large (max 5MB)');
        }

        //get extension of file
        $extension = pathinfo($this->path, PATHINFO_EXTENSION);

        $directory = "./images/".$directory."/";


        if(!is_dir($directory)){
            if (!mkdir($directory, 0777, true) && !is_dir($directory)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $directory));
            }
        }


        $imgExtensions = ["jpeg", "png", "svg", "jpg"];
        $videoExtensions = ["mp4", "mov", "ogg"];

        if(!$isVideo &&!in_array($this->extension, $imgExtensions, true))
        {
            throw new \RuntimeException('The file do not have a valid extension (jpeg, png, svg, jpg)');
        }

        if($isVideo &&!in_array($this->extension, $videoExtensions, true))
        {
            throw new \RuntimeException('The file do not have a valid extension (mp4, mov, ogg)');
        }


        if (move_uploaded_file($this->tmp_name,  $directory.$this->name.".".$this->extension)) {

            //store file in database
            try {
                $file = new FileModel();
                $file->setName($this->name);
                $file->setExtension($extension);
                $file->setCategory($category);
                $file->setPath(substr($directory, 1).$this->name.".".$extension);
                $file->save();
            } catch (\Exception $e) {
                 echo $e->getMessage();
                return false;
            }

            return $file;


        } else {
            echo "An error has occurred";
        }

    }



}