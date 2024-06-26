---
Title: Indy in depth. Глубины Indy
Date: 12.12.2006
Author: Анатолий Подгорецкий
---


Indy in depth. Глубины Indy
============

**Indy.  
Taming Internet development one protocol at a time.**

Copyright Atozed Software

Indy is Copyright (c) 1993 - 2002, Chad Z. Hower (Kudzu)  
and the Indy Pit Crew - <https://www.nevrona.com/Indy/>

&copy; Анатолий Подгорецкий, 2006, перевод на русский язык

 

## От переводчика

Зачем Я стал переводить данную книгу?
Ну, это потому что по данной теме очень мало информации, особенно на русском языке.
Поэтому я рискнул.
Но поскольку я не профессиональный переводчик, то возможны некоторые погрешности в переводе,
поэтому принимайте как есть. В конце концов, дареному коню в зубы не смотрят.

Перевод основан на старой предварительной версии книги, к сожалению, у меня нет окончательной редакции.
Но даже и в этой редакции, информация, приведенная в данной книге, того стоит.

Об авторах: они пришли из мира Юникс, отсюда некоторая ненависть к Windows и к неблокирующим вызовам.
У авторов также чувствуется некоторый хакерский и даже вирус-мейкерский подход,
это видно из текста, в части приведения примера почти готового трояна,
одобрение нарушения законодательства в части мер по передаче алгоритмов строгого шифрования,
и какими методами это было сделано.
Но все это не снижает ценности данной книги.
Текст, который очень простой и почти не составил сложностей с переводом, кроме некоторых мест.

В настоящее время есть три направления построения Интернет библиотек:

1. библиотеки событийно-ориентированные, большинство компонент Delphi – к этому классу относится ICS (Internet Component Suite от Франсуа Пьетте www.overbyte.be);
2. библиотеки с линейным кодом, структурно ориентированное программирование – к этому классу относится Indy;
3. чистые процедуры и функции, типичный представитель Synapse www.ararat.cz.

Вопрос "что лучше?" – это вопрос религиозный, мне лично нравится первый класс,
который наиболее похож на Delphi, но и остальные также имеют право на существование,
тем более, что в Delphi включена только Indy.
Франсуа Пьетте не согласился на включение его библиотеки в Delphi.

К сожалению, от версии к версии код становится все более и более монстроидальным.

О чем же эта книга?

Если вы подумали, как следует из названия, что про Indy, то это далеко не так.  
**Эта книга не про Indy, это книга про Интернет, про протоколы, термины, методы работы**,
а к Indy относятся только примеры.
Особенно отличается глава 20, в которой приведены примеры миграции на Delphi for .NET.

По окончанию перевода было обнаружено много ошибок,
и благодаря любезной помощи Михаила Евтеева (Mike Evteev) была проведена серьезная корректировка книги.
Мой корявый язык был заменен литературным, уточнена терминология
и были исправлены некоторые грамматические ошибки.

Все, кто участвовал в данной работе, являются полноправными членами команды по переводу данной книги.

При желании вы можете скачать эту книгу в формате PDF:
[Indy-in-Depth.pdf](Indy-in-Depth.pdf) 1 Mb

<!-- TOC -->

