<?php
class Model extends SQLQuery {
    protected $_model;
    protected $_table;

    function __construct() {

        try {
            $this->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        }
        catch(mysqli_sql_exception $e){
            $conf = fopen(ROOT . DS . 'config' . DS . 'config.php', 'w');
            fwrite($conf,
                "
                     <?php
                     //database constants
                     define ('DEVELOPMENT_ENVIRONMENT',false);
                     define('DB_NAME', '');
                     define('DB_USER', '');
                     define('DB_PASSWORD', '');
                     define('DB_HOST', '');
                     define('CHAR_SET', 'utf8');
                     ");
            fclose($conf);
        }
        $this->_model = get_class($this);
        $this->_table = strtolower($this->_model)."s";
    }
}