<h1>TMemo в TDBGrid</h1>
<div class="date">01.01.2007</div>


<pre>
{
A common problem when working with DBGrid is, that this component can't display TMemo fields,
multiline columns, Graphics...
There are a few good freeware components around to solve this problem.
The best one is definitly "DBGRIDPLUS", which comes with full sources.
However, this component does not allow to edit the text in memo fields.
The delphi fans out there who bought a delphi version that comes with the VCL sources can
fix this problem:
Open dbgrids.pas and make the following changes:
(To have memo editing in your app you must just add the modifyed version of dbgrids.pas to your uses clause)
}
 
function TCustomDBGrid.GetEditLimit: Integer;
begin
  Result := 0;
  if Assigned(SelectedField) and (SelectedField.DataType in [ftString, ftWideString, ftMemo]) then &lt;-- Add
    Result := SelectedField.Size;
end;
 
function TCustomDBGrid.GetEditText(ACol, ARow: Longint): string;
begin
  Result := '';
  if FDatalink.Active then
  with Columns[RawToDataColumn(ACol)] do
    if Assigned(Field) then
      Result := Field.AsString; &lt;-- Change this.
  FEditText := Result;
end;
 
{
Just compare theese edited functions with the original ones, and you will know what to change.
To get multiline cell support (not in memo fields!) for DBGridPlus, send me an email and i can send you the changed DBGridPlus.pas file.
}
</pre>


<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
