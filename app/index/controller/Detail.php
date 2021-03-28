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
use think\Request;
use think\facade\Cache;
use think\facade\Config;
class Detail extends BaseController
{
    public function index(Request $request)
    {
        $type = $request->param('type');
        $urlid = $request->param('urlid');
        switch ($type) {
            case 'tv':     // 电视剧
                {
                    if ($urls = Cache::get('Detail' . $urlid . 'urls') and $detail = Cache::get('Detail' . $urlid . 'detail')) {
                        View::assign('detail', $detail);
                        View::assign('urls', $urls);
                        View::assign('type', $type);
                        View::assign('urlid', $urlid);
                        $config = Config::get('config.seo');
                        $seo = [
                            'title' => $config['title'],
                            'description' => $config['description'],
                            'keywords' => $config['keywords']
                        ];
                        View::assign('seo', $seo);
                        return View::fetch();
                    } else {
                        $videoLink = "http://www.360kan.com/" . $type . "/" . $urlid . ".html";
                        $content = $this->videoCurl($videoLink);
                        preg_match('/<div class="num-tab-main g-clear js-tab" style="display:none;">(.*)<\/div>/sU', $content, $urls);
                        if ($urls == []) {
                            preg_match('/<div class="num-tab-main g-clear js-tab">(.*)<\/div>/sU', $content, $urls);
                        }
                        preg_match_all('/<a data-num="(\d+)" data-daochu="(.*)" href="(.*)" monitor-shortpv-c-sub="(.*)">/sU', $urls[1], $urls);
                        $nums = $urls[1];  //集数
                        $urls = $urls[3]; //视频链接
                        preg_match('#<a class="name" href="(.*)" monitor-shortpv-c-sub="tab_导演_(.*)">(.*)</a>#', $content, $monitor);
                        $monitor = $monitor[2];  //导演
                        preg_match('/<div class="item-desc-wrap g-clear js-close-wrap" style="display:none;"><span>简介 ：<\/span><p class="item-desc">(.*)<a href="#" class="js-close btn" monitor-shortpv-c-sub="tab_收起">收起&lt;&lt;<\/a><\/p>/U', $content, $desc);
                        $desc = $desc[1]; //简介
                        $desc = mb_strlen($desc) > 120 ? mb_substr($desc, 0, 120) . "******" : $desc;
                        preg_match('#<span>年代 ：</span>(.*)</p>#', $content, $year);
                        $year = $year[1]; //年代
                        preg_match('/<div class="s-cover" data-block="tj-cover"  id=\'js-s-cover\'>(.*)<\/div>/sU', $content, $img);
                        preg_match('/<img src="(.*)">/sU', $img[1], $img);
                        $img = $img[1]; //图片
                        preg_match('/<div class="title-left g-clear">(.*)<\/div>/sU', $content, $title);
                        preg_match('/<h1>(.*)<\/h1>/sU', $title[1], $title);
                        $title = $title[1]; //标题
                        $newdata = array();
                        $len = count($nums);
                        for ($i = 0; $i < $len; $i++) {
                            $newdata[$nums[$i]] = explode('?', $urls[$i])[0];
                        }
                        $detail = [
                            'title' => $title,
                            'monitor' => $monitor,
                            'year' => $year,
                            'desc' => $desc,
                            'img' => $img
                        ];
                        View::assign('detail', $detail);
                        View::assign('urls', $newdata);
                        View::assign('type', $type);
                        View::assign('urlid', $urlid);
                        Cache::set('Detail' . $urlid . 'urls', $newdata);
                        Cache::set('Detail' . $urlid . 'detail', $detail);
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
            case 'm':     // 电影
                {
                    if ($urls = Cache::get('Detail' . $urlid . 'urls') and $detail = Cache::get('Detail' . $urlid . 'detail')) {
                        View::assign('detail', $detail);
                        View::assign('urls', $urls);
                        View::assign('type', $type);
                        View::assign('urlid', $urlid);
                        $config = Config::get('config.seo');
                        $seo = [
                            'title' => $config['title'],
                            'description' => $config['description'],
                            'keywords' => $config['keywords']
                        ];
                        View::assign('seo', $seo);
                        return View::fetch();
                    } else {
                        $videoLink = "http://www.360kan.com/" . $type . "/" . $urlid . ".html";
                        $content = $this->videoCurl($videoLink);
                        preg_match_all('/<a data-daochu="(.*)" href=\"(.*)\?(.*)\" class=\"js-site-btn btn btn-play\" monitor-shortpv-c-sub=\"tab_立即播放\">立即播放<\/a>/sU', $content, $urls);
                        $urls = $urls[2]; //链接
                        $nums = $urls;  //集数
                        preg_match('/<a class=\"name\" href=\"(.*)\" monitor-shortpv-c-sub="tab_导演_(.*)">(.*)<\/a>/sU', $content, $monitor);
                        if ($monitor == []) {
                            preg_match('/<p class="item">\r?\n?\s*?<span>导演 ：<\/span>\r?\n?\s*?(.*)\r?\n?\s*?<\/p>/sU', $content, $monitor);
                            $monitor = $monitor[1];
                        } else {
                            $monitor = $monitor[2];  //导演
                        }
                        preg_match('/<span>简介 ：<\/span><p class=\"item-desc\">(.*)<a href=\"#\" class=\"js-close btn\"/U', $content, $desc);
                        if ($desc == []) {
                            preg_match('/style=\"display:none;\"><span>简介 ：<\/span><p class=\"item-desc\">(.*)\r?\n?\s*?(.*)<a href=\"#\" class=\"js-close btn\"/sU', $content, $desc);
                            $desc = $desc[2];
                            $desc = mb_strlen($desc) > 120 ? mb_substr($desc, 0, 120) . "******" : $desc;
                        } else {
                            $desc = $desc[1]; //简介
                            $desc = mb_strlen($desc) > 120 ? mb_substr($desc, 0, 120) . "******" : $desc;
                        }
                        // return json($desc);
                        preg_match('/<p class=\"item\"><span>年代 ：<\/span>(.*)<\/p>/sU', $content, $year);
                        $year = $year[1]; //年代
                        preg_match('/<div class="s-cover" data-block="tj-cover"  id=\'js-s-cover\'>(.*)<\/div>/sU', $content, $img);
                        preg_match('/<img src=\"(.*)\">/sU', $img[1], $img);
                        $img = $img[1]; //图片
                        preg_match('/<div class="title-left g-clear">(.*)<\/div>/sU', $content, $title);
                        preg_match('/<h1>(.*)<\/h1>/sU', $title[1], $title);
                        $title = $title[1]; //标题
                        $newdata = array();
                        $len = count($nums);
                        for ($i = 0; $i < $len; $i++) {
                            $newdata[($i + 1)] = $urls[$i];
                        }
                        $detail = [
                            'title' => $title,
                            'monitor' => $monitor,
                            'year' => $year,
                            'desc' => $desc,
                            'img' => $img
                        ];
                        View::assign('detail', $detail);
                        View::assign('urls', $newdata);
                        View::assign('type', $type);
                        View::assign('urlid', $urlid);
                        Cache::set('Detail' . $urlid . 'urls', $newdata);
                        Cache::set('Detail' . $urlid . 'detail', $detail);
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
            case 'ct':     // 动漫
                {
                    if ($urls = Cache::get('Detail' . $urlid . 'urls') and $detail = Cache::get('Detail' . $urlid . 'detail')) {
                        View::assign('detail', $detail);
                        View::assign('urls', $urls);
                        View::assign('type', $type);
                        View::assign('urlid', $urlid);
                        $config = Config::get('config.seo');
                        $seo = [
                            'title' => $config['title'],
                            'description' => $config['description'],
                            'keywords' => $config['keywords']
                        ];
                        View::assign('seo', $seo);
                        return View::fetch();
                    } else {
                        $videoLink = "http://www.360kan.com/" . $type . "/" . $urlid . ".html";
                        $content = $this->videoCurl($videoLink);
                        preg_match_all('/<div class="js-series-all m-series-number-container" style="display: none;" data-daochu="(.*)">(.*)<\/div><\/div><\/div>/sU', $content, $urls);
                        if ($urls[0] == []) {
                            preg_match_all('/<div class=\"m-series-number-container g-clear\" data-daochu=\"(.*)\">(.*)<\/div><\/div>/sU', $content, $urls);
                        }
                        preg_match_all('/<a data-num=\"(.*)\"data-daochu=\"(.*)\" href=\"(.*)\"/sU', $urls[2][0], $urls);
                        $nums = $urls[1];  //集数
                        $urls = $urls[3]; //视频链接
                        preg_match('/<a class=\"name\" href=\"(.*)\" monitor-shortpv-c-sub="tab_导演_(.*)">(.*)<\/a>/sU', $content, $monitor);
                        if ($monitor == []) {
                            $monitor = "未知";
                        } else {
                            $monitor = $monitor[2];  //导演
                        }
                        preg_match('/style=\"display:none;\"><span>简介 ：<\/span><p class=\"item-desc\">(.*)(\r)?<a href=\"#\" class=\"js-close btn\"/sU', $content, $desc);
                        $desc = $desc[1]; //简介
                        $desc = mb_strlen($desc) > 120 ? mb_substr($desc, 0, 120) . "******" : $desc;
                        preg_match('/<p class=\"item\"><span>年代 ：<\/span>(.*)<\/p>/sU', $content, $year);
                        $year = $year[1]; //年代
                        preg_match('/<div class="s-cover" data-block="tj-cover"  id=\'js-s-cover\'>(.*)<\/div>/sU', $content, $img);
                        preg_match('/<img src=\"(.*)\">/sU', $img[1], $img);
                        $img = $img[1]; //图片
                        preg_match('/<div class="title-left g-clear">(.*)<\/div>/sU', $content, $title);
                        preg_match('/<h1>(.*)<\/h1>/sU', $title[1], $title);
                        $title = $title[1]; //标题
                        $newdata = array();
                        $len = count($nums);
                        for ($i = 0; $i < $len; $i++) {
                            $newdata[($i + 1)] = explode('?', $urls[$i])[0];
                        }
                        $detail = [
                            'title' => $title,
                            'monitor' => $monitor,
                            'year' => $year,
                            'desc' => $desc,
                            'img' => $img
                        ];
                        View::assign('detail', $detail);
                        View::assign('urls', $newdata);
                        View::assign('type', $type);
                        View::assign('urlid', $urlid);
                        Cache::set('Detail' . $urlid . 'urls', $newdata);
                        Cache::set('Detail' . $urlid . 'detail', $detail);
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
            case 'va':     // 综艺
                {
                    if ($urls = Cache::get('Detail' . $urlid . 'urls') and $detail = Cache::get('Detail' . $urlid . 'detail')) {
                        View::assign('detail', $detail);
                        View::assign('urls', $urls);
                        View::assign('type', $type);
                        View::assign('urlid', $urlid);
                        $config = Config::get('config.seo');
                        $seo = [
                            'title' => $config['title'],
                            'description' => $config['description'],
                            'keywords' => $config['keywords']
                        ];
                        View::assign('seo', $seo);
                        return View::fetch();
                    } else {
                        $videoLink = "http://m.360kan.com/" . $type . "/" . $urlid . ".html";
                        $content = $this->videoCurl($videoLink, $timeout = 10, $user_agent = "Mozilla/5.0 (Linux; Android 10; JEF-AN20; HMSCore 5.2.0.303) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.106 HuaweiBrowser/11.0.8.301 Mobile Safari/537.36");
                        preg_match('/<div class="hide js-series-list0" style="display:block">(.*)<a href="javascript/sU', $content, $urls);
                        if ($urls[0] == []) {
                            preg_match_all('/<div class=\"m-series-number-container g-clear\" data-daochu=\"(.*)\">(.*)<\/div><\/div>/sU', $content, $urls);
                        } else {
                            preg_match_all('/<a href="(.*)(\?(.*))?" class="(.*)" >/sU', $urls[1], $urls);
                        }
                        $nums = $urls[1];  //集数
                        $urls = $urls[1]; //视频链接
                        preg_match('/<p>\r?\n?\s*?<label>主持人：<\/label>\r?\n?\s*?(.*)\r?\n?\s*?<\/p>/sU', $content, $monitor);
                        if ($monitor == []) {
                            $monitor = "未知";
                        } else {
                            $monitor = $monitor[1];  //主持人
                        }
                        preg_match('/<div class="img">\r?\n?\s*?<img src="(.*)">\r?\n?\s*?<\/div>/sU', $content, $img);
                        $img = $img[1]; //图片
                        preg_match('/<h3>\r?\n?\s*?(.*)\r?\n?\s*?<\/h3>/sU', $content, $title);
                        $title = $title[1]; //标题
                        $newdata = array();
                        $len = count($nums);
                        for ($i = 0; $i < $len; $i++) {
                            $newdata[($i + 1)] = explode('?', $urls[$i])[0];
                        }
                        $detail = [
                            'title' => $title,
                            'monitor' => $monitor,
                            'img' => $img
                        ];
                        View::assign('detail', $detail);
                        View::assign('urls', $newdata);
                        View::assign('type', $type);
                        View::assign('urlid', $urlid);
                        Cache::set('Detail' . $urlid . 'urls', $newdata);
                        Cache::set('Detail' . $urlid . 'detail', $detail);
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
    private function videoCurl($url, $timeout = 10, $user_agent = "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.94 Safari/537.36")
    {
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
