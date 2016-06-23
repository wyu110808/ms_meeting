<?php

/**
 * 微信API框架
 *
 * 职责：
 * 1.进行消息和事件的回复处理
 * 2.处理access_token
 *
 * @author chentj
 */
class Weixin {

    // 这两个在外部调用的时候才进行赋值
    private $appid;
    private $app_secret;

    const REFRESH_INTERVAL = 1800;   // 刷新时间间隔（半小时）

    private $onSubscribeMsg;         // 订阅时的消息
    private $onSubscribeCallback;   // 订阅事件回调函数
    private $onUnsubscribeCallback; // 取消订阅事件回调函数
    private $onKeywordCallbacks;    // 关键词触发回调函数
    private $onSceneCallback;       // 关注场景二维码回调函数
    private $onScanCallback;        // 已关注的情况下扫描二维码

    private $textTpl = "<xml>
               <ToUserName><![CDATA[%s]]></ToUserName>
               <FromUserName><![CDATA[%s]]></FromUserName>
               <CreateTime>%s</CreateTime>
               <MsgType><![CDATA[text]]></MsgType>
               <Content><![CDATA[%s]]></Content>
               <FuncFlag>0</FuncFlag>
               </xml>";

//    private $tpl = "<xml>
//        <ToUserName><![CDATA[toUser]]></ToUserName>
//        <FromUserName><![CDATA[fromUser]]></FromUserName>
//        <CreateTime>12345678</CreateTime>
//        <MsgType><![CDATA[news]]></MsgType>
//        <ArticleCount>2</ArticleCount>
//        <Articles>
//        <item>
//        <Title><![CDATA[title1]]></Title>
//        <Description><![CDATA[description1]]></Description>
//        <PicUrl><![CDATA[picurl]]></PicUrl>
//        <Url><![CDATA[url]]></Url>
//        </item>
//        <item>
//        <Title><![CDATA[title]]></Title>
//        <Description><![CDATA[description]]></Description>
//        <PicUrl><![CDATA[picurl]]></PicUrl>
//        <Url><![CDATA[url]]></Url>
//        </item>
//        </Articles>
//        </xml>";

    public function __construct($appid, $app_secret)
    {
        $this->appid = $appid;
        $this->app_secret = $app_secret;
    }

    /**
     * 刷新获取最新的access_token
     */
    public function refreshAccessToken() {

        $cache_file = __DIR__ . '/weixin.json';

        $file_content = file_get_contents($cache_file);
        $json = json_decode($file_content);

        if (isset($json->access_token) && $json->access_token != '' &&
            isset($json->access_token_begintime) && $json->access_token_begintime != 0 &&
            isset($json->access_token_expires_in) && $json->access_token_expires_in != 0) {

            $now = time();
            if ($now - $json->access_token_begintime <= self::REFRESH_INTERVAL) { // 半小时
                // 不用更新
            } else {
                // 更新最新的access_token到weixin.json
                $content = $this->getAccessToken();
                if (isset($content->errcode)) {
                    exit();
                } else {
                    $json->access_token_begintime = time();
                    $json->access_token = $content->access_token;
                    $json->access_token_expires_in = $content->expires_in;
                    file_put_contents($cache_file, json_encode($json));
                }// end if
            }// end if
        } else {
            // 更新最新的access_token到weixin.json
            $content = $this->getAccessToken();
            if (isset($content->errcode)) {
                exit();
            } else {
                $json->access_token_begintime = time();
                $json->access_token = $content->access_token;
                $json->access_token_expires_in = $content->expires_in;
                file_put_contents($cache_file, json_encode($json));
            }// end if
        }// end if
    }

// end function

    /**
     * 获取access_token
     * @return type
     */
    private function getAccessToken() {
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" .
            $this->appid . "&secret=" . $this->app_secret;
        $content = file_get_contents($url);
        $content = json_decode($content);
        return $content;
    }

// end function

    /**
     * 网页授权方式获取用户基本信息
     * @param type $code
     * @return type
     */
    public function getUserInfoByWeb($code) {
        $get_access_token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' .
            $this->appid . '&secret=' . $this->app_secret . '&code=' .
            $code . '&grant_type=authorization_code';
        $content = file_get_contents($get_access_token_url);
        $content = json_decode($content);
        return $content;
    }

    /**
     * 通过openid获取用户信息
     * @param $openid
     */
    public function getUserInfo($openid){
        $url = sprintf('https://api.weixin.qq.com/cgi-bin/user/info?access_token=%s&openid=%s&lang=zh_CN', $this->getLocalAccessToken(), $openid);
        $content = file_get_contents($url);
        $content = json_decode($content);
        return $content;
    }

    /**
     * 获取用户列表（前10000条记录）
     * @return mixed|string
     */
    public function getUserList(){

        $access_token = $this->getLocalAccessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/user/get?access_token='.$access_token;
        $content = file_get_contents($url);
        $content = json_decode($content);

        return $content;
    }

    /**
     * 获取缓存在本地的accessToken
     */
    private function getLocalAccessToken(){
        $cache_file = __DIR__ . '/weixin.json';

        $file_content = file_get_contents($cache_file);
        $json = json_decode($file_content);
        return $json->access_token;
    }

    /**
     * 请求授权码
     *
     * @param string $mode 授权码获取模式：snsapi_base - 网页授权，snsapi_userinfo - 用户授权
     * @param string $callback_url 授权回调网址
     * 这个函数执行到最后会有一个exit()操作
     */
    public function requestAuthCode($scope = 'snsapi_base', $callback_url) {
//        $callback_url = 'http://www.secretweapon.cn/index.php?r=kanjia/index';
        $master_openid = Yii::$app->request->get('master_openid');
        if ($master_openid != null && $master_openid != '') {
            $callback_url = $callback_url . '&master_openid=' . $master_openid;
        }
//                $authorization_url = $this->weixin->getAuthUrl($callback_url);
        if ($scope == 'snsapi_base') {
            $authorization_url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $this->appid .
                '&redirect_uri=' . urlencode($callback_url) .
                '&response_type=code&scope=snsapi_base&state=123#wechat_redirect';
        } else {
            $authorization_url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $this->appid .
                '&redirect_uri=' . urlencode($callback_url) .
                '&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect';
        }

        header("Location: $authorization_url");
        exit();
    }



    /**
     * 设置用户关注订阅时的响应消息
     * @param $msg
     */
    public function setOnSubscribeMsg($msg){
        $this->onSubscribeMsg = $msg;
    }



    /**
     * 设置用户关注订阅时的响应回调
     * @param $callback
     */
    public function setOnSubscribeListener($callback){
        $this->onSubscribeCallback = $callback;
    }

    /**
     * 设置用户取消订阅时的响应回调
     * @param $callback
     */
    public function setOnUnsubscribeListener($callback){
        $this->onUnsubscribeCallback = $callback;
    }

    public function addOnKeywordListener($keyword, $callback){
        $this->onKeywordCallbacks[$keyword] = $callback;
    }

    /**
     * 添加场景监听
     * @param $scene
     * @param $callback
     */
    public function addOnSceneListener($scene, $callback){
        $this->onSceneCallback[$scene] = $callback;
    }

    /**
     * 添加扫描二维码监听
     * @param $scene
     * @param $callback
     */
    public function addOnScanListener($scene, $callback){
        $this->onScanCallback[$scene] = $callback;
    }
    /**
     * 处理微信事件和推送
     */
    public function responseMsg() {
        Log::info('在Weixin类中响应事件');
        $message = file_get_contents('php://input');

        if (empty($message)) {
            return;
        }

        libxml_disable_entity_loader(true);

        $postObj = simplexml_load_string($message, 'SimpleXMLElement', LIBXML_NOCDATA);
        $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;

        $msgType = $postObj->MsgType != null ? $postObj->MsgType : '';
        $contentStr = $postObj->Content != null ? $postObj->Content : '';
        $event = $postObj->Event != null ? $postObj->Event : '';
        $eventKey = $postObj->EventKey != null ? $postObj->EventKey : '';
        $time = time();

        // 处理消息
//        $resultStr = '';    // 如果最终没有处理该消息的话，就返回一个空字符串
        $resultStr = 'success';    // 如果最终没有处理该消息的话，就返回一个空字符串
        if ($msgType == 'text') {
            Log::info('进入text处理分支 ');
            foreach ($this->onKeywordCallbacks as $keyword=>$callback){
                if($keyword == $contentStr){
                    Log::info('符合关键词条件');
                    $contentStr = call_user_func($callback, $fromUsername);     // 附上用户的openid传回去
                    $resultStr = sprintf($this->textTpl, $fromUsername, $toUsername, $time, $contentStr);
                    Log::info('关键词触发输出:' + $resultStr);
                }
            }
//            // 如果不是关键词的话，就进行多客服转发
//            $this->transferCustomerService($fromUsername, $toUsername);
//            $resultStr = sprintf($this->textTpl, $fromUsername, $toUsername, $time, $contentStr);
        }
        else if($msgType == 'event' && $event == 'subscribe' && strpos($eventKey, 'qrscene_') === 0){   // 未关注情况下扫描场景二维码
            // 回复带参数二维码扫描
            $scene_key = str_replace('qrscene_', '', $eventKey);
            foreach ($this->onSceneCallback as $scene=>$callback){
                if($scene == $scene_key){
                    $contentStr = call_user_func_array($callback, array($fromUsername));
                    $resultStr = sprintf($this->textTpl, $fromUsername, $toUsername, $time, $contentStr);
                }
            }
        }
        else if($msgType == 'event' && $event == 'subscribe'){
            Log::info('weixin类有触发关注事件');
            if($this->onSubscribeCallback != null){
                call_user_func_array($this->onSubscribeCallback, array($fromUsername));
            }

            if($this->onSubscribeMsg != null){
                $contentStr = $this->onSubscribeMsg;
                $resultStr = sprintf($this->textTpl, $fromUsername, $toUsername, $time, $contentStr);
            }
        }
        else if($msgType == 'event' && $event == 'unsubscribe'){
            Log::info('weixin类有触发取消关注事件');
            if($this->onUnsubscribeCallback != null){
                call_user_func_array($this->onUnsubscribeCallback, array($fromUsername));
            }
//            $contentStr = "为什么要取消关注……";
//            $resultStr = sprintf($this->textTpl, $fromUsername, $toUsername, $time, $contentStr);
        }
        else if($msgType == 'event' && $event == 'SCAN'){
            $scene_key = $eventKey;
            foreach ($this->onScanCallback as $scene=>$callback){
                if($scene == $scene_key){
                    $contentStr = call_user_func($callback, $fromUsername);
                    $resultStr = sprintf($this->textTpl, $fromUsername, $toUsername, $time, $contentStr);
                }
            }
        }

//        Log::info('最终输出:' + $resultStr);
        echo $resultStr;
        exit;
    }

//    /**
//     * 处理微信事件和推送
//     */
//    public function responseMsg() {
//
//        if (!empty($GLOBALS['HTTP_RAW_POST_DATA'])) {
//
//            /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
//              the best way is to check the validity of xml by yourself */
//            libxml_disable_entity_loader(true);
//            $postObj = simplexml_load_string($GLOBALS['HTTP_RAW_POST_DATA'], 'SimpleXMLElement', LIBXML_NOCDATA);
//            $fromUsername = $postObj->FromUserName;
//            $toUsername = $postObj->ToUserName;
//            $msgType = $postObj->MsgType;
//
//            // 处理事件
//                else{
//                    // 进行多客服转发
//                    // ...多客服转发的时候，接收方和发送方和收到消息的时候是刚好反过来的
//                    $this->transferCustomerService($fromUsername, $toUsername);
//                }
//
////                echo $postStr;
//            } else {
//                echo "";
//                exit;
//            }// end if
//        }// end if
//    }// end function

    /**
     * 多客服消息转发
     */
    private function transferCustomerService($toUsername, $fromUsername) {
        $textTpl = "<xml>
            <ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%s</CreateTime>
            <MsgType><![CDATA[transfer_customer_service]]></MsgType>
            </xml>";

        // 转发到多客服
        $time = time();
        $resultStr = sprintf($textTpl, $toUsername, $fromUsername, $time);
        echo $resultStr;
    }

    private function responseMenuEvent($toUsername, $fromUsername, $eventKey) {
        $textTpl = "<xml>
               <ToUserName><![CDATA[%s]]></ToUserName>
               <FromUserName><![CDATA[%s]]></FromUserName>
               <CreateTime>%s</CreateTime>
               <MsgType><![CDATA[text]]></MsgType>
               <Content><![CDATA[%s]]></Content>
               <FuncFlag>0</FuncFlag>
               </xml>";

        // 输出答复信息
        $time = time();
        switch ($eventKey) {
            case 'MENU_TMALL':
                $contentStr = "复制链接 mimiwuqi.tmall.com 到浏览器打开即可";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $contentStr);
                echo $resultStr;
                break;

            case 'MENU_CONSULTING':
                $contentStr = "Secret Weapon秘密武器欢迎您的咨询，我们的在线服务时间是周一至周六早8:30~晚17:30，如果我们未能及时回复您，请您直接留言，您的留言非常重要，我们会第一时间联系您，您也可以拨打客服电话4000333238或0754-83781888，我们将竭诚为您服务~";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $contentStr);
                echo $resultStr;
                break;
        }
        exit;
    }
}