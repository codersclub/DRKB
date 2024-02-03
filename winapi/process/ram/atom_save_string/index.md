---
Title: Сохранить строку в памяти + пример работы с атомами
Author: Vit
Date: 01.01.2007
---

Сохранить строку в памяти + пример работы с атомами
===================================================

::: {.date}
01.01.2007
:::

Например через атомы:

К счастью количество атомов ограничено 0xFFFF, так что простые функции
перебора работают достаточно быстро. Вот пример как сохранять и читать
значение через атомы:

    const UniqueSignature='GI7324hjbHGHJKdhgn90jshUH*hjsjshjdj';

     
    Procedure CleanAtoms;
    var P:PChar;
      i:Word;
    begin
    GetMem(p, 256);
    For i:=0 to $FFFF do
    begin
      GlobalGetAtomName(i, p, 255);
      if StrPos(p, PChar(UniqueSignature))<>nil then GlobalDeleteAtom(i);
    end;
    FreeMem(p);
    end;
     
    Procedure WriteAtom(Str:string);
    begin
    CleanAtoms;
    GlobalAddAtom(PChar(UniqueSignature+Str));
    end;
     
    Function ReadAtom:string;
    var P:PChar;
      i:Word;
    begin
    GetMem(p, 256);
    For i:=0 to $FFFF do
    begin
    GlobalGetAtomName(i, p, 255);
    if StrPos(p, PChar(UniqueSignature))<>nil then break;
    end;
    result:=StrPas(p+length(UniqueSignature));
    FreeMem(p);
    end;
     
    procedure TReadFromAtom.Button1Click(Sender: TObject);
    begin
    WriteAtom(Edit1.text);
    end;
     
    procedure TReadFromAtom.Button2Click(Sender: TObject);
    begin
    Showmessage(ReadAtom);
    end;
     

**Примечание**

Константа "UniqueSignature" должна быть достаточно длинной, чтобы
однозначно идентифицировать атом, в тоже время длина хранимой строки
вместе с UniqueSignature не должна превышать 255 символов. Данная
конструкция может хранить только 1 значение. Для хранения нескольких
значений надо назначить несколько разных UniqueSignature и использовать
сходные процедуры.

Автор: Vit

Взято с Vingrad.ru <https://forum.vingrad.ru>
