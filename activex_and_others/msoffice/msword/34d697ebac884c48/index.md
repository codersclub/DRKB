---
Title: Как сделать поиск/замену в документе?
Date: 01.01.2007
---


Как сделать поиск/замену в документе?
=====================================

::: {.date}
01.01.2007
:::

You should use a variant because the Find.Execute method is a bit buggy.
Something like this, for example:

    { ... }
    var
      Rnge: OleVariant;
    { ... }
     
    Rnge := Doc.Content;
    Rnge.Find.Execute('old', Wrap := wdFindContinue, ReplaceWith := 'new', Replace :=
      wdReplaceAll);
    { ... }

------------------------------------------------------------------------

    { ... }
      { Create the OLE Object }
    WordApp := CreateOLEObject('Word.Application');
    WordApp.Documents.Open(yourDocFile);
    WordApp.Selection.Find.ClearFormatting;
    WordApp.Selection.Find.Text := yourOldStr;
    WordApp.Selection.Find.Replacement.Text := yourNewStr;
    WordApp.Selection.Find.Forward := True;
    WordApp.Selection.Find.Wrap := 1; {wdFindContinue}
    WordApp.Selection.Find.Format := False;
    WordApp.Selection.Find.MatchCase := False;
    WordApp.Selection.Find.MatchWholeWord := False;
    WordApp.Selection.Find.MatchWildcards := True;
    WordApp.Selection.Find.MatchSoundsLike := False;
    WordApp.Selection.Find.MatchAllWordForms := False;
    WordApp.Selection.Find.Execute(Replace := 2); {wdReplaceAll}
    {Or as alternative:  WordApp.Selection.Find.Execute(Replace := 1); for one replace}
    WordApp.ActiveDocument.SaveAs(yourNewDocFile);
    WordApp.Quit;
    WordApp := Unassigned;
    { ... }

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>

------------------------------------------------------------------------

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Заменить строки в файле Word
     
    Функция заменяет файлы в документе word с опциями поиска и замены
     
    Зависимости: ComObj
    Автор:       [NIKEL], nikel@pisem.net, Norilsk
    Copyright:   Some help
    Дата:        15 сентября 2002 г.
    ********************************************** }
     
    uses ComObj; 
     
    // Флаги замены 
    type 
      TWordReplaceFlags = set of (wrfReplaceAll, wrfMatchCase, wrfMatchWildcards); 
     
    function WordStringReplace(ADocument: TFileName; SearchString, 
             ReplaceString: string; Flags: TWordReplaceFlags): Boolean; 
    const 
      wdFindContinue = 1; 
      wdReplaceOne = 1; 
      wdReplaceAll = 2; 
      wdDoNotSaveChanges = 0; 
    var 
      WordApp: OLEVariant; 
    begin 
      Result := False; 
     
      { Существует ли файл } 
      if not FileExists(ADocument) then 
      begin 
        ShowMessage('Файл не найден!'); 
        Exit; 
      end; 
     
      { Создаем OLE объект } 
      try 
        WordApp := CreateOLEObject('Word.Application'); 
      except 
        on E: Exception do 
        begin 
          E.Message := 'Word недоступен'; 
          raise; 
        end; 
      end; 
     
      try 
        { Прячем Word } 
        WordApp.Visible := False; 
        { Открываем документ } 
        WordApp.Documents.Open(ADocument); 
        { Инициализируем параметры} 
        WordApp.Selection.Find.ClearFormatting; 
        WordApp.Selection.Find.Text := SearchString; 
        WordApp.Selection.Find.Replacement.Text := ReplaceString; 
        WordApp.Selection.Find.Forward := True; 
        WordApp.Selection.Find.Wrap := wdFindContinue; 
        WordApp.Selection.Find.Format := False; 
        WordApp.Selection.Find.MatchCase := wrfMatchCase in Flags; 
        WordApp.Selection.Find.MatchWholeWord := False; 
        WordApp.Selection.Find.MatchWildcards := wrfMatchWildcards in Flags; 
        WordApp.Selection.Find.MatchSoundsLike := False; 
        WordApp.Selection.Find.MatchAllWordForms := False; 
        { Ищем} 
        if wrfReplaceAll in Flags then 
          WordApp.Selection.Find.Execute(Replace := wdReplaceAll) 
        else 
          WordApp.Selection.Find.Execute(Replace := wdReplaceOne); 
        { Сохраняем word } 
        WordApp.ActiveDocument.SaveAs(ADocument); 
        { Всё нормально } 
        Result := True; 
        { Закрываем document } 
        WordApp.ActiveDocument.Close(wdDoNotSaveChanges); 
      finally 
        { Закрываем Word } 
        WordApp.Quit; 
        WordApp := Unassigned; 
      end; 
    end; 

Пример использования:

    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      WordStringReplace('C:\SomeStrangeDoc.doc','Маша ела кашу','Маша съела кашу :)',
                         [wrfReplaceAll]); 
    end; 
