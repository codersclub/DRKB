---
Title: Поместить изображение смайлика в TRxRichEdit
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Поместить изображение смайлика в TRxRichEdit
============================================

    var
       frmMain: TfrmMain;
     
     implementation
     
     {$R *.DFM}
     {$R Smiley.res}
     
     uses
       RichEdit;
     
     type
       TEditStreamCallBack = function(dwCookie: Longint; pbBuff: PByte;
         cb: Longint; var pcb: Longint): DWORD;
       stdcall;
     
       TEditStream = record
         dwCookie: Longint;
         dwError: Longint;
         pfnCallback: TEditStreamCallBack;
       end;
     
     type
       TMyRichEdit = TRxRichEdit;
     
     // EditStreamInCallback callback function 
     
    function EditStreamInCallback(dwCookie: Longint; pbBuff: PByte;
       cb: Longint; var pcb: Longint): DWORD; stdcall;
     var
       theStream: TStream;
       dataAvail: LongInt;
     begin
       theStream := TStream(dwCookie);
       with theStream do
       begin
         dataAvail := Size - Position;
         Result := 0;
         if dataAvail <= cb then
         begin
           pcb := read(pbBuff^, dataAvail);
           if pcb <> dataAvail then
             Result := UINT(E_FAIL);
         end
         else
         begin
           pcb := read(pbBuff^, cb);
           if pcb <> cb then
             Result := UINT(E_FAIL);
         end;
       end;
     end;
     
     // Insert Stream into RichEdit 
     
    procedure PutRTFSelection(RichEdit: TMyRichEdit; SourceStream: TStream);
     var
       EditStream: TEditStream;
     begin
       with EditStream do
       begin
         dwCookie := Longint(SourceStream);
         dwError := 0;
         pfnCallback := EditStreamInCallBack;
       end;
       RichEdit.Perform(EM_STREAMIN, SF_RTF or SFF_SELECTION, Longint(@EditStream));
     end;
     
     // Load a smiley image from resource 
     
    function GetSmileyCode(ASimily: string): string;
     var
       dHandle: THandle;
       pData, pTemp: PChar;
       Size: Longint;
     begin
       pData := nil;
       dHandle := FindResource(hInstance, PChar(ASimily), RT_RCDATA);
       if dHandle <> 0 then
       begin
         Size := SizeofResource(hInstance, dHandle);
         dhandle := LoadResource(hInstance, dHandle);
         if dHandle <> 0 then
           try
             pData := LockResource(dHandle);
             if pData <> nil then
               try
                 if pData[Size - 1] = #0 then
                 begin
                   Result := StrPas(pTemp);
                 end
                 else
                 begin
                   pTemp := StrAlloc(Size + 1);
                   try
                     StrMove(pTemp, pData, Size);
                     pTemp[Size] := #0;
                     Result := StrPas(pTemp);
                   finally
                     StrDispose(pTemp);
                   end;
                 end;
               finally
                 UnlockResource(dHandle);
               end;
           finally
             FreeResource(dHandle);
           end;
       end;
     end;
     
     procedure InsertSmiley(ASmiley: string);
     var
       ms: TMemoryStream;
       s: string;
     begin
       ms := TMemoryStream.Create;
       try
         s := GetSmileyCode(ASmiley);
         if s <> '' then
         begin
           ms.Seek(0, soFromEnd);
           ms.Write(PChar(s)^, Length(s));
           ms.Position := 0;
           PutRTFSelection(frmMain.RXRichedit1, ms);
         end;
       finally
         ms.Free;
       end;
     end;
     
     procedure TfrmMain.SpeedButton1Click(Sender: TObject);
     begin
       InsertSmiley('Smiley1');
     end;
     
     procedure TfrmMain.SpeedButton2Click(Sender: TObject);
     begin
       InsertSmiley('Smiley2');
     end;
     
     // Replace a :-) or :-( with a corresponding smiley 
     
    procedure TfrmMain.RxRichEdit1KeyPress(Sender: TObject; var Key: Char);
     var
      sCode, SmileyName: string;
     
       procedure RemoveText(RichEdit: TMyRichEdit);
       begin
         with RichEdit do
         begin
           SelStart := SelStart - 2;
           SelLength := 2;
           SelText :=  '';
         end;
       end;
     
     begin
      If (Key = ')') or (Key = '(')  then
      begin
        sCode := Copy(RxRichEdit1.Text, RxRichEdit1.SelStart-1, 2) + Key;
        SmileyName := '';
        if sCode = ':-)'  then SmileyName := 'Smiley1';
        if sCode = ':-('  then SmileyName := 'Smiley2';
        if SmileyName <> '' then
        begin
          Key := #0;
          RemoveText(RxRichEdit1);
          InsertSmiley('Smiley1');
        end;
      end;
     end;

