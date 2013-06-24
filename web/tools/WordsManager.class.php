<?

	require_once("DatabaseTool.class.php");

	class WordsManager
	{
		function add($word,$frequency,$articleid,$sourceid,$worddate)
		{
			try
			{
				$db = new DatabaseTool(); 
				$query = 'INSERT INTO words(word,frequency,articleid,sourceid,worddate) VALUES(?,?,?,?,?)';
				$mysqli = $db->Connect();
				$stmt = $mysqli->prepare($query);
				$stmt->bind_param("sssss", $word,$frequency,$articleid,$sourceid,$worddate);
				$results = $db->Execute($stmt);
			
				$row = $results[0];
				$retVal = (object) array('wordid' => $row['wordid'],'word' => $row['word'],'frequency' => $row['frequency'],'articleid' => $row['articleid'],'sourceid' => $row['sourceid'],'worddate' => $row['worddate']);
	
				$db->Close($mysqli, $stmt);
			}
			catch (Exception $e)
			{
				error_log( "Caught exception: " . $e->getMessage() );
			}
		
			return $retVal;
		}

		function get($wordid)
		{
			try
			{
				$db = new DatabaseTool(); 
				$query = 'SELECT * FROM words WHERE wordid = ?';
				$mysqli = $db->Connect();
				$stmt = $mysqli->prepare($query);
				$stmt->bind_param("s", $wordid);
				$results = $db->Execute($stmt);
			
				$row = $results[0];
				$retVal = (object) array('wordid' => $row['wordid'],'word' => $row['word'],'frequency' => $row['frequency'],'articleid' => $row['articleid'],'sourceid' => $row['sourceid'],'worddate' => $row['worddate']);
	
				$db->Close($mysqli, $stmt);
			}
			catch (Exception $e)
			{
				error_log( "Caught exception: " . $e->getMessage() );
			}
		
			return $retVal;
		}

		function getall()
		{
			try
			{
				$db = new DatabaseTool(); 
				$query = 'SELECT * FROM words';
				$mysqli = $db->Connect();
				$stmt = $mysqli->prepare($query);
				$results = $db->Execute($stmt);
			
				$retArray = array();
				foreach( $results as $row )
				{
					$object = (object) array('wordid' => $row['wordid'],'word' => $row['word'],'frequency' => $row['frequency'],'articleid' => $row['articleid'],'sourceid' => $row['sourceid'],'worddate' => $row['worddate']);
					$retArray[] = $object;
				}
	
				$db->Close($mysqli, $stmt);
			}
			catch (Exception $e)
			{
				error_log( "Caught exception: " . $e->getMessage() );
			}
		
			return $retArray;
		}

		function del($wordid)
		{
			try
			{
				$db = new DatabaseTool(); 
				$query = 'DELETE FROM words WHERE wordid = ?';
				$mysqli = $db->Connect();
				$stmt = $mysqli->prepare($query);
				$stmt->bind_param("s", $wordid);
				$results = $db->Execute($stmt);
	
				$db->Close($mysqli, $stmt);
			}
			catch (Exception $e)
			{
				error_log( "Caught exception: " . $e->getMessage() );
			}
		}

		function update($word,$frequency,$articleid,$sourceid,$worddate)
		{
			try
			{
				$db = new DatabaseTool(); 
				$query = 'UPDATE words SET word = ?,frequency = ?,articleid = ?,sourceid = ?,worddate = ? WHERE wordid = ?';
				$mysqli = $db->Connect();
				$stmt = $mysqli->prepare($query);
				$stmt->bind_param("ssssss", $word,$frequency,$articleid,$sourceid,$worddate, $wordid);
				$results = $db->Execute($stmt);
	
				$db->Close($mysqli, $stmt);
			}
			catch (Exception $e)
			{
				error_log( "Caught exception: " . $e->getMessage() );
			}
		}

		///// Application Specific Functions

	}

?>
