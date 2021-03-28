<?php
/*
'--------------------------------------------------------
'软件名称：ZJVideo
'开发作者：Jerry
*官方网站：https://blog.jerryiweb.com/
'--------------------------------------------------------
*/

namespace app\index\controller;
use think\facade\Config;
use app\BaseController;
use think\facade\View;
use think\facade\Cache;

class Index extends BaseController
{
    public function index()
    {
        $type = "dianshi";
        if ($list1 = Cache::get('Indexlist1')) {
            View::assign('tv', $list1);
        } else {
            $vlist = 'http://www.360kan.com/' . $type . '/list.php?cat=all&year=all&area=all&act=all&rank=all&pageno=1';
            $fcon = $this->videoCurl($vlist);
            preg_match_all('#<span class="s1">(.*?)</span>#', $fcon, $xarr0);
            preg_match_all('#<a class="js-tongjic" href="(.*?)">#', $fcon, $xarr1);
            preg_match_all('#<img src="(.*?)">#', $fcon, $xarr3);
            $xname = $xarr0[1]; //名字
            $xlist = $xarr1[1]; //链接
            $ximg = $xarr3[1]; //图片
            for ($i = 0; $i < 12; $i++) {
                if (isset($xlist[$i])) {
                    $xlist[$i] = explode("\"", $xlist[$i])[0];
                }
                $list1[] = array(
                    'url' => 'http://www.360kan.com' . $xlist[$i],
                    'name' => $xname[$i],
                    'img' => $ximg[($i + 1)],
                    'type' => explode('/', $xlist[$i])[1],
                    'urlid' => explode('.', explode('/', $xlist[$i])[2])[0],
                );
            }
            if (!empty($list1)) {
                View::assign('tv', $list1);
            }
            Cache::set('Indexlist1',$list1);
        }
        $type = "dianying";
        if ($list2 = Cache::get('Indexlist2')) {
            View::assign('dy', $list2);
        } else {
            $vlist = 'http://www.360kan.com/' . $type . '/list.php?cat=all&year=all&area=all&act=all&rank=all&pageno=1';
            $fcon = $this->videoCurl($vlist);
            preg_match_all('#<span class="s1">(.*?)</span>#', $fcon, $xarr0);
            preg_match_all('#<a class="js-tongjic" href="(.*?)">#', $fcon, $xarr1);
            preg_match_all('#<img src="(.*?)">#', $fcon, $xarr3);
            $xname = $xarr0[1]; //名字
            $xlist = $xarr1[1]; //链接
            $ximg = $xarr3[1]; //图片
            for ($i = 0; $i < 12; $i++) {
                if (isset($xlist[$i])) {
                    $xlist[$i] = explode("\"", $xlist[$i])[0];
                }
                $list2[] = array(
                    'url' => 'http://www.360kan.com' . $xlist[$i],
                    'name' => $xname[$i],
                    'img' => $ximg[($i + 1)],
                    'type' => explode('/', $xlist[$i])[1],
                    'urlid' => explode('.', explode('/', $xlist[$i])[2])[0],
                );
            }
            if (!empty($list2)) {
                View::assign('dy', $list2);
            }
            Cache::set('Indexlist2',$list2);
        }
        $type = "dongman";
        if ($list3 = Cache::get('Indexlist3')) {
            View::assign('dm', $list3);
        } else {
            $vlist = 'http://www.360kan.com/' . $type . '/list.php?cat=all&year=all&area=all&act=all&rank=all&pageno=1';
            $fcon = $this->videoCurl($vlist);
            preg_match_all('#<span class="s1">(.*?)</span>#', $fcon, $xarr0);
            preg_match_all('#<a class="js-tongjic" href="(.*?)">#', $fcon, $xarr1);
            preg_match_all('#<img src="(.*?)">#', $fcon, $xarr3);
            $xname = $xarr0[1]; //名字
            $xlist = $xarr1[1]; //链接
            $ximg = $xarr3[1]; //图片
            for ($i = 0; $i < 12; $i++) {
                if (isset($xlist[$i])) {
                    $xlist[$i] = explode("\"", $xlist[$i])[0];
                }
                $list3[] = array(
                    'url' => 'http://www.360kan.com' . $xlist[$i],
                    'name' => $xname[$i],
                    'img' => $ximg[($i + 1)],
                    'type' => explode('/', $xlist[$i])[1],
                    'urlid' => explode('.', explode('/', $xlist[$i])[2])[0],
                );
            }
            if (!empty($list3)) {
                View::assign('dm', $list3);
            }
            Cache::set('Indexlist3',$list3);
        }
        $config = Config::get('config.seo'); 
        $seo = [
            'title' => $config['title'],
            'description' => $config['description'],
            'keywords' => $config['keywords']
        ];
        View::assign('seo',$seo);
        return View::fetch();
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
