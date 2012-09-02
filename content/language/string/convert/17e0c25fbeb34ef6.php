<h1>String &gt; PChar</h1>
<div class="date">01.01.2007</div>



<pre>
var S: String;
    P: PChar;
 
....
 
P:=PChar(S);
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

<hr />
<p>Все функции API для работы с текстом используют неудобный тип String, а PChar – быстрее. Преобразовать строку String в PChar очень просто: PChar('It is my string'). Можно использовать то, что PChar – это адрес персого символа строки, заканчивающейся символом #0. И, наконец, еще одно удобство. Delphi воспринимает массив типа Char и как обычную строку, и как строку PChar. Полная совместимость. Эта программа демонстрирует демонстрирует все это. </p>

<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
  s: array [0..99] of char;
  p: integer;
begin
  s := 'Delphi World';
  FindWindow(nil, s);
  p := pos('lp', s);
  Form1.Caption := copy(s, p, Length(s) - p);
end;
 
 
</pre>
<a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

