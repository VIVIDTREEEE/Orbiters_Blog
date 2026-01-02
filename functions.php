<?php
add_action('wp_enqueue_scripts', function () {

  // 1) 부모 테마 CSS
  wp_enqueue_style(
    'oceanwp-parent',
    get_template_directory_uri() . '/style.css'
  );

  // 2) 차일드 테마 style.css
  wp_enqueue_style(
    'oceanwp-child',
    get_stylesheet_directory_uri() . '/style.css',
    ['oceanwp-parent'],
    filemtime(get_stylesheet_directory() . '/style.css')
  );

  // 3) 커스텀 CSS들 (이관한 파일들)
  $css_files = [
    'custom-global'        => '/assets/css/global.css',
    'custom-home-hero'     => '/assets/css/home-hero-banner.css',
    'custom-header-mega'   => '/assets/css/header-megamenu.css',
    'custom-search'        => '/assets/css/search-overlay.css',
    'custom-footer'        => '/assets/css/footer.css',
  ];

  foreach ($css_files as $handle => $path) {
    $abs = get_stylesheet_directory() . $path;

    if (file_exists($abs)) {
      wp_enqueue_style(
        $handle,
        get_stylesheet_directory_uri() . $path,
        ['oceanwp-child'],                // child 이후에 덮어쓰기
        filemtime($abs)
      );
    }
  }
});