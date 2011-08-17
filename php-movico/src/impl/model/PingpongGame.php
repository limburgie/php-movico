<?php
class PingpongGame extends PingpongGameModel {

	public function getHomeTeam() {
		return PingpongTeamServiceUtil::getPingpongTeam($this->getHomeTeamId());
	}
	
	public function getOutTeam() {
		return PingpongTeamServiceUtil::getPingpongTeam($this->getOutTeamId());
	}
	
	public function getHomeTeamStr() {
		return $this->getTeamStr($this->getHomeTeamId());
	}
	
	public function getOutTeamStr() {
		return $this->getTeamStr($this->getOutTeamId());
	}
	
	public function getHomeTeamPtsStr() {
		return $this->isPlayed() ? $this->getHomeTeamPts() : "";
	}
	
	public function getOutTeamPtsStr() {
		return $this->isPlayed() ? $this->getOutTeamPts() : "";
	}
	
	public function isPlayed() {
		return $this->getDate()->isAfter(Date::createNow());
	}
	
	public function isHasReview() {
		$r = $this->getReview();
		return !empty($r);
	}
	
	private function getTeamStr($teamId) {
		return PingpongTeamServiceUtil::getPingpongTeam($teamId)->getTeamStr();
	}
	
}
?>