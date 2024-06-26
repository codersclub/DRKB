---
Title: Модуль поиска по маске (более совершеный, нежели дельфийский masks)
Author: Петрович
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Модуль поиска по маске (более совершеный, нежели дельфийский masks)
===================================================================

    unit awMachMask; // © Alexandr Petrovich Sysoev
     
    interface
     
    uses Classes;
     
    ///////////////////////////////////////////////////// Работа со списком шаблонов
    // Функции предназначены для сопоставления текстов (имен файлов) на
    // соответствие заданному шаблону или списку шаблонов.
    // Обычно используется для посторения простых фильтров, например аналогичных
    // файловым фильтрам программы Total Commander.
    //
    // Каждый шаблон аналогичен шаблону имен файлов в MS-DOS и MS Windows,
    // т.е. может включать "шаблонные" символы '*' и '?' и не может включать
    // символ '|'.
    // Любой шаблон может быть заключен в двойные кавычки ('''), при этом двойные
    // кавычки имеющиеся в шаблоне должны быть удвоены. Если шаблон включает
    // символы ';' или ' ' (пробел) то он обязательно должен быть заключен в
    // двойные кавычки.
    // В списке, шаблоны разделяются символом ';'.
    // За первым списком шаблонов, может следовать символ '|', за которым может
    // следовать второй список.
    // Текст (имя файла) будет считаться соответствующим списку шаблонов только
    // если он соответствует хотя бы одному шаблону из первого списка,
    // и не соответствует ни одному шаблону из второго списка.
    // Если первый список пуст, то подразумевается '*'
    //
    // Формальное описание синтаксиса списка шаблонов:
    //
    //    Полный список шаблонов      :: [<список включаемых шаблонов>]['|'<список исключаемых шаблонов>]
    //    список включаемых шаблонов  :: <список шаблонов>
    //    список исключаемых шаблонов :: <список шаблонов>
    //    список шаблонов             :: <шаблон>[';'<шаблон>]
    //    шаблон                      :: шаблон аналогичный шаблону имен файлов в
    //                                   MS-DOS и MS Windows, т.е. может включать
    //                                   "шаблонные" символы '*' и '?' и не может
    //                                   включать символ '|'. Шаблон может быть
    //                                   заключен в двойные кавычки (''') при этом
    //                                   двойные кавычки имеющиеся в шаблоне должны
    //                                   быть удвоены. Если шаблон включает символы
    //                                   ';' или ' ' (пробел) то он
    //                                   обязательно должен быть заключен в двойные
    //                                   кавычки.
    //
    // Например:
    //   '*.ini;*.wav'          - соответствует любым файлам с расшиениями 'ini'
    //                            или 'wav'
    //   '*.*|*.exe'            - соответствует любым файлам, кроме файлов с
    //                            расширением 'EXE'
    //   '*.mp3;*.wav|?.*;??.*' - соответствует любым файлам с расшиениями 'mp3'
    //                            и 'wav' за исключением файлов у которых имя
    //                            состоит из одного или двух символов.
    //   '|awString.*'          - соответствует любым файлам за исключением файлов
    //                            с именем awString и любым расширением.
    //
     
    Function IsMatchMask (aText, aMask :pChar ) :Boolean;                               overload;
    Function IsMatchMask (aText, aMask :String; aFileNameMode :Boolean =True) :Boolean; overload;
      // Выполняют сопоставление текста aText с одним шаблоном aMask.
      // Возвращает True если сопоставление выполнено успешно, т.е. текст
      // aText соответствует шаблону aMask.
      // Если aFileNameModd=True, то объект используется для сопоставления
      // имен файлов с шаблоном. А именно, в этом случае, если aText не
      // содержит символа '.' то он добавляется в конец. Это необходимо для
      // того, чтобы файлы без расширений соответствовали например шаблону '*.*'
     
    Function IsMatchMaskList (aText, aMaskList :String; aFileNameMode :Boolean =True): Boolean;
      // Выполняет сопоставление текста aText со списком шаблонов aMaskList.
      // Возвращает True если сопоставление выполнено успешно, т.е. текст
      // aText соответствует списку шаблонов aMaskList.
      // Если aFileNameModd=True, то объект используется для сопоставления
      // имен файлов с шаблоном. А именно, в этом случае, если aText не
      // содержит символа '.' то он добавляется в конец. Это необходимо для
      // того, чтобы файлы без расширений соответствовали например шаблону '*.*'
      //
      // Замечание, если требуется проверка сопоставления нескольких строк одному
      // списку шаблонов, эффективнее будет воспользоваться объектом tMatchMaskList.
     
    Type
      tMatchMaskList = class(tObject)
        Private
          fMaskList      :String;
          fCaseSensitive :Boolean;
          fFileNameMode  :Boolean;
     
          fPrepared     :Boolean;
          fIncludeMasks :tStringList;
          fExcludeMasks :tStringList;
     
          procedure SetMaskList      (v :String );
          procedure SetCaseSensitive (v :Boolean);
     
        Public
          constructor Create (Const aMaskList :String ='');
            // Создает объект. Если задан параметр aMaskList, то он присваивается
            // свойству MaskList.
     
          destructor  Destroy;    override;
            // Разрушает объект
     
          procedure PrepareMasks;
            // Осуществляет компиляцию списка шаблонов во внутреннюю структуру
            // используемую при сопоставлении текста.
            // Вызов данного метода не является обязательным и при необходимости
            // будет вызван автоматически.
     
          Function IsMatch (aText :String) :Boolean;
            // Выполняет сопоставление текста aText со списком шаблонов MaskList.
            // Возвращает True если сопоставление выполнено успешно, т.е. текст
            // aText соответствует списку шаблонов MaskList.
     
          Property MaskList      :String   Read fMaskList        Write SetMaskList                     ;
            // Списко шаблонов используемый для сопоставления с текстом
     
          Property CaseSensitive :Boolean  Read fCaseSensitive   Write SetCaseSensitive   default False;
            // Если False (по умолчанию), то при сопоставлении текста будет
            // регистр символов не будет учитываться.
            // Иначе, если True, сопоставление будет проводиться с учетом регистра.
     
          Property FileNameMode :Boolean   Read fFileNameMode    Write fFileNameMode      default True;
            // Если True (по умолчанию), то объект используется для сопоставления
            // имен файлов с шаблоном. А именно, в этом случае, если aText не
            // содержит символа '.' то он добавляется в конец. Это необходимо для
            // того, чтобы файлы без расширений соответствовали например шаблону '*.*'
     
        End;
     
     
    implementation
     
    uses
      SysUtils;
     
    Function IsMatchMask (aText, aMask :pChar ) :Boolean; overload;
    begin
      Result := False;
      While  True  Do begin
        Case  aMask^  of
          '*'  :   // соответствует любому числу любых символов кроме конца строки
            begin
              // переместиться на очередной символ шаблона, при этом, подряд
              // идущие '*' эквивалентны одному, поэтому пропуск всех '*'
              repeat  Inc(aMask);  Until  (aMask^<>'*');
              // если за '*' следует любой символ кроме '?' то он должен совпасть
              // с символом в тексте. т.е. нужно пропустить все не совпадающие,
              // но не далее конца строки
              If  aMask^ <> '?'  then
                While  (aText^ <> #0) And (aText^ <> aMask^)  Do  Inc(aText);
     
              If  aText^ <> #0   Then begin  // не конец строки, значит совпал символ
                // '*' 'жадный' шаблон поэтому попробуем отдать совпавший символ
                // ему. т.е. проверить совпадение продолжения строки с шаблоном,
                // начиная с того-же '*'. если продолжение совпадает, то
                If  IsMatchMask (aText+1, aMask-1)  Then  Break;  // это СОВПАДЕНИЕ
                // продолжение не совпало, значит считаем что здесь закончилось
                // соответствие '*'. Продолжим сопоставление со следующего
                // символа шаблона
                Inc(aMask); Inc(aText);     //   иначе переходим к следующему символу
                End
              Else If  (aMask^ = #0)  Then  // конец строки и конец шаблона
                Break                       //     это СОВПАДЕНИЕ
              Else                          // конец строки но не конец шаблона
                Exit                        //     это НЕ СОВПАДЕНИЕ
            End;
     
          '?'  :   // соответствует любому кроме конца строки
            If (aText^ = #0)  Then          // конец строки
              Exit                          //     это НЕ СОВПАДЕНИЕ
            Else begin                      // иначе
              Inc(aMask); Inc(aText);       //   иначе переходим к следующему символу
            End;
     
          Else     // символ в шаблоне должен совпасть с символом в строке
            If  aMask^ <> aText^  Then      // символы не совпали -
              Exit                          //     это НЕ СОВПАДЕНИЕ
            Else begin                      // совпал очередной символ
              If  (aMask^ = #0)  Then       //   совпавший символ последний -
                Break;                      //     это СОВПАДЕНИЕ
              Inc(aMask); Inc(aText);       //   иначе переходим к следующему символу
            End;
        End;
      End;
      Result := True;
    End;
     
    Function IsMatchMask (aText, aMask :String; aFileNameMode :Boolean =True) :Boolean; overload;
    begin
      If  aFileNameMode And (Pos('.',aText)=0)  then  aText := aText+'.';
      Result := IsMatchMask(pChar(aText),pChar(aMask));
    End;
     
    Function IsMatchMaskList (aText, aMaskList :String; aFileNameMode :Boolean =True) :Boolean;
    begin
      With  tMatchMaskList.Create(aMaskList)  Do try
        FileNameMode := aFileNameMode;
        Result := IsMatch(aText);
      finally
        Free;
      End;
    End;
     
     
    /////////////////////////////////////////////////////////// tFileMask
     
     
    procedure tMatchMaskList.SetMaskList (v :String );
    begin
      If  fMaskList = v  Then  Exit;
      fMaskList := v;
      fPrepared := False;
    End;
     
     
    procedure tMatchMaskList.SetCaseSensitive  (v :Boolean);
    begin
      If  fCaseSensitive = v  Then  Exit;
      fCaseSensitive := v;
      fPrepared      := False;
    End;
     
     
    constructor tMatchMaskList.Create (Const aMaskList :String);
    begin
      MaskList := aMaskList;
      fFileNameMode := True;
     
      fIncludeMasks := TStringList.Create;  With  fIncludeMasks  Do begin
        Delimiter  := ';';
    //    Sorted     := True;
    //    Duplicates := dupIgnore;
      End;
     
      fExcludeMasks := tStringList.Create;  With  fExcludeMasks  Do begin
        Delimiter  := ';';
    //    Sorted     := True;
    //    Duplicates := dupIgnore;
      End;
    End;
     
     
    destructor  tMatchMaskList.Destroy;
    begin
      fIncludeMasks.Free;
      fExcludeMasks.Free;
    End;
     
     
    procedure tMatchMaskList.PrepareMasks;
     
      procedure CleanList(l :tStrings);
      var i :Integer;
      begin
        For  i := l.Count-1  downto  0  Do   If  l[i] = ''  then  l.Delete(i);
      End;
     
    var
      s :String;
      i :Integer;
    begin
      If  fPrepared  Then  Exit;
     
      If  CaseSensitive  Then
        s := MaskList
      Else
        s := UpperCase(MaskList);
     
      i := Pos('|',s);
      If  i =  0  Then begin
        fIncludeMasks.DelimitedText := s;
        fExcludeMasks.DelimitedText := '';
        End
      Else begin
        fIncludeMasks.DelimitedText := Copy(s,1,i-1);
        fExcludeMasks.DelimitedText := Copy(s,i+1,MaxInt);
      End;
     
      CleanList(fIncludeMasks);
      CleanList(fExcludeMasks);
     
      // если список включаемых шаблонов пуст а
      // список исключаемых шаблонов не пуст, то
      // имеется ввиду что список включаемых шаблонов равен <все файлы>
      If  (fIncludeMasks.Count = 0) And (fExcludeMasks.Count <> 0)  Then
        fIncludeMasks.Add('*');
     
      fPrepared := True;
    End;
     
     
    Function tMatchMaskList.IsMatch (aText :String) :Boolean;
    var
      i :Integer;
    begin
      Result := False;
      If  aText = ''  then  Exit;
      If  Not CaseSensitive  Then  aText := UpperCase(aText);
      If  FileNameMode And (Pos('.',aText)=0)  then  aText := aText+'.';
      If  Not fPrepared  Then  PrepareMasks;
     
      // поиск в списке "включаемых" масок до первого совпадения
      For  i := 0  To  fIncludeMasks.Count-1  Do
        If  IsMatchMask(PChar(aText),PChar(fIncludeMasks[i]))  Then begin
          Result := True;
          Break;
        End;
     
      // если совпадение найдено, надо проверить по списку "исключаемых"
      If  Result  Then
        For  i := 0  To  fExcludeMasks.Count-1  Do
          If  IsMatchMask(PChar(aText),PChar(fExcludeMasks[i]))  Then begin
            Result := False;
            Break;
          End;
    End;
     
     
    end.

