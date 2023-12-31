---
Title: Получение переменных среды
Date: 01.01.2007
---


Получение переменных среды
==========================

::: {.date}
01.01.2007
:::

    procedure GetEnvironmentStrings(ss: TStrings);
    {Переменные среды}
    var
      ptr: PChar;
      s: string;
      Done: boolean;
    begin
      ss.Clear;
      s := '';
      Done := FALSE;
      ptr := windows.GetEnvironmentStrings;
      while Done = false do begin
        if ptr^ = #0 then begin
          inc(ptr);
          if ptr^ = #0 then Done := TRUE
          else ss.Add(s);
          s := ptr^;
        end else s := s + ptr^;
        inc(ptr);
      end;
    end;

Взято с <https://delphiworld.narod.ru>

------------------------------------------------------------------------

    procedure TForm1.Button5Click(Sender: TObject);
    var
      p: pChar;
    begin
      Memo1.Lines.Clear;
      Memo1.WordWrap := false;
      {$IFDEF WIN32}
      p := GetEnvironmentStrings;
      {$ELSE}
      p := GetDOSEnvironment;
      {$ENDIF}
      while p^ <> #0 do begin
        Memo1.Lines.Add(StrPas(p));
        inc(p, lStrLen(p) + 1);
      end;
      {$IFDEF WIN32}
      FreeEnvironmentStrings(p);
      {$ENDIF}
    end;
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

------------------------------------------------------------------------

Функция GetEnvironmentStrings возвращает адрес памяти со средой текущего
процесса. Все переменные возвращаются в виде строк, оканчивающихся
нулем. Набор строк терминируется двумя нулями.

Функция GetEnvironmentVariable возвращает значения переменных среды
опрашиваемого процесса. Величина также возвращается в виде строки с
завершающим нулем.

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

------------------------------------------------------------------------

    unit TDosEnv;
    interface
     
    uses
      SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics, Controls,
      Forms, Dialogs;
     
    type
      TDosEnvironment = class(TComponent)
      public
        { Public объявления класса }
        constructor Create(AOwner: TComponent); override;
        destructor Destroy; override;
     
      private
        { Объявления Private-полей }
        FDosEnvList: TStringList;
        procedure DoNothing(const Value: TStringList);
     
      protected
        { Объявления Protected-методов }
        dummy: Word;
        function GetDosEnvCount: Word;
     
      public
        { Public interface объявления }
        function GetDosEnvStr(const Name: string): string;
        { Данная функция является измененной версией функции GetEnvVar,
        присутствующей в поставляемом с Delphi модуле WinDos. Она
        использует паскалевские строки вместо строк с терминирующим нулем.
        }
     
      published
        { Published design объявления }
        property DosEnvCount: Word read GetDosEnvCount write dummy;
        property DosEnvList: TStringList read FDosEnvList write DoNothing;
      end;
     
    procedure Register;
     
    implementation
     
    constructor TDosEnvironment.Create(AOwner: TComponent);
    var
      P: PChar;
      i: Integer;
    begin
      inherited Create(AOwner);
      FDosEnvList := TStringList.Create;
      P := GetDosEnvironment; { Win API }
      i := 0;
      while P^ <> #0 do
      begin
        Inc(i);
        FDosEnvList.Add(StrPas(P));
        Inc(P, StrLen(P) + 1) { Быстрый переход к следующей переменной }
      end
    end {Create};
     
    destructor TDosEnvironment.Destroy;
    begin
      FDosEnvList.Free;
      FDosEnvList := nil;
      inherited Destroy
    end {Destroy};
     
    procedure TDosEnvironment.DoNothing(const Value: TStringList);
    begin
      MessageDlg('TDosEnvironment.DosEnvList только для чтения!', mtInformation,
        [mbOk], 0)
     
    end {DoNothing};
     
    function TDosEnvironment.GetDosEnvCount: Word;
    { Возвращает количество переменных окружения.
    }
    begin
      if Assigned(FDosEnvList) then {!!}
        Result := FDosEnvList.Count
      else
        Result := 0;
    end {GetDosEnvCount};
     
    function TDosEnvironment.GetDosEnvStr(const Name: string): string;
    { Данная функция является измененной версией функции GetEnvVar,
    присутствующей в поставляемом с Delphi модуле WinDos. Она
    использует паскалевские строки вместо строк с терминирующим нулем.
    }
    var
      i: Integer;
      Tmp: string;
      Len: Byte absolute Name;
    begin
      i := 0;
      Result := '';
      if Assigned(FDosEnvList) then {!!}
        while i < FDosEnvList.Count do
        begin
          Tmp := FDosEnvList[i];
          Inc(i);
          if Pos(Name, Tmp) = 1 then
          begin
            Delete(Tmp, 1, Len);
            if Tmp[1] = '=' then
            begin
              Delete(Tmp, 1, 1);
              Result := Tmp;
              i := FDosEnvList.Count { конец while-цикла }
            end
          end
        end
    end {GetDosEnvStr};
     
    procedure Register;
    begin
      RegisterComponents('Dr.Bob', [TDosEnvironment]);
    end {Register};
     
    end.

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
