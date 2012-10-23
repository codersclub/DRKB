<h1>Эксперты в Delphi или Программист, упростите себе жизнь</h1>
<div class="date">03.11.2004</div>


<p>Имеющее множество достоинств и довольно популярное средство разработки Delphi позволяет расширять функциональные возможности среды разработчика. Речь идет не о косметических изменениях в интерфейсе и не о добавлении компонентов или их наборов, а о придании рабочему окружению программиста новых полезных возможностей, не предусмотренных его создателями. Для решения подобной задачи в Delphi можно воспользоваться так называемыми экспертами. Вспомните, как удобно, ответив на несколько вопросов, создать готовую форму для вывода содержимого таблиц. Или, щелкнув мышью на нужном элементе в списке New Items, получить &#8220;костяк&#8221; вашего будущего проекта (рис. 1). </p>
<p><img src="/pic/clip0248.gif" width="310" height="228" border="0" alt="clip0248"></p>
<p>Рис. 1. Многие возможности Delphi реализуются с помощью экспертов </p>
<p>Что это &#8212; стандартные возможности рабочей среды? Да, но применить их можно лишь с помощью эксперта. О том, как это сделать, и пойдет речь далее. </p>
Эксперты в Delphi &#8212; что это такое? </p>
<p>Если не хватает возможностей среды или какие-то операции кажутс слишком громоздкими, то эксперты &#8212; именно то, что нужно. С помощью экспертов вы словно проникаете внутрь среды Delphi и без труда дополняете ее. Естественно, такое проникновение должно быть осторожным и аккуратным, потому как неправильное обращение с объектами и интерфейсами может вызвать сбои в работе среды или даже ее разрушение. Эксперты могут существовать в виде библиотек DLL либо компилированных модулей DCU. Выбор &#8220;формы жизни&#8221; будущего эксперта остается за вами, но имейте в виду, что расширение файла эксперта определяет способ его регистрации. О способах регистрации чуть далее &#8212; сперва давайте рассмотрим стили экспертов Delphi. Их всего четыре, и все они приведены в таблице.</p>
<p>Стили экспертов </p>
<p><img src="/pic/clip0249.gif" width="671" height="221" border="0" alt="clip0249"></p>
<p>Главное отличие между стилями заключается в способе вызова эксперта пользователем в среде Delphi. Как видите, можно определить самый удобный из них. Реализация экспертов предполагает использование интерфейса Open Tools API &#8212; набора классов, позволяющего обращатьс ко множеству функций среды Delphi. В экспертах Open Tools API может использоватьс для: </p>
&#183; Получения информации о проекте;  <br />
&#183; Получения информации о модуле или форме;  <br />
&#183; Управления модулями проекта (дл открытия, закрытия, добавления, создания);  <br />
&#183; Управления ресурсами проекта;  <br />
&#183; Модификации меню Delphi;  <br />
&#183; Регистрации изменений в проекте;  <br />
&#183; Регистрации изменений в модуле.<br /><br />
<p>Следует заметить, что интерфейс Open Tools API доступен только из программ, запущенных как часть интегрированной среды Delphi. В следующем разделе мы рассмотрим несколько полезных экспертов. </p>
Реализация класса TIExpert </p>
<p>Для создания нового эксперта необходимо наследовать новый класс от класса TIExpert, переопределив при этом часть его методов (таблица 2)</p>
Возможность переопределени методов экспертов тех или иных стилей <br>
<img src="/pic/clip0250.gif" width="259" height="249" border="0" alt="clip0250"></p>
<p>Все девять методов (таблица 3) предоставляют информацию об эксперте и организуют его взаимодействие со средой. TIExpert &#8212; это абстрактный виртуальный класс с заданными, но не реализованными функциональными возможностями. От этого класса будут порождены другие, имеющие необходимые возможности.</p>
<p><img src="/pic/clip0251.gif" width="608" height="529" border="0" alt="clip0251"></p>
<p>Определение класса TIExpert приведено далее. </p>
<pre>
TIExpert = class(TInterface)
public
{ Методы пользовательского
интерфейса с экспертом }
function GetName: string;
virtual; stdcall; abstract;
function GetAuthor: string;
virtual; stdcall; abstract;
function GetComment: string;
virtual; stdcall; abstract;
function GetPage: string;
virtual; stdcall; abstract;
function GetGlyph: HICON;
virtual; stdcall; abstract;
function GetStyle:
TExpertStyle; virtual; stdcall;
abstract;
function GetState:
TExpertState; virtual; stdcall;
abstract;
function GetIDString: string;
virtual; stdcall; abstract;
function GetMenuText: string;
virtual; stdcall; abstract;
{ Запуск эксперта }
procedure Execute; virtual;
stdcall; abstract;
end; 
</pre>

<p><b>Open Tools API</b></p>
<p>Open Tools API &#8212; это набор интерфейсов; они предоставляют доступ к среде Delphi и позволяют управлять файлами и проектами. Основной объект Open Tools API &#8212; ToolServices &#8212; это глобальная переменная. При запуске Delphi создается экземпляр класса TIToolServices, и переменной ToolServices присваивается ссылка на него. Эксперты могут использовать ToolServices дл доступа к функциям среды разработки.</p>
<p><img src="/pic/clip0252.gif" width="556" height="578" border="0" alt="clip0252"></p>
<p>Любой сервис, предоставляемый Open Tools API, прямо или косвенно вызывается через ToolServices. В таблице приведено краткое описание Open Tools API.</p>
<p>Переопределение методов &#8212; задача довольно простая; она предполагает написание всего нескольких строк кода. Например, реализация метода GetStyle вряд ли отнимет у вас много времени: </p>
<pre>
function MyExpert.GetStyle:
TexpertStyle
begin
Result := [esStandard];
end; 
</pre>

Регистрация экспертов</p>
<p>Зарегистрировать эксперт можно одним из двух способов. Первый способ сводится к определению эксперта как компонента путем вызова процедуры RegisterLibraryExpert из процедуры Register. Второй способ заключается в создании DLL-библиотеки эксперта. Преимущество первого способа в том, что не приходитс закрывать среду Delphi при внесении изменений в эксперт &#8212; достаточно его перекомпилировать. Сперва рассмотрим регистрацию эксперта как компонента. Необходимо добавить в модуль эксперта процедуру Register: </p>
<pre>
Procedure Register;
Implementation {$R*.DFM}
Procedure Register;
Begin
RegisterLibraryExpert
(TPowerExpert. Create);
// TpowerExpert — это класс регистрируемого эксперта
End; 
</pre>

<p>Для регистрации эксперта как DLLбиблиотеки следует выполнить две операции: реализовать новый проект DLL и изменить содержимое системного реестра Windows. Итак, создаем DLL. Выполните команду File р New, а затем укажите Delphi, что необходимо создать DLL. В результате появится новое окно модуля с неким набором исходного кода. После этого следует экспортировать функцию InitExpert. Обратите внимание, что эта функция экспортируется с помощью специальной константы ExpertEntryPoint, которую Delphi определяет для всех экспертов, создаваемых в виде DLL. Основное назначение функции InitExpert &#8212; возврат ссылки на объект ToolServices для дальнейшего использования и вызова процедуры RegisterProc, которая, собственно, и регистрирует эксперт. Ниже приведена реализация этой функции: </p>
<pre>
Function InitExpert(
ToolServices:ToolServices;
RegisterProc:TexpertRegisterProc;
var
Terminate:TExpertTerminateProc):
Boolean; export; stdcall;
implementation
procedure TerminateExpert;
begin
// завершение работы эксперта
end;
function InitExpert(
ToolServices:ToolServices;
RegisterProc:TExpertRegisterProc;
var
Terminate:TExpertTerminateProc):
Boolean; export; stdcall;
begin
Result:=False;
end;
// проверка, является ли запущенное приложение единственным
if (ToolServices=nil) or Assigned(ExptIntf.ToolServices)
then Exit;
ExptIntf.ToolServices:=ToolServices;
//сохраняем указатель на ToolServices
Application.Handle:=
ToolServices.GetParentHandle;
//сохраняем указатель на
ToolServices для родительского
окна
Terminate:=TerminateExpert;
//устанавливаем процедуру завершения
RegisterProc(TGenericExpert.Create);
//регистрация эксперта
Result:=True;
end; 
</pre>

<p>Когда DLL с экспертом будет готова, от вас потребуется лишь изменить системный реестр так, чтобы Delphi &#8220;знала&#8221; расположение библиотеки с экспертом и смогла ее загрузить. Для этого с помощью редактора реестра (regedit.exe) добавьте в реестр такую запись:</p>
<p>&nbsp;<br>
<p>HKEY_CURRENT_USER\Software\Borland\ Delphi\4.0\Experts MyExpert=C:\MyExpertts\MyExpert.DLL</p>
<p>&nbsp;<br>
<p>Для того чтобы среда зарегистрировала DLL, Delphi необходимо перезапустить. Вариант реализации эксперта в виде DLL кажетс автору менее удобным: перезагрузка среды отнимает больше времени по сравнению с перекомпиляцией библиотеки компонентов, что особенно ощутимо при отладке эксперта. Еще одна проблема &#8212; неполна совместимость экспертов в виде DLL, которые были созданы и скомпилированы для других версий Delphi. Автор надеется, что эта стать поможет профессионалам поближе познакомиться с экспертами Delphi. Возможно, ее публикация подтолкнет многих программистов к изучению темы. </p>
Некоторые полезные эксперты</p>
<p>Знаете ли вы, что в Internet есть предостаточно мест, где можно найти эксперты для Delphi. Одно из таких мест &#8212; польский сервер &#8220;Delphi Super Page&#8221; (http://sunsite.icm.edu.pl/delphi/). Там вы найдете множество различных экспертов и полезных компонентов. Давайте рассмотрим самый интересный, по мнению автора, набор экспертов, предоставляющий возможность ускорить разработку приложений на Delphi. Его можно загрузить по адресу: http://sunsite.icm.edu.pl/delphi/ftp/d40free/myexp100.zip. </p>
<p>Рассмотрим вкратце эти маленькие &#8220;добавки&#8221;. Набор содержит эксперт &#8212; редактор префиксов для имен компонентов. После того, как он будет установлен в инспекторе объектов, напротив свойства Name появится кнопка с многоточием. Это говорит о том, что можно воспользоватьс редактором для изменения свойства Name. С его помощью можно указывать префикс для данного класса компонента. Строго говоря, использование префиксов в названиях компонентов &#8212; это правило хорошего тона. В меню Tools теперь появляется новое подменю Prefix list editor, с помощью которого можно изменять и добавлять такие префиксы. </p>
<p>Как известно, некоторые компоненты являются контейнерами для других (например, TPanel, TGroupBox, TScrollBox и т. п.). Установленный набор позволит управлять выравниванием дочерних компонентов. Для этого достаточно щелкнуть правой кнопкой мыши и выбрать в контекстном меню пункт Align controls. В Delphi есть мастер создания элементов управления, работающих с данными. </p>
<p>Однако в рассматриваемом наборе имеется эксперт, благодаря которому можно создавать компоненты для работы с данными более совершенным способом. С помощью эксперта, вызываемого командой Tools р Shortcut list editor, можно определить свой набор клавиатурных эквивалентов для главного меню Delphi. Кроме всего прочего, после установки набора вы обнаружите, что палитра компонентов Delphi стала многострочной (рисунок). Так вы получите возможность просматривать больше закладок, чем ранее.</p>
<p><img src="/pic/clip0253.gif" width="654" height="114" border="0" alt="clip0253"></p>

<div class="author">Автор: Олег Гопанюк, ведущий программист департамента "KM-Solution" корпорации "Квазар-Микро" <a href="https://www.cpp.com.ua" target="_blank">https://www.cpp.com.ua</a></div>


