---
Title: Преобразовать первую букву каждого слова к верхнему регистру в TEdit
Date: 01.01.2007
---


Преобразовать первую букву каждого слова к верхнему регистру в TEdit
====================================================================

::: {.date}
01.01.2007
:::

    procedure TForm1.Edit1Change(Sender: TObject);
     var
       OldChange: TNotifyEvent;
       OldStart: Integer;
     begin
       with (Sender as TEdit) do
       begin
         OldChange := OnChange;
         OnChange  := nil;
         OldStart  := SelStart;
         if ((SelStart > 0) and (Text[SelStart - 1] = ' ')) or (SelStart = 1) then
         begin
           SelStart  := SelStart - 1;
           SelLength := 1;
           SelText   := AnsiUpperCase(SelText);
         end;
     
         OnChange := OldChange;
         SelStart := OldStart;
       end;
     end;

Взято с сайта: <https://www.swissdelphicenter.ch>

 

------------------------------------------------------------------------

    procedure TForm1.Edit1KeyPress(Sender: TObject; var Key: Char);
    begin
      with Sender as TEdit do
        if (Text = '') or (Text[SelStart] = ' ')
          or (SelLength = Length(Text)) then
            if Key in ['a'..'z'] then
              Key := UpCase(Key);
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
