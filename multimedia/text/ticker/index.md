---
Title: Бегущая строка
Date: 01.01.2007
---


Бегущая строка
==============

::: {.date}
01.01.2007
:::

    procedure TForm1.Timer1Timer(Sender: TObject);
    const
      LengthGoString = 10;
      Gostring = 'Этот код был взят с проекта Delphi World'+
      ' Выпуск 2002 - 2003! Этот код б';
      // Повторить столько символов - сколько в LengthGoString
    const
      i: Integer = 1;
    begin
      Label1.Caption := Copy(GoString, i, LengthGoString);
      Inc(i);
      if Length(GoString) - LengthGostring < i then
        i:=1;
    end;
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
