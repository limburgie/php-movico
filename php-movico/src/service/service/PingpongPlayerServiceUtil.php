<?php
class PingpongPlayerServiceUtil {

	public static function getActivePlayers() {
		return self::getService()->getActivePlayers();
	}

	public static function getPlayersWithEmail() {
		return self::getService()->getPlayersWithEmail();
	}

	public static function create($firstName, $lastName, $memberNo, $ranking, $recreation, $street, $place, $emailAddress, $password, $phone, $mobile) {
		return self::getService()->create($firstName, $lastName, $memberNo, $ranking, $recreation, $street, $place, $emailAddress, $password, $phone, $mobile);
	}

	public static function update($playerId, $firstName, $lastName, $memberNo, $ranking, $active, $recreation, $street, $place, $emailAddress, $password, $phone, $mobile) {
		return self::getService()->update($playerId, $firstName, $lastName, $memberNo, $ranking, $active, $recreation, $street, $place, $emailAddress, $password, $phone, $mobile);
	}

	public static function login($emailAddress, $password) {
		return self::getService()->login($emailAddress, $password);
	}

	public static function userExists($emailAddress) {
		return self::getService()->userExists($emailAddress);
	}

	public static function generateNewPassword($playerId) {
		return self::getService()->generateNewPassword($playerId);
	}

	public static function getLatestPlayers($max) {
		return self::getService()->getLatestPlayers($max);
	}

	public static function getUsersSortedByFirstName() {
		return self::getService()->getUsersSortedByFirstName();
	}

	public static function findByEmailAddress($emailAddress, $from=-1, $limit=-1) {
		return self::getService()->findByEmailAddress($emailAddress, $from, $limit);
	}

	public static function deleteByEmailAddress($emailAddress) {
		self::getService()->deleteByEmailAddress($emailAddress);
	}

	public static function findByActive($active, $from=-1, $limit=-1) {
		return self::getService()->findByActive($active, $from, $limit);
	}

	public static function deleteByActive($active) {
		self::getService()->deleteByActive($active);
	}

	public static function findByLatest($active, $from=-1, $limit=-1) {
		return self::getService()->findByLatest($active, $from, $limit);
	}

	public static function deleteByLatest($active) {
		self::getService()->deleteByLatest($active);
	}

	public static function findByRoleId($roleId, $from, $limit) {
		return self::getService()->findByRoleId($roleId, $from, $limit);
	}

	public static function setRoles($playerId, $roleIds) {
		self::getService()->setRoles($playerId, $roleIds);
	}

	public static function createPingpongPlayer($pk=0) {
		return self::getService()->createPingpongPlayer($pk);
	}

	public static function getPingpongPlayer($pk) {
		return self::getService()->getPingpongPlayer($pk);
	}

	public static function updatePingpongPlayer(PingpongPlayer $object) {
		return self::getService()->updatePingpongPlayer($object);
	}

	public static function deletePingpongPlayer($pk) {
		self::getService()->deletePingpongPlayer($pk);
	}

	public static function getPingpongPlayers($from=0, $limit=9999999999) {
		return self::getService()->getPingpongPlayers($from, $limit);
	}

	public static function countPingpongPlayers() {
		return self::getService()->countPingpongPlayers();
	}

	private static function getService() {
		return Singleton::create("PingpongPlayerService");
	}

}
?>