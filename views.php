<?php
/**
 * Views class extending native View class
 *
 * @package 1.0
 */
class Views extends View{

 
  /** 
		Convert new lines to paragraph <p>
		@return string
		@param $str string
		@param $addtag string
	**/
  function nl2p($str,$addtag='') {
      return str_replace('<p'.$addtag.'></p>', '', '<p'.$addtag.'>' . preg_replace('#\n|\r#', '</p>$0<p'.$addtag.'>', $str) . '</p>');
      
  }
  
  /** 
		Json encode @obj element and format with @format
		@return string
		@param $set string
		@param $format array
	**/
  function toJson($obj,$format=array()){
    if(!$obj)
		  return;
    $fw=Base::instance();
    if (isset($_COOKIE[session_name()]))
			@session_start();
		$fw->sync('SESSION');
		$hive=$fw->hive();
		
    if(is_array($obj)){
      $output=array();
      foreach($obj as $item){
        $output[]=$this->_dataSet($format,$item);
      }
    } 
    else
      $output=$this->_dataSet($format,$obj);
      
    if(F3::get('REQUEST.callback')){
      return F3::get('REQUEST.callback').'('.json_encode($output).')';
    }
    
    return json_encode($output);
  }
  
  protected function _dataSet($format,$item){
     return array_map(function($elmt) use($item){
       if(is_object($item)&&isset($item->$elmt))
         return $item->$elmt;
       if(is_array($item)&&isset($item[$elmt]))
          return $item[$elmt];
       },$format);
   }
  
}

?>