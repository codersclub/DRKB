---
Title: Поиск записи в больших таблицах
Author: Александр Куприн
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Поиск записи в больших таблицах
===============================

В свою очередь хочу предложить на Ваш суд небольшую процедуру, которая
мне очень помогла. Процедура позволяет переходить на любую из записей в
таблице (формат Paradox или DBase). Необходимость в ней возникла, когда
мне пришлось работать с таблицей размером в 10 и более тысяч записей у
которой было несколько калькулируемых полей и полей подлинкованных из
объектов TQuery. При использовании метода TTable.MoveBy программа
медленно и печально замолкала (вообще-то она работала, но как?!).

Встретил я этот пример в технической документации Borland (2656), где
сравнивались функции Paradox Engine и BDE. Пример был написан на C. Вот
его интерпретация на Delphi:

    uses BDE;
    ...
     
    procedure MoveToRec(RecNo: longint; taSingle: TDBDataSet);
    // переход на логическую запись
    var
      ErrorCode: DBIResult;
      CursorProps: CurProps;
    begin
      ErrorCode := DbiGetCursorProps(taSingle.Handle, CursorProps);
      if ErrorCode = DBIERR_NONE then
      begin
        case TTable(taSingle).TableType of
          ttParadox: ErrorCode := DbiSetToSeqNo(taSingle.Handle, RecNo);
          ttDBase: ErrorCode := DbiSetToRecordNo(taSingle.Handle, RecNo);
        end; { case..}
        taSingle.Resync([rmCenter]);
      end { if..}
    end; { procedure MoveToRec }

