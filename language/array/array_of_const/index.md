---
Title: Пример массива констант (Array of Const)
Author: Peter Below
Date: 01.01.2007
---


Пример массива констант (Array of Const)
========================================

Вариант 1:

Source: <https://delphiworld.narod.ru>

"Array of const" это массив переменных, декларированных как константы.
Непосредственно они представлены структурой TVarRec. Скобки просто
ограничивают массив. Массив констант дает вам возможность передавать
процедуре переменное количество параметров type-safe (безопасным)
способом. Вот пример:

    type
      TVarRec = record
        Data: record case Integer of
            0: (L: LongInt);
            1: (B: Boolean);
            2: (C: Char);
            3: (E: ^Extended);
            4: (S: ^string);
            5: (P: Pointer);
            6: (X: PChar);
            7: (O: TObject);
        end;
        Tag: Byte;
        Stuff: array[0..2] of Byte;
      end;
     
    function PtrToStr(P: Pointer): string;
    const
      HexChar: array[0..15] of Char = '0123456789ABCDEF';
     
      function HexByte(B: Byte): string;
      begin
        Result := HexChar[B shr 4] + HexChar[B and 15];
      end;
     
      function HexWord(W: Word): string;
      begin
        Result := HexByte(Hi(W)) + HexByte(Lo(W));
      end;
     
    begin
      Result := HexWord(HiWord(LongInt(P))) + ':' + HexWord(LoWord(LongInt(P)));
    end;
     
    procedure Display(X: array of const);
    var
      I: Integer;
    begin
      for I := 0 to High(X) do
        with TVarRec(X[I]), Data do
        begin
          case Tag of
            0: ShowMessage('Integer: ' + IntToStr(L));
            1: if B then
                ShowMessage('Boolean: True')
              else
                ShowMessage('Boolean: False');
            2: ShowMessage('Char: ' + C);
            3: ShowMessage('Float: ' + FloatToStr(E^));
            4: ShowMessage('String: ' + S^);
            5: ShowMessage('Pointer: ' + PtrToStr(P));
            6: ShowMessage('PChar: ' + StrPas(X));
            7: ShowMessage('Object: ' + O.ClassName);
          end;
        end;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      P: array[0..5] of Char;
     
    begin
      P := 'Привет'#0;
      Display([-12345678, True, 'A', 1.2345, 'ABC', Ptr($1234, $5678), P,
        Form1]);
    end;


------------------------------------------------------------------------

Вариант 2:

Source: Советы по Delphi от [Валентина Озерова](mailto:webmaster@webinspector.com), Сборник Kuliba

Массив констант (array of const) фактически является открытым массивом
TVarRec (описание предекларированных типов Delphi вы можете найти в
электронной справке). Приведенный ниже "псевдокод" на языке Object
Pascal может послужить скелетом для дальнейшего развития:

    procedure AddStuff(const A: array of const);
    var i: Integer;
    begin
      for i := Low(A) to High(A) do
        with A[i] do
          case VType of
            vtExtended:
              begin
                { добавляем натуральное число, все real-форматы
                  автоматически приводятся к extended }
              end;
            vtInteger:
              begin
                { добавляем целое число, все integer-форматы
                  автоматически приводятся к LongInt }
              end;
            vtObject:
              begin
                if VObject is DArray then
                  with DArray(VObject) do
                    begin
                      { добавляем массив double-типа }
                    end
                else if VObject is IArray then
                  with IArray(VObject) do
                    begin
                      { добавляем массив integer-типа }
                    end;
              end;
          end; { Case }
    end; { AddStuff }

Для получения дополнительной информации загляните в главу "open
arrays" электронной справки.


------------------------------------------------------------------------

Вариант 3:

Author: Peter Below

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Массив констант во время выполнения приложения

...хорошо, непосредственно это синтаксис не поддерживает, поскольку
массив констант Array of Const подобен открытым массивам, главным
образом в части характеристик времени компиляции. Но вы можете обойти
этот неприятный момент, обладая хотя бы начальными знаниями того, как
реализован открытый массив. Что нам для этого необходимо: динамически
размещенный массив array of TVarRec, который "принимает" ваши
параметры, и "псевдоним" (alias) функции Format, позволяющий работать
с таким массивом без "ругани" со стороны компилятора.

    type
      { объявляем тип для динамического массива array of TVarRecs }
      TVarArray = array[0..High(Word) div Sizeof(TVarRec) - 1] of TVarRec;
      PVarArray = ^TVarArray;
     
      { Объявляем alias-тип для функции Format. Передаваемые параметры будут иметь
      в стеке тот же самый порядок вызова, что и при нормальном вызове Format }
      FormatProxy = function(const aFormatStr: string; var aVarRec: TVarRec;
        highIndex: Integer): string;
     
      { AddVarRecs копирует параметры, передаваемые в массиве A в pRecs^, начиная
      с pRecs^[atIndex]. highIndex - самый большой доступный индекс pRecs, число
      распределенных элементов - 1. }
     
    procedure AddVarRecs(pRecs: PVarArray; atIndex, highIndex: Integer; const A:
      array of const);
    var
      i: Integer;
    begin
      if pRecs <> nil then
        for i := 0 to High(A) do
        begin
          if atIndex <= highIndex then
          begin
            pRecs^[atIndex] := A[i];
            Inc(atIndex);
          end { If }
          else
            Break;
        end; { For }
    end; { AddVarRecs }
     
    procedure TScratchMain.SpeedButton2Click(Sender: TObject);
    var
      p: PVarArray;
      S: string;
      Proxy: FormatProxy;
    begin
      { распределяем массив для четырех параметров, индексы - 0..3 }
      GetMem(p, 4 * Sizeof(TVarRec));
      try
        { добавляем параметры последующими вызовами AddVarRecs }
        AddVarRecs(p, 0, 3, [12, 0.5, 'Шаблон']);
        AddVarRecs(p, 3, 3, ['Тест']);
     
        { получаем полномочия Format }
        @Proxy := @SysUtils.Format;
     
        { Вызов с динамически сгенерированным массивом параметров.
        Естественно, строка формата может также быть сформирована
        и во время выполнения программы. }
        S := Proxy('Целое: %d, Реальное: %4.2f, Строки: %s, %s', p^[0], 3);
     
        { выводим результат }
        ShowMessage(S);
      finally
        FreeMem(p, 4 * Sizeof(TVarRec));
      end;
    end;

Я надеюсь вы поняли принцип. Естественно, имеются ограничения. Вы можете
передавать в AddVarRecs числовые величины, строковые переменные и
литералы, но не в коем случае не строковые выражения! В этом случае
компилятор должен для хранения результата сформировать в стеке временную
строку, передать ее в AddVarRecs (или лучше по адресу в TVarRec), и она
может прекратить свое существование или может быть перезаписана в стеке
другими данными, если в конечном счете вы передадите в Proxy целый
массив!

Тестировалось только в Delphi 1.0!


------------------------------------------------------------------------

Вариант 4:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Массив TPOINT:

    Const ptarr : Array[0..4] Of TPoint = (
      (x:0; y:4),
      ...
      ...
      (x:4; y:4)
    );



