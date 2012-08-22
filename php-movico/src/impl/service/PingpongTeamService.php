<?php
class PingpongTeamService extends PingpongTeamServiceBase {

	public function create($clubId, $teamNo, $recreation) {
		$team = $this->createPingpongTeam();
		$team->setClubId($clubId);
		$team->setTeamNo($teamNo);
		$team->setRecreation($recreation);
		return $this->updatePingpongTeam($team);
	}
	
	public function getOrCreateTeamId($clubId, $teamNo) {
		$teamStr = String::create($teamNo);
		$recreation = $teamStr->startsWith("REC");
		$teamNo = $teamStr->getLastChar();
		try {
			$team = PingpongTeamServiceUtil::findByClubAndTeam($clubId, $teamNo, $recreation);
		} catch(NoSuchPingpongTeamException $e) {
			$team = PingpongTeamServiceUtil::create($clubId, $teamNo, $recreation);
		}
		return $team->getTeamId();
	}
	
	public function getJevotaTeam($teamNo, $rec) {
		return $this->findByClubAndTeam(PingpongClubServiceUtil::getJevota()->getClubId(), $teamNo, $rec);
	}
	
}
?>