<h1>Как спрятать окно при запуске приложения?</h1>
<div class="date">01.01.2007</div>


<p>oncreate формы ставишь Application.Showmainform:=false; собственно и все , этим решается и вопрос с закладкой в таскбаре и с видимостью формы</p>
<p class="author">Автор ответа: Diamond Cat</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr /><p>Я пытаюсь создать приложение, помещающее во время запуска иконку в системную область панели задач c надлежащим контекстным меню. Тем не менее приложение все еще остается видимым в панели задач. Использование Application.ShowMainForm:=False оказывается недостаточным. </p>
<p>Я тоже столкнулся с этой проблемой, но, к счастью, нашел ответ. Вот маленький код, который классно справляется с проблемой.</p>
<pre>
procedure TMainForm.FormCreate(Sender: TObject);
begin
  Application.OnMinimize:=AppMinimize;
  Application.OnRestore:=AppMinimize;
  Application.Minimize;
  AppMinimize(@Self);
end;
 
procedure TMainForm.AppMinimize(Sender: TObject);
begin
  ShowWindow(Application.Handle, SW_HIDE);
end;
</pre>


<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
