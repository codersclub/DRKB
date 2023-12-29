---
Title: BMP -> AVI (для TAnimate)
Date: 01.01.2007
---


BMP -> AVI (для TAnimate)
=========================

::: {.date}
01.01.2007
:::

TAnimate is a rather nice component. However if you don\'t want to use
the built in AVI files and want to create your own AVI files from BMP
files, then you may have a problem as there is no tool in Delphi to do
this.

While browsing the web for information on AVI file formats I came upon a
site www.shrinkwrapvb.com/avihelp/avihelp.htm that is maintained by Ray
Mercer. In this tutorial he explains how to manipulate,read and write
AVI files. I was particularly interested in \"Step 5\" in which he shows
a utility that takes a list of BMP files that creates an AVI file which
can be used by the TAnimate component. The only problem was that the
examples are in Visual Basic, thus a conversion to Delphi was required.

I have posted this procedure

CreateAVI(const FileName : string; BMPFileList : TStrings; FramesPerSec
: integer = 10);

To keep the text of the example simple and readable I have left out most
to the error checking (try except etc.). You can also play with the
AVISaveOptions dialog box, but I can only seem to get it to work with
\"Full Frames Uncompressed\" with BMP files. Can anyone shed some light
on this ?

Errors you should check for are ..

All files are valid BMP files and are of the same size.

All Blockreads are valid with no read errors.

Ray has a downloadable EXE that works quite nicely, however I am about
to write my own utility that incorporates the following ...

Multiline file selection.

Listbox line reordering (drag/drop).

Sort File list

Layout Save and Load .

AVI Preview.

(I have beta version 1.0.0.0 ready, if anyone wants a copy of exe or
source code, drop me a mail at mheydon\@pgbison.co.za)

For further info on AVI files I recommend you vist Ray\'s site at
http://www.shrinkwrapvb.com/avihelp/avihelp.htm it really is a well
written tutorial (even if it is in Visual Basic)

    const
      // AVISaveOptions Dialog box flags
     
      ICMF_CHOOSE_KEYFRAME = 1; // show KeyFrame Every box
      ICMF_CHOOSE_DATARATE = 2; // show DataRate box
      ICMF_CHOOSE_PREVIEW = 4; // allow expanded preview dialog
      ICMF_CHOOSE_ALLCOMPRESSORS = 8; // don't only show those that
      // can handle the input format
      // or input data
      AVIIF_KEYFRAME = 10;
     
    type
     
      AVI_COMPRESS_OPTIONS = packed record
        fccType: DWORD; // stream type, for consistency
        fccHandler: DWORD; // compressor
        dwKeyFrameEvery: DWORD; // keyframe rate
        dwQuality: DWORD; // compress quality 0-10,000
        dwBytesPerSecond: DWORD; // bytes per second
        dwFlags: DWORD; // flags... see below
        lpFormat: DWORD; // save format
        cbFormat: DWORD;
        lpParms: DWORD; // compressor options
        cbParms: DWORD;
        dwInterleaveEvery: DWORD; // for non-video streams only
      end;
     
      AVI_STREAM_INFO = packed record
        fccType: DWORD;
        fccHandler: DWORD;
        dwFlags: DWORD;
        dwCaps: DWORD;
        wPriority: word;
        wLanguage: word;
        dwScale: DWORD;
        dwRate: DWORD;
        dwStart: DWORD;
        dwLength: DWORD;
        dwInitialFrames: DWORD;
        dwSuggestedBufferSize: DWORD;
        dwQuality: DWORD;
        dwSampleSize: DWORD;
        rcFrame: TRect;
        dwEditCount: DWORD;
        dwFormatChangeCount: DWORD;
        szName: array[0..63] of char;
      end;
     
      BITMAPINFOHEADER = packed record
        biSize: DWORD;
        biWidth: DWORD;
        biHeight: DWORD;
        biPlanes: word;
        biBitCount: word;
        biCompression: DWORD;
        biSizeImage: DWORD;
        biXPelsPerMeter: DWORD;
        biYPelsPerMeter: DWORD;
        biClrUsed: DWORD;
        biClrImportant: DWORD;
      end;
     
      BITMAPFILEHEADER = packed record
        bfType: word; //"magic cookie" - must be "BM"
        bfSize: integer;
        bfReserved1: word;
        bfReserved2: word;
        bfOffBits: integer;
      end;
     
      // DLL External declarations
     
    function AVISaveOptions(Hwnd: DWORD; uiFlags: DWORD; nStreams: DWORD;
      pPavi: Pointer; plpOptions: Pointer): boolean;
      stdcall; external 'avifil32.dll';
     
    function AVIFileCreateStream(pFile: DWORD; pPavi: Pointer; pSi: Pointer): integer;
      stdcall; external 'avifil32.dll';
     
    function AVIFileOpen(pPfile: Pointer; szFile: PChar; uMode: DWORD;
      clSid: DWORD): integer;
      stdcall; external 'avifil32.dll';
     
    function AVIMakeCompressedStream(psCompressed: Pointer; psSource: DWORD;
      lpOptions: Pointer; pclsidHandler: DWORD): integer;
      stdcall; external 'avifil32.dll';
     
    function AVIStreamSetFormat(pAvi: DWORD; lPos: DWORD; lpGormat: Pointer;
      cbFormat: DWORD): integer;
      stdcall; external 'avifil32.dll';
     
    function AVIStreamWrite(pAvi: DWORD; lStart: DWORD; lSamples: DWORD;
      lBuffer: Pointer; cBuffer: DWORD; dwFlags: DWORD;
      plSampWritten: DWORD; plBytesWritten: DWORD): integer;
      stdcall; external 'avifil32.dll';
     
    function AVISaveOptionsFree(nStreams: DWORD; ppOptions: Pointer): integer;
      stdcall; external 'avifil32.dll';
     
    function AVIFileRelease(pFile: DWORD): integer; stdcall; external 'avifil32.dll';
     
    procedure AVIFileInit; stdcall; external 'avifil32.dll';
     
    procedure AVIFileExit; stdcall; external 'avifil32.dll';
     
    function AVIStreamRelease(pAvi: DWORD): integer; stdcall; external 'avifil32.dll';
     
    function mmioStringToFOURCCA(sz: PChar; uFlags: DWORD): integer;
      stdcall; external 'winmm.dll';
     
    // ============================================================================
    // Main Function to Create AVI file from BMP file listing
    // ============================================================================
     
    procedure CreateAVI(const FileName: string; IList: TStrings;
      FramesPerSec: integer = 10);
    var
      Opts: AVI_COMPRESS_OPTIONS;
      pOpts: Pointer;
      pFile, ps, psCompressed: DWORD;
      strhdr: AVI_STREAM_INFO;
      i: integer;
      BFile: file;
      m_Bih: BITMAPINFOHEADER;
      m_Bfh: BITMAPFILEHEADER;
      m_MemBits: packed array of byte;
      m_MemBitMapInfo: packed array of byte;
    begin
      DeleteFile(FileName);
      Fillchar(Opts, SizeOf(Opts), 0);
      FillChar(strhdr, SizeOf(strhdr), 0);
      Opts.fccHandler := 541215044; // Full frames Uncompressed
      AVIFileInit;
      pfile := 0;
      pOpts := @Opts;
     
      if AVIFileOpen(@pFile, PChar(FileName), OF_WRITE or OF_CREATE, 0) = 0 then
      begin
        // Determine Bitmap Properties from file item[0] in list
        AssignFile(BFile, IList[0]);
        Reset(BFile, 1);
        BlockRead(BFile, m_Bfh, SizeOf(m_Bfh));
        BlockRead(BFile, m_Bih, SizeOf(m_Bih));
        SetLength(m_MemBitMapInfo, m_bfh.bfOffBits - 14);
        SetLength(m_MemBits, m_Bih.biSizeImage);
        Seek(BFile, SizeOf(m_Bfh));
        BlockRead(BFile, m_MemBitMapInfo[0], length(m_MemBitMapInfo));
        CloseFile(BFile);
     
        strhdr.fccType := mmioStringToFOURCCA('vids', 0); // stream type video
        strhdr.fccHandler := 0; // def AVI handler
        strhdr.dwScale := 1;
        strhdr.dwRate := FramesPerSec; // fps 1 to 30
        strhdr.dwSuggestedBufferSize := m_Bih.biSizeImage; // size of 1 frame
        SetRect(strhdr.rcFrame, 0, 0, m_Bih.biWidth, m_Bih.biHeight);
     
        if AVIFileCreateStream(pFile, @ps, @strhdr) = 0 then
        begin
          // if you want user selection options then call following line
          // (but seems to only like "Full frames Uncompressed option)
     
          // AVISaveOptions(Application.Handle,
          //                ICMF_CHOOSE_KEYFRAME or ICMF_CHOOSE_DATARATE,
          //                1,@ps,@pOpts);
          // AVISaveOptionsFree(1,@pOpts);
     
          if AVIMakeCompressedStream(@psCompressed, ps, @opts, 0) = 0 then
          begin
            if AVIStreamSetFormat(psCompressed, 0, @m_memBitmapInfo[0],
              length(m_MemBitMapInfo)) = 0 then
            begin
     
              for i := 0 to IList.Count - 1 do
              begin
                AssignFile(BFile, IList[i]);
                Reset(BFile, 1);
                Seek(BFile, m_bfh.bfOffBits);
                BlockRead(BFile, m_MemBits[0], m_Bih.biSizeImage);
                Seek(BFile, SizeOf(m_Bfh));
                BlockRead(BFile, m_MemBitMapInfo[0], length(m_MemBitMapInfo));
                CloseFile(BFile);
                if AVIStreamWrite(psCompressed, i, 1, @m_MemBits[0],
                  m_Bih.biSizeImage, AVIIF_KEYFRAME, 0, 0) <> 0 then
                begin
                  ShowMessage('Error during Write AVI File');
                  break;
                end;
              end;
            end;
          end;
        end;
     
        AVIStreamRelease(ps);
        AVIStreamRelease(psCompressed);
        AVIFileRelease(pFile);
      end;
     
      AVIFileExit;
      m_MemBitMapInfo := nil;
      m_memBits := nil;
    end;

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>
