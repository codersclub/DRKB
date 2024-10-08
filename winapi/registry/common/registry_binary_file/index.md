---
Title: Сохранение бинарного файла в реестре с последующим его извлечением
Author: Sergey (KosilkA), gloom@imail.ru
Date: 04.12.2003
---

Сохранение бинарного файла в реестре с последующим его извлечением
==================================================================

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Сохранение бинарного файла в реестре с последующим его извлечением
     
    Функции позволяют разбить файл на блоки 16к и затем поместить бинарные
    данные в реестр, а так же собрать эти данные обратно в файл при необходимости.
    Не знаю зачем этот код нужен, но возможно он пригодится для скрытого
    хранения данных . Не рекомендуется (!) сохранять слишком большие файлы
    в реестре, потому что размеры реестра ограничены .
     
    Зависимости: Registry,SysUtils
    Автор:       Sergey, gloom@imail.ru, Koenigsberg
    Copyright:   KosilkA
    Дата:        4 декабря 2003 г.
    ***************************************************** }
     
    //////////////////////////////////////////////////
    // функция разбивки и сохранения файла в реестр:
     
    function SaveToRegistry(RootKey: HKEY; FileName, KeyName: string): Bool;
    //где RootKey-раздел реестра,
    //FileName-путь к файлу,
    //KeyName-ключ реестра в который будем сохранять
    var
      FromF: file;
      NumRead, i: Integer;
      Buf: array[0..16383] of byte;
      reg: tregistry;
    begin
      try
        AssignFile(FromF, filename);
        Reset(FromF, 1);
        reg := tregistry.Create;
        reg.RootKey := rootkey;
        if reg.OpenKey(keyName, true) = false then //если невозможно
          //открыть ключ с правами
          //записи, то что то не так
        begin
          result := false;
          reg.Free;
          exit; //выходим
        end;
        i := 0;
        repeat //читаем и записывае в цикле
          BlockRead(FromF, Buf, SizeOf(Buf), NumRead); //читаем блок из файла
          if numread <> 0 then
          begin
            reg.WriteBinaryData(inttostr(i), buf, numread); //сохраняем блок в реестр
            inc(i);
          end;
        until (NumRead = 0);
        CloseFile(FromF);
        reg.CloseKey;
        reg.Free;
        result := true;
      except
        reg.CloseKey;
        reg.Free;
        result := false;
      end;
    end;
     
    //////////////////////////////////////////////////
    // функция сборки сохраненного файла:
     
    function BuildFromRegistry(RootKey: HKEY; KeyName, ToFileName: string): Bool;
    //где RootKey-раздел реестра,
    //KeyName -ключ реестра,
    //ToFileName-имя выходного файла .
    var
      numwritten, i: integer;
      ToF: file;
      Buf: array[0..16383] of byte;
      reg: tregistry;
    begin
      try
        AssignFile(ToF, tofilename);
        Rewrite(ToF, 1);
        reg := tregistry.Create;
        reg.RootKey := rootkey;
        if reg.OpenKey(keyname, true) = false then
          //если указанный ключ невозможно открыть - выходим
        begin
          result := false;
          reg.Free;
          exit;
        end;
        i := 0;
        repeat
          //в цикле находим значения
          //начиная с "0", читаем их
          //и добавляем блоки к файлу
          if reg.ValueExists(inttostr(i)) = true then
          begin
            reg.ReadBinaryData(inttostr(i), buf, reg.GetDataSize(inttostr(i)));
            BlockWrite(ToF, Buf, reg.GetDataSize(inttostr(i)));
          end;
          inc(i);
        until reg.ValueExists(inttostr(i)) = false;
        CloseFile(ToF);
        reg.CloseKey;
        reg.Free;
        result := true;
      except
        reg.CloseKey;
        reg.Free;
        result := false;
      end;
    end;
     
     
    // Пример использования:
     
    // сохранить:
    SaveToRegistry(HKEY_CURRENT_USER, Application.ExeName, '\Software\MyData\test');
     
    // извлечь:
    BuildFromRegistry(HKEY_CURRENT_USER, '\Software\MyData\test', 'MyBuildApp.exe');
