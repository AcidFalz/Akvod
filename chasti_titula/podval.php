<?php
/*  Подключаемый скрипт для отображения подвала*/

//Отображаем подвал
echo '
<a href="/podpisatsa/index.php" class="ssilka_v_punkte_menyu pomestit_sleva knopka_ssilka" title="Подписаться на новости">
Подписаться на новости
</a>

<a href="/chto_takoe_akvod/index.php?statiya=rezultati_i_sertifikati/rezultati_i_sertifikati.htm"  class="ssilka_v_punkte_menyu pomestit_sprava knopka_ssilka" title="Результаты испытаний АКВОДа и сертификаты">
Испытания и сертификаты
</a>






<p>';

 include_once("analyticstracking.php");


echo '
</p>

</body>
</html>

';