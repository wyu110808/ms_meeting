<?php namespace App\Http\Middleware;

use Closure;
use App\Model\Staff;

/**
 * Class CheckOpenidMiddleware
 * @package App\Http\Middleware
 * 检查是否具有openid
 */
class CheckOpenidMiddleware {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		//1、判断session获取openid,若有,直接到结尾。
		if($request->session()->has('openid')){

		}else{
			//2、没有openid,则获取code;
			//由于code时效性短，则不保存在session，查看请求里面是否有code;
			if($request->has('code')){
				$url=sprintf('https://api.weixin.qq.com/sns/oauth2/access_token?appid=%s&secret=%s&code=%s&grant_type=authorization_code',env('WEIXIN_APP_ID'),env('WEIXIN_APP_SECCRET'),$request->input('code'));
				$info=file_get_contents($url);
				$info=json_decode($info);

				if(!empty($info->errmsg)){
					abort(404);exit;
				}

				$request->session()->put('openid',$info->openid);
				$request->session()->put('access_token',$info->access_token);

				$url=sprintf('https://api.weixin.qq.com/sns/userinfo?access_token=%s&openid=%s&lang=zh_CN',$info->access_token,$info->openid);
				$info=file_get_contents($url);
				$info=json_decode($info);

				//事务保存
				DB::beginTransaction();


			}else{
				//3、无code，属于第一次访问，只能跳转到微信授权页
				//回调地址
				$callback_url=$request->url();
				
				//微信授权
				$url=sprintf('https://open.weixin.qq.com/connect/oauth2/authorize?appid=%s&redirect_uri=%s&response_type=code&scope=snsapi_userinfo&state=msmeeting&connect_redirect=1#wechat_redirect',env('WEIXIN_APP_ID'),urlencode($callback_url));
				header('location:'.$url);exit;

			}
		}
		return $next($request);
	}

	

}
