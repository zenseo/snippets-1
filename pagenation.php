		/*
	$item_on_page - документов на странице
	$all_items - всего документов
	*/
 	function pagenation ($item_on_page = 12, $all_items = 0) {
 
		$item_on_page = empty($item_on_page) ? 1 : $item_on_page;
		$all_page = ceil($all_items / $item_on_page);
		
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$page = $page < 1 ? 1 : $page;
		$page = $page > $all_page ? $all_page : $page;

		$url_doc = explode('?',$_SERVER["REQUEST_URI"]);
		$url_doc = $url_doc[0];

 
		$page_url = "";
		foreach($this->generatePagination($page, $all_items, $item_on_page) as $id) {
			if($id == 0) {
	                $page_url .= "...";  
	        } else if ($id == $page) {
	                $page_url .= '<span class="active">'.$id.'</span>';               
	        } else {
	            $page_url .= "<a class='ditto_page' href='".$url_doc."?".$this->get_list_params($id)."'>".$id."</a>";
	        }
		}

		$next_url = ($page + 1) > $all_page ? $all_page : $page + 1;
		$prev_url = ($page - 1) < 1 ? 1 : $page - 1;

		$next_url = $this->set_next($url_doc,$next_url,$params);
		$prev_url = $this->set_prev($url_doc,$prev_url,$params);

		$out = '';
		if($all_items > 0 && $all_page > 1) {
			if ($page < $all_page && $page > 1) { 
				$out .= $prev_url.$page_url.$next_url;
			} else if($page == 1) {
				$out .=  $page_url.$next_url;	
			}  else if ($page == $all_page ) { 
				$out .= $prev_url.$page_url;
			}  
		}
		//задаем позицию с которой будем выводить
		$begin = $page > 1 ? ($page - 1) * $item_on_page : 0;
		//задаем позицию до которой будем выводить
		$end = ($begin + $item_on_page) >= $all_items ? $all_items : $begin + $item_on_page;
		
		return array($out, $begin, $end, $all_page);
	}

	private function get_list_params($id) {

		$params = array();
		$get_list = $_GET;

		unset($get_list['page']);
		unset($get_list['code']);

		foreach ($get_list as $key => $value) {
			$params[] = $key.'='.$value;
		}
 
		$params[] = 'page='.$id;

		return implode('&', $params);
	}
 
	protected function set_prev($url = '', $page = 1) {
 
		return "<a href='".$url."?".$this->get_list_params($page)."'  >Предыдущая</a>";
	}

	protected function set_next($url = '', $page = 1) {
 
		return "<a href='".$url."?".$this->get_list_params($page)."'  >Следующая</a>";
	}
	
	
	protected function generatePagination($curPage, $totResults, $resultsPerPage) {
	        $totPages = ceil($totResults / $resultsPerPage);
	         
	        $pagesBefore = $curPage - 1;
	        $pagesAfter = $totPages - $curPage;
	         
	        $tabArr = array();
	         
	        if($totPages > 15) {
	                 
	                if($pagesBefore > 7) {
	                        $tabArr = array(1,2,0);
	                         
	                        if($pagesAfter > 7)
	                        {
	                                for($i=($curPage-(4)); $i<$curPage; $i++) { $tabArr[] = $i; }
	                        } else {
	                                for($i=($totPages-11); $i<$curPage; $i++) { $tabArr[] = $i; }
	                        }
	                } else {
	                        for($i=1; $i<$curPage; $i++) { $tabArr[] = $i; }
	                }
	                 
	                $tabArr[] = $curPage;
	                 
	                if($pagesAfter > 7) {
	                        if($pagesBefore > 7) {                         
	                                for($i=($curPage+1); $i<=$curPage+4; $i++) { $tabArr[] = $i; }
	                        } else {
	                                for($i=($curPage+1); $i<13; $i++) { $tabArr[] = $i; }
	                        }
	                        $tabArr[] = 0;
	                        $tabArr[] = $totPages-1;
	                        $tabArr[] = $totPages;
	                } else {
	                        for($i=($curPage+1); $i<=$totPages; $i++) { $tabArr[] = $i; }
	                }
	                 
	        } else {
	                for($i=1;$i<=$totPages;$i++) { $tabArr[] = $i; }
	        }
	                         
	        return $tabArr;
	         
	}
