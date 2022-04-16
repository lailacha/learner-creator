<?php


namespace App\Service;
use App\Model\File as FileModel;

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

    public function upload(string $directory = "assets", int $category){

        //verify if the file is an image
        if(!getimagesize($this->tmp_name)){
            die("The file is not an image");
        }

        //verify file size is less than 5MB
        if($this->size > (5*MB)){
            die("The file is too large");
        }

        //get extension of file
        $extension = pathinfo($this->path, PATHINFO_EXTENSION);

        $directory = "./images/".$directory."/";


        if(!is_dir($directory)){
            if (!mkdir($directory, 0777, true) && !is_dir($directory)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $directory));
            }
        }


        $extensions = ["jpeg", "png", "svg", "jpg"];
        if(!in_array($this->extension, $extensions, true))
        {
            die("The file do not use good extension");
        }
        if (move_uploaded_file($this->tmp_name,  $directory.$this->name.".".$this->extension)) {

            //store file in database
            try {
                $file = new FileModel();
                $file->setName($this->name);
                $file->setExtension($extension);
                $file->setCategory($category);
                $file->setPath($directory.$this->name.".".$extension);
                $file->save();
            } catch (\Exception $e) {
                 echo $e->getMessage();
                return false;
            }

            echo "The file has been uploaded";
            return $file;


        } else {
            echo "An error has occurred";
        }

    }



}