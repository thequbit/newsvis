<?

	require_once("DatabaseTool.class.php");

	class ArticlesManager
	{
		function add($sourceid,$title,$articledate)
		{
			try
			{
				$db = new DatabaseTool(); 
				$query = 'INSERT INTO articles(sourceid,title,articledate) VALUES(?,?,?)';
				$mysqli = $db->Connect();
				$stmt = $mysqli->prepare($query);
				$stmt->bind_param("sss", $sourceid,$title,$articledate);
				$results = $db->Execute($stmt);
			
				$row = $results[0];
				$retVal = (object) array('articleid' => $row['articleid'],'sourceid' => $row['sourceid'],'title' => $row['title'],'articledate' => $row['articledate']);
	
				$db->Close($mysqli, $stmt);
			}
			catch (Exception $e)
			{
				error_log( "Caught exception: " . $e->getMessage() );
			}
		
			return $retVal;
		}

		function get($articleid)
		{
			try
			{
				$db = new DatabaseTool(); 
				$query = 'SELECT * FROM articles WHERE articleid = ?';
				$mysqli = $db->Connect();
				$stmt = $mysqli->prepare($query);
				$stmt->bind_param("s", $articleid);
				$results = $db->Execute($stmt);
			
				$row = $results[0];
				$retVal = (object) array('articleid' => $row['articleid'],'sourceid' => $row['sourceid'],'title' => $row['title'],'articledate' => $row['articledate']);
	
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
				$query = 'SELECT * FROM articles';
				$mysqli = $db->Connect();
				$stmt = $mysqli->prepare($query);
				$results = $db->Execute($stmt);
			
				$retArray = array();
				foreach( $results as $row )
				{
					$object = (object) array('articleid' => $row['articleid'],'sourceid' => $row['sourceid'],'title' => $row['title'],'articledate' => $row['articledate']);
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

		function del($articleid)
		{
			try
			{
				$db = new DatabaseTool(); 
				$query = 'DELETE FROM articles WHERE articleid = ?';
				$mysqli = $db->Connect();
				$stmt = $mysqli->prepare($query);
				$stmt->bind_param("s", $articleid);
				$results = $db->Execute($stmt);
	
				$db->Close($mysqli, $stmt);
			}
			catch (Exception $e)
			{
				error_log( "Caught exception: " . $e->getMessage() );
			}
		}

		function update($sourceid,$title,$articledate)
		{
			try
			{
				$db = new DatabaseTool(); 
				$query = 'UPDATE articles SET sourceid = ?,title = ?,articledate = ? WHERE articleid = ?';
				$mysqli = $db->Connect();
				$stmt = $mysqli->prepare($query);
				$stmt->bind_param("ssss", $sourceid,$title,$articledate, $articleid);
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
