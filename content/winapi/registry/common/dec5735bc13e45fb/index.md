---
Title: Дополненный TRegistry, умеет работать с значениями типа REG\_MULTI\_SZ
Author: Кондратюк Виталий
Date: 01.01.2007
---

Дополненный TRegistry, умеет работать с значениями типа REG\_MULTI\_SZ
======================================================================

::: {.date}
01.01.2007
:::

    unit Reg;
    {$R-,T-,H+,X+}
     
    interface
     
    uses Registry, Classes, Windows, Consts, SysUtils;
     
    type
     
      TReg = class(TRegistry)
      public
        procedure ReadStringList(const name: string; list: TStringList);
        procedure WriteStringList(const name: string; list: TStringList);
      end;
     
    implementation
     
    //*** TReg *********************************************************************
    //------------------------------------------------------------------------------
    // Запись TStringList ввиде значения типа REG_MULTI_SZ в реестр
    //------------------------------------------------------------------------------
     
    procedure TReg.WriteStringList(const name: string; list: TStringList);
    var
     
      Buffer: Pointer;
      BufSize: DWORD;
      i, j, k: Integer;
      s: string;
      p: PChar;
    begin
     
      {подготовим буфер к записи}
      BufSize := 0;
      for i := 0 to list.Count - 1 do
        inc(BufSize, Length(list[i]) + 1);
      inc(BufSize);
      GetMem(Buffer, BufSize);
      k := 0;
      p := Buffer;
      for i := 0 to list.Count - 1 do
      begin
        s := list[i];
        for j := 0 to Length(s) - 1 do
        begin
          p[k] := s[j + 1];
          inc(k);
        end;
        p[k] := chr(0);
        inc(k);
      end;
      p[k] := chr(0);
     
      {запись в реестр}
      if RegSetValueEx(CurrentKey, PChar(name), 0, REG_MULTI_SZ, Buffer,
        BufSize) <> ERROR_SUCCESS then
        raise ERegistryException.CreateResFmt(@SRegSetDataFailed, [name]);
    end;
    //------------------------------------------------------------------------------
    // Чтение TStringList ввиде значения типа REG_MULTI_SZ из реестра
    //------------------------------------------------------------------------------
     
    procedure TReg.ReadStringList(const name: string; list: TStringList);
    var
     
      BufSize,
        DataType: DWORD;
      Len, i: Integer;
      Buffer: PChar;
      s: string;
    begin
     
      if list = nil then
        Exit;
      {чтение из реестра}
      Len := GetDataSize(Name);
      if Len < 1 then
        Exit;
      Buffer := AllocMem(Len);
      if Buffer = nil then
        Exit;
      try
        DataType := REG_NONE;
        BufSize := Len;
        if RegQueryValueEx(CurrentKey, PChar(name), nil, @DataType, PByte(Buffer),
          @BufSize) <> ERROR_SUCCESS then
          raise ERegistryException.CreateResFmt(@SRegGetDataFailed, [name]);
        if DataType <> REG_MULTI_SZ then
          raise ERegistryException.CreateResFmt(@SInvalidRegType, [name]);
        {запись в TStringList}
        list.Clear;
        s := '';
        for i := 0 to BufSize - 2 do
        begin // BufSize-2 т.к. последние два нулевых символа
          if Buffer[i] = chr(0) then
          begin
            list.Add(s);
            s := '';
          end
          else
            s := s + Buffer[i];
        end;
      finally
        FreeMem(Buffer);
      end;
    end;
     
    end.
     

Автор: Кондратюк Виталий

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
