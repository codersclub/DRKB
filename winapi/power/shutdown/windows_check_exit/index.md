---
Title: Узнать о завершении работы Windows
Date: 01.01.2007
---


Узнать о завершении работы Windows
==================================

Вариант 1:

Author: Даниил Карапетян (delphi4all@narod.ru)

Если текст в Memo1 был изменен, то программа не разрешает завершения
сеанса Windows.

    ...
    private
        procedure WMQueryEndSession(var Msg: TWMQueryEndSession); message WM_QUERYENDSESSION;
    ...
    procedure TForm1.WMQueryEndSession(var Msg: TWMQueryEndSession);
    begin
      Msg.Result := integer(not Memo1.Modified);
    end;

Автор справки: Алексей Денисов (aleksey@sch103.krasnoyarsk.su)

------------------------------------------------------------------------

Вариант 2:

Author: Nomadic 

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

> Как корректно перехватить сигнал выгрузки операционной системы, если в
> моей программе нет окна?

Используй `GetMessage()`, в качестве `HWND` окна пиши `NULL` (на Паскале - 0).

Если в очереди сообщений следующее - `WM_QUIT`, то эта функция фозвращает
`FALSE`. Если ты пишешь программу для Win32, то запихни это в отдельный
поток, организующий выход из программы.

