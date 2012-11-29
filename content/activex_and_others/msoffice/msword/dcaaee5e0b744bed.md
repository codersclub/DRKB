Импорт активного документа Word
===============================

::: {.date}
01.01.2007
:::

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Импорт активного документа Word
     
    Импортирует текст активного документа Word в объект класса TStrings (без форматирования). Если при открытом Worde результат отрицательный - рекомендуется перезапустить приложение, поскольку дальнейшие вызовы функции в подавляющем большинстве случаев будут приводить к ошибке
     
    Зависимости: OleServer, Word97
    Автор:       Dimka Maslov, mainbox@endimus.com, ICQ:148442121, Санкт-Петербург
    Copyright:   Dimka Maslov
    Дата:        6 февраля 2004 г.
    ********************************************** }
     
    function ImportWordActiveDocument(Strings: TStrings): Boolean;
    var
     Word: TWordApplication;
     Start, End_: Integer;
    begin
     Result := True;
     try
      Word := TWordApplication.Create(nil);
      try
       Word.AutoConnect := False;
       Word.AutoQuit := False;
       Word.ConnectKind := ckRunningInstance;
       Word.Connect;
       Start := Word.Selection.Get_Start;
       End_ := Word.Selection.Get_End_;
       Word.Selection.SetRange(0, $7FFFFFFF);
       Strings.Text := Word.Selection.Text;
       Word.Selection.SetRange(Start, End_);
       Word.Disconnect;
      finally
       Word.Free;
      end;
     except
      Result := False;
     end;
    end; 

Пример использования:

    if not ImportWordActiveDocument(Memo1.Lines) then 
     ShowMessage('Error'); 
