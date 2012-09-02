<h1>Drag &amp; Drop TImage</h1>
<div class="date">01.01.2007</div>

Вот рабочий пример. Расположите на форме панель побольше, скопируйте и измените приведенный код так, чтобы изображение загружалось из ВАШЕГО каталога Delphi.</p>
<pre>
procedure TForm1.Panel1DragDrop(Sender, Source: TObject; X, Y: Integer);
begin
  with Source as TImage do
  begin
    Left := X;
    Top := Y;
  end;
end;
 
procedure TForm1.Panel1DragOver(Sender, Source: TObject; X, Y: Integer;
  State: TDragState; var Accept: Boolean);
begin
  Accept := Source is TImage;
end;
 
procedure TForm1.FormCreate(Sender: TObject);
begin
  with TImage.Create(Self) do
  begin
    Parent := Panel1;
    AutoSize := True;
    Picture.LoadFromFile('D:\DELPHI\IMAGES\CHIP.BMP');
    DragMode := dmAutomatic;
    OnDragOver := Panel1DragOver;
    OnDragDrop := Panel1DragDrop;
  end;
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

