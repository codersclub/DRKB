---
Title: Cуществует ли диск в системе?
Author: Serious
Date: 01.01.2007
---


Cуществует ли диск в системе?
=============================

::: {.date}
01.01.2007
:::

    function DriveExists (Drive: Byte) : boolean;
    begin
      Result := Boolean (GetLogicalDrives and (1 shl Drive));
    end;
     
    procedure TForm1.Button1Click(Sender : TObject);
      var Drive : byte;
    begin
    for Drive := 0 to 25 do
      If DriveExists (Drive) then
    begin
    ListBox1.Items.Add (Chr(Drive+$41));
    end;
    end;

Автор: Serious

Взято с Vingrad.ru <https://forum.vingrad.ru>
