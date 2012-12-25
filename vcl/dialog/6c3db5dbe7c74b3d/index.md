---
Title: Как вызвать диалог «Найти файлы и паки» проводника?
Date: 01.01.2007
---


Как вызвать диалог «Найти файлы и паки» проводника?
===================================================

::: {.date}
01.01.2007
:::

Приведенный пример показывает использование DDE для вызова диалога
\'Найти файлы и паки\' Explorerа. Диалог открывается на каталоге
\"C:\\Download\".

                procedure TForm1.Button1Click(Sender: TObject); 
                 begin 
                   with TDDEClientConv.Create(Self) do begin 
                     ConnectMode := ddeManual; 
                     ServiceApplication := 'explorer.exe'; 
                     SetLink( 'Folders', 'AppProperties'); 
                     OpenLink; 
                     ExecuteMacro('[FindFolder(, C:\DOWNLOAD)]', False); 
                     CloseLink; 
                     Free; 
                   end; 
                 end;
