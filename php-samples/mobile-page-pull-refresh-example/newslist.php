<?php
/* @var $this CtlDzs */

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>斗战资讯</title>
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="apple-touch-fullscreen" content="YES">
<meta name="format-detection" content="telephone=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">

<link type="text/css" href="<?php echo $this->createSourceUrl('/css/global.css');?>" rel="stylesheet" />
<link type="text/css" href="<?php echo $this->createSourceUrl('/css/shake.css');?>" rel="stylesheet" />
<script type="text/javascript" src="<?php echo $this->createSourceUrl('/js/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo $this->createSourceUrl('/js/touch.js');?>"></script>
<script type="text/javascript" src="<?php echo $this->createSourceUrl('/js/TweenMax.min.js');?>"></script>
<script type="text/javascript" src="<?php echo $this->createSourceUrl('/js/main.js');?>"></script>
<script type="text/javascript" src="<?php echo $this->createSourceUrl('/js/shake.js');?>"></script>
<script type="text/javascript" src="<?php echo $this->createSourceUrl('/js/iscroll.js');?>"></script>
</head>

<body class="news">
<div class="nav">
    <div class="button-set">
        <a href="<?php echo $this->createUrl('dzs/newslist');?>" class="button-one-third first">斗战资讯</a>
        <a href="<?php echo $this->createUrl('dzs/videolist');?>" class="button-one-third">斗影中心</a>
        <a href="<?php echo $this->createUrl('dzs/favorite');?>" class="button-one-third last">个人收藏</a>
    </div>
</div>
<div class="page-hd">
    <h1>斗战资讯</h1>
    <span><?php echo $dzsnewstopObj->title;?></span>
    <a href="<?php echo $this->createUrl('dzs/newsview',array('id'=>$dzsnewstopObj->id));?>">了解详情</a>
</div>
<div class="page-bd">
    <div id="listPagesWrap" class="slide-wrap">
        <div id="scroller">
            <ul id="listPage" class="video-list">
            <?php if(0 < count($dzsnewslist)):?>
                <?php foreach($dzsnewslist as $dzsnews): ?>
                <li>
                    <a href="<?php echo $this->createUrl('dzs/newsview',array('id'=>$dzsnews->id));?>" class="title">
                        <h2><?php echo $dzsnews->title;?></h2>
                        <span><?php echo date('Y-m-d',  strtotime($dzsnews->createtime));?></span>
                    </a>
                </li>
                <?php endforeach;?>
            <?php endif;?>
            </ul>
            <div id="pullUp">
                <span class="pullUpIcon"></span><span class="pullUpLabel">上拉刷新...</span>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

var myScroll,pullUpEl,pullUpOffset;

function pullUpAction () {
    setTimeout(function () {//测试用，使用ajax后请删除
        var el, li, i;
        el = document.getElementById('listPage');
        //ajax请求成功后执行
        for (i=0; i<3; i++) {//3 为请求的条数
            li = document.createElement('li');
            li.innerHTML = "<li><a href='news-detail.html' class='title'><h2>斗战神结束动画</h2><span>2014-7-2</span></a></li>";
            el.appendChild(li, el.childNodes[0]);
        }
        myScroll.refresh();
    }, 1000);
}

function loaded() {
    pullUpEl = document.getElementById('pullUp');   
    pullUpOffset = pullUpEl.offsetHeight;
    
    myScroll = new iScroll('listPagesWrap', {
        useTransition: true,
        onRefresh: function () {
            if (pullUpEl.className.match('loading')) {
                pullUpEl.className = '';
                pullUpEl.querySelector('.pullUpLabel').innerHTML = '上拉加载更多...';
            }
        },
        onScrollMove: function () {
            if (this.y < (this.maxScrollY - 5) && !pullUpEl.className.match('flip')) {
                pullUpEl.className = 'flip';
                pullUpEl.querySelector('.pullUpLabel').innerHTML = '松手刷新...';
                this.maxScrollY = this.maxScrollY;
            } else if (this.y > (this.maxScrollY + 5) && pullUpEl.className.match('flip')) {
                pullUpEl.className = '';
                pullUpEl.querySelector('.pullUpLabel').innerHTML = '上拉加载更多...';
                this.maxScrollY = pullUpOffset;
            }
        },
        onScrollEnd: function () {
            if (pullUpEl.className.match('flip')) {
                pullUpEl.className = 'loading';
                pullUpEl.querySelector('.pullUpLabel').innerHTML = '加载中...';                
                pullUpAction(); // Execute custom function (ajax call?)
            }
        }
    });
}
document.addEventListener('touchmove', function (e) { e.preventDefault(); }, false);
document.addEventListener('DOMContentLoaded', function () { loaded(); }, false);
</script>
</body>
</html>

