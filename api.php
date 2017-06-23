<?php
error_reporting(0);
header('Content-Type:text/html;charset=UTF-8');
if($_GET['yyt']){//音悦台
		$id = $_GET['yyt']?$_GET['yyt']:die();
		$url = 'http://m.yinyuetai.com/mv/get-simple-video-info?callback=&videoId='.$id;
		$obj = json_decode(curl_get($url));
		if ($dl = $obj->videoInfo->videoUrl2)
		{
			header('Location: ' . $dl);die;
		}
		elseif($dl = $obj->videoInfo->videoUrl)
		{
			header('Location: ' . $dl);die;
		}
		elseif($dl = $obj->videoInfo->videoUrl3) 
		{
			header('Location: ' . $dl);die;
		}
		else
		{
			die('NOT FOUND YYT DATA.');
		}
}
        elseif($_GET['xmly']){//喜马拉雅
        $id = $_GET['xmly'];
        $data = http_curl('http://www.ximalaya.com/tracks/'.$id.'.ext.text');
        preg_match('|play_url=(.*?)&duration|',$data,$video);
        header("location:".$video[1]);
    }
        elseif($_GET['wy']){//网易音乐
        $id = $_GET['wy'];
        $data = http_curl('http://music.163.com/api/song/enhance/download/url?br=320000&id='.$id);
        preg_match('|url":"(.*?)","br"|',$data,$video);
        header("location:".$video[1]);
    }
        elseif($_GET['kwmp3']){//酷我mp3
        $id = $_GET['kwmp3'];
        $data = http_curl('http://antiserver.kuwo.cn/anti.s?format=mp3&type=convert_url&rid=MUSIC_'.$id.'&response=url');
        preg_match('|([^>]+)|',$data,$video);
        header("location:".$video[1]);
    }
        elseif($_GET['kwmv']){//酷我mv
        $id = $_GET['kwmv'];
        $data = http_curl('http://www.kuwo.cn/yy/st/mvurl?rid=MUSIC_'.$id);
        preg_match('|([^>]+)|',$data,$video);
        header("location:".$video[1]);
    }
	    elseif($_GET['kgmp3']){//酷狗mp3
		$hash = ($_GET['kgmp3'] && isset($_GET['kgmp3']))?$_GET['kgmp3']:die();
		$key = md5($hash . "kgcloud");
		$cmd = '4';//为4则输出mp3,为3则输出m4a
		$url = "http://trackercdn.kugou.com/i/?cmd=$cmd&hash=$hash&key=$key&pid=1&acceptMp3=1";//140828换pid为1，速度更快
		$r = 'http://www.kugou.com/webkugouplayer/?isopen=0&chl=yueku_index';
		$u = 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.146 Safari/537.36';
		$js_data = curl_get($url,array('IPHONE_UA'=>0,'REFERER'=>$r,'USERAGENT'=>$u));//其实可以不要referer和ua的
		/*
		//pid=0 为cdn.kugou.com
		//pid=1 为dcdn.kugou.com
		//pid=2 为android.kugou.com
		//pid=3、4 为ios.kugou.com
		//pid=5 为cdn.kugou.com
		//pid=6 为web.kugou.com
		//pid=7 为open.kugou.com
		*/
		$obj = json_decode($js_data);
		if($obj->status != '1')		die();
		else
		header('Location: '. $obj->url);
    }
		elseif($_GET['kgmp31']){//酷狗mp3
		
        $id = $_GET['kgmp31'];
        $data = http_curl('http://www.kugou.com/yy/index.php?r=play/getdata&hash='.$id);
        preg_match('|play_url":"(.*?)","|',$data,$video);
		$dizhi = stripslashes($video[1]);
        header("location:".$dizhi);
    }
	    elseif($_GET['5sing']){//5sing
		
        $id = $_GET['5sing'];
        $data = curl_get('http://5sing.kugou.com/'.$id.'.html');
        preg_match('|ticket": "(.*?)"|',$data,$video);
		$dizhi = base64_decode ($video[1]);
		preg_match('|file":"(.*?)","|',$dizhi,$dizhi1);
		$dizhi2 = stripslashes($dizhi1[1]);
        header("location:".$dizhi2);
    }
		elseif($_GET['qq']){//QQ音乐
        $id = $_GET['qq'];
		$url='http://c.y.qq.com/v8/fcg-bin/fcg_play_single_song.fcg?songmid='.$id.'&format=jsonp';
		$data = file_get_contents($url);
		preg_match('|ws(.*?)m4a|',$data,$video);
		$dizhi = 'http://ws'.$video[1].'m4a';
        header("location:".$dizhi);
		//echo $dizhi;
    }
		elseif($_GET['bd']){//bd
		
        $id = $_GET['bd'];
        $data = http_curl('http://music.baidu.com/data/music/links?songIds='.$id);
        preg_match('|showLink":"(.*?)","|',$data,$video);
		$dizhi = stripslashes($video[1]);
        header("location:".$dizhi);
		//echo $dizhi;
    }
	    elseif($_GET['live']){//酷狗live	
		
        $id = $_GET['live'];
        $url = http_curl('http://live.kugou.com/yan/'.$id);
		$data = stripslashes($url);
        preg_match('|hash":"(.*?)",|',$data,$video);
		$dizhi = 'http://trackermv.kugou.com/interface/index/?cmd=104&hash='.$video[1];
		//header("location:".$dizhi);
		$ch = curl_init($dizhi);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
		curl_setopt($ch, CURLOPT_NOBODY, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_exec($ch);
		$aaa = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
		header("location:".$aaa);
    }
	    elseif($_GET['1t']){//1ting
        $id = $_GET['1t'];
		$KK = 'http://m.1ting.com/touch/api/song?ids='.$id;
		$data = stripslashes(http_curl($KK));
		preg_match('|song_filepath":"(.*?)wma|',$data,$video);
		$url = 'http://m.1ting.com/file?url='.$video[1].'mp3';
		header("location:".$url);
		/* echo $url; */
    }
function http_curl($url)
{
                //构建user_agent模拟 pc浏览器，下方的curl中使用
                $UserAgent = 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.101 Safari/537.36';
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $url);
                // 设置超时限制防止死循环
                curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_USERAGENT, $UserAgent);
                //设置可以302跳转

                $data = curl_exec($curl);              
                return $data;
}
function curl_get($url, $array=array())
{
    $defaultOptions = array(
		'IPHONE_UA'=>1,
		'SSL'=>0,
		'TOU'=>0,
		'ADD_HEADER_ARRAY'=>0,
		'POST'=>0,
		'REFERER'=>0,
		'USERAGENT'=>0,
		'CURLOPT_FOLLOWLOCATION'=>0
	);
    $array = array_merge($defaultOptions, $array);
	
	$ch = curl_init($url);
	if($array['SSL']){
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	}
	if ($array['IPHONE_UA'])
	{
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-Agent: Mozilla/5.0 (iPhone; U; CPU iPhone OS 3_1_2 like Mac OS X; en-us) AppleWebKit/528.18 (KHTML, like Gecko) Version/4.0 Mobile/7D11 Safari/528.16'));
	}
	if (is_array($array['ADD_HEADER_ARRAY']))
	{
		curl_setopt($ch, CURLOPT_HTTPHEADER, $array['ADD_HEADER_ARRAY']);
	}
	if ($array['POST'])
	{
		curl_setopt($ch, CURLOPT_POSTFIELDS, $array['POST']);
	}
	if ($array['REFERER'])
	{
		curl_setopt($ch, CURLOPT_REFERER, $array['REFERER']);
	}
	if ($array['USERAGENT'])
	{
		curl_setopt($ch, CURLOPT_USERAGENT, $array['USERAGENT']);
	}
	if($array['TOU']){
		curl_setopt($ch, CURLOPT_HEADER, 1); //输出响应头
	}
	if ($array['CURLOPT_FOLLOWLOCATION'])
	{
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);//自动跟踪跳转的链接 
	}

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$get_url = curl_exec($ch);
	curl_close($ch);
	return $get_url;
}