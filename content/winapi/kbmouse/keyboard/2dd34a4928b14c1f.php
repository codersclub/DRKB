<h1>Как програмно переключить раскладку клавиатуры?</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Button1Click(Sender: TObject);//На русский
var
Layout: array[0.. KL_NAMELENGTH] of char;
begin
LoadKeyboardLayout( StrCopy(Layout,'00000419'),KLF_ACTIVATE);
end;
 
procedure TForm1.Button2Click(Sender: TObject);//На английский
var
Layout: array[0.. KL_NAMELENGTH] of char;
begin
LoadKeyboardLayout(StrCopy(Layout,'00000409'),KLF_ACTIVATE);
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

