<?php
namespace Http;
use Support\Compressor;
class Response{
  /**
  * the content of the output for response
  *
  * @var strin
  */
  private $content;
  /**
  * save the headers in a container
  *
  * @var array
  */
  private $headers = array();
  /**
  * the object of compressor class
  *
  * @var Support\Compressor
  */
  private $compressor;
  /**
  * set the compressor mode
  *
  * @var bool
  */
  private $compress = true;
  /**
  * initialize the constructor of the class and set the compress instance to its attribute
  *
  * @param Support\Compressor
  */
  public function __construct(Compressor $compressor)
  {
     $this->compressor = $compressor;
  }
  /**
  * set the content that will be displayed as output
  *
  * @param string $content
  * @return void
  */
  public function setContent($content)
  {
    $this->content = $content;
  }
  /**
  * send headers and content
  *
  * @return void
  */
  public function send()
  {
     $this->sendHeaders();
     $this->sendContent();
  }
  /**
  * add header to be sent before content
  *
  * @param string $header
  * @param int $code
  * return void
  */
  public function setHeader($header)
  {
     $this->headers[]   = $header;
  }
  /**
  * send all headers
  *
  * @return void
  */
  public function sendHeaders()
  {
     if(headers_sent()) return;
     foreach($this->headers AS $header)
     {
        header($header);
     }
  }
  /**
  * send content output
  *
  * @return void
  */
  public function sendContent()
  {
     if($this->contentWillBeCompressed())
     {
        $this->content = $this->compressor->compress($this->content , 'html');
     }
     echo $this->content;
  }
  /**
  * set if data will be compressed or not
  *
  * @param bool $compress
  * @return void
  */
  public function compress($compress)
  {
     $this->compress = $compress;
  }
  /**
  * check if the output will be compressed or not
  *
  * @return bool
  */
  public function contentWillBeCompressed()
  {
     return $this->compress;
  }
}