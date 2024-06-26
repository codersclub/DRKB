---
Title: Получить список процессов в компьютере сети
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Получить список процессов в компьютере сети
===========================================

    unit PerfInfo;
     
    interface
     
    uses
      Windows, SysUtils, Classes;
     
    type
      TPerfCounter = record
        Counter: Integer;
        Value: TLargeInteger;
      end;
     
      TPerfCounters = Array of TPerfCounter;
     
      TPerfInstance = class
      private
        FName: string;
        FCounters: TPerfCounters;
      public
        property Name: string read FName;
        property Counters: TPerfCounters read FCounters;
      end;
     
      TPerfObject = class
      private
        FList: TList;
        FObjectID: DWORD;
        FMachine: string;
        function GetCount: Integer;
        function GetInstance(Index: Integer): TPerfInstance;
        procedure ReadInstances;
      public
        property ObjectID: DWORD read FObjectID;
        property Item[Index: Integer]: TPerfInstance
          read GetInstance; default;
        property Count: Integer read GetCount;
        constructor Create(const AMachine: string; AObjectID: DWORD);
        destructor Destroy; override;
      end;
     
    procedure GetProcesses(const Machine: string; List: TStrings);
     
    implementation
     
    type
      PPerfDataBlock = ^TPerfDataBlock;
      TPerfDataBlock = record
        Signature: array[0..3] of WCHAR;
        LittleEndian: DWORD;
        Version: DWORD;
        Revision: DWORD;
        TotalByteLength: DWORD;
        HeaderLength: DWORD;
        NumObjectTypes: DWORD;
        DefaultObject: Longint;
        SystemTime: TSystemTime;
        PerfTime: TLargeInteger;
        PerfFreq: TLargeInteger;
        PerfTime100nSec: TLargeInteger;
        SystemNameLength: DWORD;
        SystemNameOffset: DWORD;
      end;
     
      PPerfObjectType = ^TPerfObjectType;
      TPerfObjectType = record
        TotalByteLength: DWORD;
        DefinitionLength: DWORD;
        HeaderLength: DWORD;
        ObjectNameTitleIndex: DWORD;
        ObjectNameTitle: LPWSTR;
        ObjectHelpTitleIndex: DWORD;
        ObjectHelpTitle: LPWSTR;
        DetailLevel: DWORD;
        NumCounters: DWORD;
        DefaultCounter: Longint;
        NumInstances: Longint;
        CodePage: DWORD;
        PerfTime: TLargeInteger;
        PerfFreq: TLargeInteger;
      end;
     
      PPerfCounterDefinition = ^TPerfCounterDefinition;
      TPerfCounterDefinition = record
        ByteLength: DWORD;
        CounterNameTitleIndex: DWORD;
        CounterNameTitle: LPWSTR;
        CounterHelpTitleIndex: DWORD;
        CounterHelpTitle: LPWSTR;
        DefaultScale: Longint;
        DetailLevel: DWORD;
        CounterType: DWORD;
        CounterSize: DWORD;
        CounterOffset: DWORD;
      end;
     
      PPerfInstanceDefinition = ^TPerfInstanceDefinition;
      TPerfInstanceDefinition = record
        ByteLength: DWORD;
        ParentObjectTitleIndex: DWORD;
        ParentObjectInstance: DWORD;
        UniqueID: Longint;
        NameOffset: DWORD;
        NameLength: DWORD;
      end;
     
      PPerfCounterBlock = ^TPerfCounterBlock;
      TPerfCounterBlock = record
        ByteLength: DWORD;
      end;
     
     
    {Navigation helpers}
     
    function FirstObject(PerfData: PPerfDataBlock): PPerfObjectType;
    begin
      Result := PPerfObjectType(DWORD(PerfData) + PerfData.HeaderLength);
    end;
     
     
    function NextObject(PerfObj: PPerfObjectType): PPerfObjectType;
    begin
      Result := PPerfObjectType(DWORD(PerfObj) + PerfObj.TotalByteLength);
    end;
     
     
    function FirstInstance(PerfObj: PPerfObjectType): PPerfInstanceDefinition;
    begin
      Result := PPerfInstanceDefinition(DWORD(PerfObj) + PerfObj.DefinitionLength);
    end;
     
     
    function NextInstance(PerfInst: PPerfInstanceDefinition): PPerfInstanceDefinition;
    var
      PerfCntrBlk: PPerfCounterBlock;
    begin
      PerfCntrBlk := PPerfCounterBlock(DWORD(PerfInst) + PerfInst.ByteLength);
      Result := PPerfInstanceDefinition(DWORD(PerfCntrBlk) + PerfCntrBlk.ByteLength);
    end;
     
     
    function FirstCounter(PerfObj: PPerfObjectType): PPerfCounterDefinition;
    begin
      Result := PPerfCounterDefinition(DWORD(PerfObj) + PerfObj.HeaderLength);
    end;
     
     
    function NextCounter(PerfCntr: PPerfCounterDefinition): PPerfCounterDefinition;
    begin
      Result := PPerfCounterDefinition(DWORD(PerfCntr) + PerfCntr.ByteLength);
    end;
     
     
    {Registry helpers}
     
    function GetPerformanceKey(const Machine: string): HKey;
    var
      s: string;
    begin
      Result := 0;
      if Length(Machine) = 0 then
        Result := HKEY_PERFORMANCE_DATA
      else
      begin
        s := Machine;
        if Pos('\\', s) <> 1 then
          s := '\\' + s;
        if RegConnectRegistry(PChar(s), HKEY_PERFORMANCE_DATA, Result) <> ERROR_SUCCESS then
          Result := 0;
      end;
    end;
     
     
    {TPerfObject}
     
    constructor TPerfObject.Create(const AMachine: string; AObjectID: DWORD);
    begin
      inherited Create;
      FList := TList.Create;
      FMachine := AMachine;
      FObjectID := AObjectID;
      ReadInstances;
    end;
     
     
    destructor TPerfObject.Destroy;
    var
      i: Integer;
    begin
      for i := 0 to FList.Count - 1 do
        TPerfInstance(FList[i]).Free;
      FList.Free;
      inherited Destroy;
    end;
     
     
    function TPerfObject.GetCount: Integer;
    begin
      Result := FList.Count;
    end;
     
     
    function TPerfObject.GetInstance(Index: Integer): TPerfInstance;
    begin
      Result := FList[Index];
    end;
     
     
    procedure TPerfObject.ReadInstances;
    var
      PerfData: PPerfDataBlock;
      PerfObj: PPerfObjectType;
      PerfInst: PPerfInstanceDefinition;
      PerfCntr, CurCntr: PPerfCounterDefinition;
      PtrToCntr: PPerfCounterBlock;
      BufferSize: Integer;
      i, j, k: Integer;
      pData: PLargeInteger;
      Key: HKey;
      CurInstance: TPerfInstance;
    begin
      for i := 0 to FList.Count - 1 do
        TPerfInstance(FList[i]).Free;
      FList.Clear;
      Key := GetPerformanceKey(FMachine);
      if Key = 0 then Exit;
      PerfData := nil;
      try
        {Allocate initial buffer for object information}
        BufferSize := 65536;
        GetMem(PerfData, BufferSize);
        {retrieve data}
        while RegQueryValueEx(Key,
          PChar(IntToStr(FObjectID)),  {Object name}
          nil, nil, Pointer(PerfData), @BufferSize) = ERROR_MORE_DATA do
        begin
          {buffer is too small}
          Inc(BufferSize, 1024);
          ReallocMem(PerfData, BufferSize);
        end;
        RegCloseKey(HKEY_PERFORMANCE_DATA);
        {Get the first object type}
        PerfObj := FirstObject(PerfData);
        {Process all objects}
        for i := 0 to PerfData.NumObjectTypes - 1 do
        begin
          {Check for requested object}
          if PerfObj.ObjectNameTitleIndex = FObjectID then
          begin
            {Get the first counter}
            PerfCntr := FirstCounter(PerfObj);
            if PerfObj.NumInstances > 0  then
            begin
              {Get the first instance}
              PerfInst := FirstInstance(PerfObj);
              {Retrieve all instances}
              for k := 0 to PerfObj.NumInstances - 1 do
              begin
                {Create entry for instance}
                CurInstance := TPerfInstance.Create;
                CurInstance.FName := WideCharToString(PWideChar(DWORD(PerfInst) +
                                                          PerfInst.NameOffset));
                FList.Add(CurInstance);
                CurCntr := PerfCntr;
                {Retrieve all counters}
                SetLength(CurInstance.FCounters, PerfObj.NumCounters);
                for j := 0 to PerfObj.NumCounters - 1 do
                begin
                  PtrToCntr := PPerfCounterBlock(DWORD(PerfInst) + PerfInst.ByteLength);
                  pData := Pointer(DWORD(PtrToCntr) + CurCntr.CounterOffset);
                  {Add counter to array}
                  CurInstance.FCounters[j].Counter := CurCntr.CounterNameTitleIndex;
                  CurInstance.FCounters[j].Value := pData^;
                  {Get the next counter}
                  CurCntr := NextCounter(CurCntr);
                end;
                {Get the next instance.}
                PerfInst := NextInstance(PerfInst);
              end;
            end;
          end;
          {Get the next object type}
          PerfObj := NextObject(PerfObj);
        end;
      finally
        {Release buffer}
        FreeMem(PerfData);
        {Close remote registry handle}
        if Key <> HKEY_PERFORMANCE_DATA then
          RegCloseKey(Key);
      end;
    end;
     
     
    procedure GetProcesses(const Machine: string; List: TStrings);
    var
      Processes: TPerfObject;
      i, j: Integer;
      ProcessID: DWORD;
    begin
      Processes := nil;
      List.Clear;
      try
        Processes := TPerfObject.Create(Machine, 230);  {230 = Process}
        for i := 0 to Processes.Count - 1 do
          {Find process ID}
          for j := 0 to Length(Processes[i].Counters) - 1 do
            if (Processes[i].Counters[j].Counter = 784) then
            begin
              ProcessID := Processes[i].Counters[j].Value;
              if ProcessID <> 0 then
                List.AddObject(Processes[i].Name, Pointer(ProcessID));
              Break;
            end;
      finally
        Processes.Free;
      end;
    end;
     
    end.

