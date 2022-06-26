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



        //verify file size is less than 5MB
        if($this->size > (5*MB)){
            throw new \RuntimeException('The file is to large (max 5MB)');
        }

        //get extension of file
        $extension = pathinfo($this->path, PATHINFO_EXTENSION);

        $directory = "./images/".$directory."/";


        if(!is_dir($directory)){
            echo "mkdir";
            if (!mkdir($directory, 0777, true) && !is_dir($directory)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $directory));
            }
        }

        $extensionArray = ["jpg", "jpeg", "png", "gif", "mp4", "webm", "ogg", "pdf","docx"];

        /*
        $imgExtensions = ["jpeg", "png", "svg", "jpg"];
        $videoExtensions = ["mp4", "mov", "ogg"];
        $documentExtensions = ["pdf","docx"];*/

        if(!$isVideo &&!in_array($this->extension, $extensionArray, true))
        {
            throw new \RuntimeException('The file do not have a valid extension (jpeg, png, svg, jpg)');
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

    public function download($path): void
    {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($file).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        exit;
    }


}