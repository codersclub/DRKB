<h1>Как получить дату BIOS?</h1>
<div class="date">01.01.2007</div>


<pre>
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
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

<hr />
<pre>
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
</pre>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

<hr />
<pre>
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
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>

<hr />
<pre>
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
</pre>
<a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>


