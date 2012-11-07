<h1>Рождение, жизнь и гибель формы</h1>
<div class="date">01.01.2007</div>


<p>Перевод одноимённой статьи с сайта delphi.about.com )</p>

<p>В Windows основной элемент пользовательского интерфейса - форма. В Delphi каждый проект имеет по крайней мере одно окно - главное окно приложения. Все окна в Delphi основаны на объекте TForm. В данной статье мы рассмотрим основные события учавствующие в "жизни формы".</p>

<p>   Форма</p>
<p>Формы имеют свои свойства, события и методы, при помощи которых Вы можете управлять видом и поведением формы. Форма, это обычный компонент Delphi, но в отличие от других, её нет на панели компонентов. Обычно форма создаётся при создании нового проекта (File | New Application). Вновь созданная форма будет главной формой приложения.</p>

<p>Дополнительные формы в проекте создаются через File | New Form. Так же существуют и другие способы создания форм, но здесь мы не будем рассматривать их...</p>

<p>Как и любой другой компонент (объект) форма имеет свои методы и реагирует на события. Давайте рассмотрим некоторые из этих событий...</p>

<p> Рождение</p>

<p>OnCreate -&gt; OnShow -&gt; OnActivate-&gt; OnPaint -&gt; OnResize -&gt; OnPaint ...</p>

<p>OnCreate</p>
<p>Событие OnCreate возникает при создании TForm и только один раз. При создании формы (у каторой свойство Visible установлено в True), события произойдут в следующем порядке: OnCreate, OnShow, OnActivate, OnPaint.</p>
<p>В обработчике события OnCreate можно сделать какие-либо инициализационные действия, однако, любые объекты созданные в OnCreate будут уничтожены в событии OnDestroy.</p>

<p>OnShow</p>
<p>Это событие генерируется, когда форма станет видимой. OnShow вызывается сразу перед тем, как форма станет видимой. Это событие случается, если установить свойство формы Visible в True, либо при вызове методов Show или ShowModal.</p>

<p>OnActivate</p>
<p>Это событие генерируется, когда форма становится активной, тоесть когда форма получает фокус ввода. Это событие можно использовать для того, чтобы сменить элемент формы который должен получить фокус.</p>

<p>OnPaint, OnResize</p>
<p>Эти события вызываются каждый раз, когда форма изначально создаётся. При этом OnPaint вызывается каждый раз, когда какому-нибудь элементу формы необходимо перерисоваться (это событие можно использовать, если необходимо при этом рисовать на форме что-то особенное).</p>

<p>   Жизнь</p>
<p>Когда форма создана и все её элементы ждут своих событий, чтобы обрабатывать их, жизнь формы продолжается до тех пор, пока кто-нибудь не нажмёт крестик в верхнем правом углу формы!</p>

<p>   Уничтожение</p>
<p>При уничтожении формы, события генерируются в следующем порядке:</p>


<p>... OnCloseQuery -&gt; OnClose-&gt; OnDeactivate -&gt; OnHide -&gt; OnDestroy</p>



<p>OnCloseQuery</p>
<p>Если мы попытаемся закрыть форму при помощи метода Close либо другим доступным способом (Alt+F4 либо через системное меню), то сгенерируется событие OnCloseQuery. Таким образом, это событие можно использовать, чтобы предотвратить закрытие формы. Обычно, событие OnCloseQuery используется для того, чтобы спросить пользователя - уверен ли он (возможно в приложении остались несохранённые данные).</p>

<p>procedure TForm1.FormCloseQuery(Sender: TObject; var CanClose: Boolean);</p>
<p>begin</p>
<p> if MessageDlg('Really close this window?', mtConfirmation, [mbOk, mbCancel], 0) = mrCancel then</p>
<p>   CanClose := False;</p>
<p>end;</p>

<p>Обработчик события OnCloseQuery содержит переменную CanClose, которая определяет, можно ли форме закрыться. Изначальное значение этой переменной True. Однако в обработчике OnCloseQuery можно установить возвращаемое значение CloseQuery в False, чтобы прервать выполнение метода Close.</p>

<p>OnClose</p>
<p>Если OnCloseQuery вернул CanClose=True (что указывает на то, что форма должна быть закрыта), то будет будет сгенерировано событие OnClose.</p>
<p>Событие OnClose даёт последний шанс, чтобы предотвратить закрытие формы. Обработчик OnClose имеет параметр Action со следующими четырьмя возможными значениями:</p>
<p>caNone. Форме не разрешено закрыться. Всё равно, что мы установим CanClose в False в OnCloseQuery.</p>
<p>caHide. Вместо закрытия, форма будет скрыта.</p>
<p>caFree. Форма будет закрыта, и занятые ей ресурсы будут освобождены.</p>
<p>caMinimize. Вместо закрытия, форма будет минимизирована. Это значение устанавливается поумолчанию у дочерних форм MDI.</p>

<p>Замечание: Когда пользователь шутдаунит Windows, то будет вызвано OnCloseQuery, а не OnClose. Если Вы не хотите, чтобы Windows завершила свою работу, то поместите свой код в обработчик события OnCloseQuery, хотя CanClose=False не сделает, того, что надо здесь.</p>

<p>OnDestroy</p>
<p>После того, как метод OnClose будет обработан и форма будет закрыта, то будет вызвано событие OnDestroy. В OnCreate обычно делаются действия, противоположные тем, которые проделывались в OnCreate, то есть уничтожение созданных объектов и освобождение выделенной памяти.</p>

<p>Естевственно, что когда главная форма проекта будет закрыто, то приложение будет завершено.</p>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>




