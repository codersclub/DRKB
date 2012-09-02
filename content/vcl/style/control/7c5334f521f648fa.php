<h1>Визуальные стили в Delphi</h1>
<div class="date">01.01.2007</div>


<p>TActionManager является своего рода "командным пунктом", из которого должны управляться элементы управления приложения. Нас интересует только одно свойство этого компонента </p>
<pre>
property Style: TActionBarStyle; 
</pre>

<p>По умолчанию среда разработки Delphi предлагает к использованию два стиля: </p>
<p> standard &#8212; приложение использует системную библиотеку ComCtl32.dll версии 5;&nbsp; </p>
<p> windows XP &#8212; приложение использует системную библиотеку ComCtl32.dll </p>
<p>версии 6 и единственный стандартный визуальный стиль Windows XP. </p>
<p>Эти стили применимы только к элементам управления, размещенным на панелях инструментов (TActionToolBar), созданных в компоненте </p>
<p>TActionManager. </p>
<p>Однако не торопитесь возмущаться явной ограниченностью выбора. Вы можете создать собственный стиль самостоятельно. Правда, это потребует очень много усилий &#8212; ведь на основе базовых классов элементов управления вам потребуется создать собственные классы с нужным вам поведением и внешним видом. </p>
<p>Для этого необходимо создать класс нового визуального стиля на основе класса TActionBarstyieEx. Затем новый стиль регистрируется при помощи процедуры </p>
<pre>
 procedure RegisterActnBarStyle(AStyle: TActionBarStyleEx); 
</pre>
<p>После этого ваш стиль становится доступным для свойства style компонента TActionManager. Чтобы отменить стиль, используйте процедуру </p>
<pre>
procedure UnRegisterActnBarStyle(AStyle: TActionBarStyleEx); 
</pre>
<p>Например, обе эти операции удобно выполнить при инициализации и деинициализации модуля, описывающего класс стиля: </p>
<p>Вариант регистрации и отмены собственного визуального стиля&nbsp; </p>
<pre>
var MyStyle: TMyStyleActionBars; 
... 
initialization 
  MyStyle := TMyStyleActionBars.Create; 
  RegisterActnBarStyle(MyStyle); 
finalization 
  UnregisterActnBarStyle(MyStyle); 
  MyStyle.Free; 
end. 
</pre>
<p>Для смены стиля приложения можно использовать глобальную переменную нового стиля (см. листинг 6.3). Ее достаточно присвоить свойству style: </p>
<pre>
ActionManagerl.Style := MyStyle; 
</pre>
<p>При смене стиля все элементы управления, расположенные на панелях компонента ActionManagerl, будут уничтожены и созданы заново с использованием настроек нового стиля. </p>
<p>Класс TActionBarstyieEx имеет всего несколько методов, которые необходимо перекрыть при создании собственного стиля. Все они возвращают классы объектов, используемых при создании пользовательского интерфейса. Рассмотрим их. </p>
<p>Функция </p>
<pre>
function GetStyleName: string; 
</pre>
<p>возвращает имя стиля.&nbsp; </p>
<p>Функция </p>
<pre>
function GetColorMapClass(ActionBar: TCustomActionBar): TCustomColorMapClass;
</pre>
<p>позволяет получить ссылку на класс компонента настройки цветовой палитры (см. разд. "Компоненты настройки цветовой палитры" далее в этой главе), используемый панелью инструментов. </p>
<p>Следующие три метода дают информацию о классах различных типов элементов управления, используемых при проектировании пользовательского интерфейса с помощью компонента TActionManager. </p>
<p>Для того чтобы получить доступ к элементам управления, связанным со стилем, предназначен метод </p>
<pre>
function GetControlClass(ActionBar: TCustomActionBar; AnItem:  
TActionClientltem): TCustomActionControlClass; 
</pre>
<p>Он возвращает класс элемента управления из панели ActionBar, связанного с элементом управления Anitem. Именно эта функция вызывается при создании элементов управления в панелях инструментов компонента&nbsp; </p>
<p>TAct ionManager. </p>
<p>Как уже говорилось выше, при присвоении свойству style компонента TActionManager нового значения (экземпляра класса разработанного вами визуального стиля) уничтожаются все существующие элементы управления и затем создаются новые. И в процессе создания каждого визуального компонента вызывается функция Getcontrolciass нового стиля, а возвращенное ею значение используется для вызова конструктора соответствующего класса. </p>
<p>Аналогично, для получения класса, используемого в панели меню, применяется метод </p>
<pre>
function GetPopupClass(ActionBar: TCustorrActionBar) : TGetPopupClass; 
</pre>
<p>и для классов кнопок панели инструментов применяется функция </p>
<pre>
function GetScrollBtnClass: TCustomToolScrollBtnClass; 
</pre>
<p>А класс самой панели инструментов возвращает функция </p>
<pre>
function GetAddRemoveltemClass(ActionBar: TCustomActionBar): TCustomAddRemoveltemClass;
</pre>
<p>Итак, после разработки и отладки собственных классов элементов управления с заданными свойствами вам потребуется создать потомка от класса TActionBarstyieEx и перекрыть все перечисленные выше функции так, чтобы они возвращали нужные классы для используемых типов элементов управления. </p>

