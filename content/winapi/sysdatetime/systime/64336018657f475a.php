<h1>Узнать текущие время и дату по Гринвичу</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Button4Click(Sender: TObject);
var
  lt: TSYSTEMTIME;
  st: TSYSTEMTIME;
begin
  GetLocalTime(lt);
  GetSystemTime(st);
  Memo1.Lines.Add('LocalTime = ' +
    IntToStr(lt.wmonth) + '/' +
    IntToStr(lt.wDay) + '/' +
    IntToStr(lt.wYear) + ' ' +
    IntToStr(lt.wHour) + ':' +
    IntToStr(lt.wMinute) + ':' +
    IntToStr(lt.wSecond));
  Memo1.Lines.Add('UTCTime = ' +
    IntToStr(st.wmonth) + '/' +
    IntToStr(st.wDay) + '/' +
    IntToStr(st.wYear) + ' ' +
    IntToStr(st.wHour) + ':' +
    IntToStr(st.wMinute) + ':' +
    IntToStr(st.wSecond));
end;
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
