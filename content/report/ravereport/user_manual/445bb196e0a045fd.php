<h1>Дерево проекта</h1>
<div class="date">01.01.2007</div>


<p>Панель дерева проектов предоставляет простой путь для навигации по структуре проекта. Данный вид дает обзор структуры страниц и структуры в свободном стиле. Поэтому, это делает дерево проекта очень информативной частью дизайнера Rave. Независимо делаете ли Вы простые и сложные отчеты, помните про эту панель, и увидите насколько информативным это может быть.</p>
<p><img src="/pic/clip0203.gif" width="196" height="172" border="0" alt="clip0203"></p>
<p>проект может содержать множество определений в каждой категории: Report Library (библиотека отчетов), Global Page Catalog (каталог глобальных страниц) и Data View Dictionary (словарь данных). Каждый узел (и любые под узлы) могут быть свернуты или развернуты, нажатием на символ плюс/минус. Любые из этих узлов могут быть добавлены из меню Project. Там Вы увидите пункты для каждого из узлов New Report (новый отчет), New Global Page (новая глобальная страница) и New Data View (новый просмотр данных). До добавления новой страницы New Page в отчет, узел Report Library, предварительно выберите нужный отчет и используйте пункт New Page из меню Project.</p>
<p>Развертывание дерева и контекстное меню</p>
<p>Более простым путем выполнения действий над элементами дерева проекта, это использование контекстного меню. Доступно много разных контекстных меню. Выбор контекстного меню на главном узле, типа Report Library вызывает контекстное меню с двумя пунктами Expand All и Collapse All. Данные два пункта предназначены для свертывания или развертывания всех узлов дерева, что предоставляет быстрый путь для доступа ко всем элементам.</p>
<p>Выбор пол-узла, типа Page, вызывает пункты удаления страницы. Может быть меньше или больше доступных функций.</p>
<p>Выбор компонента может показать контекстное меню с множеством пунктов. Те же пункты появляются и при вызове контекстного меню на компоненте в дизайнере страниц. Также, эти пункты отображаются в панели утилит. Может быть меньше или больше доступных функций. Для ускорения создания отчета или навигации по нему быстрой простой требуется разбираться в данных функциях этих контекстных меню.</p>
<p>Связи родитель-ребенок</p>
<p>До этого Вы узнали, как перемещаться по дереву, теперь же мы проведем маленький ликбез, что такое дерево.</p>
<p>Дерево проекта показывается, как дерево растущее вниз. База или корень (root) дерева находится на верху&nbsp; списка. Каждое последовательное вхождение является ребенком корня или веткой дерева. Это делает корень родителем всех его детей. Каждая ветвь также сама по себе является корнем для своих детей.</p>
<p>Техника, использованная в предыдущей главе, показывается, как двигаться по дереву, развертывая узлы, ассоциированные с каждым родителем. Когда ветвь имеет детей, узел появляется слева от имени ветви.</p>
<p>Библиотека отчетов является корнем дерева&nbsp; и имеет одного ребенка, называемого Report1, показанного с подсветкой текста.</p>
<p>Report1 имеет следующих детей: Page1, Page2, Page3, Page4, Page5 и Page6.</p>
<p>Page1 имеет следующих детей: Text1, Text2 и Memo1.</p>
<p>Здесь есть две группы братьев и сестер. Как и реальной семье с родителями и детьми, дети могут иметь братьев и сестер. Первая группа братьев и сестер: Page1, Page2, Page3, Page4, Page5 и Page6.</p>
<p>Первая группа братьев и сестер: Text1, Text2 и Memo1. Могут быть и другие семейные взаимосвязи, но главная, как уже отмечено, это связь родитель-ребенок.</p>
<p>Библиотека отчетов</p>
<p>Узел Report Library (библиотека отчетов) отображает структуру дизайна, включающую все использованные компоненты в каждом из отчетов. Обычно, компонент выбирается на панели страницы, просто отмечая его мышью. Тем не менее, библиотека отчетов также. Первая группа братьев и сестер использована для выбора компонентов, щелчком по имени. Когда мы щелкаем по имени компонентов, то оно подсвечивается. Для выбора нескольких компонентов, придерживайте клавишу Shift, при выборе.</p>
<p>Проект может быть простым, состоящим из одного или двух определений, но может быть и сложным с множеством определений. Каждый отчет, который создается, должен иметь свою собственную структуру. Для выбора и переключения на различные отчеты, просто делайте двойной щелчок на имени отчета в структуре библиотеки отчетов.</p>
<p>СОВЕТ: Чтобы сделать навигацию и отчет, простым для понимания, используйте описательное свойство Name. Смотрите упражнение 4 «именование компонент» в конце данной главы для эффективного использования, данного свойства.</p>
<p>Каталог глобальных страниц </p>
<p>Узел каталог глобальных страниц, где содержатся определения, которые используются как шаблон, которые могут отражаться. Это включает такие вещи как заголовки писем, формы, водяные знаки и другие определения страниц, которые могут использоваться в различных отчетах. Это упрощает общую разработку. Примером может быть отображение секции компонент на глобальной странице, где одинаковое содержимое может быть отпечатано (например, счет), но также может иметь различные заголовки в подвале страниц, например "Original", "File Copy" и "Shipping".</p>
<p>Загрузка и выгрузка глобальных страниц</p>
<p>Глобальные страницы очень полезны и применимы для дизайна, особенно когда они могут быть быстро доступны. Эти страницы могут содержать все типы объектов и компонент, которые могут повторяться и отражаться через множество страниц в различных отчетах. Многие отчеты в библиотеки отчетов могут использовать любую из глобальных страниц каталога.</p>
<p>При создании отчетов, полезным свойством дизайнера Rave является закладки дизайнера страниц. Они расположены вверху окна дизайнера страниц. Здесь все закладки, используемых страниц.</p>
<p>Глобальные страницы можно добавить на закладку для более быстрого доступа, что означает, что разработчику не нужно прокручивать все дерево для поиска нужной, часто используемой&nbsp; страницы. Вместо этого разработчик может просто загрузить страницу в закладки дизайнера и затем просто выбирать нужную страницу. Глобальные страницы могут быть загружены или выгружены закладок дизайнера, просто по правому щелчку мыши на глобальной странице и использованием контекстного меню для выбора. Быстрый путь выгрузить глобальную страницу это выбрать ее в области закладок, зто щелкнуть по странице и нажать клавишу Ctrl+F4.</p>
<p>Словарь данных</p>
<p>Словарь данных в дизайнере Rave это узел где указаны все подключения данных для отчетов. Для добавления просмотра данных в данный список, выберите New Data View из меню Project. Это вызовет диалог Data Connections. Данное окно покажет все подключения данных Rave, которые сейчас активны. Затем выберите любое из них для создания нового просмотра подсоединенного к данному подключению.</p>
<p>Ctrl+Drag&amp;Drop</p>
<p>Ctrl+Drag&amp;Drop используется для создания или зеркального отражения элемента из структуры дерева проекта или другого узла в данной структуре отчета или текущей страницы дизайнера. При перетаскивании из панели дерева проекта на страницу дизайнера, место бросания определяется местом, в котором отпущена мышь. Но, при перетаскивании их одного узла страницы в другой (в панели дерева проекта), по умолчанию, место остается тем же, что и в источнике.</p>
<p class="note">Примечание:</p>
<p>При перетаскивании не видимого компонента, он должен быть отражаемого типа. Копирование для не отражаемых типов не работает. Компоненты Regions и Bands, для которых не разрешено зеркальное отражение. Для зеркального отражения региона, сделайте регион частью секции и затем отразите эту секцию. Секция также может включать и другие компоненты.</p>
<p>ПРЕДУПРЕЖДЕНИЕ:</p>
<p>Перетаскивание (Drag&amp;Drop) работает из страницы отчета в страницу отчета, глобальной страницы в глобальную страницу, глобальную страницу в страницу отчета, но это не работает перетаскивания из страницы отчета в глобальную страницу, поскольку компоненты на отчете не видимы другим отчетам и поэтому не могут отражаться в глобальной странице.</p>
<p>Alt+Drag</p>
<p>Alt+Drag используется для смены родителя компонента в новый контейнер&nbsp; подобный секции. Все перемещения для данного компонента должны быть сделаны в той же самой странице. Когда создается новая секция, пользователь может выбрать все элементы из другой секции для помещения в новую секцию. В этом случае родитель должен быть сменен из старой секции на новую секцию, и затем новая секция может быть зеркально отражена.</p>
<p class="note">Примечание:</p>
<p>Компонент назначения должен быть контейнерного типа. Page, Region и Section все являются хранителями или контейнерами. Так, если есть или более секций на странице, элементы могут быть перетащены в другую секцию. Также все компоненты могут быть перетащены со страницы на одну из секций.</p>
<p>Упражнение 3: навигация по дереву проектов</p>
<p>Поскольку многие проекты отчета очень сложные, иерархическое дерево проекта помогает двигаться по отчетам.</p>
<p>Навигации по иерархии (развертывание, свертывание и выбор):</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 19px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">1.</td><td>разверните элемент путем нажатия на символ плюс. Затем оно сменится на минус и развернет элемент с под элементами, такими как Report1, Page1 и остальными.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 19px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">2.</td><td>свертывание элемента осуществляется нажатием на символ минус, он сменит свое рисунок на символ плюс и свернет все под элементы.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 19px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">3.</td><td>выбор элемента из дерева проекта выполняется нажатием мышкой на нужный элемент. Выбранный элемент подсвечивается.</td></tr></table></div><p>&nbsp;</p>
<p>&nbsp;</p>
<p>Упражнение 4: именование компонент</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">1.</td><td>Поскольку проекты обычно очень сложные, строго рекомендуется давать им значимые имена.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">2.</td><td>По умолчанию, свойство Name получает имя подобное "Report1", "Report2" и так далее. Но гораздо легче управлять проектом, если отчеты имеют более полезные имена. Это можно сделать через свойство Name.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">3.</td><td>при разработке соглашений об именах будьте созидательны, но помните, что пробелы или специальные символы не разрешены в свойстве Name.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">4.</td><td>в примере панели дерева проектов, по умолчанию имена отчетов были изменены. Вместо "Report1" до "Report7", имена отчетов были названы: "CustomerList", "CustomerLabels", "CustomerDue", "Invoice", "PO", "ProductsOnHand" и "ProductsOnOrder". Это важно для понимания, что панель дерева проектов в этом делает проект проще. Но, без информативной системы имен, панель дерева проектов не показывает свой потенциал.</td></tr></table></div><p>Переименование отчета (или других компонент):</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 19px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">1.</td><td>выберите отчет (компонент);</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 19px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">2.</td><td>убедитесь что отчет, который переименовывается выбран. Должен быть подсвечен;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 19px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">3.</td><td>перейдите в панель свойств и найдите свойство Name;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 19px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">4.</td><td>в поле Name, введите нудное имя;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 19px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">5.</td><td>нажмите Enter, после ввода нового имени;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 19px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">6.</td><td>посмотрите в дереве проекта и убедитесь, что имя отчета (компонента) изменилось.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 19px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="27">7.</td><td></td></tr></table></div><p>Упражнение 5: загрузка и выгрузка глобальных страниц</p>
<p>Загрузка и выгрузка глобальных страниц в область закладок дизайнера страниц делает доступ к этим страницам более быстрым и удобным. Это особенно истинно, когда Вы работаете с отображенными секциями и объектами из разных отчетов.</p>
<p>Загрузка глобальной страницы:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 19px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">1.</td><td>запустите новый отчет;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 19px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">2.</td><td>вставьте четыре пустых отчета, выбрав New Report из меню Project или щелчком New Report в панели Project;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 19px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">3.</td><td>затем, выберите "Page1" в первом отчете. Сделайте это с помощью дерева проекта. Отметьте "Page1" в дереве или щелкните на закладке "Page 1" в закладке дизайнера страниц. Как только страница будет выбрана, ее имя будет подсвечено;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 19px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">4.</td><td>добавьте три глобальные страницы в отчет. Сделайте это выбором New Global Page из меню Project или щелчком New Global Page в закладке дизайнера страниц;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 19px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">5.</td><td>заметьте, поскольку первая страница в первом отчете была выбрана при добавлении глобальной страницы в закладке дизайнера страниц. То страницы были добавлены в дерево проектов в каталог глобальных страниц;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 19px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">6.</td><td>щелкните на другой странице отчета. Заметьте, что поскольку была выбрана&nbsp; другая страница в области 7 закладок дизайнера страниц. Для добавления глобальных страниц в область закладок дизайнера страниц сделайте вызов контекстного меню глобальной страницы дерева проекта и выберите Load Page. Попробуйте загрузить все три глобальные страницы;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 19px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">7.</td><td>как только глобальные страницы загрузятся, то они будут видны в области закладок дизайнера страниц;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 19px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">8.</td><td>попробуйте загрузить глобальные страницы к двум другим оставшимся отчетам.</td></tr></table></div><p>Выгрузка глобальной страницы:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 19px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">1.</td><td>закончите шаги из предыдущего упражнения;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 19px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">2.</td><td>выберите страницу из Report 3, которая содержит все загруженные страницы;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 19px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">3.</td><td>есть два пути выгрузки страницы. Один путь это использовать контекстное меню, а другой путь это использовать горячие клавиши;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 19px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">4.</td><td>первый путь использовать контекстное меню, что требует, во-первых, выбрать страницу для выгрузки;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 19px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">5.</td><td>затем, вызвать контекстное меню на глобальной странице и выбрать пункт Unload Page из меню. Повторите его три раза для отчета Report 3;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 19px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">6.</td><td>теперь мы попробуем использовать второй путь;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 19px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">7.</td><td>выберите следующую страницу в Report 4. Убедитесь, что она содержит все глобальные страниц в области закладок дизайнера страниц;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 19px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">8.</td><td>так как страница в Report 4 выбрана, Вы можете видеть три глобальные страницы в области закладок дизайнера страниц, выберите одну из глобальных страниц из области закладок дизайнера страниц;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 19px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">9.</td><td>теперь нажмите Ctrl+F4 для выгрузки страницы;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 19px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">10.</td><td>повторите это для оставшихся глобальных страниц в каталоге.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 19px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="27">11.</td><td></td></tr></table></div><p>Упражнение 6: перетаскивание компонент (Ctrl+Drag)</p>
<p>Одной из обычных задач по перетаскиванию бывает копирование компонента Data Field на страницу в визуальном дизайнере. Приемник должен быть существующим компонентом DataBand или чистой областью страницы. Компонент Data Field будет преобразован в DataText или DataMemo на области назначения, в зависимости от типа поля источника. Выполним это с помощью следующих шагов.</p>
<p>Перетаскивание:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 19px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">1.</td><td>перейдем на узел Data View Dictionary, развернем его, если свернут;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 19px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">2.</td><td>выберем один из Data Views и развернем его, если свернут;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 19px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">3.</td><td>выберем компонент поля для копирования;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 19px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">4.</td><td>нажмем и удерживаем клавишу, теперь тащим это поле на страницу;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 19px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">5.</td><td>отпускаем клавишу мыши и клавишу Ctrl;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 19px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">6.</td><td>выбираем только что скопированное поле и устанавливаем его свойства.</td></tr></table></div><p>Данное упражнение может быть слишком простое, но дадим здесь пользователю шаги необходимые для выполнения перетягивания компонента. Поскольку полный отчет еще не закончен, так что не беспокоимся о его работоспособности.</p>
<p>Упражнение 7: смена родителя компонента (Alt+Drag)</p>
<p>Смена родителя компонента может быть очень полезной, для создания его компонент. Например, скажем, есть страница, содержащая компоненты, которые было бы лучше сгруппировать с секцию. Текущее состояние в том, страница является родителем компонент, которые надо сгруппировать. Для группы элементов, родитель должен быть сменен на компонент секции. После того как это будет сделано, элементы окажутся в секции, которую можно будет потом перемещать межу подобными другими. Есть и обратный смысл, может потребоваться убрать компонент обратно из секции и просто переместить на страницу, просто используйте Alt+Drag для выполнения данной задачи.</p>
<p>Смена родителя компонента: </p>
<p>1. &nbsp; &nbsp; &nbsp; &nbsp;перейдите Report Library, развернем его, если свернут;  &nbsp; &nbsp; &nbsp; &nbsp;<img src="/pic/clip0204.gif" width="163" height="81" border="0" alt="clip0204"> &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>2. &nbsp; &nbsp; &nbsp; &nbsp;развернем узел Report, который содержит страницу с определением;  &nbsp; &nbsp; &nbsp; &nbsp;<img src="/pic/clip0205.gif" width="162" height="114" border="0" alt="clip0205"> &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>3. &nbsp; &nbsp; &nbsp; &nbsp;развернем узел Report, который содержит приемник и источник, что бы они были видны. В Customer Statement, есть секция на странице. Мы сменим родителя у PageNumInit и Memo1 со страницы на секцию; &nbsp; &nbsp; &nbsp; &nbsp;<img src="/pic/clip0206.gif" width="162" height="160" border="0" alt="clip0206"> &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>4. &nbsp; &nbsp; &nbsp; &nbsp;выделим компоненты, у которых мы желаем сменить родителя. Для выделения удерживаем клавишу Shift при выборе компонент. Когда закончим выбор отпустим клавишу Shift. Выбранные компоненты должны быть подсвечены; &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>5. &nbsp; &nbsp; &nbsp; &nbsp;нажимаем и удерживаем клавишу Alt, теперь перетаскиваем на новый родительский компонент. В данном примере, клавиша Alt удерживается при выборе и перетягивании на новый компонент. При перетягивании компонент на нового родителя, видим, что курсор изменяется при попадании не приемник. Когда курсор показывает, что он находится над приемником, освобождаем клавишу мыши и затем клавишу Alt; &nbsp; &nbsp; &nbsp; &nbsp;<img src="/pic/clip0207.gif" width="159" height="147" border="0" alt="clip0207"> &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>6. &nbsp; &nbsp; &nbsp; &nbsp;заметим, что компоненты теперь имеют нового родителя, и у родителя появился маркер минус, указывая, сто у родителя есть несколько компонент; &nbsp; &nbsp; &nbsp; &nbsp;<img src="/pic/clip0208.gif" width="159" height="147" border="0" alt="clip0208"> &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>7. &nbsp; &nbsp; &nbsp; &nbsp;после окончания перемещения новых компонент, они могут быть настроены, как требуется.  &nbsp; &nbsp; &nbsp; &nbsp;</p>

