<?php
session_start();
session_destroy();
header('Refresh: 2; URL= /user_data/zenkin/diplom-php-inwork/?/admin/login');
echo "<h3>Вы успешно вышли</h3>";
die;
?>
