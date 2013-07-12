<?php
defined('_JEXEC') or die('Restricted access'); // no direct access
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'functions.php';
$document = null;
if (isset($this))
  $document = & $this;
$baseUrl = $this->baseurl;
$templateUrl = $this->baseurl . '/templates/' . $this->template;
artxComponentWrapper($document);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>
 <meta property="og:url" content="http://www.centralsigma.com.br/"/>
 <meta property="og:description" content="Sigma - Sistema de Gestão de Manutenção Gratuito (CMMS) desenvolvido pela Rede Industrial."/>
 <meta property="og:title" content="CENTRAL SIGMA - Novo portal de atendimento ao Usuário SIGM"/>
 <meta property="og:site_name" content="CENTRAL SIGMA"/>
 <meta property="og:type" content="website" />
 <meta property="og:image" content="http://centralsigma.com.br/thumb.png"/>
 <jdoc:include type="head" />
 <link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/system/css/system.css" type="text/css" />
 <link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/system/css/general.css" type="text/css" />
 <link rel="stylesheet" type="text/css" href="<?php echo $templateUrl; ?>/css/template.css" media="screen" />
 <!--[if IE 6]><link rel="stylesheet" href="<?php echo $templateUrl; ?>/css/template.ie6.css" type="text/css" media="screen" /><![endif]-->
 <!--[if IE 7]><link rel="stylesheet" href="<?php echo $templateUrl; ?>/css/template.ie7.css" type="text/css" media="screen" /><![endif]-->
 <script type="text/javascript" src="<?php echo $templateUrl; ?>/script.js"></script>

<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script type="text/javascript" src="/arquivos/plugins/gioplugin.js"></script>
<script type="text/javascript">
$(document).ready(function(){
$("#lateral-chat-container").parent().parent(".art-blockcontent-body").parent(".art-blockcontent").parent(".art-block-body").parent(".art-block").addClass("klateralchat");
$(".sidebar-makeparentover").parent(".art-blockcontent-body").parent(".art-blockcontent").parent(".art-block-body").parent(".art-block").addClass("klateralchat");
});
</script>
<style type="text/css">
.klateralchat{
z-index:20 !important;
position:relative !important;
}
</style>
</head>
<body>

<!-- INICIO DO GOOGLE ANALYTICS -->
<script type="text/javascript">
var _gaq = _gaq || [];_gaq.push(['_setAccount', 'UA-37868714-1']);_gaq.push(['_trackPageview']);
(function(){var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);})();</script>
<!-- FIM DO GOOGLE ANALYTICS -->



<div id="art-page-background-simple-gradient">
    <div id="art-page-background-gradient"></div>
</div>
<div id="art-main">
<div class="art-sheet">
    <div class="art-sheet-tl"></div>
    <div class="art-sheet-tr"></div>
    <div class="art-sheet-bl"></div>
    <div class="art-sheet-br"></div>
    <div class="art-sheet-tc"></div>
    <div class="art-sheet-bc"></div>
    <div class="art-sheet-cl"></div>
    <div class="art-sheet-cr"></div>
    <div class="art-sheet-cc"></div>
    <div class="art-sheet-body">
<div class="art-header">

    
		<!-- Banner em flash -->
		<object width="960" height="195" class="art-header-jpeg" >
			<param name="movie" value="http://www.centralsigma.com.br/banner-engrenagem-girando.swf"></param>
			<param name="allowFullScreen" value="true"></param>
			<param name="allowscriptaccess" value="always"></param>
			<embed src="http://www.centralsigma.com.br/banner-engrenagem-girando.swf" type="application/x-shockwave-flash" width="960" height="195" allowscriptaccess="always" allowfullscreen="true">
			</embed>
		</object>
	
</div>
<jdoc:include type="modules" name="user3" />
<jdoc:include type="modules" name="banner1" style="artstyle" artstyle="art-nostyle" />
<?php echo artxPositions($document, array('top1', 'top2', 'top3'), 'art-block'); ?>
<div class="art-content-layout">
    <div class="art-content-layout-row">
<?php if (artxCountModules($document, 'left')) : ?>
<div class="art-layout-cell art-sidebar1"><?php echo artxModules($document, 'left', 'art-block'); ?>
</div>
<?php endif; ?>
<div class="art-layout-cell art-<?php echo artxCountModules($document, 'left') ? 'content' : 'content-wide'; ?>">

<?php
  echo artxModules($document, 'banner2', 'art-nostyle');
  if (artxCountModules($document, 'breadcrumb'))
    echo artxPost(null, artxModules($document, 'breadcrumb'));
  echo artxPositions($document, array('user1', 'user2'), 'art-article');
  echo artxModules($document, 'banner3', 'art-nostyle');
?>
<?php if (artxHasMessages()) : ?><div class="art-post">
    <div class="art-post-body">
<div class="art-post-inner">
<div class="art-postcontent">
    <!-- article-content -->

<jdoc:include type="message" />

    <!-- /article-content -->
</div>
<div class="cleared"></div>

</div>

		<div class="cleared"></div>
    </div>
</div>
<?php endif; ?>
<jdoc:include type="component" />
<?php echo artxModules($document, 'banner4', 'art-nostyle'); ?>
<?php echo artxPositions($document, array('user4', 'user5'), 'art-article'); ?>
<?php echo artxModules($document, 'banner5', 'art-nostyle'); ?>
</div>

    </div>
</div>
<div class="cleared"></div>

<?php echo artxPositions($document, array('bottom1', 'bottom2', 'bottom3'), 'art-block'); ?>
<jdoc:include type="modules" name="banner6" style="artstyle" artstyle="art-nostyle" />
<div class="art-footer">
    <div class="art-footer-t"></div>
    <div class="art-footer-l"></div>
    <div class="art-footer-b"></div>
    <div class="art-footer-r"></div>
    <div class="art-footer-body">
         <?php echo artxModules($document, 'syndicate'); ?>
        <div class="art-footer-text">
          <?php if (artxCountModules($document, 'copyright') == 0): ?>
<p>Rede Industrial<br /></p>

          <?php else: ?>
          <?php echo artxModules($document, 'copyright', 'art-nostyle'); ?>
          <?php endif; ?>
        </div>
		<div class="cleared"></div>
    </div>
</div>
		<div class="cleared"></div>
    </div>
</div>
<div class="cleared"></div>
<p class="art-page-footer"><a href="">Rede Industrial</a></p>

</div>




</body> 
</html>