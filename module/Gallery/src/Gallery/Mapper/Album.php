<?php

namespace Gallery\Mapper;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\RowGatewayFeature;
use Zend\Stdlib\Hydrator\HydrationInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Db\Sql\Delete;
use Zend\Db\Sql\Expression;
use Gallery\Entity\Album as AlbumEntity;

class Album extends TableGateway
{
    protected $tableName = 'album';

    protected $idCol = 'id';

    protected $entityPrototype = null;

    protected $hydrator = null;

    public function __construct($adapter)
    {
        parent::__construct($this->tableName,
            $adapter,
            new RowGatewayFeature($this->idCol)
        );

        $this->entityPrototype = new AlbumEntity();
        $this->hydrator = new \Zend\Stdlib\Hydrator\Reflection;
    }

    public function insert($entity)
    {
        return parent::insert($this->hydrator->extract($entity));
    }
	
	public function update($entity, $where = null)
	{
		return parent::update($this->hydrator->extract($entity), $where);
	}
	
	public function delete($where)
	{
		return parent::delete($where);
	}


	public function fetchAll()
	{
		$sql = new Sql($this->getAdapter());
		$select = $sql->select()
			->from($this->tableName);
		
		$stmt = $sql->prepareStatementForSqlObject($select);
		$results = $stmt->execute();
		
		return $this->hydrate($results);
	}
	
	public function findById($id)
	{
		$sql = new Sql($this->getAdapter());
		$select = $sql->select()
			->from($this->tableName)
			->where('id = ' . $id);
		
		$stmt = $sql->prepareStatementForSqlObject($select);
		$result = $stmt->execute();
		
		return $result;
	}
	
	public function hydrate($results)
	{
		$albums = new \Zend\Db\ResultSet\HydratingResultSet(
				$this->hydrator,
				$this->entityPrototype
		);
		
		return $albums->initialize($results);
	}

    public function counterDec($albumId)
    {
        $sql = new Sql($this->getAdapter());
        $update = $sql->update($this->tableName);
        $update->set(['count_photo' => new Expression('count_photo - 1')]);
        $update->where("id = $albumId");
        $statement = $sql->prepareStatementForSqlObject($update);
        $statement->execute();
    }

    public function counterInc($albumId)
    {
        $sql = new Sql($this->getAdapter());
        $update = $sql->update($this->tableName);
        $update->set(['count_photo' => new Expression('count_photo + 1')]);
        $update->where("id = $albumId");
        $statement = $sql->prepareStatementForSqlObject($update);
        $statement->execute();
    }

    public function countPhoto($albumId)
    {
        $sql = new Sql($this->getAdapter());
        $select = $sql->select()
            ->from($this->tableName)
            ->columns(['num' => new Expression('COUNT(*)')])
            ->where("id = $albumId");
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        return $result->current()['num'];
    }

    public function addDateTimeLastPhoto($albumId, $date)
    {
        $sql = new Sql($this->getAdapter());
        $update = $sql->update($this->tableName);
        $update->set(['last_upload_photo' => $date]);
        $update->where("id = $albumId");
        $statement = $sql->prepareStatementForSqlObject($update);
        $results = $statement->execute();
    }
	
	public function getAlbumIds()
	{
		$sql = new Sql($this->adapter);
        $select = $sql->select()
            ->from($this->tableName)
            ->columns([new Expression('DISTINCT(id) as id')]);

        $stmt = $sql->prepareStatementForSqlObject($select);
        $results = $stmt->execute();

        return $results;
	}
}