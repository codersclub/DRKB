---
Title: Alexa Rank, Google PR, Yandex тИЦ
Date: 01.01.2007
Author: Александр (Rouse\_) Багель
Source: <https://rouse.drkb.ru>
---


Alexa Rank, Google PR, Yandex тИЦ
=================================

Данный программный класс, в результате своей работы, получает текущие
индексы страницы с трех самых популярных ресурсов.
Это, прежде всего, Текущий Индекс Цитирования, т.н. Yandex тИЦ, Alexa
Rank и соответственно Google Page Rank.

По поводу первых двух ничего сложного нет, выполняется обычный запрос с
указанием страницы и разбор вернувшегося XML документа. А вот с Google
Page Rank пришлось повозиться.

Google Toolbar при запросе использует контрольную сумму, которая
рассчитывается на основании имени ресурса. Сделано это естественно с
целью, чтобы вот такие компоненты, как FWPageRank не появилялись в сети
и получать значение Google PR можно было только при помощи Google
Toolbar.

Но... как говорится, на каждую хитрую... ну вы и сами дальше знаете :)

Польуйтесь :)

Скачать демонстрационный пример: [fwpagerank.zip](fwpagerank.zip) 9Kb
