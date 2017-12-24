/**
 * arrCleaner:  recursively removes any item indicated in the filter of an array
 * 
 * @param  array    $array - to filter
 * @param  array    $filter - List of elements to remove from $array
 * @param  bool     $typeFilter - (true -> Filter removes $array itens from Keys) | (false= Filter remove $array itens from Values)
 * @param  callable $callback callback takes ($value, $key)
 * @return array
 * 
 */


function arrCleaner($array,array $filter,bool $typeFilter=null, callable $callback ) {
	
		if(!is_array($array)){
			return false;
		}

		if(!is_array($filter)){
			return $array;
		}

		foreach ($array as $k => $v) {
		   
			if (is_array($v)) {
				$array[$k] = arrCleaner($v,$filter,$typeFilter, $callback);
			} else {
				if ($callback($filter,$typeFilter,$v,$k)) {
					unset($array[$k]);
				}
				
			}
		}
		return $array;
	}
	
	function arrCleanerCallback($filter,$typeFilter,$value,$key){
		
		if ($filter){
		foreach($filter as $k1=>$v1){	
			if($typeFilter){
				if ($key == $v1){
				//echo 'MATCH: '.$Key.'=>'.$v1."\n\r";
				//die();
				//$value == $v1 ? $ret = true: $ret = false;
				return true;
				}
			}else{
				if ($value == $v1){
					//echo 'MATCH: '.$value.'=>'.$v1."\n\r";
					//die();
					//$value == $v1 ? $ret = true: $ret = false;
					return true;
				}
			}
		}
	}
	};	