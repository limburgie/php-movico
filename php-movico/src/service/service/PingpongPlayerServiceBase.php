<?php
class PingpongPlayerServiceBase {

	public function createPingpongPlayer($pk=0) {
		return $this->getPersistence()->create($pk);
	}

	public function getPingpongPlayer($pk) {
		return $this->getPersistence()->findByPrimaryKey($pk);
	}

	public function updatePingpongPlayer(PingpongPlayer $object) {
		return $this->getPersistence()->update($object);
	}

	public function deletePingpongPlayer($pk) {
		$this->getPersistence()->remove($pk);
	}

	public function getPingpongPlayers($from=0, $limit=9999999999) {
		return $this->getPersistence()->findAll($from, $limit);
	}

	public function countPingpongPlayers() {
		return $this->getPersistence()->count();
	}

	private function getPersistence() {
		return Singleton::create("PingpongPlayerPersistence");
	}

}
?>