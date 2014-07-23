<?php

namespace Gallery\Mapper;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\RowGatewayFeature;
use Zend\Stdlib\Hydrator\HydrationInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Insert;
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
}