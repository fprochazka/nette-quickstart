<?php

namespace TaskList;

use Nette;



/**
 * Repository pattern class for database table
 */
abstract class Table extends Nette\Object
{

	/**
	 * @var Nette\Database\Connection
	 */
	protected $connection;

	/**
	 * @var string
	 */
	protected $tableName;



	/**
	 * @param Nette\Database\Connection $db
	 * @throws \Nette\InvalidStateException
	 */
	public function __construct(Nette\Database\Connection $db)
	{
		$this->connection = $db;

		if ($this->tableName === NULL) {
			$class = get_class($this);
			throw new Nette\InvalidStateException("Název tabulky musí být definován v $class::\$tableName.");
		}
	}



	/**
	 * Gets whole table from database
	 * @return \Nette\Database\Table\Selection
	 */
	protected function getTable()
	{
		return $this->connection->table($this->tableName);
	}



	/**
	 * Returns all records
	 * @return \Nette\Database\Table\Selection
	 */
	public function findAll()
	{
		return $this->getTable();
	}



	/**
	 * Returns all records matching criteria specified in $by
	 * (array('name' => 'David') gets converted to SQL query WHERE name = 'David')
	 *
	 * @param array $by
	 *
	 * @return \Nette\Database\Table\Selection
	 */
	public function findBy(array $by)
	{
		return $this->getTable()->where($by);
	}



	/**
	 * Returns first record matching criteria specified in $by
	 *
	 * @param array $by
	 *
	 * @return \Nette\Database\Table\ActiveRow|FALSE
	 */
	public function findOneBy(array $by)
	{
		return $this->findBy($by)->limit(1)->fetch();
	}



	/**
	 * Returns record with specified primary key
	 *
	 * @param int $id
	 *
	 * @return \Nette\Database\Table\ActiveRow|FALSE
	 */
	public function find($id)
	{
		return $this->getTable()->get($id);
	}

}
