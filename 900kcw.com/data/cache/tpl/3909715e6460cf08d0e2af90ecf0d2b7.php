<?php exit;?>00154857906116941166ecb27732ab71b082b17439e9s:13473:"a:2:{s:8:"template";s:13408:"<html>

	<head>
		<meta charset="utf-8" />
		<meta name="format-detection" content="telephone=no" />
		<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE11" />
		<title>【<?php echo $categoryInfo["name"];?>开奖结果】<?php echo $categoryInfo["name"];?>开奖查询_<?php echo $categoryInfo["name"];?>开奖号码-<?php echo $sys["site_title"];?></title>
		<meta name="keywords" content="<?php echo $categoryInfo["keywords"];?>" />
		<meta name="distribution" content="<?php echo $categoryInfo["description"];?>" />
		<link rel="stylesheet" href="/themes/168pc/css/headorfood.css" />
		<link rel="stylesheet" href="/themes/168pc/css/pk10kai.css" />
		<link rel="shortcut icon" href="/themes/168pc/img/icon/168favicon.ico">
		<link rel="stylesheet" href="/themes/168pc/css/user_adv.css" />
		<link rel="stylesheet" href="/themes/168pc/css/idangerous.swiper.css" />
		<script src="/themes/168pc/js/lib/bootstrap-3.3.0/js/tests/vendor/jquery.min.js"></script>
		<script src="/themes/168pc/js/lib/bootstrap-3.3.0/dist/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="/themes/168pc/js/lib/jscolor-2.0.4/jscolor.js"></script>
	</head>

	<body>
		<div class="bodybox">
<?php $__Template->display("themes/168pc/head"); ?>
			<div class="haomabox">
				<div class="waring" id="waringbox">
					<div class="flash"><i></i></div>
					温馨提示：因网络问题，开奖结果会有延迟，所以您需要去喝杯咖啡等一会儿！
				</div>
				<div class="haomaqu" id="pk10">
					<div class="haomaqul">
						<div class="haomaline">
							<div class="haomaimg">
								<img src="<?php echo $categoryInfo["image"];?>" />
							</div>
							<div class="numberqu">
								<div class="nuberqutit">
									<span class="pk10tit"><?php echo $categoryInfo["name"];?></span>第
									<span class="redfont preDrawIssue"></span> 期开奖号码
								</div>
								<div class="kajianhao">
									<ul id="jnumber" class="numberbox">
										<li class="nub02 "></li>
										<li class="nub01 "></li>
										<li class="nub10 "></li>
										<li class="nub04 "></li>
										<li class="nub03 "></li>
										<li class="nub06 "></li>
										<li class="nub07 "></li>
										<li class="nub08 "></li>
										<li class="nub05 "></li>
										<li class="nub09 li_after"></li>
									</ul>
								</div>
							</div>
						</div>
						<div style="display: none;">
							<table>
								<tr class="longhu">
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td class="sumFS"></td>
									<td class="sumBigSamll"></td>
									<td class="sumSingleDouble"></td>
								</tr>
							</table>
						</div>
						<div class="haomaline homaline2">
							<div class="haomaimg">
								<p class="kaijianname"><?php echo $categoryInfo["name"];?></p>
							</div>
							<div class="margt30 li_td">
								<ul class="zoushimap">
									<li class="list lihead">走势图表：</li>

										<?php $listList = service("duxcms","Label","categoryList",array( "app"=>"DuxCms", "label"=>"categoryList", "parent_id"=>25, "limit"=>4));  if(is_array($listList)) foreach($listList as $list){ ?>
  <?php if ($list['class_id']==$categoryInfo['class_id']){ ?>
    <li class="list"><a href="<?php echo $list["curl"];?>" title="<?php echo $list["name"];?>"><?php echo $list["name"];?></a></li>
  <?php }else{ ?>
   <li class="list" ><a href="<?php echo $list["curl"];?>" title="<?php echo $list["name"];?>"><?php echo $list["name"];?></a></li>
  <?php } ?>
<?php } ?>

									<li class="list morelist" id="morelist">
										<a href="javascript:void(0)" class="more">更多<img class="graypre" src="/themes/168pc/img/graypre.png" alt="" /><img class="yellowpre" src="/themes/168pc/img/yellowpre.png" alt="" /></a>
										<div class="sub_morelist" style="display: none;">
											<ul class="leftUl">
												<?php $listList = service("duxcms","Label","categoryList",array( "app"=>"DuxCms", "label"=>"categoryList", "parent_id"=>25, "class_id"=>'30,31,32,33,34,35'));  if(is_array($listList)) foreach($listList as $list){ ?>
												<li class="list">
													<a href="<?php echo $list["curl"];?>"><?php echo $list["name"];?></a>
												</li>
                                              <?php } ?>
											
										</div>
									</li>
								</ul>

							</div>
							<div class="newtuijian li_td">
								<ul class="zoushimap ">
									<li class="list lihead">新手推荐：</li>
									<li class="list">
										<a href="/beijingsaiche.html">玩法规则</a>
									</li>
									
								</ul>
							</div>
						</div>
					</div>
					<div class="haomaqur">
						<div class="haomaqur_l">
							<div class="line linetit">距<span class="nextIssue"></span>期开奖仅有</div>
							<div class="line linetime" id="timebox">
								<div class="opening opentyle">开奖中...</div>
								<div class="cuttime">
									<span class="bgtime hour">00</span>
									<span class="hourtxt">时</span>
									<span class="bgtime minute">00</span>
									<span>分</span>
									<span class="bgtime second">00</span>
									<span>秒</span>
								</div>
							</div>
							<div class="line linetit height40">已开<span class="drawCount"></span>期，还有<span class="sdrawCount"></span>期</div>
							<div class="line soundId">
								<div class="soundline soundSet" id="soundSet">
								</div>
							</div>
						</div>
						<div class="line margt20 guangimg" id="startVideo">
							<img src="/themes/168pc/img/video/jisusc_video.jpg" />
						</div>
					</div>
				</div>
			</div>
			<div class="kaijiangjl margt20">
				<div class="head">
					<ul class="zoushimap" id="kaijiangjl">
						<li class="kaijiltit">开奖记录</li>
						<li id="jrsmtj">
							<a href="javascript:">今日双面/号码统计</a>
							<i></i>
						</li>
						<li id="cltx">
							<a href="javascript:"> 长龙提醒</a>
							<i></i>
						</li>
						<li id="hmfb">
							<a href="javascript:">号码分布</a>
							<i></i>
						</li>
					</ul>
					<div id="kjls">
						<a href="pk10kai_history.html">开奖历史</a>
					</div>
					<div id="selectcolor">
						<em>护眼模式</em>
						<span class="select">&nbsp;</span>
						<span>&nbsp;</span>
						<span>&nbsp;</span>
						<span><button id="colorBtn"  class="jscolor{valueElement:'chosen-value', onFineChange:'setTextColor(this)'}">&nbsp;</button></span>
						<input id="chosen-value" value="#f0f0f0" type="hidden"/>
					</div>
				</div>
				<div class="listcontent">
					<div class="jrsmtj">
						<div class="headtxt">
							今日双面统计
						</div>
						<table cellpadding="1" cellspacing="1" border="0">
							<tr>
								<th>名次</th>
								<th colspan="4">冠军</th>
								<th colspan="4">亚军</th>
								<th colspan="4">第三名</th>
								<th colspan="4">第四名</th>
								<th colspan="4">第五名</th>
								<th colspan="4">第六名</th>
								<th colspan="4">第七名</th>
								<th colspan="4">第八名</th>
								<th colspan="4">第九名</th>
								<th colspan="4">第十名</th>
							</tr>
							<tr>
								<td>单双大小</td>
								<td>单</td>
								<td>双</td>
								<td>大</td>
								<td>小</td>
								<td>单</td>
								<td>双</td>
								<td>大</td>
								<td>小</td>
								<td>单</td>
								<td>双</td>
								<td>大</td>
								<td>小</td>
								<td>单</td>
								<td>双</td>
								<td>大</td>
								<td>小</td>
								<td>单</td>
								<td>双</td>
								<td>大</td>
								<td>小</td>
								<td>单</td>
								<td>双</td>
								<td>大</td>
								<td>小</td>
								<td>单</td>
								<td>双</td>
								<td>大</td>
								<td>小</td>
								<td>单</td>
								<td>双</td>
								<td>大</td>
								<td>小</td>
								<td>单</td>
								<td>双</td>
								<td>大</td>
								<td>小</td>
								<td>单</td>
								<td>双</td>
								<td>大</td>
								<td>小</td>
							</tr>
							<tr id="shuanmiandata">
								<td>出现次数</td>
							</tr>
						</table>
						<table class="secondtb" cellpadding="1" cellspacing="1" border="0">
							<tr>
								<th>冠亚龙虎</th>
								<th colspan="4">冠亚和</th>
								<th colspan="2">第一名龙虎</th>
								<th colspan="2">第二名龙虎</th>
								<th colspan="2">第三名龙虎</th>
								<th colspan="2">第四名龙虎</th>
								<th colspan="2">第五名龙虎</th>
							</tr>
							<tr>
								<td>单双大小龙虎</td>
								<td>单</td>
								<td>双</td>
								<td>大</td>
								<td>小</td>
								<td>龙</td>
								<td>虎</td>
								<td>龙</td>
								<td>虎</td>
								<td>龙</td>
								<td>虎</td>
								<td>龙</td>
								<td>虎</td>
								<td>龙</td>
								<td>虎</td>
							</tr>
							<tr id="gylhcs">
								<td>出现次数</td>
							</tr>
						</table>
					</div>
					<div class="cltx">
						<div class="headtxt">
							长龙连开提醒
						</div>
						<div class="cltxul">
							<ul id="cltxul">
							</ul>
						</div>
					</div>
					<div class="hmfb">
						<div class="head">
							<ul class="zoushimap" id="chakanchfb">
								<li class="kaijiltit">查看车号分布：</li>
								<li class="01">
									<a href="javascript:">号码1</a>
									<i></i>
								</li>
								<li class="02">
									<a href="javascript:">号码2</a>
									<i></i>
								</li>
								<li class="03">
									<a href="javascript:">号码3</a>
									<i></i>
								</li>
								<li class="04">
									<a href="javascript:">号码4</a>
									<i></i>
								</li>
								<li class="05">
									<a href="javascript:">号码5</a>
									<i></i>
								</li>
								<li class="06">
									<a href="javascript:">号码6</a>
									<i></i>
								</li>
								<li class="07">
									<a href="javascript:">号码7</a>
									<i></i>
								</li>
								<li class="08">
									<a href="javascript:">号码8</a>
									<i></i>
								</li>
								<li class="09">
									<a href="javascript:">号码9</a>
									<i></i>
								</li>
								<li class="10">
									<a href="javascript:">号码10</a>
									<i></i>
								</li>
								<!--<li class="reset">
									还原
								</li>-->
							</ul>
						</div>
						<div class="head head2">
							<ul class="zoushimap" id="daxiaodsfb">
								<li class="kaijiltit">大小单双分布：</li>
								<li id="dannum">
									<a href="javascript:">单</a>
									<i></i>
								</li>
								<li id="shuangnum">
									<a href="javascript:">双</a>
									<i></i>
								</li>
								<li id="danum">
									<a href="javascript:">大</a>
									<i></i>
								</li>
								<li id="xiaonum">
									<a href="javascript:">小</a>
									<i></i>
								</li>
								<li id="duizinum">
									<a href="javascript:">对子号</a>
									<i></i>
								</li>
								<li class="reset">
									还原
								</li>
							</ul>
						</div>
					</div>
					<div class="jrsmhmtj" id="jrsmhmtj">
						<table  id="jrsmhmtjTab" cellpadding="1" cellspacing="1" border="0">
							<tr>
								<th>时间</th>
								<th>期数</th>
								<th id="numberbtn" class="numberbtn">
									<span id="xshm" class="spanselect">显示号码</span>
									<span id="xsdx">显示大小</span>
									<span id="xsds">显示单双</span>
								</th>
								<th colspan="3">冠亚和</th>
								<th colspan="5">1-5龙虎</th>
							</tr>
						</table>
					</div>
				</div>
			</div>
		
		<?php $__Template->display("themes/168pc/foot"); ?>
		<div id="videobox">
			<div class="content">
				<div class="head">
					<?php echo $categoryInfo["name"];?>开奖视频
					<div class="btn">
						<ul>
							<li class="closevideo"><i class="iconfont"></i></li>
							<li class="small">小屏</li>
							<li class="big">中屏</li>
						</ul>
					</div>
				</div>
				<div class="animate">
					<div class="loading_jisusc"></div>
					<iframe style="height:100%;width:100%;border: none;" src="/themes/168pc/js/lib/finishAnimation/jisusc_index.html"></iframe>
				</div>
			</div>
		</div>
	</body>
	<script type="text/javascript" src="/themes/168pc/js/lib/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="/themes/168pc/js/lib/config.js"></script>
	<script type="text/javascript" src="/themes/168pc/js/lib/GA.js"></script>
	<script type="text/javascript" src="/themes/168pc/js/loacal/animate/animate.js"></script>
	<script type="text/javascript" src="/themes/168pc/js/loacal/pk10/pk10_index.js"></script>
	<script type="text/javascript" src="/themes/168pc/js/loacal/pk10/jishushaiche_kai.js"></script>
	<script type="text/javascript" src="/themes/168pc/js/lib/idangerous.swiper.min.js"></script>
	<script type="text/javascript" src="/themes/168pc/js/loacal/tools/tools.js"></script>
</html>";s:12:"compile_time";i:1517043061;}";