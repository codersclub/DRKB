---
Title: Найти все ссылки в TMemo
Date: 01.01.2007
---


Найти все ссылки в TMemo
========================

::: {.date}
01.01.2007
:::

    { 
      For this tip you need Memo1, ListBox1, Label1, Button1. 
     
    }
     
     procedure TForm1.Button1Click(Sender: TObject);
     var
        i, p: Integer;
       s: string;
     begin
       ListBox1.Clear;
       for i := 0 to Memo1.Lines.Count - 1 do
       begin
         if Pos('http://', Memo1.Lines.Strings[i]) > 0 then
         begin
           s := '';
           {If the current line contains a "http://", read on until a space is found 
     
           Die aktuelle Zeile wird nach der Zeichenfolge "http://" durchsucht 
           und bei Erfolg ab der gefundenen Position ausgelesen, bis ein 
           Leerzeichen auftritt...}
     
           for p := Pos('http://', Memo1.Lines.Strings[i]) to
             Length(Memo1.Lines.Strings[i]) do
             if Memo1.Lines.Strings[i][p] <> ' ' then
               s := s + Memo1.Lines.Strings[i][p]
           else
             break;
     
            {Remove some characters if address doesn't end with a space 
     
           Falls die gefundene Adresse nicht mit einem Leerzeichen abschlie?t, 
           werden hier noch anhangende Textzeichen entfernt...}
     
           while Pos(s[Length(s)], '..;!")]}?''>') > 0 do
             Delete(s, Length(s), 1);
           // Add the Address to the list... 
          //Gefundene Adresse in die Liste aufnehmen... 
          ListBox1.Items.Add(s);
         end;
       end;
     
       // Show the number of Addresses in Label1 
      // Die Zahl der gefundenen Adressen in Label1 anzeigen... 
     
      if ListBox1.Items.Count > 0 then
         label1.Caption := IntToStr(ListBox1.Items.Count) +
           ' Adresse(n) gefunden.'
       else
         label1.Caption := 'Keine Adresse gefunden.';
     end;

Взято с сайта: <https://www.swissdelphicenter.ch>
