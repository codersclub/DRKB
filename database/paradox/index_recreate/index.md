---
Title: Как пересоздать индексы?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как пересоздать индексы?
========================

    procedure TForm1.Button4Click(Sender: TObject);
    var
      aExclusive, aActive: Boolean;
    begin
      with Table1 do
      begin
        aActive := Active;
        Close;
        aExclusive := Exclusive;
        Exclusive := True;
        Open;
        Check(DbiRegenIndexes(Table1.Handle));
        Close;
        Exclusive := aExclusive;
        Active := aActive;
        Check(DbiSaveChanges(Table1.Handle));
      end;
    end;

Как и при вызове любой функции API BDE, модуль оболочки BDE API BDE
(для Delphi 1 — модули DbiTypes, DbiErrs и DbiProcs) должен быть указан в разделе «Usesе» модуля,
из которого должен быть выполнен вызов.
Используемая здесь функция API BDE DbiSaveChanges принудительно записывает любые изменения данных
в буфере памяти на диск в этот момент.

Другой способ справиться с этой ситуацией
(если во время разработки вы знаете все индексы, которые будут существовать для таблицы) -
это перебрать элементы в объекте TIndexDefs компонента TTable,
удалить каждый индекс (метод DeleteIndex),
а затем добавить обратно все необходимые индексы (метод AddIndex).

    procedure TForm1.Button3Click(Sender: TObject);
    var
      aName: string;
      i: Byte;
      aExclusive, aActive: Boolean;
    begin
      with Table1 do
      begin
        aActive := Active;
        Close;
        aExclusive := Exclusive;
        Exclusive := True;
        IndexDefs.Update;
        i := IndexDefs.Count;
        while i > 0 do
        begin
          aName := IndexDefs.Items[i - 1].Name;
          DeleteIndex(aName);
          Dec(i);
        end;
        AddIndex('', 'MainField', [ixPrimary]);
        AddIndex('Field1', 'Field1', []);
        AddIndex('Field2', 'Field2', []);
        IndexDefs.Update;
        Exclusive := aExclusive;
        Active := aActive;
        Check(DbiSaveChanges(Table1.Handle));
      end;
    end;

