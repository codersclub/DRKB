<h1>Построение древа TTreeView из базы данных</h1>
<div class="date">01.01.2007</div>

<div class="author">Автор: dron-s</div>

<pre>
procedure TOrgColumn.LoadTreeView;
type
  PItemData=^TItemData;
  TItemData=record
    Index:Integer;
  end;
 
var
  tnNew :TTreeNode;
  idNewItem:PItemData;
  i:integer;
begin
  TreeView1.Items.Clear;
 
  with data.QOrganCol do
    begin
      Active := false;
      SQL.Clear;
      SQL.Add('SELECT * FROM OrganizationColumns.DB');
      SQL.Add('ORDER BY NumColumn, Name');
      ExecSQL;
      Active := True;
    end;
 
  data.QOrganCol.First;
  while data.QOrganCol.Eof &lt;&gt; true do
    begin
      tnNew := nil;
        if data.QOrganCol.Fields[2].AsInteger &gt;0 then
          for i := 0 to TreeView1.Items.Count-1 do
            if PItemData(TreeView1.Items[i].Data).Index =
              data.QOrganCol.Fields[2].AsInteger then
            tnNew := TreeView1.Items[i];
 
        with TreeView1.Items.AddChild(tnNew, data.QOrganCol.Fields[3].AsString) do
          begin
            ImageIndex := 1;
            SelectedIndex := 0;
            idNewItem := new(PItemData);
            Data := idNewItem;
            idNewItem.Index := dmodule.data.QOrganCol.Fields[0].AsInteger;
          end;
        data.QOrganCol.Next;
    end;
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
