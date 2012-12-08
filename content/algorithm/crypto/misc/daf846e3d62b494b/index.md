---
Title: Проверка ISBN
Date: 01.01.2007
---


Проверка ISBN
=============

::: {.date}
01.01.2007
:::

ISBN (или International Standard Book Numbers, международные стандартные
номера книг) - мистические кодовые числа, однозначно идентифицирующие
книги. Цель этой статьи заключается в том, чтобы убрать покров
таинственности, окружающий структуру ISBN, и в качестве примера
разработать приложение, проверяющее правильность создания кода-кандидата
на ISBN.

ISBN имеет длину тринадцать символов, которые ограничиваются в
использовании символами-цифрами от \"0\" до \"9\", дефисом, и буквой
\"X\". Этот тринадцатисимвольный код состоит из четырех частей (между
которыми располагается дефис): идентификатор группы, идентификатор
издателя, идентификатор книги для издателя, и контрольная цифра. Первая
часть (идентификатор группы) используется для обозначения страны,
географического региона, языка и пр.. Вторая часть (идентификатор
издателя) однозначно идентифицирует издателя. Третья часть
(идентификатор книги) однозначно идентифицирует данную книгу среди
коллекции книг, выпущенных данным издателем. Четвертая, заключительная
часть (контрольная цифра), используется в коде алгоритме другими цифрами
для получения поддающегося проверке ISBN. Количество цифр, содержащееся
в первых трех частях, может быть различным, но контрольная цифра всегда
содержит один символ (расположенный между \"0\" и \"9\" включительно,
или \"X\" для величины 10), а само ISBN в целом имеет длину тринадцать
символов (десять чисел плюс три дефиса, разделяющих три части ISBN).

ISBN 3-88053-002-5 можно так разложить на части:

Группа:            3

Издатель:          88053

Книга:             002

Контрольная цифра: 5

ISBN можно проверить на правильность кода, используя простой
математический алгоритм. Суть его в следующем: нужно взять каждую из
девяти цифр первых трех частей ISBN (пропуская нечисловые дефисы),
умножить каждую отдельную цифру на число цифр, стоящих слева от позиции
числа ISBN (оно всегда будет меньше одинадцати), сложить все результаты
умножения, прибавить контрольную цифру, после чего разделить
получившееся число на одиннадцать. Если после деления на одинадцать
никакого остатка не образуется (т.е., число по модулю 11 делится без
остатка), кандидат на ISBN является верным числом ISBN. К примеру,
используем предыдущий образец ISBN 3-88053-002-5:

ISBN:              3  8  8  0  5  3  0  0  2  5

Множитель:        10  9  8  7  6  5  4  3  2  1

Продукт:          30+72+64+00+30+15+00+00+04+05 = 220

Поскольку 220 на одинадцать делится без остатка, расмотренный нами
кандидат на IDBN является верным кодом ISBN.

Данный алгоритм проверки легко портируется в код Pascal/Delphi. Для
извлечения контрольной цифры и кода из ISBN номера используются
строковые функции и процедуры, после чего они передаются в функцию
проверки. Контрольная цифра преобразуется в тип целого, на основе ее
формируется стартовое значение составной переменной, состоящей из
добавляемых цифр, умноженных на их позицию в коде ISBN (отдельные цифры,
составляющие первые три части ISBN). Для последовательной обработки
каждой цифры используется цикл For, в котором мы игнорируем дефисы и
умножаем текущую цифру на ее позицию в коде ISBN. В заключение, значение
этой составной переменной проверяется на делимость без остатка на
одиннадцать. Если остатка после деления нет, код ISBN верен, если же
остаток существует, то код кандидат на ISBN имеет неправильный код.

Вот пример этой методики, изложенной на языке функций Delphi:

    function IsISBN(ISBN: string): Boolean;
    var
      Number, CheckDigit: string;
      CheckValue, CheckSum, Err: Integer;
      i, Cnt: Word;
    begin
      {Получаем контрольную цифру}
      CheckDigit := Copy(ISBN, Length(ISBN), 1);
      {Получаем остальную часть, ISBN минус контрольная цифра и дефис}
      Number := Copy(ISBN, 1, Length(ISBN) - 2);
      {Длина разницы ISBN должны быть 11 и контрольная цифра между 0 и 9, или X}
      if (Length(Number) = 11) and (Pos(CheckDigit, '0123456789X') > 0) then
      begin
        {Получаем числовое значение контрольной цифры}
        if (CheckDigit = 'X') then
          CheckSum := 10
        else
          Val(CheckDigit, CheckSum, Err);
        {Извлекаем в цикле все цифры из кода ISBN, применяя алгоритм декодирования}
        Cnt := 1;
        for i := 1 to 12 do
        begin
          {Действуем, если только текущий символ находится между "0" и "9", исключая дефисы}
          if (Pos(Number[i], '0123456789') > 0) then
          begin
            Val(Number[i], CheckValue, Err);
            {Алгоритм для каждого символа кода ISBN, Cnt - n-й обрабатываемый символ}
            CheckSum := CheckSum + CheckValue * (11 - Cnt);
            Inc(Cnt);
          end;
        end;
        {Проверяем делимость без остатка полученного значения на 11}
        if (CheckSum mod 11 = 0) then
          IsISBN := True
        else
          IsISBN := False;
      end
      else
        IsISBN := False;
    end;

Это примитивный пример, сильно упрощенный для лучшего понимания
алгоритма декодирования кода ISBN. В реальной жизни (приложении) имеется
немало мелочей, которые необходимо учесть для нормальной работы. Для
примера, описанная выше функция требует от кандидата ISBN строку
паскалевского типа с дефисами, разделяющими четыре части кода. В
качестве дополнительной функциональности можно проверять кандидата ISBNs
на наличие дефисов. Другой полезной вещью могла бы быть проверка на
наличие трех дефисов на нужных позициях, а не простая проверка на
наличие необходимых одиннадцати символов-цифр.

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

------------------------------------------------------------------------

    function ValidateISBN(const ISBN: string): Boolean;
     // 
    // References: 
    // =========== 
    // [1] http://isbn-international.org/userman/chapter4.html 
    // 
    type
       TISBNPart = (ipGroupID, ipPublisherID, ipTitleID, ipCheckDigit);
       TISBNPartSizes = array [TISBNPart] of Integer;
     const
       ISBNSize = 13;
       ISBNDigits = ['0'..'9'];
       ISBNSpecialDigits = ['x', 'X'];
       ISBNSeparators = [' ', '-'];
       ISBNCharacters = ISBNDigits + ISBNSpecialDigits + ISBNSeparators;
     var
       CurPtr, EndPtr: PAnsiChar;
       Accumulator, Counter: Integer;
       Part: TISBNPart;
       PartSizes: TISBNPartSizes;
     
       // begin local function 
     
      function IsPartSizeValid(APart: TISBNPart): Boolean;
       const
         MaxPartSizes: TISBNPartSizes = (5, 7, 6, 1);
       begin
         Result := PartSizes[APart] <= MaxPartSizes[APart];
       end;
     
       // end local function 
     
    begin
       Result := False;
       // At first, check the overall string length. 
      if Length(ISBN) <> ISBNSize then
         Exit;
     
       CurPtr := @ISBN[1];
       EndPtr := CurPtr + Pred(ISBNSize);
       Accumulator := 0;
       Counter := 10;
       Part := ipGroupID;
       ZeroMemory(@PartSizes[Low(PartSizes)], SizeOf(PartSizes));
     
       while Cardinal(CurPtr) <= Cardinal(EndPtr) do
       begin
         if CurPtr^ in ISBNCharacters then
         begin
           if CurPtr^ in ISBNSeparators then
           begin
             // Switch to the next ISBN part, but take care of two conditions: 
            // 1. Do not let Part go beyond its upper bound (ipCheckDigit). 
            // 2. Verify if the current ISBN part does not exceed its size limit. 
            if (Part < High(Part)) and IsPartSizeValid(Part) then
               Inc(Part)
             else
               Exit;
           end
           else // CurPtr^ in [ISBNDigits, ISBNSpecialDigits] 
          begin
             // Is it the last character of the string? 
            if (CurPtr = EndPtr) then
             begin
               // Check the following conditions: 
              // 1. Make sure current ISBN Part equals to ipCheckDigit. 
              // 2. Verify if the check digit does not exceed its size limit. 
              if (Part <> High(Part)) and not IsPartSizeValid(Part) then
                 Exit;
             end
             else
               // Special check digit is allowed to occur only at the end of ISBN. 
              if CurPtr^ in ISBNSpecialDigits then
                 Exit;
     
             // Increment the size of the current ISBN part. 
            Inc(PartSizes[Part]);
     
             // Increment the accumulator by current ISBN digit multiplied by a weight. 
            // To get more detailed information, please refer to the web site [1]. 
            if (CurPtr = EndPtr) and (CurPtr^ in ISBNSpecialDigits) then
               Inc(Accumulator, 10 * Counter)
             else
               Inc(Accumulator, (Ord(CurPtr^) - Ord('0')) * Counter);
             Dec(Counter);
           end;
           Inc(CurPtr);
         end
         else
           Exit;
       end;
       // Accumulator content must be divisible by 11 without a remainder. 
      Result := (Accumulator mod 11) = 0;
     end;
     

Взято с сайта: <https://www.swissdelphicenter.ch>
