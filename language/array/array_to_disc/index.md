---
Title: Запись массива на диск
Date: 01.01.2007
---


Запись массива на диск
======================

Вариант 1:

Author: Steve Schafer

Source: Советs по Delphi от [Валентина Озерова](mailto:webmaster@webinspector.com) Сборник Kuliba

Скажем, ваша структура данных выглядит следующим образом:

    type
      TMyRec = record
        SomeField: Integer;
        SomeOtherField: Double;
        TheRest: array[0..99] of Single;
      end;

и TBlobField имеет имя MyBlobField. TMyRec назван как MyRec. Для
копирования содержимого MyRec в MyBlobField необходимо сделать
следующее:

    var
      Stream: TBlobStream;
    begin
      Stream := TBlobStream.Create(MyBlobField, bmWrite);
      Stream.Write(MyRec, SizeOf(MyRec));
      Stream.Free;
    end;

Есть другой путь:

    var
      Stream: TBlobStream;
    begin
      Stream := TBlobStream.Create(MyBlobField, bmRead);
      Stream.Read(MyRec, SizeOf(MyRec));
      Stream.Free;
    end;

------------------------------------------------------------------------

Вариант 2:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    type
      TCharArray = array[500] of Char;
     
    procedure WriteToFile(var aArray: TCharArray; sFileName: string); {Примечание:
    Объявление массива как параметр Var позволяет передавать только ссылку на массив,
    а не копировать его целиком в стек, если же вам нужна безопасная работа с массивом,
    то вам не следует передавать его как var-параметр. }
    var
      nArrayIndex: Word;
      fFileHandle: TextFile;
    begin
      AssignFile(fFileHandle, sFileName);
      Rewrite(fFileHandle);
     
      for nArrayIndex := 1 to 500 do
      begin
        Write(fFileHandle, aArray[nArrayIndex]);
      end;
     
      CloseFile(fFileHandle);
    end; {end Procedure, WriteToFile()}



