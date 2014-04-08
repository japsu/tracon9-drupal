<div class='navbar navbar-inverse navbar-tracon9 navbar-static-top' role='navigation'>
  <div class='container'>
    <div class='navbar-header'>
      <a href='/' class='navbar-brand navbar-logo'></a>
    </div>
    <div class='navbar-collapse'>
      <?php print theme('links__system_main_menu', array(
            'links' => $main_menu,
            'attributes' => array(
              'id' => 'main-menu',
              'class' => array('nav', 'navbar-nav', 'navbar-right'),
            ),
            'heading' => array(
              'text' => t(''),
              'level' => 'h2',
              'class' => array('element-invisible'),
            ),
          )); ?>
    </div>
  </div>
</div>

<div class='jumbotron tracon9-jumbotron'></div>

<div class='container'>
  <div class='row'>
    <div class='col-md-9'>
      <div class='row'>
        <div class='col-md-12'>
          <?php
          if($tabs) print render($tabs);
          print render($page['content']); ?>
        </div>
      </div>
    </div>
    <div class='ads col-md-3'>
      <?php print render($page['sidebar_ads']); ?>
    </div>
  </div>
</div>