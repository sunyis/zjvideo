#### 界面展示：

![pic47][1]

![pic48][2]
![pic49][3]
![pic50][4]

#### 介绍：

**基本：**

* 无需数据库
* 暂无后台
* 全站调用 360 影视
* 界面简洁
* Thinkphp 框架开发

**程序安装：**

1. 将压缩包解压到网站根目录
2. 将.env 文件随意改名或删除
3. 设置伪静态
4. 设置网站运行目录为 public
5. 修改配置

**配置修改：**

* 解析接口列表：`根目录/app/index/config/api.php`
* 播放页调用的接口：`根目录/app/index/controller/Play.php` 下搜索 `$url = $apis`，`$url = $apis[改为对应的接口键值] . $url;` **后面会改成后台配置且前台播放页可自选播放接口**
* SEO 信息（标题，介绍，关键字）：`根目录/app/index/config/config.php`
* 底部信息：`根目录/app/index/view/` 下各个目录中 `index.html` 中
* nginx 伪静态：

  ```
  location / {
     if (!-e $request_filename) {
      rewrite  ^(.*)$  /index.php?s=/$1  last;
      }
  }
  ```
[1]: https://blog.jerryiweb.com/usr/themes/Mirages/postpics/pic47.png
[2]: https://blog.jerryiweb.com/usr/themes/Mirages/postpics/pic48.png
[3]: https://blog.jerryiweb.com/usr/themes/Mirages/postpics/pic49.png
[4]: https://blog.jerryiweb.com/usr/themes/Mirages/postpics/pic50.png