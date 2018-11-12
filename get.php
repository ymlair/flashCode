<?php
require	 './vendor/autoload.php';
// Using Medoo namespace
use Medoo\Medoo;
// Initialize
$dbConfig = require('./db.php');
// Initialize
$database = new Medoo($dbConfig);
    
$str = trim(parse_url($_SERVER['PATH_INFO'], PHP_URL_PATH),'/');

#删除过期数据
$database->query("delete from pi_content where expire < ". time());

# 取出文本
if(is_numeric($str)){
	$content = $database->get('pi_content','content',['randstr'=>$str]);
}elseif(empty($str)){
	$content = $database->select('pi_content',['content','randstr']);
	if(!is_array($content)) exit('d0x11306');
		echo '<html>';
		echo '<body>';
	foreach($content as $item){
		echo "<li><a href='/get.php/{$item['randstr']}'>".$item['randstr'].'</a></li>';
	}
		echo '</body>';
		echo '</html>';
		exit(':)o');
	
}
$prev = <<<htm
<!DOCTYPE html>
<html>
<head>
	<META http-equiv="content-type" content="text/html; charset=UTF-8">
    <link href="/resources/antd.min.css" type="text/css" rel="stylesheet"/>
    <script src="/resources/jquery-1.8.2.min.js" type="text/javascript"></script>
    <script src="/resources/jsonFormater.js" type="text/javascript"></script>
    <link href="/resources/jsonFormater.css" type="text/css" rel="stylesheet"/>
	
</head>
<body>

<div class="layout ant-layout">
	<div class="ant-layout-header">
		<div class="logo"></div>
		<ul class="ant-menu ant-menu-horizontal  ant-menu-dark ant-menu-root" role="menu" aria-activedescendant="" tabindex="0" style="line-height: 64px;">
		<li class="ant-menu-item" role="menuitem" aria-selected="false">~</li>
		<li class="ant-menu-item-selected ant-menu-item" role="menuitem" aria-selected="true">flashCode</li>
		<li class="ant-menu-item" role="menuitem" aria-selected="false">~</li>
		</ul>
	</div>
	<div class="ant-layout-content" style="padding: 0px 50px;">
		<div class="ant-breadcrumb" style="margin: 12px 0px;">
			<span>
			<span class="ant-breadcrumb-link">内容24小时后自动清除,系统不做任何形式的保留备份!</span>
			<!-- <span class="ant-breadcrumb-separator">/</span> -->
			</span>
			<button type="button" style="float:right"  class="clip ant-btn ant-btn-dashed ant-btn-sm"><span>Copy Url</span></button>
		</div>
<div>	
<script src="/resources/clipboard.min.js"></script>
<script>
new ClipboardJS('.clip', {
    text: function(trigger) {
        return window.location.href;
    }
});
</script>
</div>
            
		<div style="background: rgb(255, 255, 255); padding: 24px; min-height: 280px;">
			<textarea id="RawJson" type="textarea" name="content" placeholder="Autosize height with minimum and maximum number of lines" class="ant-input" rows="20%" readonly="readonly">
htm;
$next = <<<hm
</textarea>
			<div>　</div>

			<div class="ant-card ant-card-bordered">
				<div>For JSON ：</div>
				<div id="ControlsRow">
				    <input type="Button" value="格式化" id='format'/>
				  <span id="TabSizeHolder">
				    缩进量
				    <select id="TabSize">
				        <option value="1">1</option>
				        <option value="2" selected>2</option>
				        <option value="3">3</option>
				        <option value="4">4</option>
				        <option value="5">5</option>
				        <option value="6">6</option>
				    </select>
				  </span>
				    <input type="checkbox" id="QuoteKeys" checked='checked' />
				    <label for="QuoteKeys">
				        引号
				    </label>&nbsp;
				      <input type="checkbox" id="CollapsibleView" checked='checked' />
				      <label for="CollapsibleView">
				          显示控制
				      </label>
				  <span id="CollapsibleViewDetail">
				    <a href="javascript:void(0);" id="expandAll">展开</a>
				    <a href="javascript:void(0);" id="collapseAll">叠起</a>
				    <a href="javascript:void(0);" class="expand" data-level="3">2级</a>
				    <a href="javascript:void(0);" class="expand" data-level="4">3级</a>
				    <a href="javascript:void(0);" class="expand" data-level="5">4级</a>
				    <a href="javascript:void(0);" class="expand" data-level="6">5级</a>
				    <a href="javascript:void(0);" class="expand" data-level="7">6级</a>
				    <a href="javascript:void(0);" class="expand" data-level="8">7级</a>
				    <a href="javascript:void(0);" class="expand" data-level="9">8级</a>
				  </span>
				</div>
			</div>
			<div class="ant-card ant-card-bordered">
			<div class="ant-card-body">
				<div id="Canvas" class="Canvas"></div>
			</div>
			</div>
			
		</div>
	</div>
	<div class="ant-layout-footer" style="text-align: center;">Ant Design ©2017 Created by Ant UED</div>
</div>

<script type="application/javascript">
    $(document).ready(function () {
        var format = function () {
            var options = {
                dom: '#Canvas',
                isCollapsible: $('#CollapsibleView').prop('checked'),
                quoteKeys: $('#QuoteKeys').prop('checked'),
                tabSize: $('#TabSize').val()
            };
            window.jf = new JsonFormater(options);
            jf.doFormat($('#RawJson').val());
        };
        $('#format').click(function () {
            format();
        });
        $('#expandAll').click(function () {
            window.jf.expandAll();
        });
        $('#collapseAll').click(function () {
            window.jf.collapseAll();
        });
        $('#TabSize, #CollapsibleView, #QuoteKeys').change(function () {
            format();
        });
        $('.expand').click(function () {
            var level = $(this).data('level');
            window.jf.collapseLevel(level);
        });
    });
</script>
</body>
</html>
hm;
header("Content-type: text/html; charset=utf-8");
#echo $prev. base64_decode($content) .$next;
echo $prev. $content .$next;
