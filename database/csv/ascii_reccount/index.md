---
Title: RecCount в таблицах ASCII
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


RecCount в таблицах ASCII
=========================

В Delphi 1.0 для получения количества записей в ASCII файле (.TXT- и
.SCH-файлы) я пользовался свойством RecordCount компонента TTable. В
Delphi 2.0 эта функциональность не поддерживается! Я прав или не прав?
Во всяком случае как мне получить количество записей, содержащихся в
ASCII таблице?

В Delphi 2.0, свойство RecordCount отображается на недокументированную
функцию BDE DbiGetExactRecordCount. Данное изменение было сделано для
обеспечения правильных величин при работе с "живыми" запросами.
Очевидно, данное API по какой-то причине не поддерживает текстовые
файлы.

Вы можете обойти эту проблему, вызывая функцию API BDE DbiGetRecordCount
напрямую (добавьте BDE к списку используемых модулей):

    procedure TForm1.FormKeyUp(Sender: TObject; var Key: Word);
    var
      RecCount: Integer;
    begin
      Check(DbiGetRecordCount(Table1.Handle, RecCount);
    end;

