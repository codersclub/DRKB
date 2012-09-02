<h1>Как менять шрифт в TRichEdit горячими клавишами?</h1>
<div class="date">01.01.2007</div>


<p>Следующий пример показывает, как можно изменять шрифт в компоненте TRichEdit при помощи следующих комбинаций клавиш:</p>

<p>Ctrl + B - Включает и выключает жирность (Bold) шрифта</p>
<p>Ctrl + I - Включает и выключает (Italic) шрифта</p>
<p>Ctrl + S - Включает и выключает зачёркивание (Strikeout) шрифта</p>
<p>Ctrl + U - Включает и выключает подчёркивание (Underline) шрифта</p>

<p>Замечание: Так же можно устанавливать сразу несколько типов шрифта.</p>

<p>Пример:</p>
<pre>
const
  KEY_CTRL_B = 02;
  KEY_CTRL_I =  9;
  KEY_CTRL_S = 19;
  KEY_CTRL_U = 21;
 
procedure TForm1.RichEdit1KeyPress(Sender: TObject; var Key: Char);
begin
  case Ord(Key) of
    KEY_CTRL_B: begin
      Key := #0;
      if fsBold in (Sender as TRichEdit).SelAttributes.Style then
      (Sender as TRichEdit).SelAttributes.Style :=
        (Sender as TRichEdit).SelAttributes.Style - [fsBold] else
      (Sender as TRichEdit).SelAttributes.Style :=
        (Sender as TRichEdit).SelAttributes.Style + [fsBold];
    end;
    KEY_CTRL_I: begin
      Key := #0;
      if fsItalic in 
      (Sender as TRichEdit).SelAttributes.Style then
        (Sender as TRichEdit).SelAttributes.Style :=
        (Sender as TRichEdit).SelAttributes.Style - [fsItalic] 
      else
       (Sender as TRichEdit).SelAttributes.Style :=
       (Sender as TRichEdit).SelAttributes.Style + [fsItalic];
    end;
    KEY_CTRL_S: begin
       Key := #0;
      if fsStrikeout in 
      (Sender as TRichEdit).SelAttributes.Style then
        (Sender as TRichEdit).SelAttributes.Style :=
        (Sender as TRichEdit).SelAttributes.Style - [fsStrikeout] 
      else
        (Sender as TRichEdit).SelAttributes.Style :=
        (Sender as TRichEdit).SelAttributes.Style + [fsStrikeout];
    end;
    KEY_CTRL_U: begin
       Key := #0;
      if fsUnderline in 
      (Sender as TRichEdit).SelAttributes.Style then
        (Sender as TRichEdit).SelAttributes.Style :=
        (Sender as TRichEdit).SelAttributes.Style - [fsUnderline] 
      else
        (Sender as TRichEdit).SelAttributes.Style :=
        (Sender as TRichEdit).SelAttributes.Style + [fsUnderline];
    end;
  end;
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

