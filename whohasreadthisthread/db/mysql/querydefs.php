<?php if (!defined('VB_ENTRY')) die('Access denied.');

class WhoHasReadThisThread_dB_MYSQL_QueryDefs extends vB_dB_QueryDefs
{
	protected $db_type = 'MYSQL';
	protected static $permission_string = false;
	
    protected $query_data = [
        'fetchReaders' => [
            vB_dB_Query::QUERYTYPE_KEY => vB_dB_Query::QUERY_SELECT,
            'query_string' => "
              SELECT DISTINCT u.userid, u.username, n.readtime
              FROM {TABLE_PREFIX}noderead n
              JOIN {TABLE_PREFIX}user u ON n.userid = u.userid
              WHERE nodeid = {nodeid}
              ORDER BY readtime DESC"
        ]
    ];
}
