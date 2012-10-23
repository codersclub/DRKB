<h1>Компоненты отчета</h1>
<div class="date">01.01.2007</div>


<p>Панель отчета одна из самых наиболее используемых при работе с отчетами по базам данных. Жизненно важно понять функции каждого компонента, особенно основы построения отчетов по базам данных, базирующие на данной панели.</p>
<p>&nbsp;</p>
<p>Следующие компоненты часто используются при разработке отчетов:</p>
Band, CalcText, DataBand, DataMemo, DataText, Region</p>
<p>Следующие компоненты будут объяснены в главе «Расширенные компоненты»:</p>
CalcController, CalcOp, CalcTotal, DataCycle, DataMirrorSection</p>
<p>Следующие компоненты не визуальные:</p>
CalcController, CalcOp, CalcTotal, DataCycle</p>
<p>Есть несколько общих характеристик компонент, которые обсудить перед рассмотрением каждого компонента в отдельности. Сначала, поговорим о цветах компонент. Большая часть компонент выглядит одинаково с другими компонентами, они серые. Но, в конце панели расположены компоненты, у которых зеленый цвет. Зеленый цвет указывает, что это не видимые компоненты. При помещении их на панель, они не видны на окне, в просмотре или на печати. Что бы увидеть эти компоненты пользователь должен использовать дерево проектов для выбора, перемещения или удаления их со страницы.</p>
<p>Большинство компонентов отчета помещаются на страницу. Только два компонента имеют исключение, это компоненты Band и DataBand. Они должны помещаться в компонент Region. Поведение этих компонент управляется установками, сделанными в "Band Style Editor", который доступен через свойство BandStyle обеих компонент.</p>
<p>Отчет может быть разработан как типичный отчет, с использованием Bands. Но уникальное возможность Rave в том, что отчет может быть разработан для других спецификаций. Компоненты Bands отчета могут перемещаться или изменять размер до нужного образа.</p>
<p>При разработке отчета, окно дизайнера может быть изменено для предпочтений дизайнера отчета.</p>
<p>Есть несколько путей управлять видом компонент Bands при разработке. Первый путь это должны ли быть видимы или нет, все заголовки компонент ALL Band Headers. Данная установка может быть изменена в панели дизайнера. Другой метод это переключение видимости содержимого Band. Если некоторая часть дизайна Band стабильна, ее можно временно спрятать, установив свойство DesignerHide в True. Будут видны только те компоненты, у которых это свойство установлено в False. Это нужно если есть большое количество компонент Band или компонент Band занимает большое пространство. Установка свойства DesignerHide не оказывает эффекта на печать, только на показ в дизайнере страницы.</p>
<p>Компонент Region</p>
<p>Что бы правильно использовать компонент Region, важно понять, что это такое. Region это контейнер для компонент Band. В простейшем форме Region должен занимать всю страницу. Это верно для печати списков.</p>
<p>Многие master-detail отчеты могут быть сделаны с помощью единственного региона. Но вы не обязаны думать о регионе, как о целой странице. Свойства региона распространяются только на положение и размер региона, занимаемый им на странице. Сознательное использование регионов дает больше гибкости, когда Вы разрабатываете сложные отчеты.. множество регионов могут быть размещены на одной странице. Они могут быть бок о бок, один над другим или вообще гулять по странице. Не путайте регионы с секциями. Компоненты Region содержать компоненты Band и только Band. А компоненты Section могут содержать любые группы компонент, включая другие компоненты Region.</p>
<p>При работе с компонентами Band, есть простое правило, которому обязательно следовать: компоненты Band должны быть в регионе. Заметим, что количество регионов на странице не ограничено или количество компонент Band внутри региона. Как далеко отчет может разрабатываться визуально, комбинация Region и Band может использоваться для решения задач любой сложности, когда помещает визуальность в разработку. Есть два основных типа: Band и DataBand. Последний используется, когда требуется повторение, например, в master-detail отчетах. Первый используется для неповторяемых нужд.</p>
<p>Компонент DataBand</p>
<p>Компонент DataBand</p>
<p>это специальная версия компоненты Band, работающая с базами данных, используемая для повторяющего получения информации из представления данных. Обычно, компонент DataBand содержит несколько компонент DataText.</p>
<p>Обычное использование DataBand это счета. Счет обычно состоит и заголовка, включая информацию такую, как дата, номер счета, имя клиента и его адрес и одну или более строк содержащих данные счета. В таком сценарии, таблица клиентов является главной, а данные счета находятся в подчиненной таблице. Информация об элементах должна быть размещена в DataBand, и управляться главной таблицей.</p>
<p>Компонент Band</p>
<p>Компонент Band для элементов, которые зафиксированы и не изменяются на странице. Обычно, компонент Band содержит компоненты Text и CalcText. Первичным примером этого, являются заголовки и подвалы. Компонент Band может содержать компоненты баз данных, так поля таблицы могут быть размещены в компоненте Band. Подвал группы может иметь '{CustomerDV.CustomerName} Totals' на этом компоненте Band.</p>
<p>Важным свойством для компонента Band является свойство "ControllerBand". Данное свойство определяет, каким компонентом DataBand управляется Band. Когда контролирующий Band установлен, графический символ на компоненте Band указывает направление контролируемый Band и также цвет символа.</p>
<p>Это поведение управляется "Always Show Band Headers". Данная установка изменяет видимость Band во время разработки. Если установлено в "off" то это дает приближенный к актуальному выводу вид, но не показывает заголовки с их символами и кодами. При начальном использовании Rave более удобным будет установить этот параметр в "on" и получить преимущества визуальной помощи предоставляемой заголовками. Но номер более комфортабельного овладения Band, можно сменить эту установку по необходимым нуждам или предпочтениям. Символьные коды справа на компоненте Band будут объяснены позже в главе «Редактор Band Style». Они дают информацию о состоянии Band. Жирные символы означают ON или активно, бледные off или не активно.</p>
<p>Редактор свойства Band Style</p>
<p>Перейдите в свойство Band Style компоненты Band или DataBand и нажмите на кнопку эллипса для открытия редактора Band Styles.</p>
<p>Это предоставляет простой метод выбора свойств для Band, с помощью установки отметок для активации или деактивации их. Заметим, что компонент Band может иметь несколько различных свойств активных одновременно. Это означает, что Band может быть для обеих Body Header и Body Footer в тоже время.</p>
<p>Область показа в редакторе Band Style была разработана для представления в стиле псевдо последовательном представления отчета. DataBand повторены три раза, что бы подчеркнуть, что это повторяющиеся данные. Текущий Band, который редактируется, отображается жирным, подчеркнутым шрифтом.</p>
<p>Символы и буквы, используемые в редакторе Band Style и в компоненте Band в области Page Layout, разработаны для предоставления информации о каждом состоянии. Основная разница между этими двумя представлениями в том, что редактор Band style показывает компоненты Band в псевдо последовательном порядке, следуя определениям каждого Band. Регион же показывает в порядке, в котором они были брошены на него. Порядок операций, в некоторых случаях, управляется этим порядком. Заголовки (заглавные буквы BGR) печатаются первыми, затем DataBand, затем подвалы (маленькие буквы bgr) для каждого уровня. Тем не менее, если есть больше одного заголовка определенного на конкретном уровне, каждый заголовок компоненты Band печатается в порядке, в котором они размещены в регионе. Так, что если это, технически возможно поместите все заголовки вверху, все компоненты DataBands в середине и все подвалы внизу региона для всех уровней master-detail. Или каждый уровень должен быть «сгрупирован», со своими заголовками, нижними колонтитулами и компонентами DataBand совместно для каждого уровня. Rave позволяет размещать регионы таким образом, что бы был наибольший смысл для порядка разработки. Только помните о порядке выполнения, например все Band одного уровня управляются их порядком внутри региона.</p>
<p>Есть несколько символов разработанных для показа связей Parent-Child / Master-Detail связей различных Band. Символ треугольника (стрелки вверх/вниз) показывают, что компонент Band управляется Master Band с тем же цветом (уровня) и может быть найден в направлении стрелки. Символ ромба представляет Master или управляющий Band. Эти символы кодированы цветом и указывают направление связи Master-Detail. Помните что, может быть связь Master-Detail-Detail, где обе подчиненные таблицы управляются той же самой главной или одна подчиненная управляется другой подчиненной.</p>
<p>Полоса заголовка каждого Band содержит информацию об этом Band. С левой стороны Band есть имя, показывающее регион, на котором он расположен - "RegionName:BandName". Правая сторона Band используется для указания стиля Band с помощью символов. Порядок этих символов на главном компоненте такой "MASTER 1PC". Порядок на контролируемом Band такой "BGRDrgb1PC". Если буквы погашены (серые) то это означает, что данный параметр не активен (off). Буква подсвечена жирным, когда данный параметр активен (ON). Следующая таблица показывает значение различных символов.&nbsp; Примечание переводчика: таблица в книге отсутствует, придется разбираться методом научного втыка.</p>
<p>Компонент DataText</p>
<p>Компонент DataText «чувствительный к данным (data-aware)» . Это означает, что он может быть использован для отображения полей данных базы. Например, можно напечатать информацию о клиенте внутри DataBand. Компонент DataText не ограничивается печатью только данных из поля базы. Через редактор Data Text (доступен через свойство DataField), могут быть отпечатаны, или как переменные отчета (Report Variables), или как параметры проекта (Project Parameters), или как поля базы (DataFields). Смотрите тему редактор DataText. Свойства LookupDataView, LookupDisplay и LookupField определяют определение, которое будет выведено вместо свойств DataView:DataField.</p>
<p>Редактор DataText</p>
<p>Есть два метода доступные для ввода в свойстве DataField. Первый это выбор отдельного поля с помощью перетаскивания. Это хорошо для обычных отчетов, где требуется только одно поле для каждого элемента DataText. Но, есть много других потребностей, где различные поля должны быть объединены. Два типовых примера комбинации: город, штат и почтовый индекс или имя и фамилия. В коде это будет выражено так:</p>
City + '_' + State + '__' + Zip</p>
FirstName + "_" + LastName</p>
<p class="note">Примечание:</p>
символы подчеркиваня здесь представляют пробелы, это только для примера.</p>
<p>Свойство DataField имеет редактор DataText, которые помогает строить сложные выражения составных полей. Для выполнения нажмите на кнопку эллипса и откройте редактор DataText. Редактор дает возможность для объединения полей, параметров или переменных совместно для построения сложных текстовых полей, просто перетаскивая их различных списков&nbsp; и выбора нужных элементов.</p>
<p>Имеется много комбинация в этом редакторе, они будут немного рассмотрены здесь, но попробуйте сами различные комбинации в практике и это должно помочь в освоении редактора.</p>
<p>Заметим, что диалог разделен на четыре группы: поля базы (Data Fields), переменные отчета (Report Variables), параметры проекта (Project Parameters), PIV переменные (Post Initialize Variables) и Data Text. Data Text это окно результата. Посмотрите это окно, вставляя различные переменные. Две кнопки с правой стороны окна это «+» и «&amp;». Плюс добавляет два значения без пробелов, а амперсанд объединяет их с одним пробелом. Первым шагом, это решить, что использовать плюс или амперсанд, затем выбрать текст в одной из трех групп, выше окна Data Text.</p>
<p>Для примера, для добавления поля OrderNo к CustNo, нажмите на кнопку «+», перейдите в группу DataField, разверните список DataField, и выберите OrderNo. Затем нажмите на кнопку «Insert Field» и увидите, что это добавилось в окно DataText. Результат в окне DataText должен быть «CustNo + OrderNumber». Можно добавить еще несколько полей из списка DataField. Заметим элемент «Selected» в группе представления DataView. Если здесь больше одного представления DataView активно, то выберите другое представление DataView, и снова добавьте поле из другого представления.</p>
<p>Но ничто не заставляет думать об объединении только полей DataFields. Переменные отчета «Report Variables» и параметры проекта «Project Parameters» тоже могут быть объединены. Перейдите в группу "Report Variables", откройте список переменных и обратите внимание, какие доступны.</p>
<p>Другой доступный элемент это параметры проекта. Это должны быть параметры «UserName», «ReportTitle» или «UserOption», инициализированные приложением. Для создания списка параметров проекта «Project Parameters», выберите узел Project в дереве проекта (самый верхний элемент). В панели свойств должно быть свойство «Parameters». Нажмите на кнопку эллипса, буден вызван типичный текстовый редактор строк, где&nbsp; Вы можете ввести различные параметры, которые передаются в Rave из приложения, подобно «UserName».</p>
<p>ПРЕДУПРЕЖДЕНИЕ:</p>
<p>Помните использовать «+» или «&amp;» между каждым элементом, которое Вы объединяете в окне Data Text. Вы можете печатать в окне Data Text, так вы можете корректировать ошибки, выделив, удалив или заменив ошибочные значения.</p>
<p>Компонент DataMemo</p>
<p>Компонент DataMemo «чувствительный к данным (data-aware)»</p>
<p>. Это означает, что он может быть использован для отображения поля Memo из представления DataView, почти в любом месте страницы. Основное различие между компонентами DataMemo и DataText в том,&nbsp; что компонент DataMemo предназначен для печати более одной строки. Например, это можно использовать для печати примечаний о счете клиенту внизу каждой страницы счета.</p>
<p>Одно из использования компонента DataMemo это создание писем. Простейший путь для выполнения этого, установить свойства DataView и DataField управлять содержимым поля Memo. Для загрузки редактора писем нажмите на кнопку эллипса на свойстве MailMergeItems. Это позволит изменить элементы установленные в Memo.</p>
<p class="note">Примечание:</p>
<p>Параметр «Case sensitive» выключен. В случае если это важно убедитесь в состоянии данного параметра.</p>
<p>Для использования редактора автоматического создания писем «Mail Merge», нажмите на кнопку «Add». Теперь напечатайте в окне «Search Token» который должен быть заменен в Memo. После как элемент введен, набейте строку замены в окне «Replacement» или нажмите кнопку «Edit» и это запустит редактор DataText, который поможет в выборе различных представлений и полей.</p>
<p>Компонент CalcText</p>
<p>Компонент</p>
<p>CalcText «чувствительный к данным (data-aware)»</p>
<p>. Основное различие между компонентами DataText и CalcText это то, что компонент CalcText специально разработан для выполнения различного рода вычислений и вывода результата данных расчетов. Свойство CalcType определяет тип вычисления и включает Average (среднее), Count (количество), Maximum (максимум), Minimum (минимум) и Sum (сумма). Например, это можно использовать для печати итогов счета вверху каждой страницы счета.</p>
<p>Свойство CountBlanks определяет должны ли включаться пустые значения в расчет среднего и количества в методах расчета. Если RunningTotal установлено в True, тогда результаты вычисления&nbsp; не сбрасываются в ноль после печати.</p>
