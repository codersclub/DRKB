<h1>Поиск фраз и записей переменной длины</h1>
<div class="date">01.01.2007</div>


<p>Для текста переменной длины вы можете использовать DBmemo. Большинство людей это делают сканированием "на лету" (когда оператор постит запрос), но для реального ускорения процесса можно попробовать способ пре-сканирования, который делают "большие мальчики" (операторы больших баз данных): </p>

<p>при внесении в базу данных новой записи она сканируется на предмет определения ключевых слов (это может быть как предопределенный список ключевых слов, так и всех слов, не встречающиеся в стоп-листе [пример: "the", "of", "and"]) </p>

<p>ключевые слова вносятся в список ключевых слов со ссылкой на номер записи, например, "hang",46 или "PC",22. </p>

<p>когда пользователь делает запрос, мы извлекаем все записи, где встречается каждое из ключевых слов, например, "hang" может возвратить номера записей 11, 46 и 22, тогда как "PC" - записи с номерами 91, 22 и 15. </p>

<p>затем мы объединяем числа из всех списков c помощью какого-либо логического оператора, например, результатом приведенного выше примера может быть запись под номером 22 (в случае логического оператора AND), или записи 11, 15, 22, 46 и 91 (в случае оператора OR). Затем извлекайте и выводите эти записи. </p>

<p>для синонимов определите таблицу синонимов (например, "hang","kaput"), и также производите поиск синонимов, добавляя их к тому же списку как и оригинальное слово. </p>

<p>слова, имеющие общие окончания (например, "hang" и "hanged"), можно также сделать синонимами, или, как это делает большинство систем, производить анализ окончаний слов, вычисляя корень по их перекрытию (например, слову "hang" соответствует любое слово, чьи первые 4 буквы равны "hang"). </p>

<p>Конечно, есть множестно технических деталей, которые необходимо учесть, например, организация списков, их эффективное управление и объединение. Оптимизация этой характеристики может вам дать очень быстрое время поиска (примером удачный реализаций могут служить двигатели поиска Nexus, Lycos или WebCrawler, обрабатывающие сотни тысяч записей в течение секунды). </p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
