---
Title: Как вставить Bitmap в TRichEdit?
Author: Krid
Date: 01.01.2007
---


Как вставить Bitmap в TRichEdit?
================================

Вариант 1:

Author: Krid

Source: <https://forum.sources.ru>

Вот так можно вставить картинку в формате Bitmap в позицию курсора в
TRichEdit:

    unit re_bmp;
     
    interface
     
    uses Windows;
     
    procedure InsertBitmapToRE(Wnd:HWND; Bmp:HBITMAP);
     
    implementation
     
    uses Activex, RichEdit;
     
    const
      IID_IDataObject: TGUID = (
       D1:$0000010E;D2:$0000;D3:$0000;D4:($C0,$00,$00,$00,$00,$00,$00,$46));
      IID_IOleObject: TGUID = (
        D1:$00000112;D2:$0000;D3:$0000;D4:($C0,$00,$00,$00,$00,$00,$00,$46));
     
      REO_CP_SELECTION    = ULONG(-1);
      REO_IOB_SELECTION   = ULONG(-1);
      REO_GETOBJ_POLEOBJ  =  $00000001;
     
    type
      TReobject = record
        cbStruct: DWORD;
        cp: ULONG;
        clsid: TCLSID;
        poleobj: IOleObject;
        pstg: IStorage;
        polesite: IOleClientSite;
        sizel: TSize;
        dvAspect: Longint;
        dwFlags: DWORD;
        dwUser: DWORD;
      end;
     
    type
      IRichEditOle = interface(IUnknown)
        ['{00020d00-0000-0000-c000-000000000046}']
        function GetClientSite(out clientSite: IOleClientSite): HResult; stdcall;
        function GetObjectCount: HResult; stdcall;
        function GetLinkCount: HResult; stdcall;
        function GetObject(iob: Longint; out reobject: TReObject;
          dwFlags: DWORD): HResult; stdcall;
        function InsertObject(var reobject: TReObject): HResult; stdcall;
        function ConvertObject(iob: Longint; rclsidNew: TIID;
          lpstrUserTypeNew: LPCSTR): HResult; stdcall;
        function ActivateAs(rclsid: TIID; rclsidAs: TIID): HResult; stdcall;
        function SetHostNames(lpstrContainerApp: LPCSTR;
          lpstrContainerObj: LPCSTR): HResult; stdcall;
        function SetLinkAvailable(iob: Longint; fAvailable: BOOL): HResult; stdcall;
        function SetDvaspect(iob: Longint; dvaspect: DWORD): HResult; stdcall;
        function HandsOffStorage(iob: Longint): HResult; stdcall;
        function SaveCompleted(iob: Longint; const stg: IStorage): HResult; stdcall;
        function InPlaceDeactivate: HResult; stdcall;
        function ContextSensitiveHelp(fEnterMode: BOOL): HResult; stdcall;
        function GetClipboardData(var chrg: TCharRange; reco: DWORD;
          out dataobj: IDataObject): HResult; stdcall;
        function ImportDataObject(dataobj: IDataObject; cf: TClipFormat;
          hMetaPict: HGLOBAL): HResult; stdcall;
      end;
     
      TImageDataObject=class(TInterfacedObject,IDataObject)
      private
       FBmp:HBITMAP;
       FMedium:TStgMedium;
       FFormatEtc: TFormatEtc;
       procedure SetBitmap(bmp:HBITMAP);
       function GetOleObject(OleClientSite:IOleClientSite; Storage:IStorage):IOleObject;
       destructor Destroy;override;
     
       // IDataObject
       function GetData(const formatetcIn: TFormatEtc; out medium: TStgMedium): HResult; stdcall;
        function GetDataHere(const formatetc: TFormatEtc; out medium: TStgMedium): HResult; stdcall;
        function QueryGetData(const formatetc: TFormatEtc): HResult; stdcall;
        function GetCanonicalFormatEtc(const formatetc: TFormatEtc; out formatetcOut: TFormatEtc): HResult; stdcall;
        function SetData(const formatetc: TFormatEtc; var medium: TStgMedium; fRelease: BOOL): HResult; stdcall;
        function EnumFormatEtc(dwDirection: Longint; out enumFormatEtc: IEnumFormatEtc): HResult; stdcall;
        function DAdvise(const formatetc: TFormatEtc; advf: Longint; 
                         const advSink: IAdviseSink; out dwConnection: Longint): HResult; stdcall;
        function DUnadvise(dwConnection: Longint): HResult; stdcall;
        function EnumDAdvise(out enumAdvise: IEnumStatData): HResult; stdcall;
      public
       procedure InsertBitmap(wnd:HWND; Bitmap:HBITMAP);
      end;
     
     
    { TImageDataObject }
     
    function TImageDataObject.DAdvise(const formatetc: TFormatEtc; advf: Integer;
      const advSink: IAdviseSink; out dwConnection: Integer): HResult;
    begin
     Result:=E_NOTIMPL;
    end;
     
    function TImageDataObject.DUnadvise(dwConnection: Integer): HResult;
    begin
     Result:=E_NOTIMPL;
    end;
     
    function TImageDataObject.EnumDAdvise(out enumAdvise: IEnumStatData): HResult;
    begin
     Result:=E_NOTIMPL;
    end;
     
    function TImageDataObject.EnumFormatEtc(dwDirection: Integer; out enumFormatEtc: IEnumFormatEtc): HResult;
    begin
     Result:=E_NOTIMPL;
    end;
     
    function TImageDataObject.GetCanonicalFormatEtc(const formatetc: TFormatEtc; out formatetcOut: TFormatEtc): HResult;
    begin
     Result:=E_NOTIMPL;
    end;
     
    function TImageDataObject.GetDataHere(const formatetc: TFormatEtc; out medium: TStgMedium): HResult;
    begin
     Result:=E_NOTIMPL;
    end;
     
    function TImageDataObject.QueryGetData(const formatetc: TFormatEtc): HResult;
    begin
     Result:=E_NOTIMPL;
    end;
     
    destructor TImageDataObject.Destroy;
    begin
     ReleaseStgMedium(FMedium);
    end;
     
    function TImageDataObject.GetData(const formatetcIn: TFormatEtc; out medium: TStgMedium): HResult;
    begin
     medium.tymed := TYMED_GDI;
     medium.hBitmap :=  FMedium.hBitmap;
     medium.unkForRelease := nil;
     Result:=S_OK;
    end;
     
    function TImageDataObject.SetData(const formatetc: TFormatEtc; var medium: TStgMedium; fRelease: BOOL): HResult;
    begin
     FFormatEtc := formatetc;
     FMedium := medium;
     Result:= S_OK;
    end;
     
    procedure TImageDataObject.SetBitmap(bmp: HBITMAP);
    var
     stgm: TStgMedium;
     fm:TFormatEtc;
    begin
     stgm.tymed := TYMED_GDI;
     stgm.hBitmap := bmp;
     stgm.UnkForRelease := nil;
     
     fm.cfFormat := CF_BITMAP;
     fm.ptd := nil;
     fm.dwAspect := DVASPECT_CONTENT;
     fm.lindex := -1;
     fm.tymed := TYMED_GDI;
     SetData(fm, stgm, FALSE);
    end;
     
    function TImageDataObject.GetOleObject(OleClientSite: IOleClientSite; Storage: IStorage):IOleObject;
    begin
     if (Fmedium.hBitmap=0) then Result:=nil else
      OleCreateStaticFromData(self, IID_IOleObject, OLERENDER_FORMAT, @FFormatEtc, OleClientSite, Storage, Result);
    end;
     
    procedure TImageDataObject.InsertBitmap(wnd:HWND; Bitmap: HBITMAP);
    var
     OleClientSite:IOleClientSite;
     RichEditOLE:IRichEditOLE;
     Storage:IStorage;
     LockBytes:ILockBytes;
     OleObject:IOleObject;
     reobject:TReobject;
     clsid:TGUID;
    begin
     if (SendMessage(wnd, EM_GETOLEINTERFACE, 0, cardinal(@RichEditOle))=0) then exit;
     
     FBmp:=CopyImage(Bitmap,IMAGE_BITMAP,0,0,0);
     if  FBmp=0 then exit;
     try
       SetBitmap(Fbmp);
       RichEditOle.GetClientSite(OleClientSite);
       if (OleClientSite=nil) then exit;
       CreateILockBytesOnHGlobal(0, TRUE,LockBytes);
       if (LockBytes = nil) then exit;
       if (StgCreateDocfileOnILockBytes(LockBytes, STGM_SHARE_EXCLUSIVE or STGM_CREATE or STGM_READWRITE, 0,Storage)<> S_OK) then
       begin
          LockBytes._Release;
          exit
        end;
     
       if (Storage = nil) then exit;
       OleObject:=GetOleObject(OleClientSite, Storage);
       if (OleObject = nil) then exit;
       OleSetContainedObject(OleObject, TRUE);
     
       ZeroMemory(@reobject, sizeof(TReobject));
       reobject.cbStruct := sizeof(TReobject);
       OleObject.GetUserClassID(clsid);
       reobject.clsid := clsid;
       reobject.cp := REO_CP_SELECTION;
       reobject.dvaspect := DVASPECT_CONTENT;
       reobject.poleobj := OleObject;
       reobject.polesite := OleClientSite;
       reobject.pstg := Storage;
     
       RichEditOle.InsertObject(reobject);
     finally
       DeleteObject(FBmp)
     end
    end;
     
     
    procedure InsertBitmapToRE(Wnd:HWND; bmp:HBITMAP);
    begin
     with TImageDataObject.Create do
     try
      InsertBitmap(Wnd,Bmp);
     finally
      Free
     end
    end;
     
    end.


Примеры использования:

    uses re_bmp;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
     InsertBitmapToRE(RichEdit1.Handle,Image1.Picture.Bitmap.Handle);
    end;
     
    ...
     
    procedure TForm1.Button2Click(Sender: TObject);
    var
     bmp:TBitmap;
    begin
     if (not OpenPictureDialog1.Execute) then exit;
     bmp:=TBitmap.Create;
     try
       bmp.LoadFromFile(OpenPictureDialog1.Filename);
       InsertBitmapToRE(RichEdit1.Handle,bmp.Handle);
     finally
       bmp.Free
     end
    end;


Таким же образом можно вставлять картинки не только в TRichEdit, но и в
RxRichEdit, стандартный виндовый RichEdit, etc.

------------------------------------------------------------------------

Вариант 2:

Source: <https://www.swissdelphicenter.ch>

    uses
       RichEdit;
     
    // Stream Callback function 
    type
       TEditStreamCallBack = function(dwCookie: Longint; pbBuff: PByte;
         cb: Longint; var pcb: Longint): DWORD;
       stdcall;
     
       TEditStream = record
         dwCookie: Longint;
         dwError: Longint;
         pfnCallback: TEditStreamCallBack;
       end;
     
    // RichEdit Type 
    type
       TMyRichEdit = TRxRichEdit;
     
    // EditStreamInCallback callback function 
    function EditStreamInCallback(dwCookie: Longint; pbBuff: PByte;
       cb: Longint; var pcb: Longint): DWORD; stdcall;
       // by P. Below 
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
       // by P. Below 
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
     
    // Convert Bitmap to RTF Code 
    function BitmapToRTF(pict: TBitmap): string;
    // by D3k 
    var
       bi, bb, rtf: string;
       bis, bbs: Cardinal;
       achar: ShortString;
       hexpict: string;
       I: Integer;
     begin
       GetDIBSizes(pict.Handle, bis, bbs);
       SetLength(bi, bis);
       SetLength(bb, bbs);
       GetDIB(pict.Handle, pict.Palette, PChar(bi)^, PChar(bb)^);
       rtf := '{\rtf1 {\pict\dibitmap ';
       SetLength(hexpict, (Length(bb) + Length(bi)) * 2);
       I := 2;
       for bis := 1 to Length(bi) do
       begin
         achar := Format('%x', [Integer(bi[bis])]);
         if Length(achar) = 1 then
           achar := '0' + achar;
         hexpict[I - 1] := achar[1];
         hexpict[I] := achar[2];
         Inc(I, 2);
       end;
       for bbs := 1 to Length(bb) do
       begin
         achar := Format('%x', [Integer(bb[bbs])]);
         if Length(achar) = 1 then
           achar := '0' + achar;
         hexpict[I - 1] := achar[1];
         hexpict[I] := achar[2];
         Inc(I, 2);
       end;
       rtf := rtf + hexpict + ' }}';
       Result := rtf;
     end;
     
     
    // Example to insert image from Image1 into RxRichEdit1 
    procedure TForm1.Button1Click(Sender: TObject);
     var
       SS: TStringStream;
       BMP: TBitmap;
     begin
       BMP := TBitmap.Create;
       BMP := Image1.Picture.Bitmap;
       SS  := TStringStream.Create(BitmapToRTF(BMP));
       try
         PutRTFSelection(RxRichEdit1, SS);
       finally
         SS.Free;
       end;
     end;

