---
Title: Генерация GUID как строки
Author: Vit
Date: 01.01.2007
---


Генерация GUID как строки
=========================

> Как в Run-time сгененрировать строку типа `'{821AB2C7-559D-48E0-A3EE-6DD50E83234C}'`?
> Типа как в среде при нажатии Ctrl-Shift-G.
> Функция CoCreateGuid выводит значение типа TGUID,
> я нигде не нашёл функции конвертации TGUID -\> String.
> Может кто знает такую функцию?

------------------------------------------------------------------------

Вариант 1:

Author: Fantasist

Source: Vingrad.ru <https://forum.vingrad.ru>

Есть такая функция.
Как ни странно называется она `GUIDToString`, и живет в SysUtils.

------------------------------------------------------------------------

Вариант 2:

Author: Jin X

Можно `GUIDToString` написать и вручную, будет выглядеть примерно так:

    procedure TForm1.Button1Click(Sender: TObject);
    var
      G: TGUID;
      S: string;
      i: Integer;
    begin
      CoCreateGuid(G);
      S := '{' + IntToHex(G.D1, 8) + '-' + IntToHex(G.D2, 4) + '-' + IntToHex(G.D3, 4) + '-';
      for i := 0 to 7 do
        begin
          S := S + IntToHex(G.D4[i], 2);
          if i = 1 then S := S + '-'
        end;
      S := S + '}';
      ShowMessage(GUIDToString(G) + #13 + S)
    end;

