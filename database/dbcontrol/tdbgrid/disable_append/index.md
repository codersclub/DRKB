---
Title: Как заблокировать TDBGrid от автодобавления новой записи?
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Как заблокировать TDBGrid от автодобавления новой записи?
=========================================================

Добавьте в обработчик события вашего TTable "BeforeInsert" следующую
строку:

    procedure TForm1.Tbable1BeforeInsert(DataSet: TDataset);
    begin
      Abort;  // <<---эту строчку
    end;

Осуществляем перехват нажатия клавиши и проверку на конец файла
(end-of-file):

    procedure TForm8.DBGrid1KeyDown(Sender: TObject;
      var Key: Word; Shift: TShiftState);
    begin
      if (Key = VK_DOWN) then
      begin
        TTable1.DisableControls;
        TTable1Next;
        if TTable1.EOF then
          Key := 0
        else
          TTable1.Prior;
        TTable1.EnableControls;
      end;
    end;

