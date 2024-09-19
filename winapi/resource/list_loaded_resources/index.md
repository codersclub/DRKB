---
Title: How to get all the resource names that are loaded in a given application?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---

How to get all the resource names that are loaded in a given application?
=========================================================================

    type
      TForm1 = class(TForm)
        Button1: TButton;
        Memo1: TMemo;
        procedure Button1Click(Sender: TObject);
      private
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.dfm}
     
    function enumResNamesProc(module: HMODULE; restype, resname: PChar;
      list: TStrings): Integer; stdcall;
    begin
      if HiWord(Cardinal(resname)) <> 0 then
        list.Add('  ' + resname)
      else
        list.Add(Format('  #%d', [loword(Cardinal(resname))]));
      Result := 1;
    end;
     
    Function StockResourceType(restype: PChar): string;
    const
      restypenames: Array [1..22] of String =
        ( 'RT_CURSOR', //       = MakeIntResource(1);
          'RT_BITMAP', //       = MakeIntResource(2);
          'RT_ICON',   //       = MakeIntResource(3);
          'RT_MENU',   //       = MakeIntResource(4);
          'RT_DIALOG', //       = MakeIntResource(5);
          'RT_STRING', //       = MakeIntResource(6);
          'RT_FONTDIR',//       = MakeIntResource(7);
          'RT_FONT',   //       = MakeIntResource(8);
          'RT_ACCELERATOR',//   = MakeIntResource(9);
          'RT_RCDATA', //       = MakeIntResource(10);
          'RT_MESSAGETABLE',//  = MakeIntResource(11);
          // DIFFERENCE = 11;
          'RT_GROUP_CURSOR',// = MakeIntResource(DWORD(RT_CURSOR +7DIFFERENCE));
          'UNKNOWN',        // 13 not used
          'RT_GROUP_ICON',  //   = MakeIntResource(DWORD(RT_ICON +DIFFERENCE));
          'UNKNOWN',        // 15 not used
          'RT_VERSION',     // = MakeIntResource(16);
          'RT_DLGINCLUDE',  // = MakeIntResource(17);
          'UNKNOWN',
          'RT_PLUGPLAY',    // = MakeIntResource(19);
          'RT_VXD',         // = MakeIntResource(20);
          'RT_ANICURSOR',   // = MakeIntResource(21);
          'RT_ANIICON'     // = MakeIntResource(22);
        );
    var
      resid: Cardinal absolute restype;
    begin
      if resid in [1..22] then
        Result := restypenames[resid]
      else
        Result := 'UNKNOWN';
    end;
     
     
    function enumResTypesProc(module: HMODULE; restype: PChar; list: TStrings): Integer; stdcall;
    begin
      if HiWord(Cardinal(restype)) <> 0 then
        list.Add(restype)
      else
        list.Add(Format('Stock type %d: %s', [LoWord(Cardinal(restype)),
          StockResourcetype(restype)]));
      EnumResourceNames(module, restype, @enumResNamesProc, Integer(list));
      Result := 1;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      memo1.Clear;
      if not EnumResourceTypes(hinstance, @enumResTypesProc, Integer(memo1.Lines)) then
        memo1.Lines.Add(Format('GetLastError= %8.8x', [GetLastError]))
      else
        memo1.Lines.Add('Successful');
    end;
     
    end.

