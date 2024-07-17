---
Title: Синхронизация TTabSet c TListBox
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Синхронизация TTabSet c TListBox
================================

Что-то аналогичное я делал раньше, тем не менее, вместо Listbox я
использовал dbGrid со следующими опциями:

[dgAlwaysShowEditor, dgTabs, dgRowSelect, dgAlwaysShowSelection, dgConfirmDelete,
dgCancelOnExit]

Кроме того, я привел код, который я использовал в ответ на щелчок на
закладке, таким образом изменяя запись в dbgrid.

    procedure TForm1.TabSet1Change(Sender: TObject; NewTab: Integer;
      var AllowChange: Boolean);
    begin
      Table1.FindNearest([Chr(NewTab+65)]);
      Table2.FindNearest([Chr(NewTab+65)]);
    end;
     
    procedure TForm1.TabSet1Click(Sender: TObject);
    var
      I: integer;
    begin
      with TabSet1 do
      begin
        if TabIndex > -1 then
        begin
          with ListBox1 do
          begin
            for I := 0 to Items.Count - 1 do
            begin
              if Pos(Tabs[TabIndex], Items[I]) = 1 then
              begin
                ItemIndex := I;
                break;
              end;
            end;
          end;
        end;
      end;
    end;

