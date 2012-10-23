<h1>Синхронизация TTabSet c TListBox</h1>
<div class="date">01.01.2007</div>

Что-то аналогичное я делал раньше, тем не менее, вместо Listbox я использовал dbGrid со следующими опциями:</p>
<p>[dgAlwaysShowEditor,dgTabs,dgRowSelect,dgAlwaysShowSelection,dgConfirmDelete, dgCancelOnExit]</p>
<p>Кроме того, я привел код, который я использовал в ответ на щелчок на закладке, таким образом изменяя запись в dbgrid.</p>
<pre>procedure TForm1.TabSet1Change(Sender: TObject; NewTab: Integer;
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
    if TabIndex &gt; -1 then
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
</pre>
&nbsp;</p>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
&nbsp;</p>
