---
Title: Поместить/получить строку из буфера обмена (Заплатка к стандартным)
Date: 26.06.2002
Author: Shaman_Naydak, shanturov@pisem.net
---


Поместить/получить строку из буфера обмена (Заплатка к стандартным)
===================================================================

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Поместить/получить строку из буфера обмена (Заплатка к стандартным)
     
    Под Win2k попытка вставить русскую строку в Clipboard 
    ClipBoard.AsText:='Проба' с последующей вставкой в Word'е 
    показывает кракозябрики.. Расследование показало, что виноваты 
    мелкомягкие (как обычно :) ) С целью нивелирования различий между 
    всеми Win-платформами были написаны эти 2 ф-ции..
    Принимают на вход/возвращают строку в Unicode - WideString.. 
    но не надо беспокоиться, Дельфи сам вставит при необходимости 
    конвертацию в/из AnsiString.
     
    Если платформа поддерживает уникод (NT), то используется этот формат, 
    иначе вызываются стандартные процедуры/ф-ции.
    Удачи!
     
    Зависимости: ClipBrd
    Автор:       Shaman_Naydak, shanturov@pisem.net
    Copyright:   Shaman_Naydak
    Дата:        26 июня 2002 г.
    ********************************************** }
     
    procedure PutStringIntoClipBoard(const Str: WideString);
    var
      Size: Integer;
      Data: THandle;
      DataPtr: Pointer;
    begin
      Size:=Length(Str);
      if Size = 0 then exit;
      if not IsClipboardFormatAvailable(CF_UNICODETEXT) then
        Clipboard.AsText:=Str
      else
      begin
        Size:=Size shl 1 + 2;
        Data := GlobalAlloc(GMEM_MOVEABLE+GMEM_DDESHARE, Size);
        try
          DataPtr := GlobalLock(Data);
          try
            Move(Pointer(Str)^, DataPtr^, Size);
            Clipboard.SetAsHandle(CF_UNICODETEXT, Data);
          finally
            GlobalUnlock(Data);
          end;
        except
          GlobalFree(Data);
          raise;
        end;
      end;
    end;
     
    function GetStringFromClipboard: WideString;
    var
      Data: THandle;
    begin
      if not IsClipboardFormatAvailable(CF_UNICODETEXT) then
        Result:=Clipboard.AsText
      else
      begin
        Clipboard.Open;
        Data := GetClipboardData(CF_UNICODETEXT);
        try
          if Data <> 0 then
            Result := PWideChar(GlobalLock(Data))
          else
            Result := '';
        finally
          if Data <> 0 then GlobalUnlock(Data);
          Clipboard.Close;
        end;
      end;
    end;
