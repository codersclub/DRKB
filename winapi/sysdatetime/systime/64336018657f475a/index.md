---
Title: Узнать текущие время и дату по Гринвичу
Date: 01.01.2007
---

Узнать текущие время и дату по Гринвичу
=======================================

::: {.date}
01.01.2007
:::

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
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
