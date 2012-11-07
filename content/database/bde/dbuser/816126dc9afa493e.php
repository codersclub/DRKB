<h1>Как сделать список всех пользователей BDE?</h1>
<div class="date">01.01.2007</div>


<pre class="delphi">
With Paradox:

procedure BDEGetPDXUserList(AList: TStrings);
var
  hCur: hDBICur;
  UDesc: USERDesc;
begin
  AList.Clear;
  Check(DBIOpenUserList(hCur));
  try
    while DBIGetNextRecord(hCur, dbiNOLOCK, @UDesc, nil) &lt;&gt; DBIERR_EOF do
    begin
      AList.Add(StrPas(UDesc.szUserName));
    end;
  finally
    DBICloseCursor(hCur);
  end;
end;
</pre>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
