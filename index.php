<?php 

require_once 'odt2html.php';
echo Odt2Html::factory('test/test.odt')->render_inline_images()->get_html_utf8();
