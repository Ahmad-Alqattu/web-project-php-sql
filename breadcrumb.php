<link rel="stylesheet" href="css/breadcrumb.css">
<nav class="breadcrumb">
    <ul>
        <?php
        $breadcrumb = array("Home", "Products", "Computers", "Laptops");
        $current_page = "Laptops";

        foreach ($breadcrumb as $step) {
            if ($step == $current_page) {
                echo '<li class="cr-step">' . $step . '</li>';
            } elseif ($step == end($breadcrumb)) {
                echo '<li class="cp-step">' . $step . '</li>';
            } else {
                echo '<li class="rm-step">' . $step . '</li>';
            }
        }






        function buildBreadcrumb() {
  $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  $pathParts = explode('/', $path);
  
  $breadcrumb = '<nav class="breadcrumb">';
  $breadcrumb .= '<a href="/">Home</a>';
  
  for ($i = 1; $i < count($pathParts); $i++) {
    $breadcrumb .= ' / ';
    $breadcrumb .= '<a href="';
    for ($j = 1; $j <= $i; $j++) {
      $breadcrumb .= '/' . $pathParts[$j];
    }
    $breadcrumb .= '">' . ucfirst($pathParts[$i]) . '</a>';
  }
  
  $breadcrumb .= '</nav>';
  
  return $breadcrumb;
}

echo buildBreadcrumb();





        ?>


    </ul>
</nav>