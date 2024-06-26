---
Title: Справочник по функциям работы с PChar
Date: 01.01.2007
---


Справочник по функциям работы с PChar
=====================================

function StrLIComp(Str1, Str2: PChar; MaxLen: Cardinal) : Integer;
: Работает как StrLComp, но без учета регистра символов.

function StrScantStr: PChar; Chr: Char) : PChar;
: Отыскивает первое вхождение символа Chr в строку Str и возвращает указатель на него или
nil в случае отстутствия.

function StrRScanfStr: PChar; Chr: Char) : PChar;
:  Работает как StrScan, но отыскивается последнее вхождение Chr.

function StrPos(Str1, Str2: PChar) : PChar;
:  Отыскивает первое вхождение строки Str2 в строку Str1 и возвращает указатель на нее или
nil в случае отстутствия.

function StrUpperfStr: PChar) : PChar;
:  Преобразует строку к верхнему регистру.

function StrLower(Str: PChar): PChar;
:  Преобразует строку к нижнему регистру.

function StrPaslStr: PChar): String;
:  Преобразует строку Str в строку типа string.

function StrAlloc(Size: Cardinal): PChar;
:  Размещает в куче памяти новую строку размером Size и возвращает указатель на нее.

function StrBufSize(Str: PChar): Cardinal;
:  Возвращает размер блока памяти, выделенного для строки при помощи функции StrAlloc.

function StrNewfStr: PChar): PChar ;
:  Размещает в куче памяти копию строки Str и возвращает указатель на нее.

procedure StrDispose(Str: PChar);
:  Уничтожает строку, размещенную при помощи StrAlloc или StrNew.

function StrLenfStr: PChar):
:  Возвращает число символов в строке Str (без учета завершающего нулевого).

function StrEndfStr: PChar): PChar;
:  Возвращает указатель на завершающий нулевой символ строки Str.

function StrMove(Dest, Source: PChar; Count: Cardinal): PChar;
: Копирует из строки Source в строку Dest ровно Count символов, причем
строки могут перекрываться.

function StrCopy(Dest, Source: PChar): PChar;
:  Копирует Source в Dest и возвращает указатель на Dest.

function StrECopy(Dest, Source: PChar): PChar;
:  Копирует Source в Dest и возвращает указатель на завершающий символ Dest.

function StrLCopy(Dest, Source: PChar; MaxLen: Cardinal): PChar;
: Работает как StrCopy, но копирует не более MaxLen символов.

function StrPCopy(Dest: PChar; const Source: String): PChar;
: Копирует строку Source (типа string) в Dest и возвращает указатель на Dest.

function StrPLCopy(Dest: PChar; const Source: string; MaxLen: Cardinal): PChar;
:  Работает как StrPCopy, но копирует не более MaxLen символов.

function StrCat(Dest, Source: PChar): PChar;
:  Дописывает Source к концу Dest и возвращает указатель на Dest.

function StrLCatfDest, Source: PChar; MaxLen: Cardinal) : PChar;
: Работает как StrCat, но копирует не более MaxLen-StrLen(Dest) символов.

function StrCoirip(Str1, Str2: PChar): Integer;
:  Сравнивает две строки (посимвольно). Возвращает значение:  
   `<0` - при Str1 < Str2;<br>
   &nbsp;` 0` - при Str1 = Str2,  
   `>0` - при Str1 \> Str2.

function StrIComp(Str1, Str2: PChar): Integer;
:  Работает как StrComp, но без учета регистра символов.

function StrLComp(Str1, Str2: PChar; MaxLen: Cardinal): Integer;
: Работает как StrComp, но сравнение происходит на протяжении не более чем
MaxLen символов.
