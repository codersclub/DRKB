---
Title: Освобождение памяти
Date: 01.01.2007
---


Освобождение памяти
===================

Вариант 1:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    unit MemMan;
     
    interface
     
    var
      GetMemCount, FreeMemCount,
        ReallocMemCount: Integer;
     
    implementation
     
    uses
      Windows, SysUtils;
     
    var
      OldMemMgr: TMemoryManager;
     
    function NewGetMem(Size: Integer): Pointer;
    begin
      Inc(GetMemCount);
      Result := OldMemMgr.GetMem(Size);
    end;
     
    function NewFreeMem(P: Pointer): Integer;
    begin
      Inc(FreeMemCount);
      Result := OldMemMgr.FreeMem(P);
    end;
     
    function NewReallocMem(P: Pointer; Size: Integer): Pointer;
    begin
      Inc(ReallocMemCount);
      Result := OldMemMgr.ReallocMem(P, Size);
    end;
     
    const
      NewMemMgr: TMemoryManager = (
        GetMem: NewGetMem;
        FreeMem: NewFreeMem;
        ReallocMem: NewReallocMem);
     
    initialization
      GetMemoryManager(OldMemMgr);
      SetMemoryManager(NewMemMgr);
     
    finalization
      SetMemoryManager(OldMemMgr);
      if (GetMemCount - FreeMemCount) <> 0 then
        MessageBox(0, pChar(
          'Objects left: ' + IntToStr(GetMemCount - FreeMemCount)),
          'MemManager', mb_ok);
    end.
    unit MemForm;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      StdCtrls, ExtCtrls;
     
    type
      TForm1 = class(TForm)
        BtnRefresh1: TButton;
        BtnCreateNil: TButton;
        BtnCreateOwner: TButton;
        BtnGetMem: TButton;
        LblResult: TLabel;
        Btn100Strings: TButton;
        Bevel1: TBevel;
        BtnRefresh2: TButton;
        procedure BtnRefresh1Click(Sender: TObject);
        procedure BtnCreateNilClick(Sender: TObject);
        procedure BtnCreateOwnerClick(Sender: TObject);
        procedure BtnGetMemClick(Sender: TObject);
        procedure FormCreate(Sender: TObject);
        procedure Btn100StringsClick(Sender: TObject);
        procedure BtnRefresh2Click(Sender: TObject);
      public
        procedure Refresh;
        procedure Refresh2;
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    uses MemMan;
     
    {$R *.DFM}
     
    procedure TForm1.Refresh;
    begin
      LblResult.Caption :=
        'Allocated: ' + IntToStr(GetMemCount) + #13 +
        'Free: ' + IntToStr(FreeMemCount) + #13 +
        'Existing: ' +
        IntToStr(GetMemCount - FreeMemCount) + #13 +
        'Re-allocated: ' + IntToStr(ReallocMemCount);
    end;
     
    procedure TForm1.Refresh2;
    begin
      LblResult.Caption := Format(
        'Allocated: %d'#13'Free: %d'#13'Existing: %d'#13'Re-allocated %d'     ,
        [GetMemCount, FreeMemCount,
        GetMemCount - FreeMemCount, ReallocMemCount]);
    end;
     
    procedure TForm1.BtnRefresh1Click(Sender: TObject);
    begin
      Refresh;
    end;
     
    procedure TForm1.BtnCreateNilClick(Sender: TObject);
    begin
      TButton.Create(nil);
      Refresh;
    end;
     
    procedure TForm1.BtnCreateOwnerClick(Sender: TObject);
    begin
      TButton.Create(self);
      Refresh;
    end;
     
    procedure TForm1.BtnGetMemClick(Sender: TObject);
    var
      P: Pointer;
    begin
      GetMem(P, 100);
      Integer(P^) := 0;
      Refresh;
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      Refresh;
    end;
     
    procedure TForm1.Btn100StringsClick(Sender: TObject);
    var
      s1, s2: string;
      I: Integer;
    begin
      s1 := 'hi';
      s2 := Btn100Strings.Caption;
      for I := 1 to 100 do
        s1 := s1 + ': hello world';
      Btn100Strings.Caption := s1;
      s1 := s2;
      Btn100Strings.Caption := s1;
      Refresh;
    end;
     
    procedure TForm1.BtnRefresh2Click(Sender: TObject);
    begin
      Refresh2;
    end;
     
    end.


------------------------------------------------------------------------

Вариант 2:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    unit MemMan;
     
    interface
     
    uses
      StdCtrls, Classes;
     
    var
      AllocCount, FreeCount: Integer;
      AllocatedList: TList;
     
    type
      TCountButton = class(TButton)
      protected
        class function NewInstance: TObject; override;
        procedure FreeInstance; override;
      end;
     
    implementation
     
    uses
      Windows, SysUtils;
     
    class function TCountButton.NewInstance: TObject;
    begin
      Inc(AllocCount);
      Result := inherited NewInstance;
      AllocatedList.Add(Result);
    end;
     
    procedure TCountButton.FreeInstance;
    var
      nItem: Integer;
    begin
      Inc(FreeCount);
      nItem := AllocatedList.IndexOf(self);
      AllocatedList.Delete(nItem);
      inherited FreeInstance;
    end;
     
    initialization
      AllocatedList := TList.Create;
     
    finalization
      if (AllocCount - FreeCount) <> 0 then
        MessageBox(0, pChar(
          'Objects left: ' + IntToStr(AllocCount - FreeCount)),
          'MemManager', mb_ok);
      AllocatedList.Free;
    end.


------------------------------------------------------------------------

Вариант 3:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    unit SnapForm;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      StdCtrls;
     
    type
      TFormSnap = class(TForm)
        Memo1: TMemo;
      private
        { Private declarations }
      public
        { Public declarations }
      end;
     
    var
      FormSnap: TFormSnap;
     
    implementation
     
    {$R *.DFM}
     
    end.
    unit DdhMMan;
     
    interface
     
    var
      GetMemCount: Integer = 0;
      FreeMemCount: Integer = 0;
      ReallocMemCount: Integer = 0;
     
    procedure SnapToFile(Filename: string);
     
    implementation
     
    uses
      Windows, SysUtils, TypInfo;
     
    var
      OldMemMgr: TMemoryManager;
      ObjList: array[1..10000] of Pointer;
      FreeInList: Integer = 1;
     
    procedure AddToList(P: Pointer);
    begin
      if FreeInList > High(ObjList) then
      begin
        MessageBox(0, 'List full', 'MemMan', mb_ok);
        Exit;
      end;
      ObjList[FreeInList] := P;
      Inc(FreeInList);
    end;
     
    procedure RemoveFromList(P: Pointer);
    var
      I: Integer;
    begin
      for I := 1 to FreeInList - 1 do
        if ObjList[I] = P then
        begin
          // remove element shifting down the others
          Dec(FreeInList);
          Move(ObjList[I + 1], ObjList[I],
            (FreeInList - I) * sizeof(pointer));
          Exit;
        end;
    end;
     
    procedure SnapToFile(Filename: string);
    var
      OutFile: TextFile;
      I, CurrFree: Integer;
      HeapStatus: THeapStatus;
      Item: TObject;
      ptd: PTypeData;
      ppi: PPropInfo;
    begin
      AssignFile(OutFile, Filename);
      try
        Rewrite(OutFile);
        CurrFree := FreeInList;
        // local heap status
        HeapStatus := GetHeapStatus;
        with HeapStatus do
        begin
          write(OutFile, 'Available address space: ');
          write(OutFile, TotalAddrSpace div 1024);
          writeln(OutFile, ' Kbytes');
          write(OutFile, 'Uncommitted portion: ');
          write(OutFile, TotalUncommitted div 1024);
          writeln(OutFile, ' Kbytes');
          write(OutFile, 'Committed portion: ');
          write(OutFile, TotalCommitted div 1024);
          writeln(OutFile, ' Kbytes');
          write(OutFile, 'Free portion: ');
          write(OutFile, TotalFree div 1024);
          writeln(OutFile, ' Kbytes');
          write(OutFile, 'Allocated portion: ');
          write(OutFile, TotalAllocated div 1024);
          writeln(OutFile, ' Kbytes');
          write(OutFile, 'Address space load: ');
          write(OutFile, TotalAllocated div
            (TotalAddrSpace div 100));
          writeln(OutFile, '%');
          write(OutFile, 'Total small free blocks: ');
          write(OutFile, FreeSmall div 1024);
          writeln(OutFile, ' Kbytes');
          write(OutFile, 'Total big free blocks: ');
          write(OutFile, FreeBig div 1024);
          writeln(OutFile, ' Kbytes');
          write(OutFile, 'Other unused blocks: ');
          write(OutFile, Unused div 1024);
          writeln(OutFile, ' Kbytes');
          write(OutFile, 'Total overhead: ');
          write(OutFile, Overhead div 1024);
          writeln(OutFile, ' Kbytes');
        end;
     
        // custom memory manager information
        writeln(OutFile); // free line
        write(OutFile, 'Memory objects: ');
        writeln(OutFile, CurrFree - 1);
        for I := 1 to CurrFree - 1 do
        begin
          write(OutFile, I);
          write(OutFile, ') ');
          write(OutFile, IntToHex(
            Cardinal(ObjList[I]), 16));
          write(OutFile, ' - ');
          try
            Item := TObject(ObjList[I]);
            // code not reliable
            { write (OutFile, Item.ClassName);
            write (OutFile, ' (');
            write (OutFile, IntToStr (Item.InstanceSize));
            write (OutFile, ' bytes)');}
            // type info technique
            if PTypeInfo(Item.ClassInfo).Kind <> tkClass then
              write(OutFile, 'Not an object')
            else
            begin
              ptd := GetTypeData(PTypeInfo(Item.ClassInfo));
              // name, if a component
              ppi := GetPropInfo(
                PTypeInfo(Item.ClassInfo), 'Name');
              if ppi <> nil then
              begin
                write(OutFile, GetStrProp(Item, ppi));
                write(OutFile, ' :  ');
              end
              else
                write(OutFile, '(unnamed): ');
              write(OutFile, PTypeInfo(Item.ClassInfo).Name);
              write(OutFile, ' (');
              write(OutFile, ptd.ClassType.InstanceSize);
              write(OutFile, ' bytes)  -  In ');
              write(OutFile, ptd.UnitName);
              write(OutFile, '.dcu');
            end
          except
            on Exception do
              write(OutFile, 'Not an object');
          end;
          writeln(OutFile);
        end;
      finally
        CloseFile(OutFile);
      end;
    end;
     
    function NewGetMem(Size: Integer): Pointer;
    begin
      Inc(GetMemCount);
      Result := OldMemMgr.GetMem(Size);
      AddToList(Result);
    end;
     
    function NewFreeMem(P: Pointer): Integer;
    begin
      Inc(FreeMemCount);
      Result := OldMemMgr.FreeMem(P);
      RemoveFromList(P);
    end;
     
    function NewReallocMem(P: Pointer; Size: Integer): Pointer;
    begin
      Inc(ReallocMemCount);
      Result := OldMemMgr.ReallocMem(P, Size);
      // remove older object
      RemoveFromList(P);
      // add new one
      AddToList(Result);
    end;
     
    const
      NewMemMgr: TMemoryManager = (
        GetMem: NewGetMem;
        FreeMem: NewFreeMem;
        ReallocMem: NewReallocMem);
     
    initialization
      GetMemoryManager(OldMemMgr);
      SetMemoryManager(NewMemMgr);
     
    finalization
      SetMemoryManager(OldMemMgr);
      if (GetMemCount - FreeMemCount) <> 0 then
        MessageBox(0, pChar('Objects left: ' +
          IntToStr(GetMemCount - FreeMemCount)),
          'MemManager', mb_ok);
    end.
    unit MemForm;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      StdCtrls, ExtCtrls;
     
    type
      TForm1 = class(TForm)
        BtnCreateNil: TButton;
        BtnCreateOwner: TButton;
        BtnFreeLast: TButton;
        LblResult: TLabel;
        Btn100Strings: TButton;
        Bevel1: TBevel;
        BtnRefresh2: TButton;
        BtnSnap: TButton;
        SaveDialog1: TSaveDialog;
        procedure Button1Click(Sender: TObject);
        procedure BtnCreateNilClick(Sender: TObject);
        procedure BtnCreateOwnerClick(Sender: TObject);
        procedure BtnFreeLastClick(Sender: TObject);
        procedure Btn100StringsClick(Sender: TObject);
        procedure BtnRefresh2Click(Sender: TObject);
        procedure BtnSnapClick(Sender: TObject);
        procedure FormShow(Sender: TObject);
      public
        b: TButton;
        procedure Refresh2;
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    uses
      DdhMMan, SnapForm;
     
    {$R *.DFM}
     
    procedure TForm1.Refresh2;
    begin
      LblResult.Caption := Format(
        'Allocated: %d'#13'Free: %d'#13'Existing: %d'#13'Re-allocated %d'     ,
        [GetMemCount, FreeMemCount,
        GetMemCount - FreeMemCount, ReallocMemCount]);
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      Refresh2;
    end;
     
    procedure TForm1.BtnCreateNilClick(Sender: TObject);
    begin
      b := TButton.Create(nil);
      Refresh2;
    end;
     
    procedure TForm1.BtnCreateOwnerClick(Sender: TObject);
    begin
      b := TButton.Create(self);
      Refresh2;
    end;
     
    procedure TForm1.BtnFreeLastClick(Sender: TObject);
    begin
      if Assigned(b) then
      begin
        b.Free;
        b := nil;
      end;
      Refresh2;
    end;
     
    procedure TForm1.Btn100StringsClick(Sender: TObject);
    var
      s1, s2: string;
      I: Integer;
    begin
      s1 := 'hi';
      s2 := Btn100Strings.Caption;
      for I := 1 to 100 do
        s1 := s1 + ': hello world';
      Btn100Strings.Caption := s1;
      s1 := s2;
      Btn100Strings.Caption := s1;
      Refresh2;
    end;
     
    procedure TForm1.BtnRefresh2Click(Sender: TObject);
    begin
      Refresh2;
    end;
     
    procedure TForm1.BtnSnapClick(Sender: TObject);
    begin
      if SaveDialog1.Execute then
      begin
        SnapToFile(SaveDialog1.Filename);
        FormSnap.Memo1.Lines.LoadFromFile(
          SaveDialog1.Filename);
        FormSnap.Show;
      end;
    end;
     
    procedure TForm1.FormShow(Sender: TObject);
    begin
      Refresh2;
    end;
     
    end.



 
