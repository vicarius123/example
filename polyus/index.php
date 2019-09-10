<?php
defined('_JEXEC') or die;
/**
* Template for Joomla! CMS, created with Artisteer.
* See readme.txt for more details on how to use the template.
*/
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'functions.php';
// Create alias for $this object reference:
$document = $this;
// Shortcut for template base url:
$templateUrl = $document->baseurl . '/templates/' . $document->template;
Artx::load("Artx_Page");
// Initialize $view:
$view = $this->artx = new ArtxPage($this);
// Decorate component with Artisteer style:
$view->componentWrapper();
JHtml::_('behavior.framework', true);

function getAllActivity(){
  $db = JFactory::getDbo();
  $query = $db->getQuery(true);
  $query->select('*');
  $query->from($db->quoteName('#__polyus_sport_activity'));
  $query->where($db->quoteName('state') . ' = 1');
  $query->order('date DESC');
  $db->setQuery($query);
  $results = $db->loadAssocList();
  $total = 0;
  foreach($results as $result){

    if($result['type'] == 'Лыжи' || $result['type']=='Велосипед'){
      $total+= round($result['activity']*0.5, 1);
    }elseif($result['type'] == 'Плавание'){
      $total+=round($result['activity']*3, 1);
    }else{
      $total+= round($result['activity'], 1);
    }

  }
  return $total;
}
$total_activity = getAllActivity();
?>
<!DOCTYPE html>
<html dir="ltr" lang="<?php echo $document->language; ?>">
<head>
  <link rel="icon" type="image/png" sizes="16x16 32x32 64x64" href="/images/apple-touch-icon-120x120.png">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900,900i&amp;subset=cyrillic,cyrillic-ext" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <jdoc:include type="head" />
  <link rel="stylesheet" href="<?php echo $document->baseurl; ?>/templates/system/css/system.css" />
  <link rel="stylesheet" href="<?php echo $document->baseurl; ?>/templates/system/css/general.css" />
  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/base/theme.css">
  <!--[if lt IE 9]><script src="https://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="<?php echo $templateUrl; ?>/css/bootstrap.css" media="screen" type="text/css" />
  <link rel="stylesheet" href="<?php echo $templateUrl; ?>/css/template.css" media="screen" type="text/css" />
  <link rel="stylesheet" href="<?php echo $templateUrl; ?>/css/responsive.css" media="screen" type="text/css" />
  <link rel="stylesheet" href="<?php echo $templateUrl; ?>/css/print.css" media="print" type="text/css" />
  <link rel="stylesheet" href="<?php echo $templateUrl; ?>/css/jquery.fancybox.min.css" type="text/css" />
  <!--[if lte IE 7]><link rel="stylesheet" href="<?php echo $templateUrl; ?>/css/template.ie7.css" media="screen" /><![endif]-->

  <?php $view->includeInlineScripts() ?>
  <script>if (document._artxJQueryBackup) jQuery = document._artxJQueryBackup;</script>
  <script src="<?php echo $templateUrl; ?>/jquery.fancybox.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</head>
<body>
  <div id="app">
    <?php if ($view->containsModules('logo') || $view->containsModules('menu') || $view->containsModules('logo-right')) : ?>
      <header class="header">
        <div class="wrapper d-flex">
          <div class="w100 d-flex align-items-center align-self-start">
            <div class="flex-fill">
              <?php echo $view->position('logo', ''); ?>
            </div>
            <div class="flex-fill text-right">
              <img src="/images/from-to2.svg" alt="" class="d-none d-sm-none d-md-none d-lg-block" style="margin-left: auto;">
              <div class="general__activity d-md-block- d-lg-none">
                <span>общая активность *</span>
                <p><?=$total_activity;?><span> км</span></p>
              </div>
            </div>
          </div>
          <div class="d-flex w100 align-self-end">
            <div class="d-flex w100 align-self-end">
              <div class="sepp"></div>
              <div class="flex-fill scrollThis">
                <div class="d-flex justify-content-between">
                  <nav class="main-nav nav align-items-end"><?php echo $view->position('menu', ''); ?></nav>
                  <div class="general__activity d-md-none d-lg-block d-none d-sm-none"><span>общая активность *</span>
                    <p><?=$total_activity;?><span> км</span></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </header>
    <? endif;?>
    <?php echo $view->position('banner1', ''); ?>
    <?php echo $view->positions(array('top1' => 33, 'top2' => 33, 'top3' => 34), 'block'); ?>
    <div class="">
      <?php
      echo $view->position('banner2', '');
      if ($view->containsModules('breadcrumb'))
      echo $view->position('breadcrumb');
      echo $view->positions(array('user1' => 50, 'user2' => 50), 'article');
      echo $view->position('banner3', '');
      echo artxPost(array('content' => '<jdoc:include type="message" />', 'classes' => ' messages'));
      echo '<jdoc:include type="component" />';
      echo $view->position('banner4', '');
      echo $view->positions(array('user4' => 50, 'user5' => 50), 'article');
      echo $view->position('banner5', '');
      ?>
    </div>
    <?php echo $view->positions(array('bottom1' => 33, 'bottom2' => 33, 'bottom3' => 34), 'block'); ?>
    <?php echo $view->position('banner6', ''); ?>
    <?php echo $view->position('debug'); ?>
  </div>
  <script>jQuery.noConflict();</script>


  <script src="https://www.amcharts.com/lib/4/core.js"></script>
  <script src="https://www.amcharts.com/lib/4/charts.js"></script>
  <script src="https://www.amcharts.com/lib/4/themes/material.js"></script>
  <script src="https://www.amcharts.com/lib/4/lang/de_DE.js"></script>
  <script src="https://www.amcharts.com/lib/4/geodata/germanyLow.js"></script>
  <script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>
  <script src="<?php echo $templateUrl; ?>/vue.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script src="<?php echo $templateUrl; ?>/script.js"></script>
  <script type="text/javascript">

  </script>
</body>
</html>
