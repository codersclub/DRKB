---
Title: Как прочитать свойства видеофайла?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как прочитать свойства видеофайла?
==================================

Below is some code to get some of the data. To use the DirectDraw/
DirectShow calls you need either the older DSHOW.PAS (DX6) or more
current DirectShow.pas header conversion from the Project JEDI web site:

    type
      TDSMediaInfo = record
        SurfaceDesc: TDDSurfaceDesc;
        Pitch: integer;
        PixelFormat: TPixelFormat;
        MediaLength: Int64;
        AvgTimePerFrame: Int64;
        FrameCount: integer;
        Width: integer;
        Height: integer;
        FileSize: Int64;
      end;
     
    function GetHugeFileSize(const FileName: string): int64;
    var
      FileHandle: hFile;
    begin
      FileHandle := FileOpen(FileName, fmOpenRead or fmShareDenyNone);
      try
        LARGE_INTEGER(Result).LowPart := GetFileSize(FileHandle, @LARGE_INTEGER(Result).HighPart);
        if LARGE_INTEGER(Result).LowPart = $FFFFFFFF then
          Win32Check(GetLastError = NO_ERROR);
      finally
        FileClose(FileHandle);
      end;
    end;
     
    function GetMediaInfo(FileName: WideString): TDSMediaInfo;
    var
      DirectDraw: IDirectDraw;
      AMStream: IAMMultiMediaStream;
      MMStream: IMultiMediaStream;
      PrimaryVidStream: IMediaStream;
      DDStream: IDirectDrawMediaStream;
      GraphBuilder: IGraphBuilder;
      MediaSeeking: IMediaSeeking;
      TimeStart, TimeStop: Int64;
      DesiredSurface: TDDSurfaceDesc;
      DDSurface: IDirectDrawSurface;
    begin
      if FileName = '' then
        raise Exception.Create('No File Name Specified');
      OleCheck(DirectDrawCreate(nil, DirectDraw, nil));
      DirectDraw.SetCooperativeLevel(GetDesktopWindow(), DDSCL_NORMAL);
      Result.FileSize := GetHugeFileSize(FileName);
      AMStream := IAMMultiMediaStream(CreateComObject(CLSID_AMMultiMediaStream));
      OleCheck(AMStream.Initialize(STREAMTYPE_READ, AMMSF_NOGRAPHTHREAD, nil));
      OleCheck(AMStream.AddMediaStream(DirectDraw, MSPID_PrimaryVideo, 0, IMediaStream(nil^)));
      OleCheck(AMStream.OpenFile(PWideChar(FileName), AMMSF_NOCLOCK));
      AMStream.GetFilterGraph(GraphBuilder);
      MediaSeeking := GraphBuilder as IMediaSeeking;
      MediaSeeking.GetDuration(Result.MediaLength);
      MMStream := AMStream as IMultiMediaStream;
      OleCheck(MMStream.GetMediaStream(MSPID_PrimaryVideo, PrimaryVidStream));
      DDStream := PrimaryVidStream as IDirectDrawMediaStream;
      DDStream.GetTimePerFrame(Result.AvgTimePerFrame);
      {Result.FrameCount := Result.MediaLength div Result.AvgTimePerFrame;}
      { TODO : Test for better accuracy }
      Result.FrameCount := Round(Result.MediaLength / Result.AvgTimePerFrame);
      Result.MediaLength := Result.FrameCount * Result.AvgTimePerFrame;
      ZeroMemory(@DesiredSurface, SizeOf(DesiredSurface));
      DesiredSurface.dwSize := Sizeof(DesiredSurface);
      OleCheck(DDStream.GetFormat(TDDSurfaceDesc(nil^), IDirectDrawPalette(nil^),
        DesiredSurface, DWord(nil^)));
      Result.SurfaceDesc := DesiredSurface;
      DesiredSurface.ddsCaps.dwCaps := DesiredSurface.ddsCaps.dwCaps or
        DDSCAPS_OFFSCREENPLAIN or DDSCAPS_SYSTEMMEMORY;
      DesiredSurface.dwFlags := DesiredSurface.dwFlags or DDSD_CAPS or DDSD_PIXELFORMAT;
      {Create a surface here to get vital statistics}
      OleCheck(DirectDraw.CreateSurface(DesiredSurface, DDSurface, nil));
      OleCheck(DDSurface.GetSurfaceDesc(DesiredSurface));
      Result.Pitch := DesiredSurface.lPitch;
      if DesiredSurface.ddpfPixelFormat.dwRGBBitCount = 24 then
        Result.PixelFormat := pf24bit
      else if DesiredSurface.ddpfPixelFormat.dwRGBBitCount = 32 then
        Result.PixelFormat := pf32bit;
      Result.Width := DesiredSurface.dwWidth;
      Result.Height := DesiredSurface.dwHeight;
    end;

