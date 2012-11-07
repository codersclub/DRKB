<h1>Стандартные компоненты</h1>
<div class="date">01.01.2007</div>


<p>панель стандартных компонент содержит семь компонент: Text, Memo, Section, Bitmap, Metafile, FontMaster и PageNumInit. Некоторые из стандартных компонент используются очень часто при разработке отчета. Данная глава приводит детальное объяснение первых пяти. Оставшиеся два (FontMaster и PageNumInit) будут объяснены в главе «Расширенные компоненты».</p>
<p>Доступ до панели стандартных компонент аналогичен доступу до других панелей. Если она не присутствует на экране, то ее можно показать через меню Tools подменю Toolbar.</p>
<p>Компонент Text</p>
<p>Компонент Text полезен для отображения одной строки текста в отчете. Работает подобно ярлыку, который может содержать простой текст (но не данные). Когда он размещается в отчете, вокруг появляется рамка, которая показывает границы. Ее видно только при выборе компонента (вместе с маркерами).</p>
<p>Компонент можно использовать для ярлыков, например графических рисунков, переменного текста, титулов формы и другого, что нужно представить строкой текста.</p>
<p>Когда компонент выбран, длина текста может быть изменена с помощью маркеров. Заметим, что высота текста само настраиваемая и не требует вмешательства пользователя.</p>
<p>Подобно другим текстовым компонентам, здесь есть свойство Font, которое позволяет изменить тип, размер и стиль. Цвет можно изменить с помощью свойства Color. Текст, отображаемый на экране, задается свойством Text.</p>
<p>Здесь есть также дополнительное свойство Rotation, которое можно использовать для поворота на указанный градус. Эффект виден только в ран тайм.</p>
<p>Компонент Memo</p>
<p>Компонент Memo подобен компоненту Text. Основная разница в том, что Компонент Memo может содержать множество строк текста. Memo можно использовать для зон с объяснениями и для заголовков и комментариев, содержащих более одной строки.</p>
<p>Подобно компоненту Text, рамка вокруг Memo появляется при его выборе. При установке шрифта Memo, все строки текста имеют тот же самый шрифт. Нет возможности иметь различные шрифты для отдельных частей текста.</p>
<p>Для изменения текста в Memo, перейдите в панель свойств и используйте свойство. Свойство Text показывает "(Memo)" и кнопку эллипс, с тремя точками. Нажмите на кнопку эллипса. Это откроет редактор текста. Текст может быть введен в этом редакторе.</p>
<p>Одна из основных проблем при использовании много строчных компонент, то, что текст может накладываться на другие компоненты. Для предотвращения этого, установите свойство ExpandParent в True. Это позволит расширять родителя компоненты Memo для надлежащего поведения компонента Memo.</p>
<p>Как только текст введен, Memo можно расширить. Текст внутри Memo одновременно будет перестроен. Если окажется, что часть текста пропала из просмотра, после ввода текста, просто измените размер, что бы весь текст был видимым.</p>
<p>Компонент Section</p>
<p>Компонент Section используется для группирования компонент. Это предоставляет такие преимущества, как возможность одновременного перемещения всех компонент секции, без выбора компонент для перемещения.</p>
<p>Для использования компонента Section, сначала нажмите на копку компоненту и затем с помощью стрелок сделайте выбор на странице. Когда выбор позиции будет закончен, то появится рамка с маркерами зеленого цвета. Внутри данной области, можно размещать любые компоненты, которые необходимо сгруппировать.</p>
<p>Дерево проекта становится очень полезным при работе с компонентом Section. В развернутом дереве, очень просто увидеть, какие компоненты входят в каждую секцию. Каждая секция и компонент может быть просто выбрана путем выбора объекта в дереве.</p>
<p>Если объект размешен сзади видимой области секции, дерево проекта может быть использовано для выбора объекта. Как только объект выбран, рамки с маркера появятся вокруг объекта. Объект затем может быть удален или помещен (совет: для перемещения используйте кнопки перемещения на панели выравнивания).</p>
<p>Несмотря на то, что связи отношений видны между деревом проекта и компонентом Section, есть необходимость в понимании связи родетель-ребенок между компонентами. Для чтения об этих типах связи смотрите главу «Связи родитель-ребенок». Компонент Section также становится очень важным при зеркальном отражении. Зеркальное отражение будет обсуждено в главе Managing Report Projects (примечание переводчика: такая глава отсутствует в документации и это очень важная часть концепции RAVE). Сейчас же просто знайте, что компонент Section становится главным, и при использовании технологии зеркального отражения чрезвычайно полезным.</p>
<p>Компоненты Bitmap и Meta файлы</p>
<p>Компоненты Bitmap и Meta файлы позволяют размещать изображения в отчете. Битмапы поддерживают файлы с расширением ".bmp", а MetaFile поддерживают файлы с расширением ".wmf" и ".emf".</p>
<p>Для вставки изображения, сначала нажмите, или на BMP или на META кнопках панели стандартных компонент, затем выберите позицию на странице. Рамка размещения с символом X появится на странице, и эта рамка может быть больше чем изображение, которое будет в ней. Это можно исправить после загрузки изображения.</p>
<p>Как только место для BMP или META появится на странице, можно перейти в панель свойств и выбрать свойство FileLink. Нажмите на эллипсе, кнопка с тремя точками.</p>
<p>Это вызовет диалог Open. Найдите свой файл образа и нажмите кнопку Open. Как только изображение загрузится, измените размеры места с помощью маркеров.</p>
<p>Упражнение 18: Text или Memo</p>
<p>Принять решение, что использовать Text или Memo очень просто. Если это только одна строка текста, то используйте компонент Text. Используйте компонент Memo, если у вас более одной строки.</p>
<p>Размещение и изменение компонента Text:</p>
<p>1.          Выберите компонент Text, размещенный на панели стандартных компонент. Кнопка компонента изменит свой цвет, для индикации.</p>
<p>2.        Поместите компонент на страницу. Также заметим, что новый компонент добавится и в дерево проекта.</p>
<p>3.        Перейдите в панель свойств измените имя компонента.</p>
<p>4.        В свойстве Text, измените текст по умолчанию на подходящий.</p>
<p>5.        Посмотрите на панель свойств и на страницу. Заметьте, что дерево проекта показывает новое имя компонента. Так же, компонент на странице показывает введенный текст.</p>
<p>Размещение и изменение компонента Memo:</p>
<p>1.          Выберите компонент Memo, размещенный на панели стандартных компонент. Кнопка компонента изменит свой цвет, для индикации.</p>
<p>2.        Поместите компонент на страницу. Также заметим, что новый компонент добавится и в дерево проекта.</p>
<p>3.        Перейдите в панель свойств и измените, имя компонента. Это изменит имя и в дерево проекта.</p>
<p>4.        В панели свойств выберите свойство Text. Нажмите на эллипс, кнопка с тремя точками (…).</p>
<p>5.        Появится редактор Memo. В редакторе Memo, введите текст, который будет размещен на странице. Memo распознает клавишу Enter. Помните, что Memo занимает тот размер, который установлен на странице.</p>
<p>5.        По окончанию нажмите кнопку OK.</p>
<p>7.        Когда закончите, переместите Memo и установите его размер, с помощью зеленых маркеров.</p>
<p>Упражнение 19: компонент Section</p>
<p>Создание и использование компонента Section:</p>
<p>1.          Выберите компонент Section. Кнопка компонента изменит свой цвет, для индикации.</p>
<p>2.        Щелкните по странице, появится рамка из точек с маркерами на ее границах. Это компонент Section.</p>
<p>3.        Обратите внимание, что в дереве проекта компонент был добавлен к компоненту Page.</p>
<p>4.        Пока компонент выбран, поместите на него любые другие компоненты. Когда выполните, снова посмотрите и заметьте, что компоненты добавлены к этой секции.</p>
<p>5.        Все добавленные компоненты в секцию, могут перемещаться одновременно. Попробуйте это сделать, поместите курсор на границу секции и, удерживая кнопку мыши, потаскайте секцию по странице.</p>
<p>6.        Секции также можно изменить размеры. Выберите маркер и, удерживая кнопку мыши, переместите курсор в нужном направлении.</p>
<p>7.        Когда закончите, щелкните, где ни будь на странице для снятия выбора с секции. Секция имеет невидимую границу, отображаемую точками, но она не печатается.</p>
<p>Упражнение 20: помещение и изменение размера битмапов</p>
<p>1.        Для выполнения данного упражнения, найдите какое ни будь изображение типа битмап (BMP) на вашем компьютере. Данное изображение должно иметь расширение ".bmp". Запомните местонахождения данного изображения.</p>
<p>2.          Создайте новую страницу отчета. Через выбор New Report Page в меню Project.</p>
<p>3.          На панели стандартных компонент, нажмите на кнопку BMP.</p>
<p>4.        Затем нажмите где ни будь на странице, что бы бросить Bitmap компонент. Появится зеленые маркеры на краях рамки.</p>
<p>5.        Пока еще Bitmap компонент выбран, перейдите в панель свойств. Найдите свойство FileLink. Здесь есть кнопка с тремя точками, называемая эллипс. Нажмите на ее.</p>
<p>6.        Используя выпадающее меню Look и используя картинку внизу. Появится диалог Open Bitmap. Найдите ваш битмап на компьютере и нажмите кнопку Open.</p>
<p>7.        Изображение появится на странице с зелеными маркера вокруг него.</p>
<p>8.        Снова перейдите в панель свойств и найдите свойство MatchSide. Данное свойство управляет пропорциями при изменении размера с помощью маркеров.</p>
<p>9.        Выберите по очереди каждый из вариантов и попробуйте изменять размер, что бы увидеть эффект от применения свойства.</p>
<p>10.        Вариант msBoth. Позволяет изменять любую сторону в любом направлении.</p>
<p>11.        Вариант msHeight. Позволяет изменять высоту, сохраняя правильные пропорции. Используйте верхний и нижний маркер.</p>
<p>12.        Вариант msInside. Позволяет делать пропорциональное изменение, но только в пределах ограниченными маркерами. Изображение не может покинуть границы маркеров.</p>
<p>13.        Вариант msWidth. Делает пропорциональное изменение, использую левый или правый маркер.</p>
