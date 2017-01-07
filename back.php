<html>
<body onload="stub()">

<?php
	$urla=$_GET['temptxt'];
	$domaina=$_GET['temptxt2'];
	$domlen=strlen($domaina);
	$check_url_statusfirst=check_url($urla);
	$end="";
	$endin=0;
	$arrlength=0;
	$arr=array();
	$arr=getlinks($urla);
	$arrlength=count($arr);
	$arrlengthstarttemp=0;
	$arrlengthendtemp=0;
	$arrlengthstart=0;
	$arrlengthend=0;
	$arrlengthtwo=1;
	$broken=array();
	$brokenlength=0;

function getlinks($urlb)
{
	$arrlengthstarttemp=$arrlength;
	$html = file_get_contents($urlb);
	$dom = new DOMDocument();
	@$dom->loadHTML($html);
	// grab all the on the page
	$xpath = new DOMXPath($dom);
	$hrefs = $xpath->evaluate("/html/body//a");

	for ($i = 0; $i < $hrefs->length; $i++) 
	{
	       $href = $hrefs->item($i);
	       $url = $href->getAttribute('href');
	       if(empty($url))
	       {
	       }
	       else
	       {
	       	$arr[$arrlength]=$url;
			$arrlength++;
	       }
	}	
	return $arr;
}
function findend($url)
{
	$end=strstr($url, '.com',true);
	$endin=0;
	if(empty($end))
	{
		$end=strstr($url, '.edu',true);
		$endin=1;
	}
	if(empty($end))
	{	
		$end=strstr($url, '.net',true);
		$endin=2;
	}
	if(empty($end))
	{	
		$end=strstr($url, '.gov',true);
		$endin=3;
	}	
	return $end;
}
function findendb($url)
{
	$end=strstr($url, '.com',true);
	$endin=0;
	if(empty($end))
	{
		$end=strstr($url, '.edu',true);
		$endin=1;
	}
	if(empty($end))
	{	
		$end=strstr($url, '.net',true);
		$endin=2;
	}
	if(empty($end))
	{	
		$end=strstr($url, '.gov',true);
		$endin=3;
	}	
	return $endin;
}

getlinks($urla);
$end=findend($urla);
$endin=findendb($urla);
for($i=0;$i<$arrlength;$i++)
{
	if(substr($arr[$i],0,1)=='/')
	{
		if($endin==0)
		{
			$arr[$i]=$end.".com".$arr[$i];
		}
		if($endin==1)
		{
			$arr[$i]=$end.".edu".$arr[$i];
		}
		if($endin==2)
		{
			$arr[$i]=$end.".net".$arr[$i];
		}
		if($endin==3)
		{
			$arr[$i]=$end.".gov".$arr[$i];
		}
	}
}

$a=$arrlength;
for($i=0;$i<$arrlength;$i++)
{
	$tempcheck=check_url($arr[$i]);
	if($tempcheck!=404 && $tempcheck!=404 )
	{
		echo $arr[$i];
		getlinks($arr[$i]);
	}
}
$b=$arrlength;
while ($arrlength<1500 && $arrlengththree>0)
{
	$arrlengthtwo=$arrlength;
	for($i=$a;$i<$b;$i++)
	{
		getlinks($arr[$i]);
	}
	$arrlengthfour=$arrlength;
	$a=$arrlengthtwo;
	$b=$arrlengthfour;
	$arrlengththree=$arrlengthfour-$arrlengthtwo;	
}
function check_url($url) {

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch , CURLOPT_RETURNTRANSFER, 1);
    $data = curl_exec($ch);
    $headers = curl_getinfo($ch);
    curl_close($ch);

    return $headers['http_code'];
}

function fixthemup($urla)
{
	$end=findend($urla);
	$endin=findendb($urla);
	for($i=0;$i<$arrlength;$i++)
	{
		if(substr($arr[$i],0,1)=='/')
		{
			if($endin==0)
			{
				$arr[$i]=$end.".com".$arr[$i];
			}
			if($endin==1)
			{
				$arr[$i]=$end.".edu".$arr[$i];
			}
			if($endin==2)
			{
				$arr[$i]=$end.".net".$arr[$i];
			}
			if($endin==3)
			{
				$arr[$i]=$end.".gov".$arr[$i];
			}
		}	
	}
}
$end=findend($urla);
$endin=findendb($urla);
for($i=0;$i<$arrlength;$i++)
{
	if(substr($arr[$i],0,1)=='/')
	{
		if($endin==0)
		{
			$arr[$i]=$end.".com".$arr[$i];
		}
		if($endin==1)
		{
			$arr[$i]=$end.".edu".$arr[$i];
		}
		if($endin==2)
		{
			$arr[$i]=$end.".net".$arr[$i];
		}
		if($endin==3)
		{
			$arr[$i]=$end.".gov".$arr[$i];
		}
	}
}
function brokenlinks()
{
  for ($i = 0; $i < $arrlength; $i++)
  {
	$check_url_status = check_url($arr[$i]);
	//$tempit=0;
	//if(substr($arr[$i],0,$domlen)==$domaina)
  //	{
		if($check_url_status == 404 || $check_url_status == 403)
		{
			$broken[$brokenlength]=$arr[$i];
			$brokenlength++;

		}
		else
		{
		  
		  
		}
  //	}
  }
}
if($check_url_statusfirst==0 || $check_url_statusfirst==404 || $check_url_statusfirst==403)
{
	$brokenb=array();
	$notwork="The site you entered does not work!";
	$brokenb[0]=$notwork;
	$broken=$brokenb;
	$brokenlength=1;
}
?>
<script type="text/javascript">
	function stub()
	{
		var broke=<?php echo json_encode($broken); ?>;
		var length=<?php echo $brokenlength; ?>;
		top.dealwithload(broke, length);
	}
</script>
</body>
</html>