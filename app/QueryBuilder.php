<?php

namespace App;

use Aura\SqlQuery\QueryFactory;
use PDO;

class QueryBuilder
{
    private $pdo, $queryFactory;

    public function __construct()
    {

        $this->pdo = new PDO('mysql:host=localhost;dbname=app2', 'root', '');

        $this->queryFactory = new QueryFactory('mysql');

    }

    public function getAll($table, $cols = ['*'])
    {

        $select = $this->queryFactory->newSelect();

        $select->cols($cols)
            ->fromRaw($table);


        $sth = $this->pdo->prepare($select->getStatement());

        $sth->execute($select->getBindValues());

        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOne($data, $table)
    {
        $whereKey = array_keys($data)[0];
        $select = $this->queryFactory->newSelect();

        $select->cols(['*'])
            ->where("$whereKey =:$whereKey")
            ->bindValues($data)
            ->from($table);

        $sth = $this->pdo->prepare($select->getStatement());

        $sth->execute($select->getBindValues());

        return $sth->fetch(PDO::FETCH_ASSOC);

    }

    public function insert($data, $table)
    {
        $insert = $this->queryFactory->newInsert();

        $insert
            ->into($table)
            ->cols($data);


        $sth = $this->pdo->prepare($insert->getStatement());

        $sth->execute($insert->getBindValues());
    }

    public function update($data, $table, $id)
    {
        $update = $this->queryFactory->newUpdate();

        $update
            ->table($table)
            ->cols($data)
            ->where('id = :id')
            ->bindValue('id', $id);

        $sth = $this->pdo->prepare($update->getStatement());

        $sth->execute($update->getBindValues());
    }

    public function delete($id, $table)
    {
        $delete = $this->queryFactory->newDelete();

        $delete
            ->from($table)
            ->where('id = :id')
            ->bindValue('id', $id);

        $sth = $this->pdo->prepare($delete->getStatement());

        $sth->execute($delete->getBindValues());
    }

    public function getWithLimit($table, $limit, $offset, $cols = ['*'])
    {

        $select = $this->queryFactory->newSelect();

        $select->cols($cols)
            ->fromRaw($table)
            ->setPaging($limit)
            ->page($offset);

        $sth = $this->pdo->prepare($select->getStatement());

        $sth->execute($select->getBindValues());

        return $sth->fetchAll(PDO::FETCH_ASSOC);

    }


}