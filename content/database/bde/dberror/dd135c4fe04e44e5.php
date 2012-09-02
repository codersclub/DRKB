<h1>Перехват ошибок DBEngine</h1>
<div class="date">01.01.2007</div>


<p class="author">Автор: Eryk </p>

<p>Ошибки общего характера, типа Key Violation или конфликты блокировки лучше всего обрабатывать в обработчике события Application.OnException ...например:</p>

<pre>
{Секция Interface}
procedure HandleException(Sender: TObject; E: Exception);
...
 
{Секция Implementation}
procedure TForm1.HandleException(Sender: TObject; E: Exception);
var
  err: DBIResult;
begin
  if E is EDBEngineError then
  begin
    err := (E as EDBEngineError).errors[(E as EDBEngineError).errorcount -
      1].errorcode;
    if (err = DBIERR_KEYVIOL) then
      showMessage('Ошибка Key violation!')
    else if (err = DBIERR_LOCKED) then
      showmessage('Запись блокирована другим пользователем')
    else if (err = DBIERR_FILELOCKED) then
      showmessage('Таблица блокирована кем-то еще')
    else
      showmessage('Другая ошибка DB')
  end
  else
    showmessage('Упс!: ' + E.Message);
end;
 
...'инсталлировать' обработчик исключений можно так:
 
procedure TForm1.FormCreate(Sender: TObject);
begin
  Application.onException:=HandleException;
end;
</pre>

<p>Для использования предопределенных констант ошибок ('DBIERR_etc.'), вам необходимо включить DBIERRS в список используемых модулей. Полный список кодов ошибок при работе с базами данных вы можете найти в файле DBIERRS.INT, расположенном в каталоге :\DELPHI\DOC.</p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
