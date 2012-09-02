<h1>Как найти все Alias, укакзывающие на MS SQL Server?</h1>
<div class="date">01.01.2007</div>



<pre>
GetAliases(ComboBox1.Items)
 
procedure GetAliases(const AList: TStrings);
var
  i: Integer;
  Desc: DBDesc;
  Buff: array[0..254] of char;
begin
  // list all BDE aliases
  Session.GetAliasNames(AList);
  for i := AList.Count - 1 downto 0 do
  begin
    StrPCopy(Buff, AList[i]);
    Check(DbiGetDatabaseDesc(Buff, @Desc));
    // no Paradox, please
    if StrPas(Desc.szDBType) = 'STANDARD' then
      AList.Delete(i)
  end
end;
</pre>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
