---
Title: Выделить строку в TMemo
Date: 01.01.2007
---


Выделить строку в TMemo
=======================

::: {.date}
01.01.2007
:::

    procedure TfrmMain.Memo1Click(Sender: TObject); 
    var 
      Line: Integer; 
    begin 
      with (Sender as TMemo) do 
      begin 
        Line      := Perform(EM_LINEFROMCHAR, SelStart, 0); 
        SelStart  := Perform(EM_LINEINDEX, Line, 0); 
        SelLength := Length(Lines[Line]); 
      end; 
    end;
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

 

 
