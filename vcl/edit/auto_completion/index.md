---
Title: Подсказка при вводе в TEdit
Date: 01.01.2007
---


Подсказка при вводе в TEdit
===========================

Сегодня поговорим о том, как помочь пользователю ввести в поле ввода
текст. Для этого компьютер должен по первым буквам вводимого слова
догадаться, что хочет написать пользователь, и предложить ему этот
вариант. Один из способов это сделать - дописывать не хватающие буквы к
слову, но выделять их.

Нужно решить три задачи:

1. определить вводимые символы,

2. найти слово, начинающееся с этих символов,

3. добавить не хватающие символы и выделить их.

Для решения первой задачи достаточно найти первый символ, не являющийся
буквой. Для решения второй задачи можно использовать поиск в StringList.
Вставить недостающие символы удобно в специальной переменной типа
String.

В этом примере словарь состоит из названий чисел (на английском): от 1
до 10. Иногда словарь можно пополнять, добавляя туда незнакомые слова,
вводимые пользователем.

    var
      words: TStringList;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      words := TStringList.Create;
      words.Sorted := true;
      words.Add('one');
      words.Add('two');
      words.Add('four');
      words.Add('five');
      words.Add('six');
      words.Add('seven');
      words.Add('eight');
      words.Add('nine');
      words.Add('ten');
    end;
     
    procedure TForm1.Edit1KeyUp(Sender: TObject; var Key: Word;
      Shift: TShiftState);
    const
      chars: set of char = ['A'..'Z', 'a'..'z', 'А'..'Я', 'а'..'я'];
    var
      w: string;
      i: integer;
      s: string;
      full: string;
      SelSt: integer;
    begin
      if Key = 13 then begin
        Edit1.SelStart := Edit1.SelStart + Edit1.SelLength;
        Edit1.SelLength := 0;
        Exit;
      end;
      s := Edit1.Text;
      SelSt := Edit1.SelStart;
      i := SelSt;
      if (length(s) > i) and (s[i+1] in chars) then Exit;
      w := '';
      while (i >= 1) and (s[i] in chars) do begin
        w := s[i] + w;
        dec(i);
      end;
      if length(w) <= 0 then Exit;
      words.Find(w, i);
      if (i >= 0) and (UpperCase(copy(words[i], 1, length(w))) = UpperCase(w)) then begin
        full := words[i];
        insert(copy(full, length(w) + 1, length(full)), s, SelSt + 1);
        Edit1.Text := s;
        Edit1.SelStart := SelSt;
        Edit1.SelLength := length(full) - length(w);
      end;
    end;
