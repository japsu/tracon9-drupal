<?php
/* BEGIN COPY-PASTE FROM 2013 */
function parse_menu($menuarr) {
  $return = Array();
  foreach($menuarr as $item) {
    $return[$item['link']['href']]['title'] = $item['link']['title'];
    if (!empty($item['below'])) $return[$item['link']['href']]['submenus'] = parse_menu($item['below']);
    $activesub = FALSE;
    if (!empty($return[$item['link']['href']]['submenus'])) {
      foreach($return[$item['link']['href']]['submenus'] as $sub) {
        if ($sub['active']) $activesub = TRUE;
      }
    }
    if ($item['link']['href'] == $_GET['q'] || ($item['link']['href'] == '<front>' && drupal_is_front_page()) || $activesub) $return[$item['link']['href']]['active'] = TRUE;
    else $return[$item['link']['href']]['active'] = FALSE;
  }
  return $return;
}

function parse_sub($menu) {
  $return = '';
  foreach($menu as $key => $item) {
    $active = FALSE;
    $curalias = base_path().drupal_get_path_alias($_GET['q']);
    if (strpos(drupal_get_path_alias($_GET['q']), 'uutiset') !== false
      || strpos(drupal_get_path_alias($_GET['q']), 'blog') !== false
      || strpos(drupal_get_path_alias($_GET['q']), 'videot') !== false) {
      if (strpos(drupal_get_path_alias($_GET['q']), drupal_get_path_alias($key)) !== false) {
        $active = TRUE;
      }
    }

    $return .= '<li'.($active || $key == $_GET['q'] || ($key == '<front>' && drupal_is_front_page()) ? ' class="active"' : '').'>';
    if (substr($key, 0, 7) == 'http://' || substr($key, 0, 8) == 'https://') {
      $href = $key;
    } else {
      $href = $key == "<front>" ? base_path() : base_path() . drupal_get_path_alias($key);
    }
    $return .= '<a href="'.$href.'">'.$item['title'].'</a>';
    $return .= '</li>';
  }
  return $return;
}

$menu = parse_menu(menu_tree_all_data('main-menu'));

$main_active = '';
$first = TRUE;
foreach($menu as $key => $menuitem) {
  $class = '';
  if ($first) {
    $class = 'home';
    $first = FALSE;
  }
  if (!empty($menuitem['active'])) {
    if ($class != '') $class .= ' ';
    $class .= 'active';
    $main_active = $key;
  }
  if (substr($key, 0, 7) == 'http://' || substr($key, 0, 8) == 'https://') {
    $href = $key;
  } else {
    $href = $key == "<front>" ? base_path() : base_path() . drupal_get_path_alias($key);
  }
}
/* END COPY-PASTE FROM 2013 */
?>

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

<div class='container'>
  <div class='row'>
    <div class='col-md-3'>
      <?php
      /* BEGIN COPY-PASTE FROM 2013 */
      $curalias = drupal_get_path_alias($_GET['q']);
      if (substr($curalias, 0, 7) == 'uutiset' || substr($curalias, 0, 4) == 'blog' || substr($curalias, 0, 6) == 'videot') {
        $main_active = '<front>';
      }
      if ($main_active != '') {
        print '<ul class="nav nav-pills nav-stacked">';
        $href = $main_active == "<front>" ? base_path() : base_path() . drupal_get_path_alias($main_active);
        print '<li class="'.((!empty($_GET['q']) && $main_active == $_GET['q']) || ($main_active == '<front>' && drupal_is_front_page()) ? 'active' : '').'"><a href="'.$href.'">'.$menu[$main_active]['title'].'</a></li>';
        if (!empty($menu[$main_active]['submenus'])) print parse_sub($menu[$main_active]['submenus']);
        print '</ul>';
      }
      /* END COPY-PASTE FROM 2013 */
      ?>
    </div>
    <div class='col-md-9'>
      <h2><?php print $title ?></h2>
      <?php
      if($tabs) print render($tabs);
      print render($page['content']);
      ?>
    </div>
  </div>
</div>
