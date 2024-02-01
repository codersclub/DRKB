---
Title: Как заполнить поля формы в MS Word?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как заполнить поля формы в MS Word?
===================================


    uses 
      ComObj; 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    var 
      WordApp: OLEvariant; 
    begin 
      Screen.Cursor := crHourglass; 
      try 
        // Create Word Instance 
        WordApp := CreateOleObject('Word.Application'); 
      except 
        ShowMessage('Cannot start MS Word.'); 
        Screen.Cursor := crDefault; 
        Exit; 
      end; 
     
      try 
        // Open a Word Document 
        WordApp.Documents.Add(Template := 'C:\TestDoc.doc'); 
     
        // Show Word 
        WordApp.Visible := True; 
     
        // Check if FormField exists and asign your text 
        if WordApp.ActiveDocument.Bookmarks.Exists('YourFormFieldName') then 
          WordApp.ActiveDocument.FormFields.Item('YourFormFieldName').Result := 'Your Text'; 
      finally 
        WordApp := Unassigned; 
        Screen.Cursor := crDefault; 
      end; 
    end; 

