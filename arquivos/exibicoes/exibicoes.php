<?php 
$JSON = file_get_contents("http://gdata.youtube.com/feeds/api/users/suportesigmari/uploads?orderby=viewCount&max-results=1&alt=json");
$JSON_Data = json_decode($JSON);
$video = $JSON_Data->feed->entry[0]->id->{'$t'};
$pos = strpos($video, 'videos/');
$video_id = substr($video, $pos + 7);
?>

<div style="width:700px;">
	   <div style="padding: 5px;">
	                
			<div style="float: left;">
				<iframe width="380" height="275" src="http://www.youtube.com/embed/<?php echo $video_id; ?>" frameborder="0" allowfullscreen></iframe>
			</div>
			<div style="float: right;">
				<div data-configid="0/2426511" style="width: 300px; height: 275px;" class="issuuembed"></div><script type="text/javascript" src="//e.issuu.com/embed.js" async="true"></script>
			</div>
		</div>
		<div style="padding: 5px;">
			<div style="float: left;">
	        	<a target="_top" style="text-align:left; margin-left: 30px; color: grey;" href="http://www.centralsigma.com.br/index.php?option=com_content&view=category&layout=blog&id=40&Itemid=864">Clique aqui para acessar a Galeria de V&iacute;deos</a>
	        </div>
			<div style="float: right;"><a target="_top" style="margin-right: 15px; color: grey;" href="http://www.centralsigma.com.br/index.php?option=com_content&view=article&id=596&Itemid=709">Clique aqui para acessar a Biblioteca Online</a></div>
		</div>
	
	<div style="float: left; margin-bottom: 2px;">
		<span style="margin-left:90px; font-size: 14px;">Exibi&ccedil;&otilde;es do v&iacute;deo:
			<?php
			//$video_ID = 'xLywhRd1pR4';
			$JSON = file_get_contents("https://gdata.youtube.com/feeds/api/videos/{$video_id}?v=2&alt=json");
			$JSON_Data = json_decode($JSON);
			$views = $JSON_Data->{'entry'}->{'yt$statistics'}->{'viewCount'};
			echo $views;
			?>
		</span>
	</div>
	<div style="float: right;">
	   <span style="margin-right:80px; font-size: 14px;">Exibi&ccedil;&otilde;es do manual:
	   4882
	   </span>
	</div>
</div>

<div>
<span>

</span>
</div>