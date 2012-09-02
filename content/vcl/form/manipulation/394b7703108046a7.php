<h1>Как сделать окно системно-модальным?</h1>
<div class="date">01.01.2007</div>


<p>Используйте функцию Windows API SetSysModalWindow(). Код ниже демонстрирует технологию работы с этой функцией. В любой момент времени может быть возможен только один модально-системны диалог, чей дескриптор возвращается функцией SetSysModalWindow(). Вам необходимо запомнить возвращаемую функцией величину для того, чтобы завершить показ диалога таким образом. Вот как примерно это должно выглядеть: </p>
<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
  x: word ;
begin
  x := SetSysModalWindow(AboutBox.handle) ;
  AboutBox.showmodal ;
  SetSysModalWindow(x) ;
end;
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

