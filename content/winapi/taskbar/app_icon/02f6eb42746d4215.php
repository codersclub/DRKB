<h1>Рисование на минимизированной иконке</h1>
<div class="date">01.01.2007</div>

Автор: Nick Hodges (Monterey, CA)</p>
<p>Есть ли у кого пример рисования на иконке минимизированного приложения с помощью Delphi?</p>
<p>Когда Delphi-приложение минимизировано, иконка, которая вы видите - реальное главное окно, объект TApplication, поэтому вам необходимо использовать переменную Application. Таким образом, чтобы удостовериться что приложение минимизировано, вызовите IsIconic(Application.Handle). Если функция возвратит True, значит так оно и есть. Для рисования на иконке создайте обработчик события Application.OnMessage. Здесь вы можете проверять наличие сообщения WM_Paint и при его нахождении отрисовывать иконку. Это должно выглядеть приблизительно так:</p>
<pre>
...
{ private declarations }
  procedure AppOnMessage(var Msg: TMsg; var Handled: Boolean);
...
 
procedure TForm1.AppOnMessage(var Msg: TMsg; var Handled: Boolean);
var
  DC: hDC;
  PS: TPaintStuff;
begin
  if (Msg.Message = WM_PAINT) and IsIconic(Application.Handle) then
  begin
    DC := BeginPaint(Application.Handle, PS);
    ...осуществляем отрисовку с помощью вызовов Windows GDI...
 
    EndPaint(Application.Handle, PS);
    Handled := True;
  end;
end;
 
procedure TForm1.OnCreate(Sender: TObject);
begin
  Application.OnMessage := AppOnMessage;
end;
</pre>
<p>Код создан на основе алгоритма Neil Rubenking.</p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
