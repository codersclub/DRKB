---
Title: Получение параметра из строки по его индексу
Author: VID, ICQ:132234868
Date: 26.04.2004
---


Получение параметра из строки по его индексу
============================================

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Получение параметра из строки по его индексу, а также получение общего числа параметров в строке
     
    В юните представлены две функции, одна из которых, GetParamFromString, позволяет получить параметр из строки, по индексу этого параметра (индексация начинается с 1). Параметров в строке, я называю части строк, разделённые каким-нибудь оговорённым разделителем, например символом ";".
    К пример строка "fex;9x-1;code" имеет три параметра: 
    fex
    9x-1
    code.
     
    Описание аргументов функции GetParamFromString:
    SourceStr - строка, содержащая в себе параметры;
    Delimiter - разделитель параметров в строке;
    Ind - индекс запрашиваемого параметра.
     
    Функция GetParamsCount просто возвращает количество параметров в строке.
    Описание аргументов функции GetParamsCount:
    SourceStr - строка, содержащая в себе параметры;
    Delimiter - разделитель параметров в строке;
     
    Зависимости: Windows
    Автор:       VID, ICQ:132234868, Махачкала
    Copyright:   (c) не моё
    Дата:        26 апреля 2004 г.
    ********************************************** }
     
    unit getstrparam;
     
    interface
     
      uses Windows;
     
      function GetParamsCount (const SourceStr, Delimiter:String): integer;
      function GetParamFromString(const SourceStr,Delimiter:String; Ind:integer):string;
     
    implementation
     
    function GetDTextItem(DText,delimeter:pchar;var idx:integer):Pchar;
    var nextpos:Pchar;i,len, p:integer;
    begin
      result:=DText;
      len:=length(delimeter);
      if (len=0) or (DText='') then exit;
      i:=1;
      while TRUE do
      begin
        p:=pos(delimeter,result);
        if (p<>0) then
          nextpos:=pointer(integer(result)+p-1)
        else nextpos:=pointer(integer(result)+length(result));
        if (i=idx) or (p=0) then break;
        result:=pointer(integer(nextpos)+len);
        inc(i);
      end;
      if i=idx then byte(nextpos^):=0 else byte(result^):=0;
    end;
     
    function GetDTextCount(DText,delimeter:pchar):integer;
    var subpos:Pchar;i,len:integer;
    begin
      result:=0;
      len:=length(delimeter);
      if (len=0) or (DText='') then exit;
      subpos:=DText;
      i:=pos(delimeter,subpos);
      while i<>0 do
      begin
        inc(result);
        subpos:=pointer(integer(subpos)+i+len-1);
        i:=pos(delimeter,subpos);
      end;
      if (byte(subpos^))<>0 then inc(result);
    end;
     
    function GetParamsCount (const SourceStr, Delimiter:String): integer;
    begin
      Result:=GetDTextCount(PChar(SourceStr), PChar(Delimiter));
    end;
     
    function GetParamFromString(const SourceStr,Delimiter:String; Ind:integer):string;
    var TmpS, TmpRes:PChar;
        LRes:integer;
    begin
      GetMem (Tmps, Length(SourceStr)+1);
      try
        CopyMemory(Tmps, PChar(SourceStr), Length(SourceStr));
        Byte(Pointer(Integer(Tmps)+Length(SourceStr))^):=0;
        TmpRes:=GetDTextItem(TmpS, PChar(Delimiter), Ind);
        LRes:=Length(TmpRes);
        SetLength(Result,LRes);
        CopyMemory(@Result[1], TmpRes, LRes);
      finally
        FreeMem(TmpS);
      end;
    end;
     
    end. 

Пример использования:

    showmessage(GetParamFromString('1;2a;3;4', ';',2));
    showmessage(inttostr(GetParamsCount('1;2;3;4', ';'))); 
