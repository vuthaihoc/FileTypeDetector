<?php
namespace Dok123\FileTypeDetector;

use \Exception;

class ContentStream {
    protected $openedOutside = false;
    protected $fp;
    protected $read = array();
    protected $url = "";
    protected $header = "";

    public function __construct($source) {
    	// check url
	    if(is_string($source) && preg_match( "/^https?\:\/\//", $source)){
		    $this->fp = $this->getFewFirstBytes( $source);
	    }
        // open regular file
        else if (is_string($source) && file_exists($source)) {
            $this->fp = fopen($source, 'rb');
        }
        // open stream
        else if (is_resource($source) && get_resource_type($source) == 'stream') {
            $this->fp = $source;
            $this->openedOutside = true;
            // cache all data if stream is not seekable
            $meta = stream_get_meta_data($source);
            if (!$meta['seekable']) {
                while (!feof($source))
                    $this->read[] = ord(fgetc($source));
            }
        } else {
            throw new Exception('Unknown source: '.var_export($source, true).' ('.gettype($source).')');
        }
    }
    
    public function getFewFirstBytes($url, $maxlen = 600){
    	echo "downloading ...\n";
    	$this->url = $url;
	    $opts = array('http' =>
		                  array(
			                  'method'  => 'GET',
			                  'user_agent '  => "Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9.2) Gecko/20100301 Ubuntu/9.10 (karmic) Firefox/3.6",
			                  'header' => array(
				                  'Accept: *'
			                  ),
		                  )
	    );
	    $context  = stream_context_create($opts);
	    $f = tmpfile();
	    if($maxlen == null){
		    $bytes = file_get_contents($url, false, $context);
	    }else{
		    $bytes = file_get_contents($url, false, $context, 0, $maxlen);
	    }
	    $this->header = $http_response_header;
	    fwrite( $f, $bytes);
	    return $f;
    }
    
    public function getAllBytes(){
    	if(!empty($this->url)){
		    $this->fp = $this->getFewFirstBytes( $this->url, null);
	    }
    }

    public function checkBytes($offset, $ethalon) {
        if ($offset < 0) {
            $stat = fstat($this->fp);
            $offset = $stat['size'] + $offset;
        }
        if (!is_array($ethalon)) $ethalon = $this->convertToBytes($ethalon);
        foreach ($ethalon as $i => $byte) {
            if (!isset($this->read[$offset+$i])) {
                fseek($this->fp, $offset+$i, SEEK_SET);
                $this->read[$offset+$i] = ord(fgetc($this->fp));
            }
            if ($this->read[$offset+$i] !== $byte)
                return false;
        }
        return true;
    }

    public function convertToBytes($string) {
        $bytes = array();
        $l = strlen($string);
        for ($i = 0; $i < $l; $i++)
            $bytes[$i] = ord($string[$i]);
        return $bytes;
    }

    public function find($offset, array $bytes, $maxDepth = 512, $reverse = false) {
        if ($offset < 0) {
            $stat = fstat($this->fp);
            $offset = $stat['size'] + $offset;
        }
        $i = 0;
        while (abs($i) <= $maxDepth) {
            $i = $reverse ? $i - 1 : $i + 1;

            if (!isset($this->read[$offset+$i])) {
                fseek($this->fp, $offset+$i, SEEK_SET);
                $this->read[$offset+$i] = ord(fgetc($this->fp));
            }

            foreach ($bytes as $j => $byte) {
                if (is_string($byte)) $byte = ord($byte);
                if ($this->read[$offset+$i+$j] != $byte)
                    continue(2);

            }
            return true;
        }
        return false;
    }

    public function __destruct() {
        if (!$this->openedOutside)
            fclose($this->fp);
    }
}
