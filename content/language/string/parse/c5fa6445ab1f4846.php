<h1>Как найти строку в строке, начиная с определенной позиции?</h1>
<div class="date">01.01.2007</div>


<pre>
//-----------------------------------------------------------------------------
// Name: cnsSmartPos
// Author: Com-N-Sense
// Date:
// Purpose: Find a substring in a string starting from any position in the string.
// Params: SubStr - a substring for search.
//         S - the source string to search within
//         StartPos - the index position to start the search.
// Result: Integer - the position of the substring,
//                   zero - if the substring was not found
// Remarks: This is the original Delphi "Pos" function modified to support
//          the start pos parameter.
//-----------------------------------------------------------------------------
function SmartPosAsm(const substr : AnsiString; const s : AnsiString; StartPos : Cardinal) : Integer;
type
  StrRec = packed record
    allocSiz: Longint;
    refCnt: Longint;
    length: Longint;
  end;
const
  skew = sizeof(StrRec);
asm
{     -&gt;EAX     Pointer to substr               }
{       EDX     Pointer to string               }
{     &lt;-EAX     Position of substr in s or 0    }
        TEST    EAX,EAX
        JE      @@noWork
 
        TEST    EDX,EDX
        JE      @@stringEmpty
 
        PUSH    EBX
        PUSH    ESI
        PUSH    EDI
 
        MOV     ESI,EAX         { Point ESI to substr           }
        MOV     EDI,EDX         { Point EDI to s                }
 
        MOV     EAX,ECX
        MOV     ECX,[EDI-skew].StrRec.length  { ECX = Length(s) }
        ADD     EDI,EAX
        SUB     ECX,EAX
 
        PUSH    EDI  { remember s position to calculate index        }
 
        MOV     EDX,[ESI-skew].StrRec.length    { EDX = Length(substr)        
        DEC     EDX                             { EDX = Length(substr) - 1              }
        JS      @@fail                          { &lt; 0 ? return 0                        }
        MOV     AL,[ESI]                        { AL = first char of substr             }
        INC     ESI                             { Point ESI to 2'nd char of substr      }
 
        SUB     ECX,EDX                         { #positions in s to look at    }
                                                { = Length(s) - Length(substr) + 1      }
        JLE     @@fail
@@loop:
        REPNE   SCASB
        JNE     @@fail
        MOV     EBX,ECX                         { save outer loop counter               }
        PUSH    ESI                             { save outer loop substr pointer        }
        PUSH    EDI                             { save outer loop s pointer             }
 
        MOV     ECX,EDX
        REPE    CMPSB
        POP     EDI                             { restore outer loop s pointer  }
        POP     ESI                             { restore outer loop substr pointer     }
        JE      @@found
        MOV     ECX,EBX                         { restore outer loop counter    }
        JMP     @@loop
 
@@fail:
        POP     EDX                             { get rid of saved s pointer    }
        XOR     EAX,EAX
        JMP     @@exit
 
@@stringEmpty:
        XOR     EAX,EAX
        JMP     @@noWork
 
@@found:
        POP     EDX                             { restore pointer to first char of s    }
        MOV     EAX,EDI                         { EDI points of char after match        }
        SUB     EAX,EDX                         { the difference is the correct index   }
@@exit:
        POP     EDI
        POP     ESI
        POP     EBX
@@noWork:
end; //SmartPosAsm
 
function cnsSmartPos(const substr : AnsiString; const s : AnsiString; StartPos : Cardinal) : Integer;
begin
  dec(StartPos);
  Result := SmartPosAsm(SubStr,S,StartPos);
  if Result &gt; 0 then Result := Result + StartPos;
end; //cnsSmartPos
</pre>

<hr />
<p>Круто конечно, но есть стандартная функция: </p>

<p>function PosEx(const SubStr, S: string; Offset: Cardinal = 1): Integer;</p>

<p class="author">Автор: Vit</p>



<pre>
{ **** UBPFD *********** by delphibase.endimus.com ****
&gt;&gt; Поиск подстроки в строке с заданной позиции
 
S - строка, в которой искать
SubStr - образец
fromPos - с какой позиции
Все на асемблере, принцип простой - ищется первый символ, затем часть строки
сравнивается с образцом начиная с этого символа
Если образец не найден, возвращает 0
Если найден - номер первого символа вхождения
 
Зависимости: Нету их!
Автор:       Romkin, romkin@pochtamt.ru, Москва
Copyright:   Модернизированная функция из SysUtils
Дата:        18 июля 2002 г.
***************************************************** }
 
function TailPos(const S, SubStr: AnsiString; fromPos: integer): integer;
asm
        PUSH EDI
        PUSH ESI
        PUSH EBX
        PUSH EAX
        OR EAX,EAX
        JE @@2
        OR EDX,EDX
        JE @@2
        DEC ECX
        JS @@2
 
        MOV EBX,[EAX-4]
        SUB EBX,ECX
        JLE @@2
        SUB EBX,[EDX-4]
        JL @@2
        INC EBX
 
        ADD EAX,ECX
        MOV ECX,EBX
        MOV EBX,[EDX-4]
        DEC EBX
        MOV EDI,EAX
@@1: MOV ESI,EDX
        LODSB
        REPNE SCASB
        JNE @@2
        MOV EAX,ECX
        PUSH EDI
        MOV ECX,EBX
        REPE CMPSB
        POP EDI
        MOV ECX,EAX
        JNE @@1
        LEA EAX,[EDI-1]
        POP EDX
        SUB EAX,EDX
        INC EAX
        JMP @@3
@@2: POP EAX
        XOR EAX,EAX
@@3: POP EBX
        POP ESI
        POP EDI
end;
</pre>

<hr />
<pre>
{ **** UBPFD *********** by delphibase.endimus.com ****
&gt;&gt; Поиск подстроки в строке с заданной позиции (стандартный вариант)
 
Вроде работает
Substr - подстрока, S - строка, fromPos - с какой позиции искать
Если вхождение не найдено, возвращает 0
Ограничения - как для ansiStrPos
 
Зависимости: SysUtils
Автор:       Romkin, romkin@pochtamt.ru, Москва
Copyright:   Romkin
Дата:        18 июля 2002 г.
***************************************************** }
 
function fAnsiPos(const Substr, S: string; FromPos: integer): Integer;
var
  P: PChar;
begin
  Result := 0;
  P := AnsiStrPos(PChar(S) + fromPos - 1, PChar(SubStr));
  if P &lt;&gt; nil then
    Result := Integer(P) - Integer(PChar(S)) + 1;
end;
 
</pre>

