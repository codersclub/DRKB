<h1>Список шрифтов, совместимых одновременно с экраном и с принтером</h1>
<div class="date">01.01.2007</div>


<p>Эти установки должны показать шрифты совместимые либо с принтером либо с экраном. В примере диалог Windows ChooseFont вызывается напрямую чтобы показать список шрифтов, совместимых одновременно и с экраном и с принтером.</p>

<p>Пример:</p>
<pre>
uses Printers, CommDlg;
 
procedure TForm1.Button1Click(Sender: TObject);
 var cf: TChooseFont; lf: TLogFont; tf: TFont;
begin
  if PrintDialog1.Execute then
  begin
    cf.hdc := Printer.Handle;
    cf.lpLogFont := @lf;
    cf.iPointSize := Form1.Canvas.Font.Size * 10;
    cf.Flags := CF_BOTH or CF_INITTOLOGFONTSTRUCT or
     CF_EFFECTS or CF_SCALABLEONLY or CF_WYSIWYG;
    cf.rgbColors := Form1.Canvas.Font.Color;
    tf.COlor := cf.RgbColors;
    Form1.Canvas.Font.Assign(tf);
    tf.Free;
    Form1.Canvas.TextOut(10, 10, 'Test');
  end;
end;
</pre>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
