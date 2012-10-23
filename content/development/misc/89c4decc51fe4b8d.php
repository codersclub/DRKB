<h1>Как прочитать время компиляции проги?</h1>
<div class="date">01.01.2007</div>


<p>Дату компилляции вытащить нельзя. Можно дату Build (т.е. дату когда ты сделал опрерацию Build All, или самую первую компилляцию)</p>
<p>1) Ставим библиотеку RxLib</p>
<p>2) Идем в опции проэкта, закладка Version Info, отмечаем птичкой - include version info</p>
<p>3) В коде пишем следующее</p>
<pre>
uses
  Rxverinf;

 
procedure TForm1.Button1Click(Sender: TObject);
begin
  with TVersionInfo.create(paramstr(0)) do
  try
    caption := datetimetostr(verfiledate);
  finally
    free;
  end;
end;
</pre>

<div class="author">Автор: Vit</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
