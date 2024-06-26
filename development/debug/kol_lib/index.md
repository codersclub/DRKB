---
Title: Библиотека KOL
Author: Кладов В.Л. (bonanzas@xcl.cjb.net)
Date: 01.01.2007
Source: [www.emanual.ru](https://www.emanual.ru)
---


Библиотека KOL
==============

KOL - кодоэкономичная объектная библиотека для Delphi


Цель данной статьи - убедить читателя (я надеюсь, этот текст попадет
в руки программиста), привыкшего к большим размерам современных программ
(о, нет, приложений, программы-то как раз были еще не очень большими) в
том, что его бессовестно надувают. Когда утверждают, что программа для
среды Windows, если она что-то полезное умеет делать, никак не может
быть меньше... ну, скажем, трехсот килобайт. А если это очень "умная"
программа, содержащая очень много полезных возможностей, хороший
интерфейс, отлично взаимодействующая с пользователем, поддерживает
различные форматы данных, современные клиент-серверные технологии, то
без полсотни мегабайт ну никак не обойтись. Чушь несусветная. Нас
обманывают!

На самом деле, объектное программирование позволяет создавать очень
экономичный по размеру код. Причем, достаточно эффективный. Примеры?
Пожалуйства. Ява - объектно-ориентированное программирование.
Ява-апплеты очень невелики по своим размерам, а как много полезного они
умеют делать! Впрочем, речь пойдет не о Яве. Предметом данного разговора
будет среда Delphi.

Как ни странно, именно Delphi оказался тем инструментом, с помощью
которого оказалось возможным изготовить библиотеку KOL - Key Objects
Library (Ключевую Объектную Библиотеку). Странно потому, может быть, что
программы, изготовленные средствами Delphi, обычно маленькими не бывают.
Минимальный стартовый размер приложения, представляющего из себя одно
пустое окно, которое можно подвигать по экрану и закрыть, и которое,
собственно, ничего больше делать не умеет, составляет около трехсот
килобайт. Причем, с выпуском каждой очередной версии Delphi этот
стартовый размер вырастает еще на несколько десятков ни в чем неповинных
килобайт.

Библиотека KOL позволяет изготавливать не менее мощные приложения,
чем стандартная библиотека Delphi - VCL (Visual Component Library,
Визуальная Библиотека Компонентов). И при этом добиваться уменьшения
размеров программ в 5-15 раз! Например, приложение DirComp, доступное
для загрузки на сайте KOL, занимает без сжатия упаковывающими
программами около 65 килобайт. Аналогичное приложение, написанное за два
года до этого с использованием стандартной библиотеки Delphi, занимало
750 килобайт. Разница впечатляет, не правда ли?

KOL - не только объектно-ориентированная, но и визуальная библиотека.
Программы и их графический интерфейс возможно проектировать практически
так же, как и в визуальной среде VCL. В дополнение к KOL идет библиотека
MCK (Mirror Classes Kit, Библиотека Зеркальных Классов), которая
содержит VCL-компоненты, устанавливающиеся на палитру обычным образом.
Единственное отличие в том, что зеркальные компоненты библиотеки MCK
существуют только на стадии разработки (design time), участвуя в
генерации "настоящего" кода, совместимого с требованиями библиотеки
KOL. Во время работы (run time) выполняется этот код, и тот, который был
добавлен самим разработчиком. В коде времени исполнения нет ссылок на
компоненты VCL, есть только объекты KOL, компактные и эффективные.

В чем же заключается секрет компактности кода? Ответ не один, но
выделить главные составляющие все же представляется возможным. В первую
очередь следует отметить способность компилятора Delphi не включать в
код конечного приложения невостребованный код. Процедуры и переменные,
на которые нет ссылок из того кода, который уже внесен в список участков
кода, подлежащих включению в конечный продукт, отбрасываются и в
дальнейшей сборке не учавствуют. К сожалению, данная способность
компилятора Delphi, называемая самими разработчиками компилятора "smart
linking" (умное связывание), несколько ограничена. В частности,
виртуальные методы используемых классов и объектов не могут быть изъяты
из процесса компиляции и сборки приложения. Соответственно, и те
переменные и процедуры (методы), на которые имеются ссылки из таких
виртуальных методов, также не могут быть отброшены.

При разработке библиотеки KOL это обстоятельство было учтено. Автору
пришлось отказаться от жесткого следования канонам
объектно-ориентированного программирования. В частности, в KOL один и
тот же объектный тип может использоваться для инкапсуляции нескольких
подобных друг другу объектов. Например, тип TControl не является базовым
для описания визуальных объектов подобно тому, как это сделано в VCL.
Представители объектного типа TControl в библиотеке KOL уже без
какого-либо наследования могут выполнять роль различных визуальных
объектов (кнопок, меток, панелек, и т.п.) - в зависимости от того, какая
глобальная функция использовалась для конструирования каждого
конкретного объекта (например, NewPanel, NewButton и т.д.)

Такое совмещение нескольких объектов в одном объектном типе, вообще
говоря, может приводить к некоторой путанице, поскольку наряду с
методами и свойствами, общими для всех объектов, инкапсулированных этим
объектным типом, могут иметься методы и свойства сугубо индивидуальные,
характерные только для некоторой конкретной разновидности объектов.
Поскольку тип (класс) тот же самый, существует вероятность ошибочного
применения метода, не свойственного для данной разновидности объекта.
Единственная причина, заставившая автора поступать так, это
необходимость избежать большого числи виртуальных методов.

Разумеется, если бы виртуальные методы благополучно пропускались
компилятором в тех случаях, когда они не нужны (а потенциально такая
возможность существует), структуру объектов можно было бы сделать более
ясной. Тем не менее, даже и в этом случае VCL не позволил бы программам
стать намного компактнее. И проблема здесь уже в том, что разработчики
VCL спроектировали свою библиотеку так, что многие объекты создаются и
многие действия производятся еще до того, как будет известно,
понадобятся ли они вообще, или так и останутся лежать в коде программы
мертвым грузом. Например, если создается визуальный объект, то для него
инициализируется шрифт, полотно для рисования, менеджеры перетаскивания,
множество других объектов - на всякий случай: а вдруг понадобятся!
Конечно, программе может понадобиться что-нибудь нарисовать, или
изменить какой-нибудь шрифт. Программа может быть спроектирована для
использования популярного интерфейса расположения плавающих панелей
drag-and-dock. Может, но ведь не обязана, так?

В противоположность VCL, библиотека KOL поступает с необязательными
действиями и объектами значительно более аккуратно. Они (действия)
выполняются и (объекты) инициализируются только тогда, когда они впервые
потребуются. Очистка ресурсов и памяти по завершении использования при
этом проблем как раз не представляет. Один и тот же (виртуальный) метод
Free прекрасно справляется с освобождением отработавших подчиненных
объектов, независимо от их типа. Собственно, это и есть главная причина
того, почему программы, изготовленные с использованием библиотеки KOL,
настолько кодоэкономичны.

В описываемой библиотеке используется несколько различных способов
реализации такого отложенного принятия решения, в зависимости от природы
необязательного к включению в программу кода. Важнее не столько
перечислить эти способы, которые, вообще говоря, являются просто удачным
применением общепринятых программистских приемов, сколько объяснить и
понять суть их действия.

Как известно, исходный текст программы превращается в исполняемый
машинный код в результате работы иногда нескольких программ:
прекомпилятора, компилятора, сборщика. Отметим, что когда речь идет о
среде Delphi, разделять эти шаги особого смысла не имеет, так как все
они выполняются одной и той же программой. Поэтому, говоря
"компилятор", будем подразумевать все эти этапы вместе. Поскольку
именно компилятор Delphi принимает решение, подключать или не подключать
код той или иной процедуры к программе, откладывание решения о
необходимости ее использования путем первого обращения к ней в коде
только тогда, когда ее функциональность оказалась востребована
разработчиком проекта, требует пояснения.

На самом деле, все очень просто разъясняется слеующим небольшим
примером. Пусть наш визуальный объект (кнопка, к примеру) содержит
свойство Font (шрифт). В отличие от VCL, не будем создавать подчиненный
объект, соответствующий этому свойству, в конструкторе нашего объекта
(кнопки, хозяина шрифта). Создадим его в том методе, который выполняет
чтение свойства Font (в методе GetFont), в случае если он еще не создан.
В итоге, если в приложении к свойству Font нигде нет обращений (т.е.
разработчику не было нужды изменять шрифт своих визуальных объектов, и
его устраивают стандартные шрифты, настроенные пользователем),
компилятор не обнаружит и ни одного вызова метода GetFont, и
соответственно, не включит в программу код этого метода. Следовательно,
ни одной ссылки не будет обнаружено ни на конструктор объекта шрифта, ни
на другие процедуры, которые иначе бы оказались задействованы и попали
бы в исполнимый модуль.

Понятно, что приведенный пример поясняет только один из многих
использованных приемов. Но принцип всех таких приемов один и тот же, а 
именно, как уже сказано выше: отложить принятие решения о подключении
дополнительного кода до тех пор, пока он не потребуется разработчику
программногопродукта. По мнению автора, данный принцип в корне
расходится со сложившейся практикой программирования. Пожалуй, на
примере KOL, в частности доказана нелепость общепринятого подхода,
который приводит к тому, что 90% кода в современных приложениях - это
шлак, мусор, который если и работает, то вхолостую, и лишь попусту
затрачивает ресурсы процессора, оперативной памяти, занимает место на
жестком диске, отнимает время при передаче лишних сотен килобайт по сети
и через интернет, и залезает при этом в ваш карман. И недаром в ответ на
вопрос, как уменьшить размер программы, иногда можно получить такой
ответ, что, дескать, зачем уменьшать? - чем больше объем, тем больше
заплатят. (Варианты: "солидней", заказчик больше уважает). Не
бессмыслица ли?

Если кто-то из Delphi-программистов, прочитавших эту статью,
заинтересуется, то милости прошу на интернет-страницу KOL/MCK, берите
себе эти библиотеки (все совершенно бесплатно, в исходных кодах), и
обязательно попробуйте. Уверяю: не пожалеете!

Кладов В.Л.  
Интернет-страница KOL/MCK: <https://sourceforge.net/projects/kolmck/>  
Почта: bonanzas@xcl.cjb.net

