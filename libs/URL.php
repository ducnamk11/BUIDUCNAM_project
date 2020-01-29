<?php 	
class URL
{
	
	public static function createLink($module,$controller,$action,$param =null)
	{
		$linkParam = "";
		if (!empty($param)) {
			foreach ($param as $key => $value) {
				$linkParam .="&$key=$value";
			}
		}
		$url = 'index.php?module='.$module.'&controller='.$controller.'&action='.$action.$linkParam;
		return $url;
	}
	public static function redirect($module,$controller,$action,$param =null)
	{
		$link = self::createLink($module,$controller,$action,$param);
		header('location:'.$link);
		exit();
	}
	public static function checkRefreshPage($value,$module,$controller,$action,$param =null)
	{
		if (Session::get('token')==$value) {
			Session::delete('token');
			URL::redirect($module,$controller,$action,$param);
		}else{
			Session::set('token',$value);
		}
	}
}
 