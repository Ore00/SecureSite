<?php

try{

include_once("env.inc");
require_once(Base_Path . "/vendor/autoload.php");
require_once(Base_Path . "/vendor/apiConnector.php");
//require_once(Base_Path .'/vendor/DBQuery.php');
require_once(Base_Path . "/Model/Profile.php");

class Controller {

  public $url;
	public $path;
	public $query;
	protected $request;



	public function __construct()
    {
			  $this->url = $_SERVER['REQUEST_URI'];
        $this->request = $this->get_request($this->url);
				$this->path = $this->get_path($this->url);
				$this->query = $this->get_query($this->url);
    }

	public function invoke()
	{
		//if (isset($_GET['type']) && $_GET['type'] == 'examples')
		if(strpos($this->path, "example") || strpos($this->query, "example"))
		{
			include 'view/examples.php';
		}
		elseif(strpos($this->path, "test") || strpos($this->query, "test"))
		{
			include 'test/index.php';
		}
		else
		{
		 	echo"<h3>See readme file or click here for <a href='view/examples.php'>examples</a></h3>";	
		}
	}

	protected function get_request($url){
		 $url = explode('/', $url);
		 $url = array_filter($url);
		 $url = array_merge($url, array());
		 return $url;
	}
	protected function get_path($url){
	   $url = parse_url($this->url);
			return $url["path"];
	}

	protected function get_query($url){
		 $url = parse_url($this->url);
		 return (isset($url["query"])) ? $url["query"] : "";
	}

}

}catch(Exception $e){
    $error = $e->getMessage() . PHP_EOL;
}

 ?>
