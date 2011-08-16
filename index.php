<?php 

require_once 'odt2html.php';
echo Odt2Html::factory('test/test.odt')->render_inline_images()->save_to_htmlfile('test.html')->get_html();
