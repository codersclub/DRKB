---
Title: Как добавить текст к закладке?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как добавить текст к закладке?
==============================

    uses
      ComObj;
     
    procedure TForm1.Button1Click(Sender: TObject);
    const
      // Word Document to open
      YourWordDocument = 'c:\test\worddoc.doc';
    var
      BookmarkName, Doc, R: OleVariant;
    begin
      // Start a Word instance
      try
        WordApp := CreateOleObject('Word.Application');
      except
        ShowMessage('Could not start MS Word!');
      end;
      // Open your Word document
      WordApp.Documents.Open(YourWordDocument);
      Doc := WordApp.ActiveDocument;
     
      // name of your bookmark
      BookmarkName := 'MyBookMark';
     
      // Check if bookmark exists
      if Doc.Bookmarks.Exists(BookmarkName) then
      begin
        R := Doc.Bookmarks.Item(BookmarkName).Range;
        // Add text at our bookmark
        R.InsertAfter('Text in bookmark');
        // You make a text formatting like changing its color
        R.Font.Color := clRed;
      end;
     
      // Save your document and quit Word
      if not VarIsEmpty(WordApp) then
      begin
        WordApp.DisplayAlerts := 0;
        WordApp.Documents.Item(1).Save;
        WordApp.Quit;
        BookmarkName := Unassigned;
        R := Unassigned;
        WordApp := Unassigned;
      end;
    end;

