<?php
/*
'--------------------------------------------------------
'软件名称：ZJVideo
'开发作者：Jerry
*官方网站：https://blog.jerryiweb.com/
'--------------------------------------------------------
*/

namespace app\index\controller;

use app\BaseController;
use think\facade\View;
use think\Request;
use think\facade\Config;

class Search extends BaseController
{
    public function index(Request $request)
    {
        $title = $request->param('title');
        $url = "https://so.360kan.com/index.php?kw=" . $title;
        $content = $this->videoCurl($url);
        preg_match('/<div class="m-mainpic">/', $content, $isset);
        $detail = [];
        if ($isset != []) {
            preg_match_all('/<div class=\"m-mainpic\">(.*)<\/div><\/div><\/div><\/div>/sU', $content, $videos);
            $videos = $videos[1];
            preg_match_all('/<i>简&nbsp;&nbsp;介&nbsp;：<\/i>\n?\s*?(.*)<\/p>/sU', $content, $detail['desc']);
            $detail['desc'] = $detail['desc'][1];
            preg_match_all('/<span class=\"playtype\">(.*)·(.*)<\/span>/sU', $content, $detail['type']);
            $detail['time'] = $detail['type'][2];
            $detail['type'] = $detail['type'][1];
            preg_match_all('/<div class="m-mainpic">(.*)<a href=\"(.*)\" class=\"g-playicon js-playicon\" title=\"(.*)\"/sU', $content, $detail['title']);
            $detail['url'] = $detail['title'][2];
            $detail['title'] = $detail['title'][3];
            preg_match_all('/data-longrecord="(.*)">\r?\s*?<img src="(.*)" alt="(...*)" \/>/sU', $content, $detail['img']);
            $detail['img'] = $detail['img'][2];
            $newdata = [];
            for ($i = 0; $i < count($detail['time']); $i++) {
                $detail['desc'][$i] = str_replace('<p>', '', $detail['desc'][$i]);
                $detail['desc'][$i] = mb_strlen($detail['desc'][$i]) > 80 ? mb_substr($detail['desc'][$i], 0, 80) . "******" : $detail['desc'][$i];
                $newdata[$i] = [
                    'title' => $detail['title'][$i],
                    'time' => $detail['time'][$i],
                    'desc' => $detail['desc'][$i],
                    'img' => $detail['img'][$i],
                    'type' => $detail['type'][$i],
                    'urlid' => explode('.', explode('/', $detail['url'][$i])[4])[0],
                ];
            }
            View::assign('data', $newdata);
            $config = Config::get('config.seo');
            $seo = [
                'title' => $config['title'],
                'description' => $config['description'],
                'keywords' => $config['keywords']
            ];
            View::assign('seo', $seo);
            return View::fetch();
        }
    }
    //CURL
    private function videoCurl($url, $timeout = 10)
    {
        $user_agent = "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.94 Safari/537.36";
        $curl = curl_init();                                        //初始化 curl
        curl_setopt($curl, CURLOPT_URL, $url);                      //要访问网页 URL 地址
        curl_setopt($curl, CURLOPT_USERAGENT, $user_agent);            //模拟用户浏览器信息 
        curl_setopt($curl, CURLOPT_REFERER, $url);                  //伪装网页来源 URL
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);                 //当Location:重定向时，自动设置header中的Referer:信息                   
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);              //数据传输的最大允许时间 
        curl_setopt($curl, CURLOPT_HEADER, 0);                      //不返回header部分
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);              //返回字符串，而非直接输出到屏幕上
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);               //跟踪爬取重定向页面
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, '0');            //不检查 SSL 证书来源
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, '0');            //不检查 证书中 SSL 加密算法是否存在
        curl_setopt($curl, CURLOPT_ENCODING, '');                    //解决网页乱码问题
        $content = curl_exec($curl);
        curl_close($curl);
        return $content;
    }
}
