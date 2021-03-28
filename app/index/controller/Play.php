<?php
/*
'--------------------------------------------------------
'软件名称：ZJVideo
'开发作者：Jerry
*官方网站：https://blog.jerryiweb.com/
'--------------------------------------------------------
*/

namespace app\index\controller;

use think\facade\View;
use app\BaseController;
use think\facade\Config;
use think\Request;
use think\facade\Cache;

class Play extends BaseController
{
    public function index(Request $request)
    {
        $id = $request->param('id');
        $type = $request->param('type');
        $urlid = $request->param('urlid');
        switch ($type) {
            case 'tv':     // 电视剧
                {
                    if ($urls = Cache::get('Play' . $urlid . 'urls') and $url = Cache::get('Play' . $urlid . 'url')) {
                        View::assign('urls', $urls);
                        View::assign('id', $id);
                        View::assign('type', $type);
                        View::assign('urlid', $urlid);
                        View::assign('url', $url);
                        $config = Config::get('config.seo');
                        $seo = [
                            'title' => $config['title'],
                            'description' => $config['description'],
                            'keywords' => $config['keywords']
                        ];
                        View::assign('seo', $seo);
                        return View::fetch();
                    } else {
                        $urlbase64 = $request->param('urlbase64');
                        $url = base64_decode($urlbase64);
                        $apis = Config::get('api.jx');
                        $url = $apis[0] . $url; //接口
                        $videoLink = "http://www.360kan.com/" . $type . "/" . $urlid . ".html";
                        $content = $this->videoCurl($videoLink);
                        preg_match('/<div class="num-tab-main g-clear js-tab" style="display:none;">(.*)<\/div>/sU', $content, $urls);
                        if ($urls == []) {
                            preg_match('/<div class="num-tab-main g-clear js-tab">(.*)<\/div>/sU', $content, $urls);
                        }
                        preg_match_all('/<a data-num="(\d+)" data-daochu="(.*)" href="(.*)\?(.*)" monitor-shortpv-c-sub="(.*)">/sU', $urls[1], $urls);
                        $nums = $urls[1];  //集数
                        $urls = $urls[3]; //视频链接
                        $newdata = array();
                        $len = count($nums);
                        for ($i = 0; $i < $len; $i++) {
                            $newdata[$nums[$i]] = $urls[$i];
                        }
                        if (!empty($newdata)) {
                            View::assign('urls', $urls);
                        }
                        View::assign('id', $id);
                        View::assign('type', $type);
                        View::assign('urlid', $urlid);
                        View::assign('url', $url);
                        Cache::set('Play' . $urlid . 'urls', $urls);
                        Cache::set('Play' . $urlid . 'url', $url);
                        $config = Config::get('config.seo');
                        $seo = [
                            'title' => $config['title'],
                            'description' => $config['description'],
                            'keywords' => $config['keywords']
                        ];
                        View::assign('seo', $seo);
                        return View::fetch();
                    }
                    break;
                }
            case 'm': {
                    if ($urls = Cache::get('Play' . $urlid . 'urls') and $url = Cache::get('Play' . $urlid . 'url')) {
                        View::assign('urls', $urls);
                        View::assign('id', $id);
                        View::assign('type', $type);
                        View::assign('urlid', $urlid);
                        View::assign('url', $url);
                        $config = Config::get('config.seo');
                        $seo = [
                            'title' => $config['title'],
                            'description' => $config['description'],
                            'keywords' => $config['keywords']
                        ];
                        View::assign('seo', $seo);
                        return View::fetch();
                    } else {
                        $urlbase64 = $request->param('urlbase64');
                        $url = base64_decode($urlbase64);
                        $apis = Config::get('api.jx');
                        $url = $apis[0] . $url; //接口
                        $videoLink = "http://www.360kan.com/" . $type . "/" . $urlid . ".html";
                        $content = $this->videoCurl($videoLink);
                        preg_match_all('/<a data-daochu="(.*)" href=\"(.*)\?(.*)\" class=\"js-site-btn btn btn-play\" monitor-shortpv-c-sub=\"tab_立即播放\">立即播放<\/a>/sU', $content, $urls);
                        $urls = $urls[2]; //链接
                        $nums = $urls;  //集数
                        $newdata = array();
                        $len = count($nums);
                        for ($i = 0; $i < $len; $i++) {
                            $newdata[($i + 1)] = $urls[$i];
                        }
                        if (!empty($newdata)) {
                            View::assign('urls', $urls);
                        }
                        View::assign('id', $id);
                        View::assign('type', $type);
                        View::assign('urlid', $urlid);
                        View::assign('url', $url);
                        Cache::set('Play' . $urlid . 'urls', $urls);
                        Cache::set('Play' . $urlid . 'url', $url);
                        $config = Config::get('config.seo');
                        $seo = [
                            'title' => $config['title'],
                            'description' => $config['description'],
                            'keywords' => $config['keywords']
                        ];
                        View::assign('seo', $seo);
                        return View::fetch();
                    }
                    break;
                }
            case 'ct': {
                    if ($urls = Cache::get('Play' . $urlid . 'urls') and $url = Cache::get('Play' . $urlid . 'url')) {
                        View::assign('urls', $urls);
                        View::assign('id', $id);
                        View::assign('type', $type);
                        View::assign('urlid', $urlid);
                        View::assign('url', $url);
                        $config = Config::get('config.seo');
                        $seo = [
                            'title' => $config['title'],
                            'description' => $config['description'],
                            'keywords' => $config['keywords']
                        ];
                        View::assign('seo', $seo);
                        return View::fetch();
                    } else {
                        $urlbase64 = $request->param('urlbase64');
                        $url = base64_decode($urlbase64);
                        $apis = Config::get('api.jx');
                        $url = $apis[0] . $url; //接口
                        $videoLink = "http://www.360kan.com/" . $type . "/" . $urlid . ".html";
                        $content = $this->videoCurl($videoLink);
                        preg_match_all('/<div class="js-series-all m-series-number-container" style="display: none;" data-daochu="(.*)">(.*)<\/div><\/div><\/div>/sU', $content, $urls);
                        if ($urls[0] == []) {
                            preg_match('/<div class=\"m-series-number-container g-clear\" data-daochu=\"(.*)\">(.*)<\/div><\/div>/sU', $content, $urls);
                            preg_match_all('/<a data-num=\"(.*)\"data-daochu=\"(.*)\" href=\"(.*)\?/sU', $urls[2], $urls);
                        } else {
                            preg_match_all('/<a data-num=\"(.*)\"data-daochu=\"(.*)\" href=\"(.*)\?/sU', $urls[2][0], $urls);
                        }
                        $nums = $urls[1];  //集数
                        $urls = $urls[3]; //视频链接
                        $newdata = array();
                        $len = count($nums);
                        for ($i = 0; $i < $len; $i++) {
                            $newdata[($i + 1)] = $urls[$i];
                        }
                        if (!empty($newdata)) {
                            View::assign('urls', $urls);
                        }
                        View::assign('id', $id);
                        View::assign('type', $type);
                        View::assign('urlid', $urlid);
                        View::assign('url', $url);
                        Cache::set('Play' . $urlid . 'urls', $urls);
                        Cache::set('Play' . $urlid . 'url', $url);
                        $config = Config::get('config.seo');
                        $seo = [
                            'title' => $config['title'],
                            'description' => $config['description'],
                            'keywords' => $config['keywords']
                        ];
                        View::assign('seo', $seo);
                        return View::fetch();
                    }
                    break;
                }
            case 'va': {
                    if ($urls = Cache::get('Play' . $urlid . 'urls') and $url = Cache::get('Play' . $urlid . 'url')) {
                        View::assign('urls', $urls);
                        View::assign('id', $id);
                        View::assign('type', $type);
                        View::assign('urlid', $urlid);
                        View::assign('url', $url);
                        $config = Config::get('config.seo');
                        $seo = [
                            'title' => $config['title'],
                            'description' => $config['description'],
                            'keywords' => $config['keywords']
                        ];
                        View::assign('seo', $seo);
                        return View::fetch();
                    } else {
                        $urlbase64 = $request->param('urlbase64');
                        $url = base64_decode($urlbase64);
                        $apis = Config::get('api.jx');
                        $url = $apis[0] . $url; //接口
                        $videoLink = "http://m.360kan.com/" . $type . "/" . $urlid . ".html";
                        $content = $this->videoCurl($videoLink);
                        preg_match_all('/<a href=\"(.*)(\?(.*))?\" class="/sU', $content, $urls);
                        $nums = $urls[1];  //集数
                        $urls = $urls[1]; //视频链接
                        $newdata = array();
                        $len = count($nums) - 1;
                        for ($i = 1; $i < $len; $i++) {
                            $newdata[$i] = $urls[$i];
                        }
                        if (!empty($newdata)) {
                            View::assign('urls', $newdata);
                        }
                        View::assign('id', $id);
                        View::assign('type', $type);
                        View::assign('urlid', $urlid);
                        View::assign('url', $url);
                        Cache::set('Play' . $urlid . 'urls', $urls);
                        Cache::set('Play' . $urlid . 'url', $url);
                        $config = Config::get('config.seo');
                        $seo = [
                            'title' => $config['title'],
                            'description' => $config['description'],
                            'keywords' => $config['keywords']
                        ];
                        View::assign('seo', $seo);
                        return View::fetch();
                    }
                    break;
                }
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
