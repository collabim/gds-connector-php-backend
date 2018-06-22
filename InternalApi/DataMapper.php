<?php

namespace CollabimApp\InternalApi;

class DataMapper
{
    private $db;

    public function __construct(
        \Kutny_Db_Adapter_Pdo $db
    ) {
        $this->db = $db;
    }

    public function getQueries(string $method, string $securityEndpointKey)
    {
        $stmt = $this->db->prepare(
            '
            SELECT prepareDataStatement, getDataStatement
            FROM internal_api
            WHERE methodName=:method AND securityKey=:securityKey;
        '
        );
        $stmt->bindParam(':method', $method);
        $stmt->bindParam(':securityKey', $securityEndpointKey);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function getData(string $prepareDataStatement, string $getDataStatement)
    {
        $this->db->query(
            $prepareDataStatement
        );
        $stmt = $this->db->query(
            $getDataStatement
        );

        return $stmt->fetchAll();
    }
}
