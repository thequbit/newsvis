<?

	require_once("DatabaseTool.class.php");

	class RunsManager
	{
		function add($sourceid,$startdt,$enddt,$successful)
		{
			try
			{
				$db = new DatabaseTool(); 
				$query = 'INSERT INTO runs(sourceid,startdt,enddt,successful) VALUES(?,?,?,?)';
				$mysqli = $db->Connect();
				$stmt = $mysqli->prepare($query);
				$stmt->bind_param("ssss", $sourceid,$startdt,$enddt,$successful);
				$results = $db->Execute($stmt);
			
				$row = $results[0];
				$retVal = (object) array('runid' => $row['runid'],'sourceid' => $row['sourceid'],'startdt' => $row['startdt'],'enddt' => $row['enddt'],'successful' => $row['successful']);
	
				$db->Close($mysqli, $stmt);
			}
			catch (Exception $e)
			{
				error_log( "Caught exception: " . $e->getMessage() );
			}
		
			return $retVal;
		}

		function get($runid)
		{
			try
			{
				$db = new DatabaseTool(); 
				$query = 'SELECT * FROM runs WHERE runid = ?';
				$mysqli = $db->Connect();
				$stmt = $mysqli->prepare($query);
				$stmt->bind_param("s", $runid);
				$results = $db->Execute($stmt);
			
				$row = $results[0];
				$retVal = (object) array('runid' => $row['runid'],'sourceid' => $row['sourceid'],'startdt' => $row['startdt'],'enddt' => $row['enddt'],'successful' => $row['successful']);
	
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
				$query = 'SELECT * FROM runs';
				$mysqli = $db->Connect();
				$stmt = $mysqli->prepare($query);
				$results = $db->Execute($stmt);
			
				$retArray = array();
				foreach( $results as $row )
				{
					$object = (object) array('runid' => $row['runid'],'sourceid' => $row['sourceid'],'startdt' => $row['startdt'],'enddt' => $row['enddt'],'successful' => $row['successful']);
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

		function del($runid)
		{
			try
			{
				$db = new DatabaseTool(); 
				$query = 'DELETE FROM runs WHERE runid = ?';
				$mysqli = $db->Connect();
				$stmt = $mysqli->prepare($query);
				$stmt->bind_param("s", $runid);
				$results = $db->Execute($stmt);
	
				$db->Close($mysqli, $stmt);
			}
			catch (Exception $e)
			{
				error_log( "Caught exception: " . $e->getMessage() );
			}
		}

		function update($sourceid,$startdt,$enddt,$successful)
		{
			try
			{
				$db = new DatabaseTool(); 
				$query = 'UPDATE runs SET sourceid = ?,startdt = ?,enddt = ?,successful = ? WHERE runid = ?';
				$mysqli = $db->Connect();
				$stmt = $mysqli->prepare($query);
				$stmt->bind_param("sssss", $sourceid,$startdt,$enddt,$successful, $runid);
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
