---
Title: Удалить dbase index flag
Date: 01.01.2007
---


Удалить dbase index flag
========================

::: {.date}
01.01.2007
:::

    Function UnCheckIndex(FileDbf: string): Boolean;
    var
      Dbf: file;
      Car: Char;
    begin
      Result := T;
      AssignFile(Dbf, FileDbf);
      Car := #0;
      {$I-}
      Reset(Dbf, 1);
      if not ErrorIO(FileDbf, IoResult) then 
      begin
        Seek(Dbf, 28);
        {Flag's position}
        if not ErrorIO(FileDbf, IoResult) then
          BlockWrite(Dbf, Car, 1, Num_R)
        else
          Result := F;
        CloseFile(Dbf);
        if ErrorIO(FileDbf, IoResult) then
          Result := F;
      end
      else
        Result := F;
      {$I+}
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      if UnCheckIndex('MyBase.dbf') then
        ShowMessage('Flag removed');
    end;

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
