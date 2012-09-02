<h1>Имя пользователя Paradox</h1>
<div class="date">01.01.2007</div>


<p>Вы можете выполнить эту задачу, непосредственно обращаясь к BDE. Включите следующие модули в сецию Uses вашего модуля: DBIPROCS, DBIERRS, DBITYPES</p>

<p>Ниже приведена функция с именем ID, возвращающая сетевое имя входа:</p>
<pre>
function ID: string;
var
  rslt: DBIResult;
  szErrMsg: DBIMSG;
  pszUserName: PChar;
begin
 
  try
    Result := '';
    pszUserName := nil;
    GetMem(pszUserName, SizeOf(Char) * DBIMAXXBUSERNAMELEN);
    rslt := DbiGetNetUserName(pszUserName);
    if rslt = DBIERR_NONE then
      Result := StrPas(pszUserName)
    else
      begin
        DbiGetErrorString(rslt, szErrMsg);
        raise Exception.Create(StrPas(szErrMsg));
      end;
    FreeMem(pszUserName, SizeOf(Char) * DBIMAXXBUSERNAMELEN);
    pszUserName := nil;
  except
    on E: EOutOfMemory do ShowMessage('Ошибка. ' + E.Message);
    on E: Exception do ShowMessage(E.Message);
  end;
  if pszUserName &lt;&gt; nil then FreeMem(pszUserName, SizeOf(Char) * DBIMAXXBUSERNAMELEN);
end;
</pre>

<p>Взято из Советов по Delphi от <a href="mailto:mailto:webmaster@webinspector.com" target="_blank">Валентина Озерова</a></p>
<p>Сборник Kuliba</p>

