---
Title: Как узнать номер BIOS для разных версий Windows?
Date: 01.01.2007
---


Как узнать номер BIOS для разных версий Windows?
================================================

Вариант 1:

Author: МММ

**Windows 9X**


    with Memo1.Lines do
      begin
        Add('MainBoardBiosName:'+^I+string(Pchar(Ptr($FE061))));
        Add('MainBoardBiosCopyRight:'+^I+string(Pchar(Ptr($FE091))));
        Add('MainBoardBiosDate:'+^I+string(Pchar(Ptr($FFFF5))));
        Add('MainBoardBiosSerialNo:'+^I+string(Pchar(Ptr($FEC71))));
      end;

**Windows NT**

В Windows NT/2000/XP не получится прочитать значения прямо из BIOS, однако,
ничего не мешает нам считать нужные значения из реестра.


    procedure TBIOSInfo.GetRegInfoWinNT;
     
    var
      Registryv       : TRegistry;
      RegPath         : string;
      sl              : TStrings;
    begin
      Params.Clear;
     
      RegPath := '\HARDWARE\DESCRIPTION\System';
      registryv:=tregistry.Create;
      registryv.rootkey:=HKEY_LOCAL_MACHINE;
      sl := nil;
      try
        registryv.Openkey(RegPath,false);
        ShowMessage('BIOS Date: '+RegistryV.ReadString('SystemBiosDate'));
        sl := ReadMultirowKey(RegistryV,'SystemBiosVersion');
        ShowMessage('BIOS Version: '+sl.Text);
      except
      end;
      Registryv.Free;
      if Assigned(sl) then sl.Free;
    end;
     
    //следующий метод получает многострочные значения из реестра
    //и преобразует их в TStringlist

    function ReadMultirowKey(reg: TRegistry; Key: string): TStrings;
    const bufsize = 100;
    var
      i: integer;
      s1: string;
      sl: TStringList;
      bin: array[1..bufsize] of char;
    begin
      try
        result := nil;
        sl := nil;
        sl := TStringList.Create;
        if not Assigned(reg) then
          raise Exception.Create('TRegistry object not assigned.');
        FillChar(bin,bufsize,#0);
        reg.ReadBinaryData(Key,bin,bufsize);
        i := 1;
        s1 := '';
        while i < bufsize do
        begin
          if ord(bin[i]) >= 32 then
            s1 := s1 + bin[i]
          else
          begin
            if Length(s1) > 0 then
            begin
              sl.Add(s1);
              s1 := '';
            end;
          end;
          inc(i);
        end;
        result := sl;
      except
        sl.Free;
        raise;
      end;
    end;

нашел на
<https://www.sources.ru/delphi/system/get_bios_information_w9x.shtml>

и
<https://www.sources.ru/delphi/system/get_bios_information_nt_2000_xp.shtml>


------------------------------------------------------------------------

Вариант 2:

Source: Gua, fbsdd@ukr.net

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Получение серийного номера BIOS
     
    Зависимости:
    Автор:       Gua, fbsdd@ukr.net, ICQ:141585495, Simferopol
    Copyright:
    Дата:        03 мая 2002 г.
    ***************************************************** }
     
    function GetBiosNumber: string;
    begin
      result := string(pchar(ptr($FEC71)));
    end;
