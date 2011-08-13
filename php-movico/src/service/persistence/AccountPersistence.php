<?php
class AccountPersistence extends Persistence {

	const TABLE = "Account";

	public function findByEmailAddress($emailAddress, $from=-1, $limit=-1) {
		$limitStr = ($from == -1 && $limit == -1) ? "" : " LIMIT $from,$limit";
		$whereClause = "`emailAddress`='".Singleton::create("NullConverter")->fromDOMtoDB($emailAddress)."'".$limitStr;
		if(parent::$dbCache->hasFinder('Account', $whereClause)) {
			return parent::$dbCache->getFinder('Account', $whereClause);
		}
		$result = $this->db->selectQuery("SELECT * FROM ".self::TABLE." WHERE $whereClause");
		if($result->isEmpty()) {
			throw new NoSuchAccountException();
		}
		$result = $this->getAsObject($result->getSingleRow());
		parent::$dbCache->setFinder('Account', $whereClause, $result);
		return $result;
	}

	public function findByPrimaryKey($accountId) {
		if(parent::$dbCache->hasSingle("Account", $accountId)) {
			return parent::$dbCache->getSingle("Account", $accountId);
		}
		$result = $this->db->selectQuery("SELECT * FROM ".self::TABLE." WHERE accountId='".addslashes($accountId)."'");
		if($result->isEmpty()) {
			throw new NoSuchAccountException($accountId);
		}
		$result = $this->getAsObject($result->getSingleRow());
		parent::$dbCache->setSingle("Account", $accountId, $result);
		return $result;
	}

	public function create($accountId) {
		$obj = new Account();
		$obj->setAccountId($accountId);
		$obj->setNew(true);
		return $obj;
	}

	public function remove($accountId) {
		$this->findByPrimaryKey($accountId);
		$this->db->updateQuery("DELETE FROM ".self::TABLE." WHERE accountId='".addslashes($accountId)."'");
		parent::$dbCache->resetEntity('Account');
		parent::$dbCache->resetSingle("Account", $accountId);
	}

	public function update(Account $object) {
		$q = "UPDATE ".self::TABLE." SET `emailAddress`='".Singleton::create("NullConverter")->fromDOMtoDB($object->getEmailAddress())."', `password`='".Singleton::create("NullConverter")->fromDOMtoDB($object->getPassword())."' WHERE accountId='".addslashes($object->getAccountId())."'";
		$pk = $object->getAccountId();
		if($object->isNew()) {
			if(empty($pk)) {
				$q = "INSERT INTO ".self::TABLE." (`emailAddress`, `password`) VALUES ('".Singleton::create("NullConverter")->fromDOMtoDB($object->getEmailAddress())."', '".Singleton::create("NullConverter")->fromDOMtoDB($object->getPassword())."')";
			} else {
				$q = "INSERT INTO ".self::TABLE." (`emailAddress`, `password`) VALUES ('".Singleton::create("NullConverter")->fromDOMtoDB($object->getAccountId())."', '".Singleton::create("NullConverter")->fromDOMtoDB($object->getEmailAddress())."', '".Singleton::create("NullConverter")->fromDOMtoDB($object->getPassword())."')";
			}
		}
		$this->db->updateQuery($q);
		if(empty($pk)) {
			$pk = $this->db->selectQuery("SELECT accountId from ".self::TABLE." ORDER BY accountId DESC limit 1")->getSingleton();
		}
		$result = $this->findByPrimaryKey($pk);
		parent::$dbCache->resetEntity("Account");
		parent::$dbCache->setSingle("Account", $pk, $result);
		return $result;
	}

	public function findAll($from, $limit) {
		if(parent::$dbCache->hasAll('Account')) {
			return parent::$dbCache->getAll('Account');
		}
		$rows = $this->db->selectQuery("SELECT * FROM ".self::TABLE."  LIMIT $from,$limit")->getResult();
		$objects = $this->getAsObjects($rows);
		parent::$dbCache->setAll('Account', $objects);
		return $objects;
	}

	public function count() {
		if(parent::$dbCache->hasAll('Account')) {
			return count(parent::$dbCache->getAll('Account'));
		}
		return $this->db->selectQuery("SELECT COUNT(*) FROM ".self::TABLE)->getSingleton();
	}

	protected function getAsObject($row) {
		$result = new Account();
		$result->setNew(false);
		$result->setAccountId(Singleton::create("NullConverter")->fromDBtoDOM($row["accountId"]));
		$result->setEmailAddress(Singleton::create("NullConverter")->fromDBtoDOM($row["emailAddress"]));
		$result->setPassword(Singleton::create("NullConverter")->fromDBtoDOM($row["password"]));
		return $result;
	}

}
?>