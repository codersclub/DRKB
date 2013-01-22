---
Title: Пример чтения данных по битовой маске из значения
Author: Rouse\_
Date: 01.01.2007
---


Пример чтения данных по битовой маске из значения
=================================================

::: {.date}
01.01.2007
:::

Пример чтения данных по битовой маске из значения:

    procedure TForm1.Button1Click(Sender: TObject);

    const
      Col: Word = $ABCD;
    var
      R,
      G,
      B: Byte;
    begin
      R := Byte(Col shr 8) div 8; // первые 5 бит
      G := ((Byte(Col shr 8) and $7) * 8) or (Byte(Col) div $20); // Вторые 6 бит
      B := Byte(Col) and $1F; // третьи 5 бит
    end;

Автор: Rouse\_

Взято из <https://forum.sources.ru>
