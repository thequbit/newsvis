<?

	require_once("DatabaseTool.class.php");

	class SourcesManager
	{
		function add($name,$url)
		{
			try
			{
				$db = new DatabaseTool(); 
				$query = 'INSERT INTO sources(name,url) VALUES(?,?)';
				$mysqli = $db->Connect();
				$stmt = $mysqli->prepare($query);
				$stmt->bind_param("ss", $name,$url);
				$results = $db->Execute($stmt);
			
				$row = $results[0];
				$retVal = (object) array('sourceid' => $row['sourceid'],'name' => $row['name'],'url' => $row['url']);
	
				$db->Close($mysqli, $stmt);
			}
			catch (Exception $e)
			{
				error_log( "Caught exception: " . $e->getMessage() );
			}
		
			return $retVal;
		}

		function get($sourceid)
		{
			try
			{
				$db = new DatabaseTool(); 
				$query = 'SELECT * FROM sources WHERE sourceid = ?';
				$mysqli = $db->Connect();
				$stmt = $mysqli->prepare($query);
				$stmt->bind_param("s", $sourceid);
				$results = $db->Execute($stmt);
			
				$row = $results[0];
				$retVal = (object) array('sourceid' => $row['sourceid'],'name' => $row['name'],'url' => $row['url']);
	
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
				$query = 'SELECT * FROM sources';
				$mysqli = $db->Connect();
				$stmt = $mysqli->prepare($query);
				$results = $db->Execute($stmt);
			
				$retArray = array();
				foreach( $results as $row )
				{
					$object = (object) array('sourceid' => $row['sourceid'],'name' => $row['name'],'url' => $row['url']);
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

		function del($sourceid)
		{
			try
			{
				$db = new DatabaseTool(); 
				$query = 'DELETE FROM sources WHERE sourceid = ?';
				$mysqli = $db->Connect();
				$stmt = $mysqli->prepare($query);
				$stmt->bind_param("s", $sourceid);
				$results = $db->Execute($stmt);
	
				$db->Close($mysqli, $stmt);
			}
			catch (Exception $e)
			{
				error_log( "Caught exception: " . $e->getMessage() );
			}
		}

		function update($name,$url)
		{
			try
			{
				$db = new DatabaseTool(); 
				$query = 'UPDATE sources SET name = ?,url = ? WHERE sourceid = ?';
				$mysqli = $db->Connect();
				$stmt = $mysqli->prepare($query);
				$stmt->bind_param("sss", $name,$url, $sourceid);
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
