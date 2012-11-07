<h1>Пример вызова TUtility DLL из Delphi?</h1>
<div class="date">01.01.2007</div>


<pre class="delphi">
var
  Session: hTUses;
  i: integer;
  ErrorCode: word;
  ResultCode: word;
 
procedure BdeError(ResultCode: Word);
begin
  if ResultCode &lt;&gt; 0 then
    raise Exception.CreateFmt('BDE ошибка %x', [ResultCode]);
end;
 
begin
  try
    BdeError(DbiInit(nil));
    BdeError(TUInit(@Session));
 
    for i := 1 to High(TableNames) do
      begin
        WriteLn('Проверка ' + TableNames[i]);
 
        ResultCode := TUVerifyTable(Session, @TableNames[i, 1], szPARADOX, 'TABLERRS.DB', nil, TU_Append_Errors, ErrorCode);
        BdeError(ResultCode);
 
        if ErrorCode = 0 then
          WriteLn('Успешно')
        else
          WriteLn('ОШИБКА! -- Для информации смотри TABLERRS.DB!');
 
        WriteLn('');
      end;
  finally
    BdeError(TUExit(Session));
    BdeError(DbiExit);
  end;
end.
</pre>

<p>Взято из Советов по Delphi от <a href="mailto:mailto:webmaster@webinspector.com" target="_blank">Валентина Озерова</a></p>

<p>Сборник Kuliba</p>

