---
Title: Генетические алгоритмы
Author: Mystic, mystic2000@newmail.ru
Date: 25.04.2002
---


Генетические алгоритмы
======================

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Генетические алгоритмы
     
    Класс, реализующий генетический алгоритм.
     
    Зависимости: Classes, SysUtils, Windows, Math
    Автор:       Mystic, mystic2000@newmail.ru, ICQ:125905046, Харьков
    Copyright:   Mystic
    Дата:        25 апреля 2002 г.
    ********************************************** }
     
    unit Genes;
     
    interface
     
    uses {Fuzzy,} Classes, SysUtils, Windows, Math;
     
    type
      TGeneAlgorithm = class;
      TExtendedArray = array of Extended;
     
      TEstimateEvent = procedure (Sender: TObject; const X: TExtendedArray; var Y: Extended) of object;
      TIterationEvent = procedure (Sender: TObject; Iteration: Integer);
      TBestChangeEvent = procedure (Sender: TObject; BestEstimate: Extended);
     
      EGeneError = class(Exception) end;
     
      TCardinalArray = array of Cardinal;
      TGeneRecord = record
        Bits: TCardinalArray;
        Values: TExtendedArray;
        Estimate: Extended;
      end;
      TGeneRecords = array of TGeneRecord;
     
      TSolutionThread = class(TThread)
      private
        FOwner: TGeneAlgorithm;
      protected
        procedure Execute; override;
        property Owner: TGeneAlgorithm read FOwner;
      public
        constructor Create(AOwner: TGeneAlgorithm);
      end;
     
      TGeneState = (gsExecute, gsSuspend, gsTune);
     
      TGeneAlgorithm = class
      private
        FData: array of TGeneRecord; // Algorithm data
        FLock: TRTLCriticalSection;
        FLowValues: TExtendedArray;
        FHighValues: TExtendedArray;
        FSolutionThread: TSolutionThread;
        FMutation: Extended;
        FInversion: Extended;
        FCrossover: Extended;
        FMaxPopulation: Integer;
        FBitPerNumber: Integer;
        FMinPopulation: Integer;
        FDimCount: Integer;
        FOnBestChange: TBestChangeEvent;
        FOnEstimate: TEstimateEvent;
        FOnIteration: TIterationEvent;
        FIteration: Integer;
    // FBestEstimate: Extended;
        FState: TGeneState;
     
        BitSize: Integer;
     
        function GetBestEstimate: Extended;
        function GetHighValues(I: Integer): Extended;
        function GetIteration: Integer;
        function GetLowValues(I: Integer): Extended;
        procedure SetBitPerNumber(const Value: Integer);
        procedure SetCrossover(const Value: Extended);
        procedure SetDimCount(const Value: Integer);
        procedure SetHighValues(I: Integer; const Value: Extended);
        procedure SetInversion(const Value: Extended);
        procedure SetLowValues(I: Integer; const Value: Extended);
        procedure SetMaxPopulation(const Value: Integer);
        procedure SetMinPopulation(const Value: Integer);
        procedure SetMutation(const Value: Extended);
        procedure SetOnBestChange(const Value: TBestChangeEvent);
        procedure SetOnEstimate(const Value: TEstimateEvent);
        procedure SetOnIteration(const Value: TIterationEvent);
        procedure Lock;
        procedure Unlock;
        function GetBestX(I: Integer): Extended;
        function GetState: TGeneState;
     
        procedure DoCrossover(N: Integer);
        procedure DoMutation(N: Integer);
        procedure DoInversion(N: Integer);
     
        procedure EstimatePopulation(StartIndex: Integer);
        procedure SortPopulation;
        procedure MakeChild;
     
      public
        // Creation & destroying
        constructor Create;
        destructor Destroy; override;
     
        // Running / stopping
        procedure Run;
        procedure Abort;
        procedure Suspend;
        procedure Resume;
     
        // Saving / opening
        procedure LoadFromStream(S: TStream);
        procedure SaveToStream(S: TStream);
     
        // Algorithm param
        property BitPerNumber: Integer read FBitPerNumber write SetBitPerNumber;
        property MaxPopulation: Integer read FMaxPopulation write SetMaxPopulation;
        property MinPopulation: Integer read FMinPopulation write SetMinPopulation;
        property Crossover: Extended read FCrossover write SetCrossover;
        property Mutation: Extended read FMutation write SetMutation;
        property Inversion: Extended read FInversion write SetInversion;
        property DimCount: Integer read FDimCount write SetDimCount;
        property LowValues[I: Integer]: Extended read GetLowValues write SetLowValues;
        property HighValues[I: Integer]: Extended read GetHighValues write SetHighValues;
     
        // Info property
        property Iteration: Integer read GetIteration;
        property BestX[I: Integer]: Extended read GetBestX;
        property BestEstimate: Extended read GetBestEstimate;
        property State: TGeneState read GetState;
     
        // Events
        property OnEstimate: TEstimateEvent read FOnEstimate write SetOnEstimate;
        property OnIteration: TIterationEvent read FOnIteration write SetOnIteration;
        property OnBestChange: TBestChangeEvent read FOnBestChange write SetOnBestChange;
     
      end;
     
    implementation
     
    resourcestring
      SCannotSetParam = 'Невозможно установить параметр %s в состоянии %s';
      SCannotGetParam = 'Невозможно прочитать параметр %s в состоянии %s';
      SInvalidParam = 'Параметр %s не может быть %s (%d).';
      SNonPositive = 'отрицательным или нулевым';
      SInvalidProbality = 'вероятность %s должна быть в диапазоне 0..1 (%f).';
      SLess2 = 'меньше двух';
      SEmpty = 'Неправильный индекс при обращении к %s (%d) при нулевом количества элементов.';
      SInvalidIndex = 'Неправильный индекс при обращении к %s (%d). Индекс должен лежать в диапазоне от %d до %d';
      SNonEstimate = 'Не задана функция оценки.';
     
    const
      SState: array[TGeneState] of string = (
        'настройки параметров алгоритма',
        'работы алгоритма',
        'остановки алгоритма');
     
    { TGeneAlgorithm }
     
    procedure TGeneAlgorithm.Abort;
    var
      I: Integer;
    begin
      if FState=gsExecute then
      begin
        FSolutionThread.Terminate;
        FSolutionThread.WaitFor;
      end;
      Lock;
      try
        for I:=0 to Length(FData)-1 do
        begin
          SetLength(FData[I].Bits, 0);
          SetLength(FData[I].Values, 0);
        end;
        SetLength(FData, 0);
        FState := gsTune;
      finally
        Unlock;
      end;
    end;
     
    constructor TGeneAlgorithm.Create;
    begin
      InitializeCriticalSection(FLock);
      FBitPerNumber := 8;
      FMinPopulation := 5000;
      FMaxPopulation := 10000;
      FMutation := 0.1;
      FCrossover := 0.89;
      FInversion := 0.01;
      FDimCount := 0;
      FState := gsTune;
    end;
     
    destructor TGeneAlgorithm.Destroy;
    begin
      Abort;
      DeleteCriticalSection(FLock);
      SetLength(FLowValues, 0);
      SetLength(FHighValues, 0);
      inherited;
    end;
     
    procedure TGeneAlgorithm.DoCrossover(N: Integer);
    var
      I: Integer;
      Parent1, Parent2: Integer;
      Bit, ByteCount: Integer;
      BitPos: Byte;
      Mask: Integer;
    begin
      Parent1 := Random(FMinPopulation);
      Parent2 := Random(FMinPopulation);
      Bit := Random(FDimCount*FBitPerNumber-1);
      ByteCount := Bit div 32;
      for I:=0 to ByteCount-1 do
        FData[N].Bits[I] := FData[Parent1].Bits[I];
      for I:=ByteCount+1 to BitSize-1 do
        FData[N].Bits[I] := FData[Parent2].Bits[I];
      BitPos := Bit - 32*ByteCount;
      asm
        MOV CL, BitPos
        MOV EAX, -1
        SHL EAX, CL
        MOV Mask, EAX
      end;
      FData[N].Bits[ByteCount] :=
        (FData[Parent1].Bits[ByteCount] and not Mask) or
        (FData[Parent2].Bits[ByteCount] and Mask);
    end;
     
    procedure TGeneAlgorithm.DoInversion(N: Integer);
     
    function GetBit(Addr: Pointer; No: Integer): Byte; assembler;
    asm
      MOV EAX, Addr
      MOV ECX, No
      BT [EAX], ECX
      SBB EAX, EAX
      AND EAX, 1
    end;
     
    procedure SetBit(Addr: Pointer; No: Integer; Value: Byte); assembler;
    asm
      MOV EAX, Addr
      OR Value,Value
      JZ @@1
      BTS [EAX], No
      RET
    @@1:
      BTR [EAX], No
      RET
    end;
     
    var
      Parent, Bit, I: Integer;
      B: Byte;
     
    begin
      Parent := Random(FMinPopulation);
      Bit := Random(FDimCount*FBitPerNumber-1);
      FData[N].Bits := FData[Parent].Bits;
      repeat
        B := GetBit(FData[N].Bits, 0);
        for I:=0 to FDimCount*FBitPerNumber-2 do
          SetBit(FData[N].Bits, I, GetBit(FData[N].Bits, I+1));
        SetBit(FData[N].Bits, FDimCount*FBitPerNumber-1, B);
        if Bit=0 then Break;
        Bit := Bit - 1;
      until False;
    end;
     
    procedure TGeneAlgorithm.DoMutation(N: Integer);
    var
      Parent: Integer;
      Bit, BitPos, ByteCount: Integer;
      Mask: Cardinal;
    begin
      Parent := Random(FMinPopulation);
      Bit := Random(FDimCount*FBitPerNumber);
      ByteCount := Bit div 32;
      BitPos := Bit - 32 * ByteCount;
      Mask := 1 shl BitPos;
      FData[N].Bits := FData[Parent].Bits;
      FData[N].Bits[ByteCount] := FData[N].Bits[ByteCount] xor Mask;
    end;
     
    procedure TGeneAlgorithm.EstimatePopulation(StartIndex: Integer);
    var
      I, J, K, Index: Integer;
      P, Q, Y: Extended;
      MaxWeight, Weight: Extended;
      Addr: Pointer;
      GrayBit, BinBit: Cardinal;
    begin
      MaxWeight := Power(2, FBitPerNumber);
      for I:=StartIndex to Length(FData)-1 do
      begin
        Index := 0;
        Addr := FData[I].Bits;
        for J:=0 to FDimCount-1 do
        begin
          Weight := 0.5 * MaxWeight;
          P := 0.0;
          BinBit := 0;
     
          for K:=0 to FBitPerNumber-1 do
          begin
            asm
              MOV EAX, Addr
              MOV ECX, Index
              BT [EAX], ECX
              SBB EAX, EAX
              AND EAX, 1
              MOV GrayBit, EAX
              INC Index
            end;
            BinBit := BinBit xor GrayBit;
            if BinBit=1 then P := P + Weight;
            Weight := 0.5 * Weight;
          end;
     
          P := P / MaxWeight;
          Q := 1 - P;
          FData[I].Values[J] := P * FHighValues[J] + Q * FLowValues[J];
        end;
        Y := 0;
        FOnEstimate(Self, FData[I].Values, Y);
        FData[I].Estimate := Y;
      end;
    end;
     
    function TGeneAlgorithm.GetBestEstimate: Extended;
    begin
      Lock;
      try
        Result := 0.0; //Kill warning
        if FState=gsTune then
          raise EGeneError.CreateFmt(SCannotGetParam, ['BestEstimate', SState[FState]]);
        Result := FData[0].Estimate;
      finally
        Unlock;
      end;
    end;
     
    function TGeneAlgorithm.GetBestX(I: Integer): Extended;
    begin
      Lock;
      try
        Result := 0.0; // Kill warning
        if FState=gsTune then
          raise EGeneError.CreateFmt(SCannotGetParam, ['BestX', SState[FState]]);
        if (FDimCount=0) then
          raise EGeneError.CreateFmt(SEmpty, ['BestX', I]);
        if (I<0) or (I>=FDimCount) then
          raise EGeneError.CreateFmt(SInvalidIndex, ['BestX', I, 0, DimCount]);
        Result := FData[0].Values[I];
      finally
        Unlock;
      end;
    end;
     
    function TGeneAlgorithm.GetHighValues(I: Integer): Extended;
    begin
      Lock;
      try
        Result := 0.0; // Kill warning
        if FState <> gsTune then
          raise EGeneError.CreateFmt(SCannotGetParam, ['HighValues', SState[FState]]);
        if (FDimCount=0) then
          raise EGeneError.CreateFmt(SEmpty, ['HighValues', I]);
        if (I<0) or (I>=FDimCount) then
          raise EGeneError.CreateFmt(SInvalidIndex, ['HighValues', I, 0, DimCount]);
        Result := FHighValues[I];
      finally
        Unlock;
      end;
    end;
     
    function TGeneAlgorithm.GetIteration: Integer;
    begin
      Lock;
      try
        Result := 0; // Kill warning
        if FState=gsTune then
          raise EGeneError.CreateFmt(SCannotGetParam, ['Iteration', SState[FState]]);
        Result := FIteration;
      finally
        Unlock;
      end;
    end;
     
    function TGeneAlgorithm.GetLowValues(I: Integer): Extended;
    begin
      Lock;
      try
        Result := 0.0; // Kill warning
        if FState <> gsTune then
          raise EGeneError.CreateFmt(SCannotGetParam, ['LowValues', SState[FState]]);
        if (FDimCount=0) then
          raise EGeneError.CreateFmt(SEmpty, ['LowValues', I]);
        if (I<0) or (I>=FDimCount) then
          raise EGeneError.CreateFmt(SInvalidIndex, ['LowValues', I, 0, DimCount]);
        Result := FLowValues[I];
      finally
        Unlock;
      end;
    end;
     
    function TGeneAlgorithm.GetState: TGeneState;
    begin
      Lock;
      try
        Result := FState;
      finally
        Unlock;
      end;
    end;
     
    procedure TGeneAlgorithm.LoadFromStream(S: TStream);
    begin
     
    end;
     
    procedure TGeneAlgorithm.Lock;
    begin
      EnterCriticalSection(FLock);
    end;
     
    procedure TGeneAlgorithm.MakeChild;
    var
      I: Integer;
      RandomValue: Extended;
    begin
      for I:=FMinPopulation to FMaxPopulation-1 do
      begin
        RandomValue := Random;
        if RandomValue<FCrossover then DoCrossover(I) else
        if RandomValue<FCrossover+FMutation then DoMutation(I) else
          DoInversion(I);
      end;
    end;
     
    procedure TGeneAlgorithm.Resume;
    begin
      if FState <> gsSuspend then
        raise EGeneError.Create('Прежде чем возобновить, надо начать!');
      FSolutionThread.Create(Self);
      FState := gsExecute;
    end;
     
    procedure TGeneAlgorithm.Run;
    var
      I, J: Integer;
      b1, b2: Cardinal;
    begin
      Lock;
      try
        if not Assigned(FOnEstimate) then
          raise EGeneError.Create(SNonEstimate);
        Abort;
     
        try
     
          // Getting memory
          SetLength(FData, FMaxPopulation);
          for I:=0 to Length(FData)-1 do
          begin
            FData[I].Values := nil;
            FData[I].bits := nil;
          end;
          BitSize := FDimCount * FBitPerNumber + 31;
          BitSize := BitSize and not 31;
          BitSize := BitSize div 32;
          for I:=0 to Length(FData)-1 do
          begin
            SetLength(FData[I].Values, DimCount);
            SetLength(FData[I].Bits, BitSize);
          end;
     
          // Initializing Population
          for I:=0 to Length(FData)-1 do
          begin
            for J:=0 to BitSize-1 do
            begin
              b1 := Random(35536);
              b2 := Random(35536);
              FData[I].Bits[J] := b1 shl 16 + b2;
            end;
          end;
     
          EstimatePopulation(0);
          SortPopulation;
          FIteration := 0;
          FState := gsExecute;
          FSolutionThread := TSolutionThread.Create(Self);
     
        except
     
          Abort;
     
        end;
     
     
      finally
        Unlock;
      end;
     
     
    end;
     
    procedure TGeneAlgorithm.SaveToStream(S: TStream);
    begin
     
    end;
     
    procedure TGeneAlgorithm.SetBitPerNumber(const Value: Integer);
    begin
      Lock;
      try
        if FState <> gsTune then
          raise EGeneError.CreateFmt(SCannotSetParam, ['BitPerNumber', SState[FState]]);
        if Value<=0 then
          raise EGeneError.CreateFmt(SInvalidParam, ['BitPerNumber', SNonPositive, Value]);
        FBitPerNumber := Value;
      finally
        Unlock;
      end;
    end;
     
    procedure TGeneAlgorithm.SetCrossover(const Value: Extended);
    begin
      Lock;
      try
        if FState <> gsTune then
          raise EGeneError.CreateFmt(SCannotSetParam, ['Crossover', SState[FState]]);
        if (Value<0) or (Value>1) then
          raise EGeneError.CreateFmt(SInvalidProbality, ['кроссовера', Value]);
        FCrossover := Value;
        if FCrossover + FMutation > 1.0 then
        begin
          FMutation := 1.0 - FCrossover;
          FInversion := 0.0;
        end
        else begin
          FInversion := 1.0 - FMutation - FCrossover;
        end;
      finally
        Unlock;
      end;
    end;
     
    procedure TGeneAlgorithm.SetDimCount(const Value: Integer);
    var
      I: Integer;
    begin
      Lock;
      try
        if FState <> gsTune then
          raise EGeneError.CreateFmt(SCannotSetParam, ['DimCount', SState[FState]]);
        if FDimCount=Value then Exit;
        if Value<=0 then
          raise EGeneError.CreateFmt(SInvalidParam, ['DimCount', SNonPositive, Value]);
        SetLength(FLowValues, Value);
        SetLength(FHighValues, Value);
        for I:=FDimCount to Value-1 do
        begin
          FLowValues[I] := 0.0;
          FHighValues[I] := 1.0;
        end;
        FDimCount := Value;
      finally
        Unlock;
      end;
    end;
     
    procedure TGeneAlgorithm.SetHighValues(I: Integer; const Value: Extended);
    begin
      Lock;
      try
        if FState <> gsTune then
          raise EGeneError.CreateFmt(SCannotSetParam, ['HighValues', SState[FState]]);
        if (FDimCount=0) then
          raise EGeneError.CreateFmt(SEmpty, ['HighValues', Value]);
        if (I<0) or (I>=FDimCount) then
          raise EGeneError.CreateFmt(SInvalidIndex, ['HighValues', Value, 0, DimCount]);
        FHighValues[I] := Value;
        if FLowValues[I] > FHighValues[I] then
          FLowValues[I] := FHighValues[I];
      finally
        Unlock;
      end;
    end;
     
    procedure TGeneAlgorithm.SetInversion(const Value: Extended);
    begin
      Lock;
      try
        if FState <> gsTune then
          raise EGeneError.CreateFmt(SCannotSetParam, ['Crossover', SState[FState]]);
        if (Value<0) or (Value>1) then
          raise EGeneError.CreateFmt(SInvalidProbality, ['инверсии', Value]);
        FInversion := Value;
        if FCrossover + FInversion > 1.0 then
        begin
          FCrossover := 1.0 - FInversion;
          FMutation := 0.0;
        end
        else begin
          FMutation := 1.0 - FInversion - FCrossover;
        end;
      finally
        Unlock;
      end;
    end;
     
    procedure TGeneAlgorithm.SetLowValues(I: Integer; const Value: Extended);
    begin
      Lock;
      try
        if FState <> gsTune then
          raise EGeneError.CreateFmt(SCannotSetParam, ['LowValues', SState[FState]]);
        if (FDimCount=0) then
          raise EGeneError.CreateFmt(SEmpty, ['LowValues', Value]);
        if (I<0) or (I>=FDimCount) then
          raise EGeneError.CreateFmt(SInvalidIndex, ['LowValues', Value, 0, DimCount]);
        FLowValues[I] := Value;
        if FHighValues[I] < FLowValues[I] then
          FHighValues[I] := FLowValues[I];
      finally
        Unlock;
      end;
    end;
     
    procedure TGeneAlgorithm.SetMaxPopulation(const Value: Integer);
    begin
      Lock;
      try
        if FState <> gsTune then
          raise EGeneError.CreateFmt(SCannotSetParam, ['MaxPopulation', SState[FState]]);
        if Value<2 then
          raise EGeneError.CreateFmt(SInvalidParam, ['MaxPopulation', SLess2, Value]);
        FMaxPopulation := Value;
        if FMinPopulation >= FMaxPopulation then FMinPopulation := FMaxPopulation - 1;
      finally
        Unlock;
      end;
    end;
     
    procedure TGeneAlgorithm.SetMinPopulation(const Value: Integer);
    begin
      Lock;
      try
        if FState <> gsTune then
          raise EGeneError.CreateFmt(SCannotSetParam, ['MinPopulation', SState[FState]]);
        if Value<=0 then
          raise EGeneError.CreateFmt(SInvalidParam, ['MinPopulation', SNonPositive, Value]);
        FMinPopulation := Value;
        if FMinPopulation >= FMaxPopulation then FMaxPopulation := FMinPopulation + 1;
      finally
        Unlock;
      end;
    end;
     
    procedure TGeneAlgorithm.SetMutation(const Value: Extended);
    begin
      Lock;
      try
        if FState <> gsTune then
          raise EGeneError.CreateFmt(SCannotSetParam, ['Crossover', SState[FState]]);
        if (Value<0) or (Value>1) then
          raise EGeneError.CreateFmt(SInvalidProbality, ['мутации', Value]);
        FMutation := Value;
        if FCrossover + FMutation > 1.0 then
        begin
          FCrossover := 1.0 - FMutation;
          FInversion := 0.0;
        end
        else begin
          FInversion := 1.0 - FMutation - FCrossover;
        end;
      finally
        Unlock;
      end;
    end;
     
    procedure TGeneAlgorithm.SetOnBestChange(const Value: TBestChangeEvent);
    begin
      Lock;
      try
        FOnBestChange := Value;
      finally
        Unlock;
      end;
    end;
     
    procedure TGeneAlgorithm.SetOnEstimate(const Value: TEstimateEvent);
    begin
      Lock;
      try
        if FState <> gsTune then
          raise EGeneError.CreateFmt(SCannotSetParam, ['OnEstimate', SState[FState]]);
        FOnEstimate := Value;
      finally
        Unlock;
      end;
    end;
     
    procedure TGeneAlgorithm.SetOnIteration(const Value: TIterationEvent);
    begin
      Lock;
      try
        FOnIteration := Value;
      finally
        Unlock;
      end;
    end;
     
    procedure TGeneAlgorithm.SortPopulation;
     
    procedure QuickSort(L, R: Integer);
    var
      I, J: Integer;
      P: Extended;
      T: TGeneRecord;
    begin
      repeat
        I := L;
        J := R;
        P := FData[(L + R) shr 1].Estimate;
        repeat
          while FData[I].Estimate > P do
            Inc(I);
          while FData[J].Estimate < P do
            Dec(J);
          if I <= J then
          begin
            if (I=0) or (J=0) then Lock;
            try
              T := FData[I];
              FData[I] := FData[J];
              FData[J] := T;
            finally
              if (I=0) or (J=0) then UnLock;
            end;
            Inc(I);
            Dec(J);
          end;
        until I > J;
        if L < J then
          QuickSort(L, J);
        L := I;
      until I >= R;
    end;
     
    begin
      QuickSort(0, Length(FData) - 1);
    end;
     
    procedure TGeneAlgorithm.Suspend;
    begin
      if FState<>gsExecute then
        raise EGeneError.Create('Прежде чем остановить, надо запустить!');
      FSolutionThread.Terminate;
    // FSolutionThread.WaitFor;
      FState := gsSuspend;
    end;
     
    procedure TGeneAlgorithm.Unlock;
    begin
      LeaveCriticalSection(FLock);
    end;
     
    { TSolutionThread }
     
    constructor TSolutionThread.Create(AOwner: TGeneAlgorithm);
    begin
      FOwner := AOwner;
      FreeOnTerminate := True;
      inherited Create(False);
    end;
     
    procedure TSolutionThread.Execute;
    begin
      repeat
        Owner.MakeChild;
        Owner.EstimatePopulation(Owner.FMinPopulation);
        Owner.SortPopulation;
        Inc(Owner.FIteration);
      until Terminated;
      Sleep(10);
    end;
     
    end. 

Пример использования:

    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      StdCtrls, Genes, ExtCtrls, Grids;
     
    type
      TForm1 = class(TForm)
        Edit1: TEdit;
        Edit2: TEdit;
        Edit3: TEdit;
        Button1: TButton;
        Button2: TButton;
        Button3: TButton;
        Edit4: TEdit;
        Button4: TButton;
        Button5: TButton;
        Timer1: TTimer;
        Button7: TButton;
        Label1: TLabel;
        Grid: TStringGrid;
        Label2: TLabel;
        procedure FormCreate(Sender: TObject);
        procedure FormDestroy(Sender: TObject);
        procedure Button1Click(Sender: TObject);
        procedure Button2Click(Sender: TObject);
        procedure Button3Click(Sender: TObject);
        procedure Button4Click(Sender: TObject);
        procedure Button5Click(Sender: TObject);
        procedure Button7Click(Sender: TObject);
        procedure Timer1Timer(Sender: TObject);
      private
        procedure Refresh;
        procedure GeneEstimate(Sender: TObject; const X: TExtendedArray; var Y: Extended);
      public
        FGene: TGeneAlgorithm;
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      DecimalSeparator := '.';
      FGene := TGeneAlgorithm.Create;
      Refresh;
    end;
     
    procedure TForm1.FormDestroy(Sender: TObject);
    begin
      FGene.Free;
    end;
     
    procedure TForm1.Refresh;
    begin
      Edit1.Text := FloaTtoStr(FGene.Crossover);
      Edit2.Text := FloatToStr(FGene.Mutation);
      Edit3.Text := FloatToStr(FGene.Inversion);
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      FGene.Crossover := StrTofloat(Edit1.Text);
      Refresh;
    end;
     
    procedure TForm1.Button2Click(Sender: TObject);
    begin
      FGene.Mutation := StrTofloat(Edit2.Text);
      Refresh;
    end;
     
    procedure TForm1.Button3Click(Sender: TObject);
    begin
      FGene.Inversion := StrTofloat(Edit3.Text);
      Refresh;
    end;
     
    procedure TForm1.Button4Click(Sender: TObject);
    begin
      FGene.BitPerNumber := StrToInt(Edit4.Text);
      Edit4.Text := IntToStr(FGene.BitPerNumber);
    end;
     
    procedure TForm1.Button5Click(Sender: TObject);
    var I: Integer;
    begin
      Randomize;
      FGene.DimCount := 5;
      FGene.MaxPopulation := 10000;
      FGene.MinPopulation := 5000;
      FGene.OnEstimate := GeneEstimate;
      for I:=0 to 4 do
      begin
        FGene.LowValues[I] := 0;
        FGene.HighValues[I] := 10;
      end;
      FGene.Run;
      Timer1.Enabled := True;
    end;
     
    procedure TForm1.GeneEstimate(Sender: TObject; const X: TExtendedArray;
      var Y: Extended);
    var I: Integer;
    begin
      Y := 0;
      for I:=Low(X) to High(X) do
        Y := Y + Sqr(X[I]-I);
      Y := -Y; 
    end;
     
    procedure TForm1.Button7Click(Sender: TObject);
    var I: Integer;
    begin
      Timer1.Enabled := False;
      Label1.Caption := '';
      FGene.Suspend;
      Grid.RowCount := FGene.DimCount + 1;
      for I:=0 to FGene.DimCount-1 do
        Grid.Cells[0,I+1] := FloattoStr(FGene.BestX[I]);
      FGene.Abort;
    end;
     
    procedure TForm1.Timer1Timer(Sender: TObject);
    begin
      Label1.Caption := FloatToStr(FGene.BestEstimate);
    end;
     
    end. 
