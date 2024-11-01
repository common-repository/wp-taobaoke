=== WP-TaoBaoKe ===
Contributors: Simon Fan
Donate link: http://www.sohao.net/
Tags: TaoBaoKe, TaoBao, shopping, shopping ad
Requires at least: 2.0.2
Tested up to: 2.8
Stable tag: trunk

非常简单的插件，你可以自由扩展。

WP-TaoBaoKe让WordPress用户可以方便得将淘宝客广告插入到文章（post）, 页面（page）, 边栏（sidebar）和小工具（widget）中。

WP-TaoBaoKe enables you add taobaoke to your wordpress sidebar or widget.


开发网站：
http://www.sohao.net/
http://www.sohao.net/donate.htm

== Description ==

开发网站：
http://www.sohao.net/
http://www.sohao.net/donate.htm

= 中文说明 =
本插件使WordPress用户可以方便将淘宝客广告插入到文章（post）, 页面（page）, 边栏（sidebar）和小工具（widget）中。

1.如何在模板中显示淘宝客广告？

将<?php tbk_show(); ?>放到你模板（template）的适当位置即可。

2.如何在文章（post）中显示广告？

在HTML模式下，将[taobaoke]放到你的文章中即可。

3.如何在小工具（widget）中显示广告？

到外观->小工具中将wp-taobaoke拖放到你的边栏中即可。

4.如何定制广告样式？

目前版本默认只有一种简单的样式，请到wp-taobaoke/taobaoke-css.css中定制样式。

以后版本会增加更方便的定制样式的功能，敬请期待！

= English Description =
WP-TaoBaoKe enables you add taobaoke to your wordpress sidebar or widget.

1.Want to show the taobaoke AD in your sidebar or any part of your page?

Put `<?php tbk_show(); ?>` in your template.

2.Want to show the taobaoke AD in your blog?

Put the [taobaoke] in your blog content.

3.Want to show the taobaoke in your widget?

Open the apperance->widget, drag the wp-taobaoke to your sidebar.

4.Want to customize the AD style?

Open the wp-taobaoke/taobaoke-css.css to edit the style.

== Installation ==
= 中文安装指南 =

1. 上传wp-taobaoke所有文件到你的插件目录(`/wp-content/plugins/)中, `/wp-content/plugins/wp-taobaoke/`.

2. 在WordPress后台->插件管理面板中激活wp-taobaoke.

3. 到WordPress后台->设置中设置你的淘宝客广告选项。

4. 请根据中文说明来将淘宝客广告加入到你的文章，页面，边栏和小工具中。

= English Installation =

1. Upload all files of wp-taobaoke to the `/wp-content/plugins/wp-taobaoke/` directory.

2. Activate the plugin through the 'Plugins' menu in WordPress.

3. Go to Setup -> TaoBaoKe to change the configuration according to your situation.

4. Place `<?php tbk_show(); ?>` in your templates

== Frequently Asked Questions ==

中文FAQ
= 本插件是否免费？ =
Yes

= 使用本插件的前提条件? =

请到阿里妈妈网站http://www.alimama.com注册淘宝客,取得你的淘宝客pid.

FAQ

= Is WP-TaoBaoKe free? =

Yes.

= What should I do to use WP-TaoBaoKe? =

You should register in alimama.com to get the PID.

== Screenshots ==

1. 截屏1

2. 截屏2

== Changelog ==

= 1.3 =
* Make the product subcategory works.

= 1.2 =
* Fix the bug of product category.

= 1.1 =
* Add the zh_CN language resource.

= 1.0 =
* Add widget.
* Add shortcode.

= 0.5 =
* Can configure the TaoBaoKe in the admin panel.