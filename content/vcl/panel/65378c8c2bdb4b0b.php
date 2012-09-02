<h1>Панель с двумя полосами слева, которые можно двигать</h1>
<div class="date">01.01.2007</div>

<p>Для создания панелей в двумя полосами слева, которые можно двигать друг относительно друга, используют компонент ControlBar (вкладка Additional), на котором обычно размещают один или несколько ToolBar (вкладка Win32). Чтобы сделать возможным "вытаскивание" панели из ControlBar нужно написать следующий код: </p>
<pre>
procedure TForm1.FormCreate(Sender: TObject);
begin
  ToolBar1.DockSite := true;
  ToolBar1.DragKind := dkDock;
  ToolBar1.DragMode := dmAutomatic;
end;
 
procedure TForm1.ControlBar1DockOver(Sender: TObject;
  Source: TDragDockObject; X, Y: Integer; State: TDragState;
  var Accept: Boolean);
begin
  Accept := (Source.Control is TToolBar);
  if Accept then
    with Source.DockRect do
    begin
      TopLeft := ControlBar1.ClientToScreen(ControlBar1.ClientRect.TopLeft);
      Right := Left + Source.Control.Width;
      Bottom := Top + Source.Control.Height;
    end;
end;
</pre>
<p>Вы можете убрать метод FormCreate, установив нужные свойства компонента ToolBar1 на стадии разработки при помощи Object Inspector. </p>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
