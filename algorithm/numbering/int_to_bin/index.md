---
Title: Преобразование числа в двоичную запись
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Преобразование числа в двоичную запись
======================================

Для преобразования числа в двоичную запись удобно использовать функции
shl и and. Эта функция преобразует число в строку из единиц и нулей.
Количество цифр определяется параметром Digits.

    function IntToBin(Value: integer; Digits: integer): string;
    var
      i: integer;
    begin
      result := '';
      for i := 0 to Digits - 1 do
        if Value and (1 shl i) > 0 then
          result := '1' + result
        else
          result := '0' + result;
    end;

Вот пример использования этой функции:

    procedure TForm1.Edit1Change(Sender: TObject);
    begin
      Form1.Caption := IntToBin(StrToIntDef(Edit1.Text, 0), 128);
    end;

