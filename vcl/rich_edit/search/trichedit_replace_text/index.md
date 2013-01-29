---
Title: TRichEdit -- замена текста
Date: 01.01.2007
---


TRichEdit -- замена текста
==========================

::: {.date}
01.01.2007
:::

    // This example doesn't use TReplaceDialog 
    // Ohne Benutzung von TReplaceDialog 
     
    function Search_And_Replace(RichEdit: TRichEdit; 
      SearchText, ReplaceText: string): Boolean; 
    var 
      startpos, Position, endpos: integer; 
    begin 
      startpos := 0; 
      with RichEdit do 
      begin 
        endpos := Length(RichEdit.Text); 
        Lines.BeginUpdate; 
        while FindText(SearchText, startpos, endpos, [stMatchCase])<>-1 do 
        begin 
          endpos   := Length(RichEdit.Text) - startpos; 
          Position := FindText(SearchText, startpos, endpos, [stMatchCase]); 
          Inc(startpos, Length(SearchText)); 
          SetFocus; 
          SelStart  := Position; 
          SelLength := Length(SearchText); 
          richedit.clearselection; 
          SelText := ReplaceText; 
        end; 
        Lines.EndUpdate; 
      end; 
    end; 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      Search_And_Replace(Richedit1, 'OldText', 'NewText'); 
    end;
     

Взято с сайта: <https://www.swissdelphicenter.ch>
