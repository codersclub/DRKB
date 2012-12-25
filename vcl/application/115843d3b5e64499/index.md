---
Title: Как выполнить какой-то процесс тогда, когда пользователь не работает с моим приложением?
Author: p0s0l
Date: 01.01.2007
---


Как выполнить какой-то процесс тогда, когда пользователь не работает с моим приложением?
========================================================================================

::: {.date}
01.01.2007
:::

Создайте процедуру, которая будет вызываться при событии
Application.OnIdle.

Обьявим процедуру:

    {Private declarations}
    procedure IdleEventHandler(Sender: TObject; var Done: Boolean);
     
    В разделе implementation опишем поцедуру:
     
    procedure TForm1.IdleEventHandler(Sender: TObject; var Done: Boolean);
    begin
      {Do a small bit of work here}    
      Done := false;
    end;

В методе Form\'ы OnCreate укажем что наша процедура вызывается на
событии:

Application.OnIdle.Application.OnIdle := IdleEventHandler;

Событие OnIdle возникает один раз - когда приложение переходит в режим
\"безделья\" (idle).

Если в обработчике переменной Done присвоить False событие будет
вызываться

вновь и вновь, до тех пор пока приложение \"бездельничает\" и

переменной Done не присвоенно значение True.

Источник: http://www.vlata.com/delphi/

Автор: p0s0l
