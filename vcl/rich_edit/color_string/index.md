---
Title: Добавить цветную строку в TRichEdit
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Добавить цветную строку в TRichEdit
===================================

    { 
      To color text in a TRichEdit, follow this two steps: 
      1) Select the text with the SelStart, SelLength properties. 
      2) Set the text attribtutes through the SelAttributes property. 
    }
     
    { 
      1. Example/ Beispiel: 
     
      Add a colored line to a TRichEdit: 
    }
     
     procedure AddColoredLine(ARichEdit: TRichEdit; AText: string; AColor: TColor);
     begin
       with ARichEdit do
       begin
         SelStart := Length(Text);
         SelAttributes.Color := AColor;
         SelAttributes.Size := 8;
         SelAttributes.Name := 'MS Sans Serif';
         Lines.Add(AText);
       end;
     end;
     
     procedure TForm1.Button1Click(Sender: TObject);
     begin
       AddColoredLine(RichEdit1, 'Hallo', clRed);
       AddColoredLine(RichEdit1, 'Hallo', clGreen);
     end;
     
    { 
      2. Example/ Beispiel: 
     
      To color the 5 characters. 
      Die ersten 5 Zeichen im Richedit blau einfдrben. 
    }
     
     
     procedure TForm1.Button1Click(Sender: TObject);
     begin
       RichEdit1.SelStart  := 0;
       RichEdit1.SelLength := 5;
       RichEdit1.SelAttributes.Color := clBlue;
     end;
     
    { 
      3. Example/ Beispiel: ( by www.delphimania.de) 
     
      To color a specified line with a color 
      So kann eine beliebige Zeile mit einer Farbe gefдrbt werden: 
    }
     
     procedure RE_ColorLine(ARichEdit: TRichEdit; ARow: Integer; AColor: TColor);
     begin
       with ARichEdit do
       begin
         SelStart := SendMessage(Handle, EM_LINEINDEX, ARow - 1, 0);
         SelLength := Length(Lines[ARow - 1]);
         SelAttributes.Color := AColor;
         SelLength := 0;
       end;
     end;
     
     procedure TForm1.Button1Click(Sender: TObject);
     begin
       ZeileFaerben(RichEdit1, 4, clGreen);
     end;

