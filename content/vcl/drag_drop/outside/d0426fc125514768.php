<h1>Drag &amp; Drop с минимизированным приложением</h1>
<div class="date">01.01.2007</div>

<p>В ситуации, когда ваше приложение минимизировано, необходимо понимать, что окно главной формы НЕ работает. Фактически, если вы проверяете окно главной формы, и обнаруживаете, что оно имеет прежний размер, не удивляйтесь, оно просто невидимо. Иконка минимизированного Delphi-приложения принадлежит объекту Application, чей дескриптор окна - Application.Handle.</p>
<p>Вот некоторый код из моей программы, который с помощью компонента CheckBox проверяет возможность принятия перетаскиваемых файлов минимизированным приложением:</p>
<pre>
procedure TForm1.WMDropFiles(var Msg: TWMDropFiles);
{Вызывается только если TApplication НЕ получает drag/drop}
begin
  RecordDragDrop(Msg.Drop, False); {внутренняя функция}
  Msg.Result := 0;
end;
 
procedure TForm1.AppOnMessage(var Msg: TMsg; var Handled: Boolean);
{когда активно, получаем сообщения WM_DROPFILES, посылаемые
форме ИЛИ минимизированному приложению}
begin
  if Msg.message = WM_DROPFILES then
  begin
    RecordDragDrop(Msg.wParam, Msg.hWnd = Application.Handle);
    Handled := True;
  end;
end;
 
procedure TForm1.FormCreate(Sender: TObject);
begin
  DragAcceptFiles(Handle, True);
  DragAcceptFiles(Application.Handle, False);
  Application.OnMessage := nil;
end;
</pre>
<p>OK? Первоначально вызов DragAcceptFiles работает с дескриптором главной формы...</p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
&nbsp;</p>
