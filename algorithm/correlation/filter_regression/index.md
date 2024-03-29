---
Title: Фильтрация, регрессия, работа с массивом и серией
Date: 30.04.2002
Author: lookin, lookin@mail.ru
---


Фильтрация, регрессия, работа с массивом и серией
=================================================

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Фильтрация, регрессия, работа с массивом и серией
     
    Модуль предназначен для выполнения процедур:
    - фильтрации
    - регрессии
    - операций с массивами
    - операций с сериями
     
    Зависимости: Math, TeEngine, Graphics, SysUtils, Dialogs
    Автор:       lookin, lookin@mail.ru, Екатеринбург
    Copyright:   lookin
    Дата:        30 апреля 2002 г.
    ***************************************************** }
     
    unit FilterRegressionArraySeries;
     
    interface
     
    uses Math, TeEngine, Graphics, SysUtils, Dialogs;
     
    type
      TIntegerArray = array of integer;
    type
      TExIntegerArray = array of TIntegerArray;
    type
      TDoubleArray = array of double;
    type
      TExDoubleArray = array of TDoubleArray;
    type
      TStringArray = array of string;
    type
      TExStringArray = array of TStringArray;
     
    procedure ArrayExpanding(var ValueArray: TDoubleArray; ExpandCoef: integer);
    procedure ArrayLengthening(var ValueArray: TDoubleArray; SplitValue: integer);
    procedure ArrayShortening(var ValueArray: TDoubleArray; SplitValue: integer);
    procedure CubicSplineSmoothing(var ValueArray: TDoubleArray; Dsc: double;
      Coef: integer);
    procedure SevenPointNonLinearSmoothing(var ValueArray: TDoubleArray;
      Dsc: double; Coef: integer);
    procedure FourierAnalysis(var ValueArray: TDoubleArray; NumGarmonics: integer);
    procedure DoArraySmoothing(var ValueArray: TDoubleArray; FilterType: integer;
      Dsc: double; SplitCoef, ExpandCoef: integer;
      CycledFilter: boolean);
     
    procedure LinearRegression(ValueArray, ArgumentArray: TDoubleArray;
      SourceSeries, DestSeries: TChartSeries;
      var MainCoef, FreeCoef: double; SeriesColor: TColor;
      var Hint: string);
    procedure HyperbolicRegression(ValueArray, ArgumentArray: TDoubleArray;
      SourceSeries, DestSeries: TChartSeries;
      var MainCoef, FreeCoef: double;
      SeriesColor: TColor; var Hint: string);
    procedure PowerRegression(ValueArray, ArgumentArray: TDoubleArray;
      SourceSeries, DestSeries: TChartSeries;
      var MainCoef, FreeCoef: double; SeriesColor: TColor;
      var Hint: string);
    procedure PolynomialRegression(ValueArray, ArgumentArray: TDoubleArray;
      SourceSeries, DestSeries: TChartSeries;
      PolyDegree: integer; var ArrayCoefs: TDoubleArray;
      SeriesColor: TColor; var Hint: string);
    procedure ExponentRegression(ValueArray, ArgumentArray: TDoubleArray;
      SourceSeries, DestSeries: TChartSeries;
      var MainCoef, FreeCoef: double; SeriesColor: TColor;
      var Hint: string; Warning: boolean);
    procedure ExponentialRegression(ValueArray, ArgumentArray: TDoubleArray;
      SourceSeries, DestSeries: TChartSeries;
      var MainCoef, FreeCoef: double; SeriesColor: TColor;
      var Hint: string; Warning: boolean);
    procedure ExpPowerRegression(ValueArray, ArgumentArray: TDoubleArray;
      SourceSeries, DestSeries: TChartSeries;
      var MainCoef, FreeCoef: double; SeriesColor: TColor;
      var Hint: string; Warning: boolean);
     
    procedure CheckArrayBounds(var CArray: TDoubleArray; var FromPoint, ToPoint:
      integer);
    procedure CheckSeriesBounds(CSeries: TChartSeries; var FromPoint, ToPoint:
      integer);
    procedure ArrayFromArray(var SourceArray, DestArray: TDoubleArray;
      FromPoint, ToPoint, Discrete: integer; Derivative: boolean);
    procedure ArrayFromSeries(var ValueArray: TDoubleArray; DataSeries:
      TChartSeries;
      FromPoint, ToPoint, Discrete: integer; Derivative: boolean);
    procedure SeriesFromArray(var ValueArray: TDoubleArray; DataSeries:
      TChartSeries;
      FromPoint, ToPoint, Discrete: integer; Derivative: boolean);
    function DerivFromArray(var SourceArray: TDoubleArray; FromPoint, ToPoint,
      Discrete: integer; Extremum: string;
      var Position: integer): double;
    function DerivFromSeries(DataSeries: TChartSeries; FromPoint, ToPoint,
      Discrete: integer; Extremum: string;
      var Position: integer): double;
    function ValueFromSeries(DataSeries: TChartSeries; FromPoint, ToPoint: integer;
      Extremum: string; var Position: integer): double;
    function ValueFromArray(var SourceArray: TDoubleArray; FromPoint, ToPoint:
      integer;
      Extremum: string; var Position: integer): double;
    function CalculateAreaOfArray(var SourceArray: TDoubleArray;
      FromPoint, ToPoint, Method: integer;
      BindToZero: boolean): double;
    function CalculateAreaOfSeries(DataSeries: TChartSeries; FromPoint, ToPoint,
      Method: integer; BindToZero: boolean): double;
    procedure LinearTrendExclusion(var ValueArray: TDoubleArray);
     
    procedure ColorizeSeries(DataSeries: TChartSeries; NewColor: TColor);
    procedure SetXInterval(DataSeries: TChartSeries; XInterval: double);
    procedure SetSeriesAxis(DataSeries: TChartSeries; NewAxis: TVertAxis);
     
    var
      rv, rsmooth, smootha: TDoubleArray;
     
    implementation
     
    //Нелинейный фильтр по 7 точкам
     
    procedure SevenPointNonLinearSmoothing(var ValueArray: TDoubleArray;
      Dsc: double; Coef: integer);
    var
      j, k, i: integer;
      resv: array of array of double;
    begin
      if (Coef = 0) or (Coef = 1) then
        Exit;
      SetLength(resv, Coef, (Length(ValueArray) div Coef));
      for j := 0 to Coef - 1 do
        for i := 0 to Length(resv[0]) - 1 do
          resv[j][i] := ValueArray[i * Coef + j];
      for k := 0 to Coef - 1 do
        for j := 0 to Length(resv[0]) - 1 do
        begin
          if j = 0 then
            resv[k][j] := (39 * ValueArray[j * Coef + k] +
              8 * ValueArray[(j + 1) * Coef + k] - 4 * (ValueArray[(j + 2) * Coef +
                k] +
              ValueArray[(j + 3) * Coef + k] - ValueArray[(j + 4) * Coef + k]) +
              ValueArray[(j + 5) * Coef + k] - 2 * ValueArray[(j + 6) * Coef + k]) /
                42;
          if j = 1 then
            resv[k][j] := (8 * ValueArray[j * Coef + k] +
              19 * ValueArray[(j + 1) * Coef + k] + 16 * ValueArray[(j + 2) * Coef +
                k] +
              6 * ValueArray[(j + 3) * Coef + k] - 4 * ValueArray[(j + 4) * Coef + k]
                -
              7 * ValueArray[(j + 5) * Coef + k] + 4 * ValueArray[(j + 6) * Coef +
                k]) / 42;
          if j = 2 then
            resv[k][j] := (-4 * ValueArray[j * Coef + k] +
              16 * ValueArray[(j + 1) * Coef + k] + 19 * ValueArray[(j + 2) * Coef +
                k] +
              12 * ValueArray[(j + 3) * Coef + k] + 2 * ValueArray[(j + 4) * Coef +
                k] -
              4 * ValueArray[(j + 5) * Coef + k] + ValueArray[(j + 6) * Coef + k]) /
                42;
          if (j > 2) and (j < Length(resv[0]) - 3) then
            resv[k][j] :=
              (7 * ValueArray[j * Coef + k] + 6 * (ValueArray[(j - 1) * Coef + k] +
              ValueArray[(j + 1) * Coef + k]) + 3 * (ValueArray[(j - 2) * Coef + k]
                +
              ValueArray[(j + 2) * Coef + k]) - 2 * (ValueArray[(j - 3) * Coef + k]
                +
              ValueArray[(j + 3) * Coef + k])) / 21;
          if j = Length(resv[0]) - 3 then
            resv[k][j] := (-4 * ValueArray[j * Coef + k] +
              16 * ValueArray[(j - 1) * Coef + k] + 19 * ValueArray[(j - 2) * Coef +
                k] +
              12 * ValueArray[(j - 3) * Coef + k] + 2 * ValueArray[(j - 4) * Coef +
                k] -
              4 * ValueArray[(j - 5) * Coef + k] + ValueArray[(j - 6) * Coef + k]) /
                42;
          if j = Length(resv[0]) - 2 then
            resv[k][j] := (8 * ValueArray[j * Coef + k] +
              19 * ValueArray[(j - 1) * Coef + k] + 16 * ValueArray[(j - 2) * Coef +
                k] +
              6 * ValueArray[(j - 3) * Coef + k] - 4 * ValueArray[(j - 4) * Coef + k]
                -
              7 * ValueArray[(j - 5) * Coef + k] + 4 * ValueArray[(j - 6) * Coef +
                k]) / 42;
          if j = Length(resv[0]) - 1 then
            resv[k][j] := (39 * ValueArray[j * Coef + k] +
              8 * ValueArray[(j - 1) * Coef + k] - 4 * ValueArray[(j - 2) * Coef + k]
                -
              4 * ValueArray[(j - 3) * Coef + k] - 4 * ValueArray[(j - 4) * Coef + k]
                +
              ValueArray[(j - 5) * Coef + k] - 2 * ValueArray[(j - 6) * Coef + k]) /
                42;
        end;
      for j := Coef to Length(resv[0]) - Coef do
        for k := 0 to Coef - 1 do
          ValueArray[j * Coef + k] := resv[k][j];
    end;
     
    //Фильтр с кубическими сплайнами
     
    procedure CubicSplineSmoothing(var ValueArray: TDoubleArray; Dsc: double;
      Coef: integer);
    var
      j, k, i, N: integer;
      vresv, resv: array of array of double;
      maxv: array of double;
      av, h, mi, mj, v1, v2: double;
    begin
      if (Coef = 0) or (Coef = 1) then
        Exit;
      N := Length(ValueArray);
      SetLength(resv, Coef, N);
      h := Coef * Dsc;
      for k := 0 to Coef - 1 do
        for j := 0 to (N div Coef) - 2 do
        begin
          if j = 0 then
          begin
            mi := (4 * ValueArray[(j + 1) * Coef + k] -
              ValueArray[(j + 2) * Coef + k] - 3 * ValueArray[j * Coef + k]) / 2;
            mj := (ValueArray[(j + 2) * Coef + k] - ValueArray[j * Coef + k]) / 2;
          end;
          if j = (N div Coef) - 2 then
          begin
            mi := (ValueArray[(j + 1) * Coef + k] - ValueArray[(j - 1) * Coef + k])
              / 2;
            mj := (3 * ValueArray[(j + 1) * Coef + k] + ValueArray[(j - 1) * Coef +
              k] -
              4 * ValueArray[j * Coef + k]) / 2;
          end;
          if (j > 0) and (j < ((N div Coef) - 2)) then
          begin
            mi := (ValueArray[(j + 1) * Coef + k] - ValueArray[(j - 1) * Coef + k])
              / 2;
            mj := (ValueArray[(j + 2) * Coef + k] - ValueArray[j * Coef + k]) / 2;
          end;
          for i := j * Coef to (j + 1) * Coef do
          begin
            v1 := ((j + 1) * Coef + k) * Dsc - (i + k) * Dsc;
            v2 := (i + k) * Dsc - (j * Coef + k) * Dsc;
            resv[k][i + k] := (Sqr(v1) * (2 * v2 + h) * ValueArray[j * Coef + k] +
              Sqr(v2) * (2 * v1 + h) * ValueArray[(j + 1) * Coef + k] +
              (Sqr(v1) * v2 * mi + Sqr(v2) * (-v1) * mj) / 2) / h / h / h;
          end;
        end;
      for j := Coef to N - 1 - Coef do
      begin
        av := 0;
        for k := 0 to Coef - 1 do
          av := av + resv[k][j];
        av := av / Coef;
        ValueArray[j] := av;
      end;
    end;
     
    //Гармонический синтез Фурье
     
    procedure FourierAnalysis(var ValueArray: TDoubleArray; NumGarmonics: integer);
    var
      i, j, N: integer;
      yn, ap, bp: double;
      AFCoef, BFCoef: TDoubleArray;
    begin
      N := Length(ValueArray);
      SetLength(AFCoef, NumGarmonics);
      SetLength(BFCoef, NumGarmonics);
      AFCoef[0] := Sum(ValueArray) / N;
      BFCoef[0] := 0;
      for i := 1 to NumGarmonics - 1 do
      begin
        AFCoef[i] := 0;
        BFCoef[i] := 0;
        for j := 0 to N - 1 do
        begin
          AFCoef[i] := AFCoef[i] + ValueArray[j] * cos(Pi * i * j * 2 / N);
          BFCoef[i] := BFCoef[i] + ValueArray[j] * sin(Pi * i * j * 2 / N);
        end;
        AFCoef[i] := AFCoef[i] * 2 / N;
        BFCoef[i] := BFCoef[i] * 2 / N;
      end;
      for j := 0 to N - 1 do
      begin
        yn := 0;
        ap := 0;
        bp := 0;
        for i := 1 to NumGarmonics - 1 do
        begin
          ap := ap + AFCoef[i] * cos(2 * Pi * i * (j / N));
          bp := bp + BFCoef[i] * sin(2 * Pi * i * (j / N));
        end;
        yn := AFCoef[0] + ap + bp;
        ValueArray[j] := yn;
      end;
    end;
     
    //Общая процедура вызова нужного фильтра
     
    procedure DoArraySmoothing(var ValueArray: TDoubleArray; FilterType: integer;
      Dsc: double; SplitCoef, ExpandCoef: integer; CycledFilter: boolean);
    var
      j: integer;
    begin
      smoothA := nil;
      rsmooth := ValueArray;
      ArrayExpanding(rsmooth, ExpandCoef);
      ArrayLengthening(smoothA, SplitCoef);
      if FilterType = 1 then
        if CycledFilter then
          for j := 2 to SplitCoef do
            SevenPointNonLinearSmoothing(smoothA, Dsc, j)
        else
          SevenPointNonLinearSmoothing(smoothA, Dsc, SplitCoef);
      if FilterType = 2 then
        CubicSplineSmoothing(smoothA, Dsc, SplitCoef);
      ArrayShortening(smoothA, SplitCoef);
      ValueArray := smoothA;
    end;
     
    //Расширение массива заданным числом точек справа и слева
     
    procedure ArrayLengthening(var ValueArray: TDoubleArray; SplitValue: integer);
    var
      sv, N, i: integer;
      bv, ev: double;
    begin
      N := Length(ValueArray);
      sv := 10 * SplitValue;
      bv := 0;
      ev := 0;
      for i := 0 to 9 do
        bv := bv + ValueArray[i];
      bv := bv / 10;
      for i := N - 1 downto N - 10 do
        ev := ev + ValueArray[i];
      ev := ev / 10;
      SetLength(ValueArray, N + sv);
      for i := N - 1 downto 0 do
        ValueArray[i + trunc(sv / 2)] := ValueArray[i];
      for i := trunc(sv / 2) - 1 downto 0 do
        ValueArray[i] := bv;
      for i := N + trunc(sv / 2) to N + sv - 1 do
        ValueArray[i] := ev;
    end;
     
    //Сокращение массива заданным числом точек справа и слева
     
    procedure ArrayShortening(var ValueArray: TDoubleArray; SplitValue: integer);
    var
      sv, N, i: integer;
    begin
      N := Length(ValueArray);
      sv := 10 * SplitValue;
      for i := 0 to N - sv - 1 do
        ValueArray[i] := ValueArray[i + trunc(sv / 2)];
      SetLength(ValueArray, N - sv);
    end;
     
    //Расширение массива заданным числом точек между 2-мя соседними
     
    procedure ArrayExpanding(var ValueArray: TDoubleArray; ExpandCoef: integer);
    var
      i, k, N, sub: integer;
      diap: double;
    begin
      N := Length(ValueArray);
      sub := ExpandCoef - 1;
      SetLength(smoothA, N * ExpandCoef - sub);
      for i := 0 to N - 1 do
      begin
        smoothA[i * ExpandCoef] := ValueArray[i];
        if i <> 0 then
        begin
          diap := (smoothA[i * ExpandCoef] - smoothA[(i - 1) * ExpandCoef]);
          for k := 0 to ExpandCoef - 1 do
            smoothA[(i - 1) * ExpandCoef + k] :=
              smoothA[(i - 1) * ExpandCoef] + diap * (k / ExpandCoef);
        end;
      end;
    end;
     
    //Линейная регрессия
     
    procedure LinearRegression(ValueArray, ArgumentArray: TDoubleArray;
      SourceSeries,
      DestSeries: TChartSeries; var MainCoef, FreeCoef: double;
      SeriesColor: TColor; var Hint: string);
    var
      b0, b1, xsum, ysum, pxy, xsqua: double;
      y, x: array of double;
      i, N: integer;
      s: string;
    begin
      if ValueArray <> nil then
        N := Length(ValueArray)
      else
        N := SourceSeries.XValues.Count;
      pxy := 0;
      xsqua := 0;
      SetLength(x, N);
      SetLength(y, N);
      for i := 0 to N - 1 do
      begin
        if ValueArray <> nil then
        begin
          y[i] := ValueArray[i];
          x[i] := ArgumentArray[i];
        end
        else
        begin
          y[i] := SourceSeries.YValues.Value[i];
          x[i] := SourceSeries.XValues.Value[i];
        end;
        pxy := pxy + x[i] * y[i];
        xsqua := xsqua + x[i] * x[i];
      end;
      xsum := Sum(x);
      ysum := Sum(y);
      b1 := (xsum * ysum - N * pxy) / (xsum * xsum - N * xsqua);
      b0 := (ysum - b1 * xsum) / N;
      MainCoef := b1;
      FreeCoef := b0;
      if DestSeries <> nil then
        for i := 0 to N - 1 do
          if ValueArray <> nil then
            DestSeries.AddXY(ArgumentArray[i],
              b1 * ArgumentArray[i] + b0, '', SeriesColor)
          else
            DestSeries.AddXY(SourceSeries.XValues.Value[i],
              b1 * SourceSeries.XValues.Value[i] + b0, '', SeriesColor);
      if b0 < 0 then
        s := ''
      else
        s := '+ ';
      Hint := Format('%0.3f', [b1]) + '*X ' + s + Format('%0.3f', [b0]);
      x := nil;
      y := nil;
    end;
     
    //Гиперболическая регрессия
     
    procedure HyperbolicRegression(ValueArray, ArgumentArray: TDoubleArray;
      SourceSeries, DestSeries: TChartSeries; var MainCoef, FreeCoef: double;
      SeriesColor: TColor; var Hint: string);
    var
      b0, b1, ax, ysum, axsqua, dxy: double;
      y, x: array of double;
      i, N: integer;
      s: string;
    begin
      if ValueArray <> nil then
        N := Length(ValueArray)
      else
        N := SourceSeries.XValues.Count;
      axsqua := 0;
      ax := 0;
      dxy := 0;
      SetLength(x, N);
      SetLength(y, N);
      for i := 0 to N - 1 do
      begin
        if ValueArray <> nil then
        begin
          y[i] := ValueArray[i];
          x[i] := ArgumentArray[i];
        end
        else
        begin
          y[i] := SourceSeries.YValues.Value[i];
          x[i] := SourceSeries.XValues.Value[i];
        end;
        if x[i] = 0 then
        begin
          MessageDlg('Hyperbolic regression inapplicable...',
            mtWarning, [mbOk], 0);
          Hint := 'No equation';
          MainCoef := 0;
          FreeCoef := 0;
          Exit;
        end;
        dxy := dxy + y[i] / x[i];
        ax := ax + 1 / x[i];
        axsqua := axsqua + 1 / (x[i] * x[i]);
      end;
      ysum := Sum(y);
      b1 := (dxy - (ysum * ax) / N) / (axsqua - (ax * ax) / N);
      b0 := (ysum - b1 * ax) / N;
      MainCoef := b1;
      FreeCoef := b0;
      if DestSeries <> nil then
        for i := 0 to N - 1 do
          if ValueArray <> nil then
            DestSeries.AddXY(ArgumentArray[i],
              b1 / ArgumentArray[i] + b0, '', SeriesColor)
          else
            DestSeries.AddXY(SourceSeries.XValues.Value[i],
              b1 / SourceSeries.XValues.Value[i] + b0, '', SeriesColor);
      if b0 < 0 then
        s := ''
      else
        s := '+ ';
      Hint := Format('%0.3f', [b1]) + '/X ' + s + Format('%0.3f', [b0]);
      x := nil;
      y := nil;
    end;
     
    //Степенная регрессия
     
    procedure PowerRegression(ValueArray, ArgumentArray: TDoubleArray;
      SourceSeries, DestSeries: TChartSeries; var MainCoef, FreeCoef: double;
      SeriesColor: TColor; var Hint: string);
    var
      b0, b1, lnx, lny, xlnsqua, plnxy: double;
      y, x: array of double;
      i, N: integer;
    begin
      if ValueArray <> nil then
        N := Length(ValueArray)
      else
        N := SourceSeries.XValues.Count;
      lnx := 0;
      lny := 0;
      xlnsqua := 0;
      plnxy := 0;
      SetLength(x, N);
      SetLength(y, N);
      for i := 0 to N - 1 do
      begin
        if ValueArray <> nil then
        begin
          y[i] := ValueArray[i];
          x[i] := ArgumentArray[i];
        end
        else
        begin
          y[i] := SourceSeries.YValues.Value[i];
          x[i] := SourceSeries.XValues.Value[i];
        end;
        if (x[i] <= 0) or (y[i] <= 0) then
        begin
          MessageDlg('Power regression inapplicable...', mtWarning, [mbOk], 0);
          Hint := 'No equation';
          MainCoef := 0;
          FreeCoef := 0;
          Exit;
        end;
        lnx := lnx + ln(x[i]);
        lny := lny + ln(y[i]);
        plnxy := plnxy + ln(x[i]) * ln(y[i]);
        xlnsqua := xlnsqua + ln(x[i]) * ln(x[i]);
      end;
      b1 := (lnx * lny - N * plnxy) / (lnx * lnx - N * xlnsqua);
      b0 := exp((lny - b1 * lnx) / N);
      MainCoef := b1;
      FreeCoef := b0;
      if DestSeries <> nil then
        for i := 0 to N - 1 do
          if ValueArray <> nil then
            DestSeries.AddXY(ArgumentArray[i],
              Power(ArgumentArray[i], b1) * b0, '', SeriesColor)
          else
            DestSeries.AddXY(SourceSeries.XValues.Value[i],
              Power(SourceSeries.XValues.Value[i], b1) * b0, '', SeriesColor);
      Hint := Format('%0.3f', [b0]) + '*X^' + Format('%0.3f', [b1]);
      x := nil;
      y := nil;
    end;
     
    //Полиномиальная регрессия
     
    procedure PolynomialRegression(ValueArray, ArgumentArray: TDoubleArray;
      SourceSeries, DestSeries: TChartSeries; PolyDegree: integer;
      var ArrayCoefs: TDoubleArray; SeriesColor: TColor; var Hint: string);
    var
      bcoef, dcoef: TDoubleArray;
      ccoef: array of TDoubleArray;
      i, j, k, N: integer;
      polynom: double;
    begin
      if ValueArray <> nil then
        N := Length(ValueArray)
      else
        N := SourceSeries.XValues.Count;
      Hint := '';
      ArrayCoefs := nil;
      SetLength(ccoef, PolyDegree + 1);
      for i := 0 to Length(ccoef) - 1 do
        SetLength(ccoef[i], PolyDegree + 1);
      SetLength(dcoef, PolyDegree + 1);
      SetLength(bcoef, PolyDegree + 1);
      for i := 0 to Length(dcoef) - 1 do
      begin
        dcoef[i] := 0;
        for j := 0 to N - 1 do
        begin
          if ValueArray <> nil then
            dcoef[i] := dcoef[i] +
              Power(ArgumentArray[j], i) * ValueArray[j]
            else
            dcoef[i] := dcoef[i] + Power(SourceSeries.XValues.Value[j], i) *
              SourceSeries.YValues.Value[j];
        end;
        for j := 0 to Length(ccoef) - 1 do
        begin
          ccoef[i][j] := 0;
          for k := 0 to N - 1 do
          begin
            if ValueArray <> nil then
              ccoef[i][j] :=
                ccoef[i][j] + Power(ArgumentArray[k], i + j)
              else
              ccoef[i][j] := ccoef[i][j] + Power(SourceSeries.XValues.Value[k], i +
                j);
          end;
        end;
      end;
      for i := 0 to Length(ccoef) - 2 do
        for j := i + 1 to Length(ccoef) - 1 do
        begin
          ccoef[j][i] := -ccoef[j][i] / ccoef[i][i];
          dcoef[j] := dcoef[j] + ccoef[j][i] * dcoef[i];
          for k := i + 1 to Length(ccoef) - 1 do
            ccoef[j][k] := ccoef[j][k] + ccoef[j][i] * ccoef[i][k];
        end;
      bcoef[Length(bcoef) - 1] := dcoef[Length(dcoef) - 1] /
        ccoef[Length(bcoef) - 1][Length(bcoef) - 1];
      for i := Length(ccoef) - 2 downto 0 do
      begin
        for j := i + 1 to Length(ccoef) - 1 do
          bcoef[i] := bcoef[i] + bcoef[j] * ccoef[i][j];
        bcoef[i] := (dcoef[i] - bcoef[i]) / ccoef[i][i];
      end;
      SetLength(ArrayCoefs, Length(bcoef));
      for i := 0 to Length(bcoef) - 1 do
        ArrayCoefs[i] := bcoef[i];
      if DestSeries <> nil then
        for i := 0 to N - 1 do
        begin
          polynom := 0;
          if ValueArray <> nil then
          begin
            for j := 0 to PolyDegree do
              polynom := polynom + bcoef[j] * Power(ArgumentArray[i], j);
            DestSeries.AddXY(ArgumentArray[i], polynom, '', SeriesColor);
          end
          else
          begin
            for j := 0 to PolyDegree do
              polynom := polynom +
                bcoef[j] * Power(SourceSeries.XValues.Value[i], j);
            DestSeries.AddXY(SourceSeries.XValues.Value[i],
              polynom, '', SeriesColor);
          end;
        end;
      for j := PolyDegree downto 0 do
        Hint := Hint + Format('%0.3f', [bcoef[j]]) + '*X^' + IntToStr(j);
      dcoef := nil;
      bcoef := nil;
      ccoef := nil;
    end;
     
    //Показательная регрессия
     
    procedure ExponentRegression(ValueArray, ArgumentArray: TDoubleArray;
      SourceSeries, DestSeries: TChartSeries; var MainCoef, FreeCoef: double;
      SeriesColor: TColor; var Hint: string; Warning: boolean);
    var
      i, N: integer;
      x, y: array of double;
      lgy, xsum, xsqua, a, b, lga, xlgy, lgb: double;
    begin
      if ValueArray <> nil then
        N := Length(ValueArray)
      else
        N := SourceSeries.XValues.Count;
      lgy := 0;
      xsqua := 0;
      xlgy := 0;
      SetLength(x, N);
      SetLength(y, N);
      for i := 0 to N - 1 do
      begin
        if ValueArray <> nil then
        begin
          y[i] := ValueArray[i];
          x[i] := ArgumentArray[i];
        end
        else
        begin
          y[i] := SourceSeries.YValues.Value[i];
          x[i] := SourceSeries.XValues.Value[i];
        end;
        if y[i] <= 0 then
        begin
          if Warning then
            MessageDlg('Exponent regression inapplicable',
              mtWarning, [mbOk], 0);
          Hint := 'No equation';
          MainCoef := 0;
          FreeCoef := 0;
          Exit;
        end;
        lgy := lgy + Log10(y[i]);
        xsqua := xsqua + x[i] * x[i];
        xlgy := xlgy + x[i] * Log10(y[i]);
      end;
      xsum := Sum(x);
      lgb := (xlgy - (lgy * xsum) / N) / (xsqua - (xsum * xsum) / N);
      lga := (lgy - lgb * xsum) / N;
      b := Power(10, lgb);
      a := Power(10, lga);
      MainCoef := b;
      FreeCoef := a;
      if DestSeries <> nil then
        for i := 0 to N - 1 do
          if ValueArray <> nil then
            DestSeries.AddXY(ArgumentArray[i],
              a * Power(b, ArgumentArray[i]), '', SeriesColor)
          else
            DestSeries.AddXY(SourceSeries.XValues.Value[i],
              a * Power(b, SourceSeries.XValues.Value[i]), '', SeriesColor);
      Hint := 'Exponent regression equation: Y = ' +
        Format('%0.5f', [a]) + ' * (' + Format('%0.5f', [b]) + ' ^ X)';
      x := nil;
      y := nil;
    end;
     
    //Экспоненциальная регрессия
     
    procedure ExponentialRegression(ValueArray, ArgumentArray: TDoubleArray;
      SourceSeries, DestSeries: TChartSeries; var MainCoef, FreeCoef: double;
      SeriesColor: TColor; var Hint: string; Warning: boolean);
    var
      i, N: integer;
      x, y: array of double;
      lny, xsum, xsqua, xlny, b0, b1: double;
    begin
      MainCoef := 0;
      FreeCoef := 0;
      if ValueArray <> nil then
        N := Length(ValueArray)
      else
        N := SourceSeries.XValues.Count;
      lny := 0;
      xsqua := 0;
      xlny := 0;
      SetLength(x, N);
      SetLength(y, N);
      for i := 0 to N - 1 do
      begin
        if ValueArray <> nil then
        begin
          y[i] := ValueArray[i];
          x[i] := ArgumentArray[i];
        end
        else
        begin
          y[i] := SourceSeries.YValues.Value[i];
          x[i] := SourceSeries.XValues.Value[i];
        end;
        if y[i] <= 0 then
        begin
          if Warning then
            MessageDlg('Exponential regression inapplicable',
              mtWarning, [mbOk], 0);
          Hint := 'No equation';
          MainCoef := 0;
          FreeCoef := 0;
          Exit;
        end;
        lny := lny + Ln(y[i]);
        xsqua := xsqua + x[i] * x[i];
        xlny := xlny + x[i] * Ln(y[i]);
      end;
      xsum := Sum(x);
      b1 := (xsum * lny - N * xlny) / (xsum * xsum - N * xsqua);
      b0 := exp((lny - b1 * xsum) / N);
      MainCoef := b1;
      FreeCoef := b0;
      if DestSeries <> nil then
        for i := 0 to N - 1 do
          if ValueArray <> nil then
            DestSeries.AddXY(ArgumentArray[i],
              b0 * Exp(b1 * ArgumentArray[i]), '', SeriesColor)
          else
            DestSeries.AddXY(SourceSeries.XValues.Value[i],
              b0 * Exp(b1 * SourceSeries.XValues.Value[i]), '', SeriesColor);
      Hint := 'Exponential regression equation: Y = ' +
        Format('%0.5f', [b0]) + ' * exp(' + Format('%0.5f', [b1]) + ' * X)';
      x := nil;
      y := nil;
    end;
     
    //Степенно-экспоненциальная регрессия
     
    procedure ExpPowerRegression(ValueArray, ArgumentArray: TDoubleArray;
      SourceSeries, DestSeries: TChartSeries; var MainCoef, FreeCoef: double;
      SeriesColor: TColor; var Hint: string; Warning: boolean);
    var
      i, N: integer;
      x, y: array of double;
      matr: array[0..3] of double;
      lny, xsum, xsqua, xlny, b0, b1: double;
    begin
      MainCoef := 0;
      FreeCoef := 0;
      if ValueArray <> nil then
        N := Length(ValueArray)
      else
        N := SourceSeries.XValues.Count;
      lny := 0;
      xsqua := 0;
      xlny := 0;
      SetLength(x, N);
      SetLength(y, N);
      for i := 0 to N - 1 do
      begin
        if ValueArray <> nil then
        begin
          y[i] := ValueArray[i];
          x[i] := ArgumentArray[i];
        end
        else
        begin
          y[i] := SourceSeries.YValues.Value[i];
          x[i] := SourceSeries.XValues.Value[i];
        end;
        if y[i] <= 0 then
        begin
          if Warning then
            MessageDlg('Exponent-Power regression inapplicable',
              mtWarning, [mbOk], 0);
          Hint := 'No equation';
          MainCoef := 0;
          FreeCoef := 0;
          Exit;
        end;
        lny := lny + Ln(y[i]);
        xsqua := xsqua + x[i] * x[i];
        xlny := xlny + x[i] * Ln(y[i]);
      end;
      xsum := Sum(x);
      b1 := (xsum * lny - N * xlny) / (xsum * xsum - N * xsqua);
      b0 := exp((lny - b1 * xsum) / N);
      MainCoef := b1;
      FreeCoef := b0;
      if DestSeries <> nil then
        for i := 0 to N - 1 do
          if ValueArray <> nil then
            DestSeries.AddXY(ArgumentArray[i],
              b0 * Exp(b1 * ArgumentArray[i]), '', SeriesColor)
          else
            DestSeries.AddXY(SourceSeries.XValues.Value[i],
              b0 * Exp(b1 * SourceSeries.XValues.Value[i]), '', SeriesColor);
      Hint := 'Exponent-Power regression equation: Y = ' +
        Format('%0.5f', [b0]) + ' * exp(' + Format('%0.5f', [b1]) + ' * X)';
      x := nil;
      y := nil;
    end;
     
    //Общая процедура проверки массива
     
    procedure CheckArrayBounds(var CArray: TDoubleArray; var FromPoint, ToPoint:
      integer);
    begin
      if FromPoint < 0 then
        FromPoint := 0;
      if (ToPoint <= 0) or (ToPoint > Length(CArray) - 1) then
        ToPoint := Length(CArray) - 1;
      if FromPoint > ToPoint then
        ToPoint := FromPoint;
    end;
     
    //Общая процедура проверки серии
     
    procedure CheckSeriesBounds(CSeries: TChartSeries; var FromPoint, ToPoint:
      integer);
    begin
      if FromPoint < 0 then
        FromPoint := 0;
      if (ToPoint <= 0) or (ToPoint > CSeries.XValues.Count - 1) then
        ToPoint := CSeries.XValues.Count - 1;
      if FromPoint > ToPoint then
        ToPoint := FromPoint;
    end;
     
    //Извлечение массива из массива
     
    procedure ArrayFromArray(var SourceArray, DestArray: TDoubleArray;
      FromPoint, ToPoint, Discrete: integer; Derivative: boolean);
    var
      i: integer;
    begin
      DestArray := nil;
      if SourceArray = nil then
        DestArray := nil
      else
      begin
        CheckArrayBounds(SourceArray, FromPoint, ToPoint);
        if Discrete = 0 then
          Discrete := 1;
        if Derivative = false then
        begin
          SetLength(DestArray, ((ToPoint - FromPoint) div Discrete) + 1);
          for i := 0 to Length(DestArray) - 1 do
            DestArray[i] :=
              SourceArray[i * Discrete + FromPoint];
        end
        else
        begin
          SetLength(DestArray, ((ToPoint - FromPoint) div Discrete));
          for i := 1 to Length(DestArray) do
            DestArray[i - 1] :=
              (SourceArray[i * Discrete + FromPoint] -
              SourceArray[i * Discrete + FromPoint - 1]) / Discrete;
        end;
      end;
    end;
     
    //Извлечение массива из серии
     
    procedure ArrayFromSeries(var ValueArray: TDoubleArray; DataSeries:
      TChartSeries;
      FromPoint, ToPoint, Discrete: integer; Derivative: boolean);
    var
      i: integer;
    begin
      if DataSeries = nil then
        ValueArray := nil
      else
        with DataSeries do
        begin
          CheckSeriesBounds(DataSeries, FromPoint, ToPoint);
          if Discrete = 0 then
            Discrete := 1;
          if Derivative = false then
          begin
            SetLength(ValueArray, ((ToPoint - FromPoint) div Discrete) + 1);
            for i := 0 to Length(ValueArray) - 1 do
              ValueArray[i] :=
                YValues.Value[i * Discrete + FromPoint];
          end
          else
          begin
            SetLength(ValueArray, ((ToPoint - FromPoint) div Discrete));
            for i := 1 to Length(ValueArray) do
              ValueArray[i - 1] :=
                (YValues.Value[i * Discrete + FromPoint] - YValues.Value[i * Discrete
                  + FromPoint - 1]) /
                (XValues.Value[i * Discrete + FromPoint] -
                XValues.Value[i * Discrete + FromPoint - 1]);
          end;
        end;
    end;
     
    //Извлечение серии из массива
     
    procedure SeriesFromArray(var ValueArray: TDoubleArray; DataSeries:
      TChartSeries;
      FromPoint, ToPoint, Discrete: integer; Derivative: boolean);
    var
      i, n: integer;
    begin
      if DataSeries = nil then
        Exit
      else
        with DataSeries do
        begin
          Clear;
          CheckArrayBounds(ValueArray, FromPoint, ToPoint);
          if Discrete = 0 then
            Discrete := 1;
          if Derivative = false then
          begin
            n := ((ToPoint - FromPoint) div Discrete) + 1;
            for i := 0 to n - 1 do
              DataSeries.AddXY(i, ValueArray[i * Discrete + FromPoint],
                '', DataSeries.SeriesColor);
          end
          else
          begin
            n := (ToPoint - FromPoint) div Discrete;
            for i := 1 to n do
              DataSeries.AddXY(i - 1, (ValueArray[i * Discrete + FromPoint] -
                ValueArray[i * Discrete + FromPoint - 1]) / Discrete,
                '', DataSeries.SeriesColor);
          end;
        end;
    end;
     
    //Извлечение производной из массива
     
    function DerivFromArray(var SourceArray: TDoubleArray; FromPoint, ToPoint,
      Discrete: integer; Extremum: string; var Position: integer): double;
    var
      i: integer;
      d: double;
    begin
      DerivFromArray := 0;
      if SourceArray = nil then
        DerivFromArray := 0
      else
      begin
        CheckArrayBounds(SourceArray, FromPoint, ToPoint);
        if Discrete = 0 then
          Discrete := 1;
        SetLength(rv, (ToPoint - FromPoint) div Discrete);
        for i := 1 to Length(rv) do
          rv[i - 1] := (SourceArray[i * Discrete + FromPoint] -
            SourceArray[i * Discrete + FromPoint - 1]) / Discrete;
        if Extremum = 'max' then
          d := MaxValue(rv);
        if Extremum = 'min' then
          d := MinValue(rv);
        if Extremum = 'mean' then
          d := Mean(rv);
        for i := 0 to Length(rv) - 1 do
          if rv[i] = d then
          begin
            Position := i;
            break;
          end;
        DerivFromArray := d;
      end;
    end;
     
    //Извлечение производной из серии
     
    function DerivFromSeries(DataSeries: TChartSeries; FromPoint, ToPoint,
      Discrete: integer; Extremum: string; var Position: integer): double;
    var
      i: integer;
      d: double;
    begin
      DerivFromSeries := 0;
      if DataSeries = nil then
        DerivFromSeries := 0
      else
        with DataSeries do
        begin
          CheckSeriesBounds(DataSeries, FromPoint, ToPoint);
          if Discrete = 0 then
            Discrete := 1;
          SetLength(rv, (ToPoint - FromPoint) div Discrete);
          for i := 1 to Length(rv) do
            rv[i - 1] := (YValues.Value[i * Discrete + FromPoint] -
              YValues.Value[i * Discrete + FromPoint - 1]) / (XValues.Value[i *
                Discrete + FromPoint] -
              XValues.Value[i * Discrete + FromPoint - 1]);
          if Extremum = 'max' then
            d := MaxValue(rv);
          if Extremum = 'min' then
            d := MinValue(rv);
          if Extremum = 'mean' then
            d := Mean(rv);
          for i := 0 to Length(rv) - 1 do
            if rv[i] = d then
            begin
              Position := i;
              break;
            end;
          DerivFromSeries := d;
        end;
    end;
     
    //Извлечение величины из серии
     
    function ValueFromSeries(DataSeries: TChartSeries; FromPoint, ToPoint: integer;
      Extremum: string; var Position: integer): double;
    var
      i: integer;
      d: double;
    begin
      if DataSeries = nil then
        ValueFromSeries := 0
      else
        with DataSeries do
        begin
          CheckSeriesBounds(DataSeries, FromPoint, ToPoint);
          SetLength(rv, ToPoint - FromPoint);
          for i := 0 to Length(rv) - 1 do
            rv[i] := YValues.Value[FromPoint + i];
          if Extremum = 'max' then
            d := MaxValue(rv);
          if Extremum = 'min' then
            d := MinValue(rv);
          if Extremum = 'mean' then
            d := Mean(rv);
          for i := 0 to Length(rv) - 1 do
            if rv[i] = d then
            begin
              Position := i;
              break;
            end;
          ValueFromSeries := d;
        end;
    end;
     
    //Извлечение величины из массива
     
    function ValueFromArray(var SourceArray: TDoubleArray; FromPoint,
      ToPoint: integer; Extremum: string; var Position: integer): double;
    var
      i: integer;
      d: double;
    begin
      if SourceArray = nil then
        ValueFromArray := 0
      else
      begin
        CheckArrayBounds(SourceArray, FromPoint, ToPoint);
        SetLength(rv, ToPoint - FromPoint);
        for i := 0 to Length(rv) - 1 do
          rv[i] := SourceArray[FromPoint + i];
        if Extremum = 'max' then
          d := MaxValue(rv);
        if Extremum = 'min' then
          d := MinValue(rv);
        if Extremum = 'mean' then
          d := Mean(rv);
        for i := 0 to Length(rv) - 1 do
          if rv[i] = d then
          begin
            Position := i;
            break;
          end;
        ValueFromArray := d;
      end;
    end;
     
    //Вычисление площади под кривой, получаемой данными из массива
     
    function CalculateAreaOfArray(var SourceArray: TDoubleArray;
      FromPoint, ToPoint, Method: integer; BindToZero: boolean): double;
    var
      i: integer;
      sq, subv: double;
    begin
      if SourceArray = nil then
        CalculateAreaOfArray := 0
      else
      begin
        CheckArrayBounds(SourceArray, FromPoint, ToPoint);
        sq := 0;
        if BindToZero then
          subv :=
            (SourceArray[ToPoint] + SourceArray[FromPoint]) / 2
          else
          subv := 0;
        for i := FromPoint to ToPoint - 1 do
        begin
          if Method = 1 then
            sq := sq + Abs(SourceArray[i] - subv) +
              (Abs(SourceArray[i + 1] - subv) - Abs(SourceArray[i] - subv)) / 2;
          if Method = 2 then
            sq := sq + Abs(SourceArray[i] - subv) +
              (Abs(SourceArray[i + 1] - subv) - Abs(SourceArray[i] - subv)) / 2 - 1
                / (48 * Power(0.5, 1.5));
          if Method = 3 then
            if (i mod 2) = 1 then
              sq := sq + 2 * Abs(SourceArray[i] - subv);
          if Method = 4 then
            if (i mod 2) = 1 then
              sq := sq + 2 * Abs(SourceArray[i] - subv) - 1 / (96 * Power(0.5,
                1.5));
        end;
        CalculateAreaOfArray := sq;
      end;
    end;
     
    //Вычисление площади под кривой, получаемой данными из серии
     
    function CalculateAreaOfSeries(DataSeries: TChartSeries; FromPoint, ToPoint,
      Method: integer; BindToZero: boolean): double;
    var
      i: integer;
      sq, subv: double;
    begin
      if DataSeries = nil then
        CalculateAreaOfSeries := 0
      else
        with DataSeries do
        begin
          CheckSeriesBounds(DataSeries, FromPoint, ToPoint);
          sq := 0;
          if BindToZero then
            subv := (YValues.Value[ToPoint] +
              YValues.Value[FromPoint]) / 2
          else
            subv := 0;
          for i := FromPoint to ToPoint - 1 do
          begin
            if Method = 1 then
              sq := sq + Abs(YValues.Value[i] - subv) +
                (Abs(YValues.Value[i + 1] - subv) - Abs(YValues.Value[i] - subv)) /
                  2;
            if Method = 2 then
              sq := sq + Abs(YValues.Value[i] - subv) +
                (Abs(YValues.Value[i + 1] - subv) -
                Abs(YValues.Value[i] - subv)) / 2 - 1 / (48 * Power(0.5, 1.5));
            if Method = 3 then
              if (i mod 2) = 1 then
                sq := sq + 2 * Abs(YValues.Value[i] - subv);
            if Method = 4 then
              if (i mod 2) = 1 then
                sq := sq + 2 * Abs(YValues.Value[i] - subv) - 1 / (96 * Power(0.5,
                  1.5));
          end;
          CalculateAreaOfSeries := sq;
        end;
    end;
     
    //Исключение линейной составляющей
     
    procedure LinearTrendExclusion(var ValueArray: TDoubleArray);
    var
      i, N: integer;
      b0, b1, nx: double;
    begin
      N := Length(ValueArray);
      nx := 0;
      for i := 0 to N - 1 do
        nx := nx + (i + 1) * ValueArray[i];
      b0 := (2 * (2 * N + 1) * Sum(ValueArray) - 6 * nx) / (N * (N - 1));
      b1 := (12 * nx - 6 * (N + 1) * Sum(ValueArray)) / (N * (N - 1) * (N + 1));
      for i := 0 to N - 1 do
      begin
        ValueArray[i] := ValueArray[i] - (i * b1);
      end;
    end;
     
    //Расцветка серии
     
    procedure ColorizeSeries(DataSeries: TChartSeries; NewColor: TColor);
    var
      i: integer;
    begin
      for i := 0 to DataSeries.XValues.Count - 1 do
        DataSeries.ValueColor[i] := NewColor;
    end;
     
    //Задание нового приращения по оси X
     
    procedure SetXInterval(DataSeries: TChartSeries; XInterval: double);
    var
      i: integer;
    begin
      for i := 0 to DataSeries.XValues.Count - 1 do
        DataSeries.XValues.Value[i] := DataSeries.XValues.Value[i] * XInterval;
    end;
     
    //Привязка серии к новой оси
     
    procedure SetSeriesAxis(DataSeries: TChartSeries; NewAxis: TVertAxis);
    begin
      DataSeries.VertAxis := NewAxis;
    end;
     
    end.
