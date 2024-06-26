---
Title: Перехват ошибок DBEngine
Author: Eryk
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Перехват ошибок DBEngine
========================

Ошибки общего характера, типа Key Violation или конфликты блокировки
лучше всего обрабатывать в обработчике события Application.OnException.

Например:

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

Для использования предопределенных констант ошибок ('DBIERR\_etc.'),
вам необходимо включить DBIERRS в список используемых модулей. Полный
список кодов ошибок при работе с базами данных вы можете найти в файле
DBIERRS.INT, расположенном в каталоге C:\\DELPHI\\DOC.

