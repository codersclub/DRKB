---
Title: String -> PChar
Date: 01.01.2007
---


String -> PChar
===============

Вариант 1:

Source: <https://forum.sources.ru>

    var S: String;
        P: PChar;
    ....
    P:=PChar(S);


------------------------------------------------------------------------

Вариант 2:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Все функции API для работы с текстом используют неудобный тип String, а
PChar - быстрее. Преобразовать строку String в PChar очень просто:
    PChar('It is my string')

 Можно использовать то, что PChar - это
адрес персого символа строки, заканчивающейся символом #0. И, наконец,
еще одно удобство. Delphi воспринимает массив типа Char и как обычную
строку, и как строку PChar. Полная совместимость.

Эта программа
демонстрирует демонстрирует все это.

    procedure TForm1.Button1Click(Sender: TObject);
    var
      s: array [0..99] of char;
      p: integer;
    begin
      s := 'Delphi World';
      FindWindow(nil, s);
      p := pos('lp', s);
      Form1.Caption := copy(s, p, Length(s) - p);
    end;

