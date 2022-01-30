<?php


namespace App\Core;


class Recaptcha
{
    /**
     * @var string
     */
    private $secretKey;
    private $publicKey;

    public function __construct(string $publicKey = "6LdqSEAeAAAAAIrfjm8MfW03lxfTzmxiyVcWuSgy", string $secretKey = CAPTCHA_SECRET_KEY)
    {
    $this->publicKey = $publicKey;
    $this->secretKey = $secretKey;
    }

    public function checkRecaptcha($code)
    {
        if(empty($code)){
            return false;
        }
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=$this->secretKey&response={$code}";
        if(function_exists("curl_version")){

            $curl = curl_init($url);
             curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_TIMEOUT, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
            $response = curl_exec($curl);
            $response = json_decode($response);
            if($response->success)
            {
                return true;
            }
        }
        else {
            $response = file_get_contents($curl);
            return false;

        }
       return false;
    }

    public function renderRecaptcha()
    {
        return "<div class='g-recaptcha' data-sitekey='{$this->publicKey}'></div>";
    }
}