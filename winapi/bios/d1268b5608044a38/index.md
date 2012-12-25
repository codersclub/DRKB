---
Title: Как получить дату BIOS?
Date: 01.01.2007
---


Как получить дату BIOS?
=======================

::: {.date}
01.01.2007
:::

    unit BiosDate; 
     
    interface 
     
    function GetBiosDate: String; 
     
    implementation 
     
    function SegOfsToLinear(Segment, Offset: Word): Integer; 
    begin 
      result := (Segment SHL 4) OR Offset; 
    end; 
     
    function GetBiosDate: String; 
    begin 
      result := String(PChar(Ptr(SegOfsToLinear($F000, $FFF5)))); 
    end; 
     
    end.

Взято из <https://forum.sources.ru>

------------------------------------------------------------------------

    var
      BiosDate: array[0..7] of char absolute
      $FFFF5;
      PCType: byte absolute $FFFFE;
     
    procedure TForm1.FormCreate(Sender: TObject);
    var
      S: string;
    begin
      case PCType of
        $FC: S := 'AT';
        $FD: S := 'PCjr';
        $FE: S := 'XT =8-O';
        $FF: S := 'PC';
      else
        S := 'Нестандартный';
      end;
      Caption := 'Дата BIOS: ' + BiosDate + '  Тип ПК: ' + S;
    end;

Взято с <https://delphiworld.narod.ru>

------------------------------------------------------------------------

    function GetBiosDate1: String;
     var
        Buffer : Array[0..8] Of Char;
        N : DWORD;
     begin
        ReadProcessMemory(GetCurrentProcess,
        Ptr($FFFF5),
        @Buffer,
        8,
        N);
        Buffer[8] := #0;
        result := StrPas(Buffer)
     end;
     
     function GetBiosDate2: String;
     begin
        result := string(pchar(ptr($FFFF5)));
     end;
     
     
     {Only for Win 95/98/ME) 

Взято с сайта: <https://www.swissdelphicenter.ch>

------------------------------------------------------------------------

    function GetBIOSDate: string;
    {получение даты BIOS в Win95}
    var
      s: array[0..7] of char;
      p: pchar;
    begin
      p := @s;
      asm
        push esi
        push edi
        push ecx
        mov esi,$0ffff5
        mov edi,p
        mov cx,8
        @@1:mov al,[esi]
        mov [edi],al
        inc edi
        inc esi
        loop @@1
        pop ecx
        pop edi
        pop esi
      end;
      setstring(result, s, 8);
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
