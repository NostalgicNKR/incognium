<?php
include_once("config/config.php");


class ProcessLink {
    private $con;
    public $url;
    function __construct($url, $con){
        $this->url = $url;
        $this->con = $con;
    }

    function getAlias() {
    if($this->isExist()) return $this->isExist();
    return $this->insertLink();
    }

    function isExist() {
        $statement = $this->con->prepare("SELECT alias FROM links WHERE url = ?");
        $statement->bind_param("s", $this->url);
        $statement->execute();
        $data = $statement->get_result();
        $result = $data->fetch_all(MYSQLI_ASSOC);
        if(empty($result[0])) {
            return false; 
        }
        return $result[0]['alias'];
    }

    function insertLink() {
        $alias = $this->generateAlias(); 
        $statement = $this->con->prepare("INSERT INTO links(url, alias) VALUES(?,?)");
        $statement->bind_param("ss", $this->url, $alias);
        $statement->execute();
        return $alias;
    }

    function generateAlias() {  
        $token = substr(md5(uniqid(rand(), true)),0,5);
        $statement = $this->con->prepare("SELECT alias FROM links WHERE alias = ?");
        $statement->bind_param("s", $token);
        $statement->execute();
        $statement->store_result();
        if($statement->num_rows > 0) {
            $this->generateAlias();
        } else {
            return $token;
        }
    }
}

if(isset($_GET['url'])) {
    global $con;
    $processLink = new ProcessLink($_GET['url'], $con);
    header('Location: '."http://localhost/url?alias=".$processLink->getAlias());
}