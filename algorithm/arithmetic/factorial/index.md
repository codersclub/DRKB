---
Title: Как посчитать факториал?
Date: 01.01.2007
---


Как посчитать факториал?
========================

Вариант 1:

    { 
      The factorial of a positive integer is defined as: 
     
      n! = n*(n-1)*(n-2)*(n-3)*...*2*1 
      1! = 1 
      0! = 1 
     
      Example: 5! = 5*4*3*2*1 
    } 
     
    // Iterative Solution: 
     
    function FacIterative(n: Word): Longint; 
    var 
      f: LongInt; 
      i: Integer; 
    begin 
      f := 1; 
      for i := 2 to n do f := f * i; 
      Result := f; 
    end; 
     
     
    // Recursive Solution: 
     
    function FacRecursive(n: Word): LongInt; 
    begin 
      if n > 1 then 
        Result := n * FacRecursive(n-1) 
      else 
        Result := 1; 
    end; 

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>

------------------------------------------------------------------------

Вариант 2:

Процедура для нахождения точного значения факториала числа.

Вы когда-нибудь находили факториал 10? - это легко, а 20?,а 100? Даже с
помощью самого продвинутого калькулятора это не получится, (имею в виду
точное значение, например в 100!-158 цифр, какой должен быть дисплей
калькулятора, чтобы показать такое значение??!)C помощью программы
содержащей алгоритм похожий на описанный, это можно сделать. Для такой
программы нужна форма(form, содержащая такие компоненты Memo(имя в
процедуре mmOutput), Maskedit(med),ProgressBar(PB-это не обязательно, но
если считаешь очень большой факториал, то это занимает некоторое время,
поэтому визуально следить за временем, оставшимся на вычисление, очень
удобно). Идея программы: переменные в Delphi не могут содержать таких
длинных чисел, поэтому здесь используется массив целых переменных,
обрабатывая который и получаем нужный ответ. В результате можно считать
факториалы многотысячных чисел, я считал 5000!,дальше считать долго, но
возможно.

    procedure TForm1.bbRunClick(Sender: TObject); //обработка события от мыши
    var //это раздел указания переменных
      result: string; //переменная result целого типа
      M: array of integer;
        //"M" - это матрица, или массив, причем динамический, то есть его размеры можно
      F, i, j, k, n: integer;
        //изменять, это увеличивает время выполнения программы, но интересно попробовать
    begin
      if med.text = '' then
        med.text := '0'; //свойство text компонента med проверяется на наличие
      n := StrToInt(Trim(MEd.Text));
        //введенного числа, StrToInt-преобразование строки в число
      if n < 4 then
        exit; //trim-удаление пробелов из строки
      PB.Max := (n + sqr(n)); //Это определение размеров PB
      PB.Position := 0;
      screen.Cursor := crHourGlass;
        //появляется новый курсор, стандартный "виндовский"
      setLength(M, 2); //определение границ массива
      M[0] := 1; //присвоение 0-ому элементу массива М значения 1....
      M[1] := 0;
      k := 1;
      for i := 1 to n do
      begin
        F := 0;
        PB.StepBy(i * 2); //изменение показаний PB
        for j := 0 to k do
        begin
          SetLength(M, k + 1);
          M[j] := M[j] * i + F; //здесь основная идея программы
          if (M[j] div 10) > 0 then
            k := k + 1;
          F := M[j] div 10;
          M[j] := M[j] mod 10;
        end;
      end;
      for i := k downto 0 do //перебор целых значений от k до 0
      begin
        if M[i] > 0 then
          break;
        if M[i] = 0 then
          k := k - 1;
      end;
      SetLength(M, k); //изменение размеров массива М до кол-ва элементов-k
      Result := '';
      for j := k downto 0 do
        Result := Result + IntToStr(M[j]);
      mmOutput.Lines.Add(IntToStr(n) + '! = ' + result);
        //добавление результата в редактор Memo(mmOutput)
      if n6.Checked = true then
        mmoutput.Lines.Add('В этом числе ' + IntToStr(length(result)) + ' цифр.');
      M := nil; //освобождение памяти IntToStr-преобразование числа в строку
      screen.Cursor := crDefault; //смена курсора
      Med.Text := '';
      Med.SetFocus; //передача фокуса ввода компоненту med
    end;
     
     
     

DelphiWorld 6.0 <https://delphiworld.narod.ru/>

