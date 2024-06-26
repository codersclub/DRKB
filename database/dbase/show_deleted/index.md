---
Title: Показ меток удаленных записей в dBASE-файлах
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Показ меток удаленных записей в dBASE-файлах
============================================

Для начала вы должны включить SoftDeletes, после чего вы сможете
просматривать записи, помеченные к удалению. В противном случае, вы их
не увидите. По умолчанию, для файлов DBF, SoftDeletes установлен в
False. Вот логика работы:

    procedure TForm1.Button1Click(Sender: TObject);
    var
      B: BOOL;
      W: Word;
    begin
      Check(DbiSetProp(hDBIObj(Table1.Handle), curSOFTDELETEON,
        longint(True)));
      { Проверяем, что это работает }
      Check(DbiGetProp(hDBIObj(Table1.Handle), curSOFTDELETEON, @B,
        sizeof(B), W));
      if B = False then
        Label2.Caption := 'Не помечена'
      else
        Label2.Caption := 'Помечена';
    end;

Когда указатель на запись указывает на запись, которую вы хотите
удалить, используйте следующую логику:

    Table1.UpdateCursorPos;
    Check(DbiUndeleteRecord(Table1.Handle));

Метод UpdateCursorPos устанавливает основной курсор BDE на позицию
курсора текущей записи, который существуют только для того, чтобы все
работало правильно. Вам нужно только вызвать этот метод прямым вызовом
одной из BDE API функций (такой как, например, DbiUndeleteRecord).

Ну и, наконец, чтобы все работало, поместите модули DBIPROCS и DBITYPES
с список USES.

