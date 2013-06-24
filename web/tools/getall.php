<?

	require_once("DatabaseTool.class.php");

	$from = $_GET["from"];

	switch($from)
	{
		default:
			echo "{}";
			break;

		case "sources":
			require_once("SourcesManager.class.php");
			$mgr = new SourcesManager();
			echo json_encode($mgr->getall());
			break;

		case "articles":
			require_once("ArticlesManager.class.php");
			$mgr = new ArticlesManager();
			echo json_encode($mgr->getall());
			break;

		case "words":
			require_once("WordsManager.class.php");
			$mgr = new WordsManager();
			echo json_encode($mgr->getall());
			break;

	}

?>