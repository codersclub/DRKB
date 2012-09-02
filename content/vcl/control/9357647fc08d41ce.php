<h1>Доступ к страницам TTabbedNotebook</h1>
<div class="date">01.01.2007</div>


<p>При добавлении компонентов во время выполнения программы, вам необходимо присвоить для каждого компонента свойству parent (контейнер) _страницу_ компонента notebook, а не сам notebook. </p>

<p>Вы можете сделать это следующим образом (пример дан для кнопки):</p>

<pre>
MyButton := TButton.Create( Form1 );  {как обычно...}
...
...
MyButton.Parent := TTabPage( TabbedNotebook1.Pages.Objects[n] );
{ &lt;== где 'n' - индекс желаемой страницы ==&gt; }
</pre>

<p>Свойство notebook 'Pages' имеет тип StringList и содержит список заголовков и объектов 'TTabPage'. </p>

<p>Я сам пользовался этой техникой несколько месяцев. Не могу вспомнить где я сам раздобыл эту информацию, но в документации про это ничего не сказано. Может кто-нибудь знает, где об этом написано? </p>

<p>При добавлении компонента на страницу TabbedNotebook во время выполнения приложения, указатель на желаемую страницу для свойства Parent нового компонента должен быть назначен перед тем, как он будет реально показан. Способ получить доступ ко всем страницам TTabbedNotebook во время выполнения программы - с помощью свойства-массива Objects свойства TabbedNotebook Pages. Другими словами, страничные компоненты хранятся как объекты, присоединенные к имени страницы в списке строк свойства Pages. В следующим коде показано создание кнопки на второй странице компонента TabbedNotebook1:</p>

<pre>
var
NewButton : TButton;
begin
NewButton := TButton.Create(Self);
NewButton.Parent := TWinControl(TabbedNotebook1.Pages.Objects[1])
...
</pre>

<p>Вот как страница TNotebook может быть использована в качестве родителя для вновь создаваемого на ней компонента:</p>
<pre>
NewButton.Parent := TWinControl(Notebook1.Pages.Objects[1])
</pre>

<p>Вот как страница (закладка) TTabSet может быть использована в качестве родителя для вновь создаваемого на ней компонента:</p>
<pre>
NewButton.Parent := TWinControl(TabSet1.Tabs.Objects[1])
</pre>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

