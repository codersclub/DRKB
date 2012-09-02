<h1>DLL со строковыми ресурсами</h1>
<div class="date">01.01.2007</div>


<p>Делаешь текстовый файл с ресурсами, типа</p>

<p>--my.rc--</p>
<p>STRINGTABLE</p>
<p>{</p>
<p>00001, "My String #1"</p>
<p>00002, "My String #2"</p>
<p>}</p>

<p>Далее компилируешь его:</p>
<p>brcc32 my.rc</p>
<p>У тебя получится my.res. </p>
<p>Делаешь DLL: </p>

<p>--my.dpr--</p>

<pre>
library my;
 
{$R my.res}
 
begin
 
end.
</pre>



<p>Компилируешь Дельфиским компилятором:</p>

<p>dcc32 my.dpr</p>
<p>Получаешь, наконец-то свою my.dll </p>

<p>Теперь о том, как использовать. </p>

<p>В своей программе:</p>

<pre>
var
  h: THandle;
  S: array [0..255] of Char;
begin
  h := LoadLibrary('MY.DLL');
  if h &lt;= 0 then 
    ShowMessage('Bad Dll Load')
  else
  begin
    SetLength(S, 512);
    LoadString(h, 1, @S, 255);
    FreeLibrary(h);
  end;
end;
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

