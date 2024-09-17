---
Title: Экспорт и импорт из реестра
Date: 01.01.2007
---

Экспорт и импорт из реестра
===========================

reg-файлы - это, как и ожидалось, формат, понимаемый и поддерживаемый
сугубо программой regedit.

Командная строка у неё такая:

Импорт в реестр:

    regedit RegData.reg

Экспорт из реестра:

    regedit /e RegData.reg HKEY_LOCAL_MACHINE\Software\Microsoft\Windows

Если в параметрах встречаются пробелы, их ессно надо заключать в
кавычки. Код в Delphi, который экспортирует ветвь реестра может быть
например такой:

    uses
      ShellApi;
     
    procedure TMain.ExportBtnClick(Sender: TObject);
    var
      FileName, Key: string;
    begin
      FileName := ... //заполнить именем файла (расширение указывать)
      Key := ... //заполнить именем ключа, типа
      //Key := 'HKEY_LOCAL_MACHINE\Software\Microsoft\Windows NT\CurrentVersion'
      if ShellExecute(Handle, 'open', 'regedit.exe',
      PChar(Format('/e "%s" "%s"', [FileName, Key])),
      '', SW_SHOWDEFAULT) <= 32
      then //если ошибка, то возвращаемый код <=32
        RaiseLastWin32Error();
    end;
