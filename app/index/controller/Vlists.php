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
class Vlists extends BaseController
{
    public function index(Request $request)
    {
        $page = $request->param('page');
        $type = $request->param('type');
        switch ($type) {
            case 'dianshi': {
                    if ($list1 = Cache::get('page'.$page.'Vlistslist1') and $pagemax1 = Cache::get('Vlistspagemax1')) {
                        View::assign('pagemax', $pagemax1);
                        View::assign('list', $list1);
                        View::assign('type', $type);
                        $config = Config::get('config.seo');
                        $seo = [
                            'title' => $config['title'],
                            'description' => $config['description'],
                            'keywords' => $config['keywords']
                        ];
                        View::assign('seo', $seo);
                        return View::fetch();
                    } else {
                        $vlist = "http://www.360kan.com/" . $type . "/list.php?cat=all&year=all&area=all&act=all&rank=all&pageno=" . $page . "&from=dianshi_list";
                        $fcon = $this->videoCurl($vlist);
                        preg_match_all('/<a href=\'(.*)pageno=(.*)\' target=\'_self\' monitor-shortpv-c-sub=\'(.*)\'>(.*)<\/a>/sU', $fcon, $pages);
                        if (count($pages[2]) != 0) {
                            $pagemax = $pages[2][count($pages[2]) - 1];
                        }
                        preg_match_all('#<span class="s1">(.*?)</span>#', $fcon, $xarr0);
                        preg_match_all('#<a class="js-tongjic" href="(.*?)">#', $fcon, $xarr1);
                        preg_match_all('#<img src="(.*?)">#', $fcon, $xarr3);
                        $xname = $xarr0[1]; //名字
                        $xlist = $xarr1[1]; //链接
                        $ximg = $xarr3[1]; //图片
                        for ($i = 0; $i < 32; $i++) {
                            if (isset($xlist[$i])) {
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
                        }
                        if (!empty($list1)) {
                            View::assign('pagemax', ($pagemax - 1));
                            View::assign('list', $list1);
                            View::assign('type', $type);
                        }
                        Cache::set('Vlistspagemax1', ($pagemax - 1));
                        Cache::set('page'.$page.'Vlistslist1', $list1);
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
            case 'dianying': {
                    if ($list2 = Cache::get('page'.$page.'Vlistslist2') and $pagemax2 = Cache::get('Vlistspagemax2')) {
                        View::assign('pagemax', $pagemax2);
                        View::assign('list', $list2);
                        View::assign('type', $type);
                        $config = Config::get('config.seo');
                        $seo = [
                            'title' => $config['title'],
                            'description' => $config['description'],
                            'keywords' => $config['keywords']
                        ];
                        View::assign('seo', $seo);
                        return View::fetch();
                    } else {
                        $vlist = "http://www.360kan.com/" . $type . "/list.php?rank=rankhot&cat=all&area=all&act=all&year=all&pageno=" . $page . "&from=dianying_list";
                        $fcon = $this->videoCurl($vlist);
                        preg_match_all('/<a href=\'(.*)pageno=(.*)\' target=\'_self\' monitor-shortpv-c-sub=\'(.*)\'>(.*)<\/a>/sU', $fcon, $pages);
                        if (count($pages[2]) != 0) {
                            $pagemax = $pages[2][count($pages[2]) - 1];
                        }
                        preg_match_all('#<span class="s1">(.*?)</span>#', $fcon, $xarr0);
                        preg_match_all('#<a class="js-tongjic" href="(.*?)">#', $fcon, $xarr1);
                        preg_match_all('#<img src="(.*?)">#', $fcon, $xarr3);
                        $xname = $xarr0[1]; //名字
                        $xlist = $xarr1[1]; //链接
                        $ximg = $xarr3[1]; //图片
                        for ($i = 0; $i < 32; $i++) {
                            if (isset($xlist[$i])) {
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
                        }
                        if (!empty($list2)) {
                            View::assign('pagemax',$pagemax);
                            View::assign('list', $list2);
                            View::assign('type', $type);
                        }
                        Cache::set('Vlistspagemax2',$pagemax);
                        Cache::set('page'.$page.'Vlistslist2', $list2);
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
            case 'dongman': {
                    if ($list3 = Cache::get('page'.$page.'Vlistslist3') and $pagemax3 = Cache::get('Vlistspagemax3')) {
                        View::assign('pagemax', $pagemax3);
                        View::assign('list', $list3);
                        View::assign('type', $type);
                        $config = Config::get('config.seo');
                        $seo = [
                            'title' => $config['title'],
                            'description' => $config['description'],
                            'keywords' => $config['keywords']
                        ];
                        View::assign('seo', $seo);
                        return View::fetch();
                    } else {
                        $vlist = "http://www.360kan.com/" . $type . "/list.php?rank=rankhot&cat=all&area=all&act=all&year=all&pageno=" . $page . "&from=dianying_list";
                        $fcon = $this->videoCurl($vlist);
                        preg_match_all('/<a href=\'(.*)pageno=(.*)\' target=\'_self\' monitor-shortpv-c-sub=\'(.*)\'>(.*)<\/a>/sU', $fcon, $pages);
                        if (count($pages[2]) != 0) {
                            $pagemax = $pages[2][count($pages[2]) - 1];
                        }
                        preg_match_all('#<span class="s1">(.*?)</span>#', $fcon, $xarr0);
                        preg_match_all('#<a class="js-tongjic" href="(.*?)">#', $fcon, $xarr1);
                        preg_match_all('#<img src="(.*?)">#', $fcon, $xarr3);
                        $xname = $xarr0[1]; //名字
                        $xlist = $xarr1[1]; //链接
                        $ximg = $xarr3[1]; //图片
                        for ($i = 0; $i < 32; $i++) {
                            if (isset($xlist[$i])) {
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
                        }
                        if (!empty($list3)) {
                            View::assign('pagemax',$pagemax);
                            View::assign('list', $list3);
                            View::assign('type', $type);
                        }
                        Cache::set('Vlistspagemax3',$pagemax);
                        Cache::set('page'.$page.'Vlistslist3', $list3);
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
            case 'zongyi': {
                    if ($list4 = Cache::get('page'.$page.'Vlistslist4') and $pagemax4 = Cache::get('Vlistspagemax4')) {
                        View::assign('pagemax', $pagemax4);
                        View::assign('list', $list4);
                        View::assign('type', $type);
                        $config = Config::get('config.seo');
                        $seo = [
                            'title' => $config['title'],
                            'description' => $config['description'],
                            'keywords' => $config['keywords']
                        ];
                        View::assign('seo', $seo);
                        return View::fetch();
                    } else {
                        $vlist = "http://www.360kan.com/" . $type . "/list.php?rank=rankhot&cat=all&area=all&act=all&year=all&pageno=" . $page . "&from=dianying_list";
                        $fcon = $this->videoCurl($vlist);
                        preg_match_all('/<a href=\'(.*)pageno=(.*)\' target=\'_self\' monitor-shortpv-c-sub=\'(.*)\'>(.*)<\/a>/sU', $fcon, $pages);
                        if (count($pages[2]) != 0) {
                            $pagemax = $pages[2][count($pages[2]) - 1];
                        }
                        preg_match_all('#<span class="s1">(.*?)</span>#', $fcon, $xarr0);
                        preg_match_all('#<a class="js-tongjic" href="(.*?)">#', $fcon, $xarr1);
                        preg_match_all('#<img src="(.*?)">#', $fcon, $xarr3);
                        $xname = $xarr0[1]; //名字
                        $xlist = $xarr1[1]; //链接
                        $ximg = $xarr3[1]; //图片
                        for ($i = 0; $i < 32; $i++) {
                            if (isset($xlist[$i])) {
                                if (isset($xlist[$i])) {
                                    $xlist[$i] = explode("\"", $xlist[$i])[0];
                                }
                                $list4[] = array(
                                    'url' => 'http://www.360kan.com' . $xlist[$i],
                                    'name' => $xname[$i],
                                    'img' => $ximg[($i + 1)],
                                    'type' => explode('/', $xlist[$i])[1],
                                    'urlid' => explode('.', explode('/', $xlist[$i])[2])[0],
                                );
                            }
                        }
                        if (!empty($list4)) {
                            View::assign('pagemax',$pagemax);
                            View::assign('list', $list4);
                            View::assign('type', $type);
                        }
                        Cache::set('Vlistspagemax4',$pagemax);
                        Cache::set('page'.$page.'Vlistslist4', $list4);
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
