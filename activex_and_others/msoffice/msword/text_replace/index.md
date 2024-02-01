---
Title: Как заменить текст в документе MS Word?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как заменить текст в документе MS Word?
=======================================


    { 
      This function starts a hidden word instance, opens a specified document "ADocument" 
      and replaces (all) occurrences of "SearchString" with a specified "ReplaceString". 
      The function is similar to the Delphi StringReplace() function. 
    } 
     
    uses 
      ComObj; 
     
    // Replace Flags 
    type 
      TWordReplaceFlags = set of (wrfReplaceAll, wrfMatchCase, wrfMatchWildcards); 
     
    function Word_StringReplace(ADocument: TFileName; SearchString, ReplaceString: string; Flags: TWordReplaceFlags): Boolean; 
    const 
      wdFindContinue = 1; 
      wdReplaceOne = 1; 
      wdReplaceAll = 2; 
      wdDoNotSaveChanges = 0; 
    var 
      WordApp: OLEVariant; 
    begin 
      Result := False; 
     
      { Check if file exists } 
      if not FileExists(ADocument) then 
      begin 
        ShowMessage('Specified Document not found.'); 
        Exit; 
      end; 
     
      { Create the OLE Object } 
      try 
        WordApp := CreateOLEObject('Word.Application'); 
      except 
        on E: Exception do 
        begin 
          E.Message := 'Word is not available.'; 
          raise; 
        end; 
      end; 
     
      try 
        { Hide Word } 
        WordApp.Visible := False; 
        { Open the document } 
        WordApp.Documents.Open(ADocument); 
        { Initialize parameters} 
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
        { Perform the search} 
        if wrfReplaceAll in Flags then 
          WordApp.Selection.Find.Execute(Replace := wdReplaceAll) 
        else 
          WordApp.Selection.Find.Execute(Replace := wdReplaceOne); 
        { Save word } 
        WordApp.ActiveDocument.SaveAs(ADocument); 
        { Assume that successful } 
        Result := True; 
        { Close the document } 
        WordApp.ActiveDocument.Close(wdDoNotSaveChanges); 
      finally 
        { Quit Word } 
        WordApp.Quit; 
        WordApp := Unassigned; 
      end; 
    end; 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      Word_StringReplace('C:\Test.doc','Old String','New String',[wrfReplaceAll]); 
    end; 

