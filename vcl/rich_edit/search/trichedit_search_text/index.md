---
Title: TRichEdit - поиск текста
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


TRichEdit - поиск текста
=========================

    function SearchForText_AndSelect(RichEdit: TRichEdit; SearchText: string): Boolean; 
    var 
      StartPos, Position, Endpos: Integer; 
    begin 
      StartPos := 0; 
      with RichEdit do 
      begin 
        Endpos := Length(RichEdit.Text); 
        Lines.BeginUpdate; 
        while FindText(SearchText, StartPos, Endpos, [stMatchCase])<>-1 do 
        begin 
          Endpos   := Length(RichEdit.Text) - startpos; 
          Position := FindText(SearchText, StartPos, Endpos, [stMatchCase]); 
          Inc(StartPos, Length(SearchText)); 
          SetFocus; 
          SelStart  := Position; 
          SelLength := Length(SearchText); 
        end; 
        Lines.EndUpdate; 
      end; 
    end; 
     
     
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      SearchForText_AndSelect(RichEdit1, 'Some Text'); 
    end;

