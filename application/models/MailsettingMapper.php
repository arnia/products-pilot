<?php

class Application_Model_MailsettingMapper
{
    protected $_dbTable;

    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_Mailsetting');
        }
        return $this->_dbTable;
    }

    public function getDefault(){
        $query = "select id from mailsettings where def=1";
        if($result = $this->query($query,1)) return $result->id;
        else return 0;
    }

    public function setDefault($id){
        $id = $this->_mysqli->escape_string($id);
        $query = "update mailsettings set def=0";
        $ok = $this->query($query);
        $query = "update mailsettings set def=1
                  where id = $id";
        $ok =ok && $this->query($query);
        //var_dump($query);
        return $ok;
    }

    public function update($id,$json){
        $id = $this->_mysqli->escape_string($id);
        $query = "update mailsettings set smtp_config='$json'
                      where id=$id ";
        //var_dump($query);
        return $this->query($query);
    }

    public function delete($id){
        $id = $this->_mysqli->escape_string($id);
        $query = "delete from mailsettings where id = $id";
        return $this->query($query);
    }

    public function getAllSettings(){
        $query = "select * from mailsettings";
        return $this->query($query);
    }



    public function getConfig(){

        $result = $this->getDbTable()->fetchRow($this->getDbTable()->select('smtp_config'));
        if(count($result) == 0 ) throw new Exception('Mail configuration missing');
        $cfg = json_decode($result->smtp_config, true);
        $mailSetting = new Application_Model_Mailsetting($cfg);
        return $mailSetting;
    }

    public function add($json){
        $data = array(
            'smtp_config' => $json,
        );
        $this->getDbTable()->insert($data);
    }

}
 