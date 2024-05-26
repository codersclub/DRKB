---
Title: Частичный показ DateTime
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Частичный показ DateTime
========================

При отображении TDateTimeField в DBGrid с форматированием hh:mm (для
показа только времени), любая попытка изменения времени приводит (при
передаче данных) к ошибке примерно такого содержания:

    '07:00 is not a valid DateTime'
    (07:00 - неверный DateTime)

Я хотел бы посылать данные приблизительно в таком виде:

    trunc(oldDateTimevalue) + strtoTime(displaytext)

Следующий обработчик события TDateTimeField OnSetText не слишком
элегантен, но он работает!

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

Здесь мы исходим из предположения, что у вас имеется маска
редактирования, допускающая формат hh:mm или hh:mm:ss.



 
