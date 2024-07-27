---
Title: Как присвоить значение свойству selected в TListBox?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как присвоить значение свойству selected в TListBox?
====================================================

Свойство "selected" компонента ТListBox может быть использованно
только если свойство MultiSelect установленно в True. Если Вы работаете
с ListBox\'ом у которого MultiSelect=false то используйте свойство
ItemIndex.

    procedure TForm1.Button1Click(Sender: TObject);
    begin
            ListBox1.Items.Add('1');
            ListBox1.Items.Add('2');
            {This will fail on a single selection ListBox}
    //        ListBox1.Selected[1] := true;
            ListBox1.ItemIndex := 1; {This is ok}
    end;

