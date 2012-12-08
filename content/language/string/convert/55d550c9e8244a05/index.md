---
Title: Преобразование Unicode строк в DFM файлах Delphi 6 в Ansi строки
Date: 01.01.2007
---


Преобразование Unicode строк в DFM файлах Delphi 6 в Ansi строки
================================================================

::: {.date}
01.01.2007
:::

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Преобразование Unicode строк в DFM файлах Delphi 6 в Ansi строки.
     
    При попытке открыть проект созданный в Delphi 6 из Delphi 5 возникает 
    проблема с чтением DFM-файла. Проблема заключается в том, что Delphi5 
    не может прочитать строки, записанные в формате Unicode (WideString). 
    Данная функция переводит строки из DFM файла в формат ANSI, после чего
    DFM файл читается в D5. Но при этом может возникнуть проблема, 
    связанная с незнакомыми для D5 свойствами компонентов, которая, 
    в свою очередь, решается игнорированием этих свойств.
     
    Зависимости: Classes
    Автор:       Радионов Алексей (Alx2), alx@argo.mv.ru, ICQ:113442587, Ульяновск
    Copyright:   Alx2
    Дата:        31 мая 2002 г.
    ********************************************** }
     
    Procedure RemoveUnicodeFromDFM(Const Filename: String);
      Function isChanges(Const S: String; Var Res: String): Boolean;
      Var len: Integer;
        Function LexemSharp(Var K: Integer): Boolean; 
        Begin
          Result := (K < len) And (S[K] = '#');
          If Result Then
          Begin
            inc(K);
            While (K <= len) And (S[K] In ['0'..'9']) Do inc(K);
          End;
        End;
        Function LexemAp(Var K: Integer): Boolean;
        Begin
          Result := (K < len) And (S[K] = '''');
          If Result Then
          Begin
            inc(K);
            While (K <= len) And (S[K] <> '''') Do inc(K);
            If K <= len
              Then
              inc(K);
          End;
        End;
     
        Function Lexem(Var K: Integer; Var Str: String): Boolean;
        Var
          Start: Integer;
          ValS : String;
        Begin
          Result := False;
          Start := K;
          If LexemSharp(K) Then
          Begin
            ValS := Copy(S, Start + 1, K - Start - 1);
            Str := WideChar(StrToInt(ValS));
            Result := True;
          End
          Else
            If LexemAp(K) Then
            Begin
              Str := Copy(S, Start + 1, K - Start - 2);
              Result := True;
            End;
        End;
     
        Function Prepare(Var K: Integer): String;
        Var Str: String;
          WasLexem: Boolean;
        Begin
          Result := '';
          WasLexem := False;
          While Lexem(K, Str) Do
          Begin
            Result := Result + Str;
            WasLexem := True;
          End;
          If Result <> '' Then
            Result := '''' + Result + '''' + Copy(S, K, Length(S))
          Else
            If Not WasLexem Then
              Result := S
            Else
              Result := '''''';
        End;
        Function Min(A, B: Integer): Integer;
        Begin
          If A = 0 Then Result := B
          Else
            If B = 0 Then Result := A
            Else
              If A > B Then Result := B
              Else Result := A;
        End;
     
      Var
        StartIdx: Integer;
      Begin
        Result := False;
        StartIdx := Min(Pos('#', S), Pos('''', S));
        If StartIdx > 0 Then
        Begin
          len := Length(S);
          While (StartIdx <= len) And (Not (S[StartIdx] In ['#', ''''])) Do inc(StartIdx);
          If StartIdx < len Then
          Begin
            Res := Copy(S, 1, StartIdx - 1) + Prepare(StartIdx);
            Result := True;
          End;
        End;
      End;
     
    Var
      SList: TStringList;
      K : Integer;
      Res : String;
    Begin
      SList := TStringList.Create;
      Try
        SList.LOADFROMFILE(Filename);
        For K := 0 To SList.Count - 1 Do
          If isChanges(SList[K], Res) Then
            SList[K] := Res;
        SList.SaveToFile(Filename);
      Finally
        SList.Free;
      End;
    End; 

Пример использования:

    Procedure TForm1.Button1Click(Sender: TObject);
    Var
      K: Integer;
    Begin
      If OpenDialog1.Execute Then
        For K := 0 To OpenDialog1.Files.Count - 1 Do
          RemoveUnicodeFromDFM(OpenDialog1.Files[K]);
    End; 
