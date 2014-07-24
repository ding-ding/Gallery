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
use Gallery\Entity\Photo as PhotoEntity;

class Photo extends TableGateway
{
	protected $tableName = 'photo';

    protected $idCol = 'id';

    protected $entityPrototype = null;

    protected $hydrator = null;
	
	public function __construct($adapter)
	{
		parent::__construct($this->tableName,
            $adapter,
            new RowGatewayFeature($this->idCol)
        );

        $this->entityPrototype = new PhotoEntity();
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
	
	public function findByAlbumId($albumId)
	{
		$sql = new Sql($this->adapter);
		$select = $sql->select()
			->from($this->tableName)
			->where('album_id = ' . $albumId);
		
		$stmt = $sql->prepareStatementForSqlObject($select);
		$results = $stmt->execute();
		
		return $this->hydrate($results);
	}
	
	public function hydrate($results)
	{
		$albums = new \Zend\Db\ResultSet\HydratingResultSet(
				$this->hydrator,
				$this->entityPrototype
		);
		
		return $albums->initialize($results);
	}
}