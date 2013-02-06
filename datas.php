<?php
/**
 * Datas class extending native Prefab
 *
 * @package 1.0
 */
class Datas extends Prefab{
  /** 
 		Check validity on @datas using @rules rulez
 		@return mix (array|false)
 		@param $datas array
 		@param $rules array
 	**/
  function check($datas,$rules){
    foreach($rules as $item=>$rule){
      $rulz=explode(',',$rule);
      $check[$item]=array_map(function ($rul) use ($datas,$item){
        if(!isset($datas[$item])){
          return;
        }
        if($rul=='required'){
          if(!$datas[$item])
            return 'false';
        }
        if (preg_match("/(\w+)->(\w+)/i",$rul,$matches)){
          $valid=new $matches[1];
          if(!$valid->$matches[2]($datas[$item]))
            return 'false';
        }
        if(preg_match("/^=(\w+)/",$rul,$matches)){
          if($datas[$item]!=$datas[$matches[1]])
            return 'false';
        }
      },$rulz);
    }
    $checked=array_filter(array_map(function($item){return implode(', ',array_filter($item,'strlen'));},$check));
    if(count($checked)<1){
      return false;
    }
    return $checked;
  }
  





}
?>