<?php namespace App\Http\Middleware;

use Closure;
use Weixin;

//require_once(__DIR__.'/../../vendor/chance/Weixin.php')

class WeixinAccessTokenMiddleware {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{	
		$weixin=new Weixin(env('WEIXIN_APP_ID'),env('WEIXIN_APP_SECRET'));//实例化weixin类，传入env中的appid和app_secret;
		$weixin->refreshAccessToken();//使用类中的方法
		return $next($request);
	}

}
