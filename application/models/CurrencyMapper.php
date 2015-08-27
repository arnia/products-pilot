<?php

class Application_Model_CurrencyMapper
{
    protected $_dbTable;

    public function setDbTable($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

    public function getDbTable() {
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_Currency');
        }
        return $this->_dbTable;
    }

    public function fetchAllActive() {
        $resultSet = $this->getDbTable()->fetchAll($this->getDbTable()->select()->where('active = ?', 1));
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Currency($row);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Currency($row);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function find($id) {
        $result = $this->getDbTable()->find($id);

        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $category = new Application_Model_Currency($row);

        return $category;
    }

    public function save(Application_Model_Currency $currency) {
        if($currency->def) $currency->active = 1;
        $data = array(
            'id'          => $currency->id,
            'code' => $currency->code,
            'rate' => $currency->rate,
            'def' => $currency->def,
            'active' => $currency->active,
        );

        if($data['def']) {
            $this->getDbTable()->update(array('def' => 0),array('id <> ?' => $currency->id));
        }
        if (null === ($id = $currency->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }

    public function getDefaultCurrency() {
        $row = $this->getDbTable()->fetchRow($this->getDbTable()->select()->where('def = ?', 1));
        $currency = new Application_Model_Currency($row);
        return $currency;
    }

    public function updater($currencies) {
        foreach($currencies as $code => $rate) {
            $this->getDbTable()->update(array('rate' => $rate), array('code = ?' => $code));
        }
    }

    public function findByCode($code) {
        $row = $this->getDbTable()->fetchRow($this->getDbTable()->select()->where('code = ?', $code));
        $currency = new Application_Model_Currency($row);
        return $currency;
    }
}