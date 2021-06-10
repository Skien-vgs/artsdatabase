<?php 
/**
 * Copyright (C) 2021 BITJUNGLE Rune Mathisen
 * This code is licensed under a GPLv3 license 
 * See http://www.gnu.org/licenses/gpl-3.0.html 
 *
 * @author  BITJUNGLE Rune Mathisen <devel@bitjungle.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.html GNU GPLv3
 */

class DB extends PDO 
{
    private $_ini;

    /**
     * Create a new DB object
     * 
     * @param string $file INI file name.
     */
    public function __construct($file = 'search.php') 
    {
        $this->_ini = parse_ini_file($file, true);

        $dsn = $this->_ini['db']['driver'] . 
        ':dbname=' . $this->_ini['db']['dbname'] .
        ';host=' . $this->_ini['db']['host'];
        
        parent::__construct(
            $dsn, 
            $this->_ini['db']['user'], 
            $this->_ini['db']['passwd']
        );
    }

    /**
     * Select all data in the database table
     * 
     * @return array|false
     */
    public function getAllData() 
    {
        $query = 'SELECT * FROM art_info ORDER BY art ASC;';
        $stmt = $this->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Search the database for a specific string
     * 
     * @param string $str The search string
     * 
     * @return array|false
     */
    public function searchData($str) 
    {
        $query = 'SELECT latinsk, art FROM art_info
                  WHERE art LIKE :search_string
                  OR latinsk LIKE :search_string
                  ORDER BY art ASC;';
        $stmt = $this->prepare($query);
        $stmt->execute(['search_string' => "%{$str}%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>