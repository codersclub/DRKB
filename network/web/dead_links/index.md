---
Title: Детектор мертвых ссылок
Date: 01.01.2007
---


Детектор мертвых ссылок
=======================

::: {.date}
01.01.2007
:::

Любой серьезный web сайт и его web мастер должны всегда следить за
актуальность ссылок. И если обнаружится мертвая ссылка (например другой
web сайт прекратил существование), но нет никаких оправданий для
внутренних мертвых ссылок. И поэтому я написал простую программу, назвав
ее HTMLINKS, которая может сканировать .HTM файлы на их присутствие на
локальной машине. (что бы потом загрузить их на сервер). HTM файлы из
текущего каталога и всех подкаталогов рекурсивно читаются и проверяются
на тег \"\<A HREF=\" или \"\<FRAME SRC=\". Если страница локальная, то
есть без префикса \"http://\", то файл открывается с использованием
относительно пути. Если страница не находится, то мы имеем внутреннюю
мертвую ссылку, которая должна быть исправлена!!

Заметим, что программа игнорирует все \"file://\", \"ftp://\",
\"mailto:\", \"news:\" and \".exe?\" значения если они встретятся внутри
\"HREF\" части. Конечно, вы свободны в расширить HTMLINKS для проверки и
этих случаев, можно также реализовать проверку и внешних ссылок. Для
информации я написал и детектор внешних мертвых ссылок в статье для The
Delphi Magazine, подробности можно найти на моем web сайте. Для анализа
мертвых локальных ссылок код следующий:

::: {style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 0px;"}
      {$APPTYPE CONSOLE}
      {$I-,H+}
      uses
        SysUtils;
      var
        Path: String;
     
        procedure CheckHTML(const Path: String);
        var
          SRec: TSearchRec;
          Str: String;
          f: Text;
        begin
          if FindFirst('*.htm', faArchive, SRec) = 0 then
          repeat
            Assign(f,SRec.Name);
            Reset(f);
            if IOResult = 0 then { no error }
            while not eof(f) do
            begin
              readln(f,Str);
              while (Pos('<A HREF="',Str)  0) or
                    (Pos('FRAME SRC="',Str)  0) do
              begin
                if Pos('<A HREF="',Str)  0 then
                  Delete(Str,1,Pos('HREF="',Str)+8-3)
                else
                  Delete(Str,1,Pos('FRAME SRC="',Str)+10);
                if (Pos('#',Str) <> 1) and
                   (Pos('http://',Str) <> 1) and
                   (Pos('mailto:',Str) <> 1) and
                   (Pos('news:',Str) <> 1) and
                   (Pos('ftp://',Str) <> 1) and
                   (Pos('.exe?',Str) = 0) then { skip external links & exe }
                begin
                  if Pos('file:///',Str) = 1 then Delete(Str,1,8);
                  if (Pos('#',Str)  0) and
                     (Pos('#',Str) < Pos('"',Str)) then Str[Pos('#',Str)] := '"';
                  if not FileExists(Copy(Str,1,Pos('"',Str)-1)) then
                    writeln(Path,'\',SRec.Name,': [',Copy(Str,1,Pos('"',Str)-1),']')
                end
              end
            end;
            Close(f);
            if IOResult <> 0 then { skip }
          until FindNext(SRec) <> 0;
          FindClose(SRec);
          // check sub-directories recursively
          if FindFirst('*.*', faDirectory, SRec) = 0 then
          repeat
            if ((SRec.Attr AND faDirectory) = faDirectory) and
                (SRec.Name[1] <> '.') then
            begin
              ChDir(SRec.Name);
              CheckHTML(Path+'\'+SRec.Name);
              ChDir('..')
            end
          until FindNext(SRec) <> 0;
          FindClose(SRec)
        end {CheckHTML};
     
      begin
        writeln('HTMLinks 4.0 (c) 1997-2000 by Bob Swart (aka Dr.Bob - www.drbob42.com)');
        writeln;
        FileMode := $40;
        GetDir(0,Path);
        CheckHTML(Path)
      end.

 

 

Интернет решения от доктора Боба (http://www.drbob42.com)

\(c) 2000, Анатолий Подгорецкий, перевод на русский язык
(<https://nps.vnet.ee/ftp>)
:::
