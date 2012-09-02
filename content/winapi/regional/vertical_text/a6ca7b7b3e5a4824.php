<h1>Как изменить фоновый цвет текста?</h1>
<div class="date">01.01.2007</div>


<p class="author">Автор: Олег Кулабухов </p>
<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
  OldTextColor: TColorRef;
  OldBkColor: TColorRef;
  OldBkMode: Integer;
begin
  OldTextColor := SetTextColor(Form1.Canvas.Handle, clYellow);
  OldBkColor := SetBkColor(Form1.Canvas.Handle, clGreen);
  OldBkMode := SetBkMode(Form1.Canvas.Handle, OPAQUE);
  TextOut(Form1.Canvas.Handle, 20, 20, 'Delphi World - лучше всех! ;-)', 27);
  SetBkMode(Form1.Canvas.Handle, OldBkMode);
  SetBkColor(Form1.Canvas.Handle, OldBkColor);
  SetTextColor(Form1.Canvas.Handle, OldTextColor);
end;
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
