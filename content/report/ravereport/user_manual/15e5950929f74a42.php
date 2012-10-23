<h1>Обзор компонент</h1>
<div class="date">01.01.2007</div>


<p>Что такое компонент</p>
<p>Компонентом называется то что, размещается на странице, такое как - штрих код, линия, регион, графический примитив (shape) и другие. Компоненты, доступные Rave, находятся на панелях (например, Standard, Drawing, Report и Barcode).</p>
<p>Панели доступны, через выбор меню Tools | Toolbars. Доступные панели показываются в следующем подменю и имеют отметку, если они видимы в текущий момент. После того как панель становится активной, компонент может быть выбран и помещен на страницу. Страница это особый компонент, и более детально рассмотрен в главе «Дизайнер страниц». с каждым компонентом ассоциируется набор свойств. Эти свойства могут быть просмотрены с помощью панели свойств. Установка свойств каждого компонента производится или вводом значения в текстовом диалоге, использование выпадающего меню или нажатием на кнопку с символом эллипса (…).</p>
<p>Есть много свойств ассоциированных с каждым компонентом, но не беспокойтесь об их количестве. Свойства позволяют настраивать поведение компонента и в большинстве случаев значение по умолчанию вполне адекватно. Также, заметьте, что количество свойств может варьироваться в зависимости от уровня пользователя, можно изменить через предпочтения (preferences). Для настройки уровня пользователя откройте закладку environment в диалоге preferences. Смотрите главу «Предпочтения».</p>
<p>Поскольку есть много свойств, ассоциированных с каждым компонентом, данная глава делает фокус в основном на панелях компонент, чем на их свойства. Текущая глава производит хороший обзор каждой панели компонент без детального рассмотрения свойств. Заметим, что многие компоненты имеют общии свойства, так что как только свойство изучено, то оно может быть применено к остальным компонентам.</p>
<p>Компоненты также определяются отношениями к другим компонентам. Данная связь определяется как родитель-дитя. Когда текстовый компонент помещается на страницу, родителем является страница и подчиненным текстовый компонент. По-другому на это можно посмотреть так, что страница содержит текстовый компонент, родительский компонент содержит подчиненный компонент.</p>
<p>Связь родитель-дитя также расширяется на позиционирование компонентов. Любое позиционирование делается относительно верхнего левого угла родителя, это свойства Left и Top, которые используются для определения относительной позиции компонента. Родитель подобен компоненту Section, который может содержать любое количество других компонент; затем если родительский компонент перемещается, его подчиненные компоненты перемещаются одновременно. Если родительский компонент удаляется, то удаляются и все его дети.</p>
<p>Связь родитель-дитя определяется при создании подчиненного компонента. Если подчиненный компонент бросается на родительский компонент, то он становится дитем данного родителя. Если компонент бросаются на страницу, и затем перемещается на другой компонент (такой как Section), то он все равно остается дитем страницы.</p>
<p>Дерево проекта, более подробно описано позже, визуально показывает связь родитель-дитя компонент. В действительности, компонент Project является главным родителем всех отчетов, остальных страниц и объектов данных. Отчеты родители страниц отчета. Страницы родители компонент помещенных на них. Еще есть другие компоненты, которые могут быть родителями, такие как Region (регионы), Band (полосы) и Section (секции).</p>
<p>Панели компонент</p>
<p>Есть четыре стандартные панели компонент. Другие панели компонент могут быть представлены дополнительными add-on пакетами. Нормальный набор компонент следующий: "Standard", "Drawing", "Report" и "Bar Code". Одно из общих свойств, применимое ко всем компонентам, будет объяснено здесь.</p>
<p>Свойство Name используется для задания имени, которое должно быть уникальным. По умолчанию Rave назначает последовательные имена, базируясь на типе компонента, такие как 'Section1', 'Section2' и так далее. Смените его на более описательное, что бы сделать дерево проекта более читабельным и проект более простым для обслуживания. Свойство Name не должно содержать пробелов или специальных символов. Данное имя будет использоваться в панели дерева проектов.</p>
<p>Несколько следующих глав дают обзор четырех панелей компонент. Это служит только как введение, более подробная информация будет сделано позже.</p>
<p>Стандартные компоненты</p>
<p>Панель стандартных компонент, содержит большинство, наиболее часто используемых компонент. Когда панель стандартных компонент видима, выберите и поместите компонент, такой как битмап, секция, текстовый компонент на страницу.</p>
<p>Компонент Text создает одиночную строку текста, которая может быть изменена с помощью панели свойств.</p>
<p>Компонент Memo позволяет отображать несколько строк текста, включая многострочный текст.</p>
<p>Компонент Section это очень специальный компонент, который позволяет объединять несколько компонент.</p>
<p>Компоненты Bitmap и Metafile, позволяют разместить графические образы в отчете. Компонент FontMaster позволяет пользователю определять стандартные шрифты для различных частей отчета, например заголовкам, содержимому и подвалам.</p>
<p>Последний компонент называется PageNumInit, данный компонент позволяет начать нумерацию в отчете.</p>
<p>Используйте эти компоненты для создания базы отчета, вставки текста и образов.</p>
<p>Компоненты штрих кодов</p>
<p>панель штрих кодов компонент содержит шесть компонент: PostNetBarCode, 2of5BarCode, Code39BarCode, 128BarCode, UPCBarCode и EANBarCode.</p>
<p>Они используются для создания всех типов штрих кодов в отчете.</p>
<p>Компоненты рисования</p>
<p>Панель компонентов рисования содержат графические компонент. Это включает рисование линий, квадратов, прямоугольников, кругов и эллипсов.</p>
<p>Компоненты слева направо: Line, HLine, VLine, Rectangle, Square, Ellipse и Circle.</p>
<p>Они используются для рисования графических примитивов и общего форматирования отчета. Используйте их для разделения областей отчета или для создания информативных образов.</p>
<p>Компоненты отчета</p>
<p>Здесь несколько компонент отчета: (слева направо) DataText, DataMemo, CalcText, DataMirrorSection, Region, Band, DataBand, DataCycle, CalcOp, CalcTotal, CalcController. Используйте компонент для взаимодействия с базой и создания функциональных отчетов.</p>
<p>Компоненты с красной точкой в верхнем правом углу, относятся к компонентам&nbsp; данных (Data Aware) и могут отображать информацию из базы данных. Каждый компонент имеет свойство DataView, которое позволяет взаимодействовать с базой данных.</p>
<p>Компоненты зеленым фоном не видимые. Их можно увидеть только в дереве проекта, а не на странице.</p>
<p>Компоненты Band и DataBand должны быть размещены внутри региона (Region). Поэтому при размещении их на странице, сначала поместите Region на страницу, в котором затем разместите Band или DataBand компонент. Нет ограничения на количество компонент Bands в регионе, или обязанности все размещать в одном регионе. Может быть столько регионов, сколько вам нужно. Каждый компонент Band имеет свой собственных набор свойств для управления его поведением. Смотрите главу «Компоненты отчета» для получения более подробной информации..</p>
