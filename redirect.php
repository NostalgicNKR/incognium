<?php 
include_once("config/config.php");
class PageRedirect {
    public $alias;
    private $con;

    function __construct($alias, $con) {
        $this->alias = $alias;
        $this->con = $con;
    }


    function getURL() {
        $statement = $this->con->prepare("SELECT * FROM links WHERE alias = ?");
        $statement->bind_param("s", $this->alias);
        $statement->execute();
        $data = $statement->get_result();
        $result = $data->fetch_all(MYSQLI_ASSOC);
        if(empty($result[0])) {
            return false;
        } else {
            $this->updateHits($result[0]['hits']);
            $this->redirectToURL($result[0]['url']);
        }
    }

    function updateHits($updatehits) {
        $hits = $updatehits + 1;
        $statement = $this->con->prepare("UPDATE links SET hits = ? WHERE alias = ?");
        $statement->bind_param("is", $hits, $this->alias);
        $statement->execute();
    }

    function redirectToURL($url) {
        header('Location: '.$url);
    }

}

if(isset($_GET['alias'])) {
    global $con;
    $pageRedirect = new PageRedirect($_GET['alias'], $con);
    $pageRedirect->getURL();
}