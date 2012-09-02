<h1>Как вместо печати графики использовать резидентный шрифт принтера?</h1>
<div class="date">01.01.2007</div>


<p>Используте функцию Windows API - GetStockObject() чтобы получить дескриптор (handle) шрифта по умолчанию устройства (DEVICE_DEFAULT_FONT) и передайте его Printer.Font.Handle. </p>
<pre>
uses Printers;
 
procedure TForm1.Button1Click(Sender: TObject);
var
  tm: TTextMetric;
  i: integer;
begin
  if PrintDialog1.Execute then
    begin
      Printer.BeginDoc;
      Printer.Canvas.Font.Handle := GetStockObject(DEVICE_DEFAULT_FONT);
      GetTextMetrics(Printer.Canvas.Handle, tm);
      for i := 1 to 10 do
        begin
          Printer.Canvas.TextOut(100, i * tm.tmHeight +
            tm.tmExternalLeading, 'Test');
        end;
      Printer.EndDoc;
    end;
end;
</pre>

