---
Title: Как найти пароль к базе данных?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как найти пароль к базе данных?
===============================

Я знаю, что существует множество утилит, которые стоят $$,
для удаления пароля доступа к базе данных.
А вот как это можно реализовать в Delphi.

Обратите внимание, что этот метод не предназначен для базы данных
с безопасностью на уровне пользователя и файлом информации о рабочей группе.
Идея основана на формате файла базы данных доступа.

Пароль хранится в месте $42 и шифруется с помощью простого xor.
Следующая функция выполняет расшифровку.

    function GetPassword(filename: string): string;
    var
      Stream: TFilestream;
      buffer: array[0..12] of char;
      str: string;
    begin
      try
        stream := TFileStream.Create(filename, fmOpenRead);
      except
        ShowMessage('Could not open the file.Make sure that the file is not in use.');
        exit;
      end;
      stream.Seek($42, soFromBeginning);
      stream.Read(buffer, 13);
      stream.Destroy;
     
      str := chr(Ord(buffer[0]) xor $86);
      str := str + chr(Ord(buffer[1]) xor $FB);
      str := str + chr(Ord(buffer[2]) xor $EC);
      str := str + chr(Ord(buffer[3]) xor $37);
      str := str + chr(Ord(buffer[4]) xor $5D);
      str := str + chr(Ord(buffer[5]) xor $44);
      str := str + chr(Ord(buffer[6]) xor $9C);
      str := str + chr(Ord(buffer[7]) xor $FA);
      str := str + chr(Ord(buffer[8]) xor $C6);
      str := str + chr(Ord(buffer[9]) xor $5E);
      str := str + chr(Ord(buffer[10]) xor $28);
      str := str + chr(Ord(buffer[11]) xor $E6);
      str := str + chr(Ord(buffer[12]) xor $13);
      Result := str;
    end;

