<?php
class DB_Model
{
    /**
     * $db PDO database connection
     */
    function __construct($db)
    {
        try
        {
            $this->db = $db;
        }
        catch (PDOException $e)
        {
            exit('Database connection could not be established.');
        }
    }

    public function ft_query($sql)
    {
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query;
    }

    public function prepared_query($sql, $parameters)
    {
        $query = $this->db->prepare($sql);
        $query->execute($parameters);
        return $query;
    }

    function exists($sql, $parameters)
    {
        $query = $this->db->prepare($sql);
        $query->execute($parameters);
        return $query->fetchColumn();
    }
}