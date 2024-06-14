<?php 
if (!defined('VB_ENTRY')) die('Access denied.');
class WhoHasReadThisThread_Api_readers extends vB_Api
{
	/**
	 * Get all users who has read the nodeid (should be a thread)
	 *
	 * @param [int] $nodeid
	 * @return array
	 */
	public function getThreadReader($nodeid)
	{
		$nodeReaders = [];
		$nodeid = (int)$nodeid;
		if(empty($nodeid)) 
		{
			throw new vB_Exception_Api('invalid_request');
		}
		elseif (!empty((int) $nodeid) AND $nodeid > 1)
		{
			$readers = vB::getDbAssertor()->getRows('WhoHasReadThisThread:fetchReaders', ['nodeid' => $nodeid]);
			$user = [];
			$userids = [];
			foreach ($readers AS $key => $reader)
			{
				$user['avataruser'] = array(
					'userid' => $reader['userid'],
					'username' => $reader['username'],
				);
				$user['readtime'] = $reader['readtime'];
				$nodeReaders[$key] = $user;
				$userids[] = $reader['userid'];
			}
			
			$avatars = vB_Api::instanceInternal('user')->fetchAvatars($userids, false);
			
			foreach ($readers AS $key => $reader) 
			{	
				$avatar = $avatars[$reader['userid']] ?? [];
				$user['avatar'] = (empty($avatar)) ? 0 : $avatar;
				//$user['avatar']['isfullurl'] = false;

				$nodeReaders[$key] = $user;
			}
			return $nodeReaders;
		}
		return $nodeReaders;
	}
}