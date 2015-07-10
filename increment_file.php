	function send_nomer() {
		$obj = $_SERVER['DOCUMENT_ROOT'].'/id.txt';

		$file_content = file($obj);
		$content = $file_content[0];
		$content = empty($content) ? 1 : intval($content) + 1;
		$fp = fopen($obj,"w+");
		flock ($fp,LOCK_EX);
		fwrite($fp,  $content);
		fflush ($fp);
		flock ($fp,LOCK_UN);
		fclose($fp);
		return $content;
	}
