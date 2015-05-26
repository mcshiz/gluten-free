<?php 
// require_once("/gluten-free/php/pdo-core.php") ;
require_once($_SERVER["DOCUMENT_ROOT"]."/php/pdo-core.php") ;



class GetList {

public function getList() {
    $sql = "SELECT * FROM `gluten-free` ORDER BY `votes` ASC";
    try
    {

        $pdoCore = Core::getInstance();
        $pdoObject = $pdoCore->dbh->prepare($sql);
        $category = "Beer";
        $queryArray = array(':category' => $category);
        
        if ($pdoObject->execute($queryArray)) {

            $list = $pdoObject->fetchAll(PDO::FETCH_ASSOC);
            $total = count($list);
            $names = array();
            $this->glist = $list;
            $this->pdoCore = $pdoCore;
        } 
    } catch (PDOException $pe) {
        trigger_error('Could not connect to mysql DB. ' . $pe->getMessage(), E_USER_ERROR);
    }
}
    public function say(){
        $e = $this->glist;
        return json_encode($e);
    }

    public function sendData ($ajax) {
        $data = json_decode($ajax, true);
        return $this->updateQuery($data);
    }

    private function updateQuery($data) {
        $sql = "INSERT INTO `gluten-free` (id, name, free, votes, category, celiacs) VALUES(:id, :name, :free, :votes, :category, :celiacs) ON DUPLICATE KEY UPDATE votes=:votes";
        $pdoCore = $this->pdoCore;

            if(!$data['id']){
                $id = "";
                $free = "0";
                $votes = "1";
            } else {
                $id = str_replace('"', '', $data['id']);
                $free = str_replace('"', '', $data['free']);
                $votes = str_replace('"', '', $data['votes']);
            }
            $celiacs = str_replace('"', '', $data['celiacs']);
            $name = str_replace('"', '', $data['name']);
            $category = str_replace('"', '', $data['category']);

            $pdoObject = $pdoCore->dbh->prepare($sql);
            $pdoObject->execute(array('id' => $id, 'name' => $name, 'free' => $free, 'votes' => $votes, 'category' => $category, 'celiacs' => $celiacs ));
         return $pdoObject->errorInfo();
        

    }

}        



