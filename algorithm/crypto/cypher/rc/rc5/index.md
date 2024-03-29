---
Title: RC5
Author: Igor Matveev, teap_leap@mail.ru
Date: 01.01.2004
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


RC5
===

Прежде всего немного о самом алгоритме: алгоритм был разработан
Рональдом Ривестом (Ronald L. Rivest) для компании RSA Data Security. На
основе RC5 в свое время был создан алгоритм шифрования RC6, который
участвовал в конкурсе на звание AES (Advanced Encryption Standard -
"Продвинутый" алгоритм шифрования). объявленном национальным
институтом стандартизации и технологий для замены уже устаревшего
алгоритма DES. Тогда RC6 не выиграл только из-за низкой
производительности аппаратных реализаций алгоритма. А программные
реализации RC5 и RC6 являются, пожалуй, самыми быстрыми среди всех
алгоритмов шифрования, обеспечивающих достаточную стойкость перед
атаками.

Например, по некоторым данным скорость грамотно построенной аппаратной
реализации алгоритма RC5 на компьютере с скоростью процессора 200 МГц
может достигать 10..11 Мбайт/сек, а алгоритма RC6 - 11..12 Мбайт/сек.
Для сравнения - скорость работы алгоритма Rijndael (победитель конкурса
на звание AES) при вышеозначенных характеристиках процессора может
достигать максимум 7 Мбайт/сек.

Если вам срочно нужно внедрить алгоритмы шифрования в свои коммерческие
проекты - на мой взгляд лучший выбор это RC5 или RC6. И не только
потому, что они значительно проще в реализации, чем, например, IDEA, но
и потому, что RC5 и RC6 (насколько я знаю - ручаться не могу) свободные
алгоритмы и вы не должны отчислять часть прибыли при коммерческом
использовании алгоритма.

Итак, RC5 работает с блоками по восемь байт - два 32 битных слова. В
отличии от IDEA и Rijndael в RC5 после развертывания ключа вычисляется
один подключ, который используется и при шифровании, и при дешифровании.
RC5, как и большинство алгоритмов - раундовый алгоритм, другими словами,
при шифрации блока над ним производятся одни и те же операции несколько
раз, в RC5 таких раундов 12.

Вот пожалуй и все, что вам нужно знать о теории алгоритма RC5, все
остальное видно из модуля. Модуль RC5 похож на модуль IDEA из моей
предыдущей статьи. Если вы уже используете модуль IDEA в своих
программах - для использования RC5 вам достаточно просто убрать из uses
модуль IDEA и включить туда модуль RC5 (все имена методов сохраняются).

    { *********************************************************************** }
    {                                                                         }
    { Delphi Еncryption Library                                               }
    { Еncryption / Decryption stream - RC5                                    }
    {                                                                         }
    { Copyright (c) 2004 by Matveev Igor Vladimirovich                        }
    { With offers and wishes write: teap_leap@mail.ru                         }
    {                                                                         }
    { *********************************************************************** }
     
    unit RC5;
     
    interface
     
    uses
      SysUtils, Classes;
     
    type
      TRC5Block = array[1..2] of LongWord;
     
    const
      Rounds     = 12;
      BlockSize  = 8;
      BufferSize = 2048;
      KeySize    = 64;
      KeyLength  = 2 * (Rounds + 1);
     
      P32 = $b7e15163;
      Q32 = $9e3779b9;
     
    var
      Key        : string;
      KeyPtr     : PChar;
     
      S : array[0..KeyLength-1] of LongWord;
     
    ////////////////////////////////////////////////////////////////////////////////
    // Дополнительные функции
     
    procedure Initialize(AKey: string);          // Инициализация
    procedure CalculateSubKeys;                  // Подготовка подключей
    function EncipherBlock(var Block): Boolean;  // Шифрация блока (8 байт)
    function DecipherBlock(var Block): Boolean;  // Дешифрация блока
     
     
    ////////////////////////////////////////////////////////////////////////////////
    // Главные функции
     
    function EncryptCopy(DestStream, SourseStream : TStream; Count: Int64;
      Key : string): Boolean;    // Зашифровать данные из одного потока в другой
     
    function DecryptCopy(DestStream, SourseStream : TStream; Count: Int64;
      Key : string): Boolean;    // Расшифровать данные из одного потока в другой
     
    function EncryptStream(DataStream: TStream; Count: Int64;
      Key: string): Boolean;     // Зашифровать содержимое потока
     
    function DecryptStream(DataStream: TStream; Count: Int64;
      Key: string): Boolean;     // Расшифровать содержимое потока
     
    implementation
     
    ////////////////////////////////////////////////////////////////////////////////
     
    function ROL(a, s: LongWord): LongWord;
    asm
      mov    ecx, s
      rol    eax, cl
    end;
     
    ////////////////////////////////////////////////////////////////////////////////
     
    function ROR(a, s: LongWord): LongWord;
    asm
      mov    ecx, s
      ror    eax, cl
    end;
     
    ////////////////////////////////////////////////////////////////////////////////
     
    procedure InvolveKey;
    var
      TempKey : string;
      i, j    : Integer;
      K1, K2  : LongWord;
    begin
     // Разворачивание ключа до длинны 64 символа
     TempKey := Key;
     i := 1;
     while ((Length(TempKey) mod KeySize) <> 0) do
       begin
         TempKey := TempKey + TempKey[i];
         Inc(i);
       end;
     
     // Now shorten the key down to one KeySize block by combining the bytes
     i := 1;
     j := 0;
     while (i < Length(TempKey)) do
       begin
         Move((KeyPtr+j)^, K1, 4);
         Move(TempKey[i], K2, 4);
         K1 := ROL(K1, K2) xor K2;
         Move(K1, (KeyPtr+j)^, 4);
         j := (j + 4) mod KeySize;
         Inc(i, 4);
       end;
    end;
     
    ////////////////////////////////////////////////////////////////////////////////
     
    procedure Initialize(AKey: string);
    begin
     Key := AKey;
     GetMem(KeyPtr, KeySize);
     FillChar(KeyPtr^, KeySize, #0);
     
     InvolveKey;
    end;
     
    ////////////////////////////////////////////////////////////////////////////////
     
    {$R-,Q-}
     
    procedure CalculateSubKeys;
    var
      i, j, k : Integer;
      L       : array[0..15] of LongWord;
      A, B    : LongWord;
    begin
     // Copy the key into L
     Move(KeyPtr^, L, KeySize);
     
     // Now initialize the S table
     S[0] := P32;
     for i := 1 to KeyLength-1 do
       S[i] := S[i-1] + Q32;
     
     // Now scramble the S table with the key
     i := 0;
     j := 0;
     A := 0;
     B := 0;
     for k := 1 to 3*KeyLength do
       begin
         A := ROL((S[i] + A + B), 3);
         S[i] := A;
         B := ROL((L[j] + A + B), (A + B));
         L[j] := B;
         i := (i + 1) mod KeyLength;
         j := (j + 1) mod 16;
       end;
    end;
     
    ////////////////////////////////////////////////////////////////////////////////
     
     
    function EncipherBlock(var Block): Boolean;
    var
      RC5Block : TRC5Block absolute Block;
      i        : Integer;
    begin
     Inc(RC5Block[1], S[0]);
     Inc(RC5Block[2], S[1]);
     
     for i := 1 to Rounds do
       begin
         RC5Block[1] := ROL((RC5Block[1] xor RC5Block[2]), RC5Block[2]) + S[2*i];
         RC5Block[2] := ROL((RC5Block[2] xor RC5Block[1]), RC5Block[1]) + S[2*i+1];
       end;
     
     Result := TRUE;
    end;
     
    ////////////////////////////////////////////////////////////////////////////////
     
    function DecipherBlock(var Block): Boolean;
    var
      RC5Block : TRC5Block absolute Block;
      i        : Integer;
    begin
     for i := Rounds downto 1 do
       begin
         RC5Block[2] := ROR((RC5Block[2]-S[2*i+1]), RC5Block[1]) xor RC5Block[1];
         RC5Block[1] := ROR((RC5Block[1]-S[2*i]),   RC5Block[2]) xor RC5Block[2];
       end;
     
     Dec(RC5Block[2], S[1]);
     Dec(RC5Block[1], S[0]);
     
     Result := TRUE;
    end;
     
    ////////////////////////////////////////////////////////////////////////////////
    // Реализация главных функций
     
    function EncryptCopy(DestStream, SourseStream : TStream; Count: Int64;
      Key : string): Boolean;
    var
      Buffer   : TRC5Block;
      PrCount  : Int64;
      AddCount : Byte;
    begin
     Result := True;
     try
       if Key = '' then
         begin
           DestStream.CopyFrom(SourseStream, Count);
           Exit;
         end;
       Initialize(Key);
       CalculateSubKeys;
       PrCount := 0;
       while Count - PrCount >= 8 do
         begin
           SourseStream.Read(Buffer, BlockSize);
           EncipherBlock(Buffer);
           DestStream.Write(Buffer, BlockSize);
           Inc(PrCount, 8);
         end;
     
       AddCount := Count - PrCount;
       if Count - PrCount <> 0 then
         begin
           SourseStream.Read(Buffer, AddCount);
           DestStream.Write(Buffer, AddCount);
         end;
     except
       Result := False;
     end;
    end;
     
    ////////////////////////////////////////////////////////////////////////////////
     
    function DecryptCopy(DestStream, SourseStream : TStream; Count: Int64;
      Key : string): Boolean;
    var
      Buffer   : TRC5Block;
      PrCount  : Int64;
      AddCount : Byte;
    begin
     Result := True;
     try
       if Key = '' then
         begin
           DestStream.CopyFrom(SourseStream, Count);
           Exit;
         end;
       Initialize(Key);
       CalculateSubKeys;
       PrCount := 0;
       while Count - PrCount >= 8 do
         begin
           SourseStream.Read(Buffer, BlockSize);
           DecipherBlock(Buffer);
           DestStream.Write(Buffer, BlockSize);
           Inc(PrCount, 8);
         end;
     
       AddCount := Count - PrCount;
       if Count - PrCount <> 0 then
         begin
           SourseStream.Read(Buffer, AddCount);
           DestStream.Write(Buffer, AddCount);
         end;
     except
       Result := False;
     end;
    end;
     
    ////////////////////////////////////////////////////////////////////////////////
     
    function EncryptStream(DataStream: TStream; Count: Int64; Key: string): Boolean;
    var
      Buffer   : TRC5Block;
      PrCount  : Int64;
    begin
     Result := True;
     try
       if Key = '' then
         begin
           DataStream.Seek(Count, soFromCurrent);
           Exit;
         end;
       Initialize(Key);
       CalculateSubKeys;
       PrCount := 0;
       while Count - PrCount >= 8 do
         begin
           DataStream.Read(Buffer, BlockSize);
           EncipherBlock(Buffer);
           DataStream.Seek(-BlockSize, soFromCurrent);
           DataStream.Write(Buffer, BlockSize);
           Inc(PrCount, 8);
         end;
     except
       Result := False;
     end;
    end;
     
    ////////////////////////////////////////////////////////////////////////////////
     
    function DecryptStream(DataStream: TStream; Count: Int64; Key: string): Boolean;
    var
      Buffer   : TRC5Block;
      PrCount  : Int64;
    begin
     Result := True;
     try
       if Key = '' then
         begin
           DataStream.Seek(Count, soFromCurrent);
           Exit;
         end;
       Initialize(Key);
       CalculateSubKeys;
       PrCount := 0;
       while Count - PrCount >= 8 do
         begin
           DataStream.Read(Buffer, BlockSize);
           DecipherBlock(Buffer);
           DataStream.Seek(-BlockSize, soFromCurrent);
           DataStream.Write(Buffer, BlockSize);
           Inc(PrCount, 8);
         end;
     except
       Result := False;
     end;
    end;
     
    // Завершение главных функций ...
    ////////////////////////////////////////////////////////////////////////////////
     
    {$R+,Q+} 
     
    end.

Вот и все что касается RC5 шифрования, в следующей статье мы рассмотрим
алгоритм RC6 - заранее могу сказать, что он очень похож на RC5.

Перепечатка данной статьи разрешается автором только без изменения,
модуль, представленный в данной статье абсолютно свободен для
использования - пользуйтесь!

Матвеев Игорь Владимирович


