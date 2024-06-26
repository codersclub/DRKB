---
Title: Определение восхода и захода солнца и луны
Author: Александр Ермолаев
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Определение восхода и захода солнца и луны
==========================================

    program sunproject;
     
    uses
      Forms,
      main in 'main.pas' {Sun};
     
    {$R *.RES}
     
    begin
      Application.Initialize;
      Application.Title := 'Sun';
      Application.CreateForm(TSun, Sun);
      Application.Run;
    end.

    object Sun: TSun
      Left = 210
        Top = 106
        BorderIcons = [biSystemMenu, biMinimize]
        BorderStyle = bsSingle
        Caption = 'Sun'
        ClientHeight = 257
        ClientWidth = 299
        Color = clBtnFace
        Font.Charset = DEFAULT_CHARSET
        Font.Color = clWindowText
        Font.Height = -11
        Font.Name = 'MS Sans Serif'
        Font.Style = []
        OldCreateOrder = False
        Position = poDesktopCenter
        OnCreate = CreateForm
        PixelsPerInch = 96
        TextHeight = 13
        object GroupBoxInput: TGroupBox
        Left = 4
          Top = 4
          Width = 173
          Height = 93
          Caption = ' Ввод '
          TabOrder = 0
          object LabelLongitude: TLabel
          Left = 35
            Top = 44
            Width = 78
            Height = 13
            Alignment = taRightJustify
            Caption = 'Долгота (град):'
        end
        object LabelTimeZone: TLabel
          Left = 13
            Top = 68
            Width = 100
            Height = 13
            Alignment = taRightJustify
            Caption = 'Часовая зона (час):'
        end
        object LabelAtitude: TLabel
          Left = 40
            Top = 20
            Width = 73
            Height = 13
            Alignment = taRightJustify
            Caption = 'Широта (град):'
        end
        object EditB5: TEdit
          Tag = 1
            Left = 120
            Top = 16
            Width = 37
            Height = 21
            TabOrder = 0
            Text = '0'
        end
        object EditL5: TEdit
          Tag = 2
            Left = 120
            Top = 40
            Width = 37
            Height = 21
            TabOrder = 1
            Text = '0'
        end
        object EditH: TEdit
          Tag = 3
            Left = 120
            Top = 64
            Width = 37
            Height = 21
            TabOrder = 2
            Text = '0'
        end
      end
      object GroupBoxCalendar: TGroupBox
        Left = 184
          Top = 4
          Width = 109
          Height = 93
          Caption = ' Календарь '
          TabOrder = 1
          object LabelD: TLabel
          Left = 19
            Top = 20
            Width = 30
            Height = 13
            Alignment = taRightJustify
            Caption = 'День:'
        end
        object LabelM: TLabel
          Left = 13
            Top = 44
            Width = 36
            Height = 13
            Alignment = taRightJustify
            Caption = 'Месяц:'
        end
        object LabelY: TLabel
          Left = 28
            Top = 68
            Width = 21
            Height = 13
            Alignment = taRightJustify
            Caption = 'Год:'
        end
        object EditD: TEdit
          Tag = 1
            Left = 56
            Top = 16
            Width = 37
            Height = 21
            TabOrder = 0
            Text = '0'
        end
        object EditM: TEdit
          Tag = 2
            Left = 56
            Top = 40
            Width = 37
            Height = 21
            TabOrder = 1
            Text = '0'
        end
        object EditY: TEdit
          Tag = 3
            Left = 56
            Top = 64
            Width = 37
            Height = 21
            TabOrder = 2
            Text = '0'
        end
      end
      object ButtonCalc: TButton
        Left = 12
          Top = 227
          Width = 169
          Height = 25
          Caption = '&Вычислить'
          TabOrder = 2
          OnClick = ButtonCalcClick
      end
      object ListBox: TListBox
        Left = 4
          Top = 104
          Width = 289
          Height = 117
          ItemHeight = 13
          TabOrder = 3
      end
      object ButtonClear: TButton
        Left = 192
          Top = 227
          Width = 91
          Height = 25
          Caption = '&Очистить'
          TabOrder = 4
          OnClick = ButtonClearClick
      end
    end

    {
    Программа вычисляет время восхода и захода солнца по дате
    (с точностью до минуты) в пределах нескольких текущих столетий.
    Производит корректировку, если географическая точка находится
    в арктическом или антарктическом регионе, где заход или восход солнца
    на текущую дату может не состояться.
    Вводимые данные: положительная северная широта и отрицательная западная долгота.
    Часовой пояс указывается относительно Гринвича
    (например, 5 для EST и 4 для EDT).
    Алгоритм обсуждался в "Sky & Telescope" за август 1994, страница 84.
    }
     
    unit main;
     
    interface
     
    uses
     
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms,
      Dialogs, StdCtrls;
     
    type
     
      TSun = class(TForm)
        GroupBoxInput: TGroupBox;
        LabelLongitude: TLabel;
        EditB5: TEdit;
        EditL5: TEdit;
        LabelTimeZone: TLabel;
        EditH: TEdit;
        GroupBoxCalendar: TGroupBox;
        LabelD: TLabel;
        LabelM: TLabel;
        LabelY: TLabel;
        EditD: TEdit;
        EditM: TEdit;
        EditY: TEdit;
        ButtonCalc: TButton;
        ListBox: TListBox;
        ButtonClear: TButton;
        LabelAtitude: TLabel;
        procedure Calendar; // Календарь
        procedure GetTimeZone; // Получение часового пояса
        procedure PosOfSun; // Получаем положение солнца
        procedure OutInform; // Процедура вывода информации
        procedure PossibleEvents(Hour: integer); // Возможные события на
        полученный час
     
        procedure GetDate; //Получить значения даты
        procedure GetInput; //Получить значения широты,...
        procedure ButtonCalcClick(Sender: TObject);
        procedure CreateForm(Sender: TObject);
        procedure ButtonClearClick(Sender: TObject);
      private
        function Sgn(Value: Double): integer; // Сигнум
      public
        { Public declarations }
      end;
     
    var
     
      Sun: TSun;
      st: string;
      aA, aD: array[1..2] of double;
      B5: integer;
      L5: double;
      H: integer;
      Z, Z0, Z1: double;
      D: double;
      M, Y: integer;
      A5, D5, R5: double;
      J3: integer;
      T, T0, TT, T3: double;
      L0, L2: double;
      H0, H1, H2, H7, N7, D7: double;
      H3, M3: integer;
      M8, W8: double;
      A, B, A0, D0, A2, D1, D2, DA, DD: double;
      E, F, J, S, C, P, L, G, V, U, W: double;
      V0, V1, V2: double;
      C0: integer;
      AZ: double;
     
    const
     
      P2 = Pi * 2; // 2 * Pi
      DR = Pi / 180; // Радиан на градус
      K1 = 15 * DR * 1.0027379;
     
    implementation
     
    {$R *.DFM}
     
    function TSun.Sgn(Value: Double): integer;
    begin
     
      {if Value = 0 then} Result := 0;
      if Value > 0 then
        Result := 1;
      if Value < 0 then
        Result := -1;
    end;
     
    procedure TSun.Calendar;
    begin
     
      G := 1;
      if Y < 1583 then
        G := 0;
      D1 := Trunc(D);
      F := D - D1 - 0.5;
      J := -Trunc(7 * (Trunc((M + 9) / 12) + Y) / 4);
      if G = 1 then
      begin
        S := Sgn(M - 9);
        A := Abs(M - 9);
        J3 := Trunc(Y + S * Trunc(A / 7));
        J3 := -Trunc((Trunc(J3 / 100) + 1) * 3 / 4);
      end;
      J := J + Trunc(275 * M / 9) + D1 + G * J3;
      J := J + 1721027 + 2 * G + 367 * Y;
      if F >= 0 then
        Exit;
      F := F + 1;
      J := J - 1;
    end;
     
    procedure TSun.GetTimeZone;
    begin
     
      T0 := T / 36525;
      S := 24110.5 + 8640184.813 * T0;
      S := S + 86636.6 * Z0 + 86400 * L5;
      S := S / 86400;
      S := S - Trunc(S);
      T0 := S * 360 * DR;
    end;
     
    procedure TSun.PosOfSun;
    begin
     
      //      Фундаментальные константы
      //  (Van Flandern & Pulkkinen, 1979)
      L := 0.779072 + 0.00273790931 * T;
      G := 0.993126 + 0.0027377785 * T;
      L := L - Trunc(L);
      G := G - Trunc(G);
      L := L * P2;
      G := G * P2;
      V := 0.39785 * Sin(L);
      V := V - 0.01000 * Sin(L - G);
      V := V + 0.00333 * Sin(L + G);
      V := V - 0.00021 * TT * Sin(L);
      U := 1 - 0.03349 * Cos(G);
      U := U - 0.00014 * Cos(2 * L);
      U := U + 0.00008 * Cos(L);
      W := -0.00010 - 0.04129 * Sin(2 * L);
      W := W + 0.03211 * Sin(G);
      W := W + 0.00104 * Sin(2 * L - G);
      W := W - 0.00035 * Sin(2 * L + G);
      W := W - 0.00008 * TT * Sin(G);
     
      // Вычисление солнечных координат
      S := W / Sqrt(U - V * V);
      A5 := L + ArcTan(S / Sqrt(1 - S * S));
      S := V / Sqrt(U);
      D5 := ArcTan(S / Sqrt(1 - S * S));
      R5 := 1.00021 * Sqrt(U);
    end;
     
    procedure TSun.PossibleEvents(Hour: integer);
    var
      num: string;
    begin
     
      st := '';
      L0 := T0 + Hour * K1;
      L2 := L0 + K1;
      H0 := L0 - A0;
      H2 := L2 - A2;
      H1 := (H2 + H0) / 2; // Часовой угол,
      D1 := (D2 + D0) / 2; // наклон в получасе
      if Hour <= 0 then
        V0 := S * Sin(D0) + C * Cos(D0) * Cos(H0) - Z;
      V2 := S * Sin(D2) + C * Cos(D2) * Cos(H2) - Z;
      if Sgn(V0) = Sgn(V2) then
        Exit;
      V1 := S * Sin(D1) + C * Cos(D1) * Cos(H1) - Z;
      A := 2 * V2 - 4 * V1 + 2 * V0;
      B := 4 * V1 - 3 * V0 - V2;
      D := B * B - 4 * A * V0;
      if D < 0 then
        Exit;
      D := Sqrt(D);
      if (V0 < 0) and (V2 > 0) then
        st := st + 'Восход солнца в ';
      if (V0 < 0) and (V2 > 0) then
        M8 := 1;
      if (V0 > 0) and (V2 < 0) then
        st := st + 'Заход солнца в ';
      if (V0 > 0) and (V2 < 0) then
        W8 := 1;
      E := (-B + D) / (2 * A);
      if (E > 1) or (E < 0) then
        E := (-B - D) / (2 * A);
      T3 := Hour + E + 1 / 120; // Округление
      H3 := Trunc(T3);
      M3 := Trunc((T3 - H3) * 60);
      Str(H3: 2, num);
      st := st + num + ':';
      Str(M3: 2, num);
      st := st + num;
      H7 := H0 + E * (H2 - H0);
      N7 := -Cos(D1) * Sin(H7);
      D7 := C * Sin(D1) - S * Cos(D1) * COS(H7);
      AZ := ArcTan(N7 / D7) / DR;
      if (D7 < 0) then
        AZ := AZ + 180;
      if (AZ < 0) then
        AZ := AZ + 360;
      if (AZ > 360) then
        AZ := AZ - 360;
      Str(AZ: 4: 1, num);
      st := st + ', азимут ' + num;
    end;
     
    procedure TSun.OutInform;
    begin
     
      if (M8 = 0) and (W8 = 0) then
      begin
        if V2 < 0 then
          ListBox.Items.Add('Солнце заходит весь день ');
        if V2 > 0 then
          ListBox.Items.Add('Солнце восходит весь день ');
      end
      else
      begin
        if M8 = 0 then
          ListBox.Items.Add('В этот день солнце не восходит ');
        if W8 = 0 then
          ListBox.Items.Add('В этот день солнце не заходит ');
      end;
    end;
     
    procedure TSun.GetDate;
    begin
     
      D := StrToInt(EditD.text);
      M := StrToInt(EditM.text);
      Y := StrToInt(EditY.text);
    end;
     
    procedure TSun.GetInput;
    begin
     
      B5 := StrToInt(EditB5.Text);
      L5 := StrToInt(EditL5.Text);
      H := StrToInt(EditH.Text);
    end;
     
    procedure TSun.ButtonCalcClick(Sender: TObject);
    var
      C0: integer;
    begin
     
      GetDate;
      GetInput;
      ListBox.Items.Add('Широта: ' + EditB5.Text +
        ' Долгота: ' + EditL5.Text +
        ' Зона: ' + EditH.Text +
        ' Дата: ' + EditD.Text +
        '/' + EditM.Text +
        '/' + EditY.Text);
      L5 := L5 / 360;
      Z0 := H / 24;
      Calendar;
      T := (J - 2451545) + F;
      TT := T / 36525 + 1; // TT - столетия, начиная с 1900.0
      GetTimeZone; // Получение часового пояса
      T := T + Z0;
      PosOfSun; // Получаем положение солнца
      aA[1] := A5;
      aD[1] := D5;
      T := T + 1;
      PosOfSun;
      aA[2] := A5;
      aD[2] := D5;
      if aA[2] < aA[1] then
        aA[2] := aA[2] + P2;
      Z1 := DR * 90.833; // Вычисление зенита
      S := Sin(B5 * DR);
      C := Cos(B5 * DR);
      Z := Cos(Z1);
      M8 := 0;
      W8 := 0;
      A0 := aA[1];
      D0 := aD[1];
      DA := aA[2] - aA[1];
      DD := aD[2] - aD[1];
      for C0 := 0 to 23 do
      begin
        P := (C0 + 1) / 24;
        A2 := aA[1] + P * DA;
        D2 := aD[1] + P * DD;
        PossibleEvents(C0);
        if st <> '' then
          ListBox.Items.Add(st);
        A0 := A2;
        D0 := D2;
        V0 := V2;
      end;
      OutInform;
      ListBox.Items.Add(''); // Разделяем данные
    end;
     
    procedure TSun.CreateForm(Sender: TObject);
    begin
     
      EditD.Text := FormatDateTime('d', Date);
      EditM.Text := FormatDateTime('m', Date);
      EditY.Text := FormatDateTime('yyyy', Date);
    end;
     
    procedure TSun.ButtonClearClick(Sender: TObject);
    begin
      ListBox.Clear;
    end;
     
    end.


