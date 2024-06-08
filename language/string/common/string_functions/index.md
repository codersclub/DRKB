---
Title: Справочник по функциям работы со строками
Date: 01.01.2007
---


Справочник по функциям работы со строками
=========================================

function NewStrtconst(S: String): PString;
: Создает копию строки S и возвращает указатель на нее.

procedure DisposeStr(P: PString) ;
: Уничтожает строку, на которую указывает Р.

procedure AssignStr(var P: PString; const S: strings)
: Уничтожает строку, на которую указывает Р и затем присваивает ему
адрес созданной копии строки S.

procedure AppendStrfvar Dest: string; const S: string);
: Добавляет строку S в конец строки Dest.

function Uppercase(const S: string): string;
: Преобразует символы \'a\'..\'z\' в строке S к верхнему регистру.

function LowerCase(const S: string): string;
: Преобразует символы \'A\'..\'Z\' в строке S к нижнему регистру.

function CompareStr(const S1, S2: string): Integer;
: Сравнивает две строки S1 и S2 с учетом регистра символов.
Возвращаемое значение равно 0 в случае равенства строк
или разности кодов пары первых несовпадающих символов.

function CompareText(const S1, S2: string): Integer;
: Сравнивает две строки без учета регистра символов.

function AnsiUpperCase(const S: string): string;
: Преобразует символы в строке к верхнему регистру с учетом языкового драйвера.

function AnsiLowerCase(const S: string) : string;
: Преобразует символы в строке к нижнему регистру с учетом языкового драйвера.

function AnsiCompareStr(const S1, S2: string): Integer;
: Сравнивает две строки с использованием языкового драйвера
 и с учетом регистра символов.

function AnsiCompareText(const S1, S2 : string) : Integer;
: Сравнивает две строки с использованием языкового драйвера
 и без учета регистра символов.

function IsValidldent(const Ident: string): Boolean;
: Возвращает True, если строка Ident может служить идентификатором
 в программе на Object Pascal
 (т. е. содержит только буквы и цифры,
  причем первый символ - буква).

function IntToStr(Value: Longint): string;
: Преобразует целое число в строку.

function IntToHex(Value: Longint; Digits: Integer): string;
: Преобразует целое число в строку с его шестнадцатиричным представлением.

function StrToInt(const S: string): Longint;
: Преобразует строку в целое число.
  При ошибке возникает исключительная ситуация EConvertError.

function StrToIntDef(const S: string; Default; Longint): Longint;
: Работает как StrToInt, но при ошибке возвращает значение Default.

function LoadStr(Ident: Word): string;
: Загружает строку с индексом Ident из ресурсов приложения.

function FmtLoadStr(Ident: Word; const Args: array of const): string;
: Загружает строку с индексом Ident из ресурсов приложения с
форматированием (см. описание функции Format).
