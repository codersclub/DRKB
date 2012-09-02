<h1>Как заставить формы минимизироваться на панель задач с анимацией?</h1>
<div class="date">01.01.2007</div>

Автор: Nomadic </p>
<p>Дело-то вот в чем: Главным окном программы дельфийской является не главная форма, а окно TApplication, которое имеет нулевые размеры, поэтому его не видно. Именно для него показывается иконка на панели задач. Когда пользователь нажимает кнопку минимизации на главной форме, команда минимизации передается этому окну, и сворачивается именно оно, а для остальных просто делается hide. А так как окно TApplication имеет нулевые размеры, то и анимации никакой не видно. </p>
<p>А чтобы этого избежать, необходимо: </p>
<p>В исходном тесте модуля проекта после вызова Application.Initialize выполнить вызов</p>
<pre>
// В исходном тесте модуля проекта после вызова Application.Initialize
SetWindowLong(Application.Handle, GWL_EXSTYLE,
GetWindowLong(Application.Handle, GWL_EXSTYLE) or WS_EX_TOOLWINDOW);
</pre>
<p>В исходном тексте модуля главной формы перекрыть следующие методы -</p>
<pre>
// // В классе формы
// Интерфейс
 
protected
procedure CreateParams(var p: TCreateParams); override;
procedure WMSysCommand(var m: TMessage); message WM_SYSCOMMAND;
 
 
 
 
 
// Реализация
procedure TMainForm.CreateParams(var p: TCreateParams);
begin
 
inherited;
p.WndParent := 0;
end;
 
procedure TMainForm.WMSysCommand(var m: TMessage);
begin
 
m.Result := DefWindowProc(Handle, m.Msg, m.wParam, m.lParam);
end;
</pre>
<p>Вместо SetWindowLong в MDI-приложениях лучше использовать</p>
ShowWindow(Application.Handle, SW_HIDE);
<p>&nbsp;</p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

