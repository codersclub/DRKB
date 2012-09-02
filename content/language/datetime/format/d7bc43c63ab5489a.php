<h1>Частичный показ DateTime</h1>
<div class="date">01.01.2007</div>

<p>При отображении TDateTimeField в DBGrid с форматированием hh:mm (для показа только времени), любая попытка изменения времени приводит (при передаче данных) к ошибке примерно такого содержания: "'07:00 is not a valid DateTime" (07:00 - неверный DateTime). Я хотел бы посылать данные приблизительно в таком виде "trunc(oldDateTimevalue)+strtoTime(displaytext)" </p>
<p>Следующий обработчик события TDateTimeField OnSetText не слишком элегантен, но он работает! </p>
<pre>
procedure TForm1.Table1Date1SetText(Sender: TField; const Text: String);
var
  d: TDateTime;
  t: string;
begin
  t := Text;
  with Sender as TDateTimeField do 
  begin
    if IsNull then 
      d := SysUtils.Date
    else 
      d := AsDateTime;
    AsDateTime := StrToDateTime(Copy(DateToStr(d),1,8)+' '+t);
  end;
end;
</pre>
<p>Здесь мы исходим из предположения, что у вас имеется маска редактирования, допускающая формат hh:mm или hh:mm:ss. </p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
&nbsp;</p>
