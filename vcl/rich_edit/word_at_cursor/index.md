---
Title: Получить слово под курсором в TRichEdit
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Получить слово под курсором в TRichEdit
=======================================

    uses 
      RichEdit; 
     
    procedure TForm1.RichEdit1MouseMove(Sender: TObject; Shift: TShiftState; 
      X, Y: Integer); 
    var 
      iCharIndex, iLineIndex, iCharOffset, i, j: Integer; 
      Pt: TPoint; 
      s: string; 
    begin 
      with TRichEdit(Sender) do 
      begin 
        Pt := Point(X, Y); 
        // Get Character Index from word under the cursor 
        iCharIndex := Perform(Messages.EM_CHARFROMPOS, 0, Integer(@Pt)); 
        if iCharIndex < 0 then Exit; 
        // Get line Index 
        iLineIndex  := Perform(EM_EXLINEFROMCHAR, 0, iCharIndex); 
        iCharOffset := iCharIndex - Perform(EM_LINEINDEX, iLineIndex, 0); 
        if Lines.Count - 1 < iLineIndex then Exit; 
        // store the current line in a variable 
        s := Lines[iLineIndex]; 
        // Search the beginning of the word 
        i := iCharOffset + 1; 
        while (i > 0) and (s[i] <> ' ') do Dec(i); 
        // Search the end of the word 
        j := iCharOffset + 1; 
        while (j <= Length(s)) and (s[j] <> ' ') do Inc(j); 
        // Display Text under Cursor 
        Caption := Copy(s, i, j - i); 
      end; 
    end;  

