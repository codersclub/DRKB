---
Title: Узнать о завершении работы Windows
Author: Даниил Карапетян (delphi4all@narod.ru)
Date: 01.01.2007
---


Узнать о завершении работы Windows
==================================

::: {.date}
01.01.2007
:::

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

Автор: Даниил Карапетян (delphi4all@narod.ru)

Автор справки: Алексей Денисов (aleksey@sch103.krasnoyarsk.su)

------------------------------------------------------------------------

 

Как корректно перехватить сигнал выгрузки операционной системы, если в
моей программе нет окна

Автор: Nomadic 

Используй GetMessage(), в качестве HWND окна пиши NULL (на Паскале - 0).
Если в очереди сообщений следующее - WM\_QUIT, то эта функция фозвращает
FALSE. Если ты пишешь программу для Win32, то запихни это в отдельный
поток, организующий выход из программы.

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
