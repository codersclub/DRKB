---
Title: Как сделать Ping?
Author: Vit
Date: 01.01.2007
---


Как сделать Ping?
=================

::: {.date}
01.01.2007
:::

В коде используется функция ExecCmdine из статьи:
[Как запустить консольное приложение и перехватить вывод?](/kylix/311a5c6b05404bc2/)

    function Ping(host:string):boolean;
      var  params, CommandLine:string;
           t:TStringList;
           i:integer;
    begin
      Params := Format('-s%d ', [32]);
      Params := Params+Format('-c%d ', [1]);
      CommandLine := Format('ping %s%s', [Params, host]);
      t:=TStringList.Create;
      ExecCmdine(CommandLine, t);
      Result:=pos('1 received, 0% packet loss', t.text)>0;
      t.free;
    end; 

Примечание

Под отладчиком Kylix код может не работать. Надо запускать приложение не
под Kylix для того чтобы удостовериться что код работает.

Более подробную информацию можно получить запустив в консоле:

man ping

Автор: Vit
