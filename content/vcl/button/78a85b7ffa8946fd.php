<h1>Как текст на кнопке расположить под заданным углом?</h1>
<div class="date">01.01.2007</div>

Как выдать текст под наклоном? </p>
<p>Чтобы вывести под любым углом текст необходимо использовать TrueType Fonts (например &#171;Arial&#187;). Например:</p>
<pre>
var
  LogFont: TLogFont;
begin
  GetObject(Canvas.Font.Handle, SizeOf(TLogFont), @LogFont);
  {Вывести текст 1/10 градуса против часовой стрелки}
  LogFont.lfEscapement := Angle * 10;
  Canvas.Font.Handle := CreateFontIndirect(LogFont);
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
