<!DOCTYPE html>
<!-- index.php -->
<html>
  <head>
   <meta charset="UTF-8">
    <title>Welcome to My WebSite!</title>
  </head>
  <body>
    <!-- Статик болон динамик агуулгын ялгаа -->
    <p>Samdan.</p>
    
    <?php echo "PHP скриптээр, програмын кодоор үүсгэсэн динамик агуулга."; ?>
    <p>Вэб серверийн цаг: 
       <span><?php 
              // Системийн цагийг HTTP гаралтад бичих
              echo "Өнөөдөр бол " . date("Y/m/d");
             ?></span>
    <p>
  </body>
</html>
