<?php
namespace Scraper\Opener;
class ResourceOpener
{
    private $url;
    private $ch;

    public function __construct($url)
    {
        $this->url = $url;
        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_URL, $this->url);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->ch, CURLOPT_HEADER, false);
        curl_setopt($this->ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:11.0) Gecko/20100101 Firefox/11.0");
        curl_setopt($this->ch, CURLOPT_COOKIE, 'SESSION_COOKIEACCEPT=true');
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
    }

    public function open()
    {
        return curl_exec($this->ch);
    }

    public function __destruct()
    {

        curl_close($this->ch);
    }
}