<h1>Задать пароль на MS ACCESS через ADO</h1>
<div class="date">01.01.2007</div>


<pre>
type
  TPasswordAction = (paSet, paChange, paRemove);
 
  ....
 
function ChangeAccessDBPassword(DatabaseName: string; action: TPasswordAction;
  OldPassword: string = ''; NewPassword: string = ''): boolean;
var
  DAO: _DBEngine;
  db: Database;
  ClassID: TGUID;
  V35, V36: string;
  oldPass, newPass: string;
begin
  Result := false;
  V35 := 'DAO.DBEngine.35';
  V36 := 'DAO.DBEngine.36';
  try
    try
      ClassID := ProgIDToClassID(v36);
    except
      try
        ClassID := ProgIDToClassID(v35);
      except
        raise;
      end;
    end;
    DAO := CreateComObject(ClassID) as _DBEngine;
    if action = paSet then
    begin
      db := DAO.OpenDatabase(DatabaseName, true, false, '');
      db.NewPassword(#0, NewPassword);
    end
    else
    begin
      db := DAO.OpenDatabase(DatabaseName, true, false, ';pwd=' + OldPassword);
      if action = paChange then
        db.NewPassword(OldPassword, NewPassword)
      else
        db.NewPassword(OldPassword, #0);
    end;
    Result := true;
  except
    // выводим сообщение о ошибке
    on E: Exception do
    begin
      Result := false;
      ShowMessage(e.message);
    end;
  end;
end.
</pre>

<p>Пример использования: <br>
<p>устанавливаем новый пароль - БАЗА ДОЛЖНА БЫТЬ НЕ ЗАПАРОЛЕНА, иначе будет ошибка:)</p>
<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
  newPass: string;
begin
  if InputQuery('New password', 'Enter new password', newPass) then
    if ChangeAccessDBPassword(ExtractFilePath(ParamStr(0)) + 'db2.mdb', paSet,
      '', newPass) then
      ShowMessage('OK!')
    else
      ShowMessage('Error!');
end;
 
//изменяем пароль
procedure TForm1.Button2Click(Sender: TObject);
var
  oldPass, newPass: string;
begin
  if InputQuery('Old password', 'Enter old password', oldPass) then
    if InputQuery('New password', 'Enter new password', newPass) then
      if ChangeAccessDBPassword(ExtractFilePath(ParamStr(0)) + 'db2.mdb',
        paChange, oldPass, newPass) then
        ShowMessage('OK!')
      else
        ShowMessage('Error!');
end;
 
//удаляем пароль
procedure TForm1.Button3Click(Sender: TObject);
var
  oldPass: string;
begin
  if InputQuery('Password', 'Enter password', oldPass) then
    if ChangeAccessDBPassword(ExtractFilePath(ParamStr(0)) + 'db2.mdb',
      paRemove, oldPass, '') then
      ShowMessage('OK!')
    else
      ShowMessage('Error!');
end;
 
</pre>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
<p class="p_Heading1">Автор:dron-s</p>
&nbsp;<br>

<p>&nbsp;<br>
&nbsp;<br>
&nbsp;<br>
<p>&nbsp;</p>

