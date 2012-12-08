---
Title: Массив без ограничения типа и размера
Date: 01.01.2007
---


Массив без ограничения типа и размера
=====================================

::: {.date}
01.01.2007
:::

    //к примеру опишем свой тип
    type
     
      MyType = record
        zap1: longword;
        zap2: char;
        zap3: string[10];
      end;
     
    //опишем НЕОГРАНИЧЕННЫЙ массив переменный типа MyType
    //хотя, может использоваться абсолютно любой
    var
      m: array of MyType;
     
      ....
     
    procedure TForm1.Button1Click(Sender: TObject);
    var i: byte;
    begin
      for i := 0 to 9 do // нумерация элементов начинается с нуля!
     
        begin
          SetLength(m, Length(m) + 1); // увеличение длины массива на 1
          m[i].zap1 := i; //  присвоение
          m[i].zap2 := chr(i); //          полям
          m[i].zap3 := inttostr(i); //              значений
        end;
    end;
     
    ....
     
    SetLength(m, 0); // освобождение памяти
    end.

C Уважением,

Сергей Дьяченко, sd\@arzamas.nnov.ru

Взято из Советов по Delphi от [Валентина
Озерова](mailto:mailto:webmaster@webinspector.com)

Сборник Kuliba
