---
Title: Можно ли удалять из списка TDriveComboBox диски которые отключены?
Date: 01.01.2007
---


Можно ли удалять из списка TDriveComboBox диски которые отключены?
==================================================================

::: {.date}
01.01.2007
:::

На некоторых laptop компьютерах может не быть флоппи дисковода. Можно ли
удалять из списка TDriveComboBox диски которые отключены?

В примере TDriveComboBox не показывает дисководы, которые не готовы.
(not ready). Учтите что на многих компьютерах будет ощутимая задержка
при поверке plug&play флоппи дисковода.

    procedure TForm1.FormCreate(Sender: TObject);
    var
      i: integer;
      OldErrorMode: Word;
      OldDirectory: string;
    begin
      OldErrorMode := SetErrorMode(SEM_NOOPENFILEERRORBOX);
      GetDir(0, OldDirectory);
      i := 0;
      while i <= DriveComboBox1.Items.Count - 1 do
        begin
    {$I-}
          ChDir(DriveComboBox1.Items[i][1] + ':\');
    {$I+}
          if IoResult <> 0 then
            DriveComboBox1.Items.Delete(i)
          else
            inc(i);
        end;
      ChDir(OldDirectory);
      SetErrorMode(OldErrorMode);
    end;
