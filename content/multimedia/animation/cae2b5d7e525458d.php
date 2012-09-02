<h1>Как экстрагировать фрейм из AVI?</h1>
<div class="date">01.01.2007</div>


<pre>
uses 
 VfW { from download }; 
 
function GrabAVIFrame(avifn: string; iFrameNumber: Integer; ToFileName: TFileName): Boolean; 
var 
  Error: Integer; 
  pFile: PAVIFile; 
  AVIStream: PAVIStream; 
  gapgf: PGETFRAME; 
  lpbi: PBITMAPINFOHEADER; 
  bits: PChar; 
  hBmp: HBITMAP; 
  AviInfo: TAVIFILEINFOW; 
  sError: string; 
  TmpBmp: TBitmap; 
  DC_Handle: HDC; 
begin 
  Result := False; 
  // Initialize the AVIFile library. 
  AVIFileInit; 
 
  // The AVIFileOpen function opens an AVI file 
  Error := AVIFileOpen(pFile, PChar(avifn), 0, nil); 
  if Error &lt;&gt; 0 then 
  begin 
    AVIFileExit; 
    case Error of 
      AVIERR_BADFORMAT: sError := 'The file couldnot be read'; 
      AVIERR_MEMORY: sError := 'The file could not be opened because of insufficient memory.'; 
      AVIERR_FILEREAD: sError := 'A disk error occurred while reading the file.'; 
      AVIERR_FILEOPEN: sError := 'A disk error occurred while opening the file.'; 
    end; 
    ShowMessage(sError); 
    Exit; 
  end; 
 
  // AVIFileInfo obtains information about an AVI file 
  if AVIFileInfo(pFile, @AVIINFO, SizeOf(AVIINFO)) &lt;&gt; AVIERR_OK then 
  begin 
    // Clean up and exit 
    AVIFileRelease(pFile); 
    AVIFileExit; 
    Exit; 
  end; 
 
  // Show some information about the AVI 
  Form1.Memo1.Lines.Add('AVI Width : ' + IntToStr(AVIINFO.dwWidth)); 
  Form1.Memo1.Lines.Add('AVI Height : ' + IntToStr(AVIINFO.dwHeight)); 
  Form1.Memo1.Lines.Add('AVI Length : ' + IntToStr(AVIINFO.dwLength)); 
 
  // Open a Stream from the file 
  Error := AVIFileGetStream(pFile, AVIStream, streamtypeVIDEO, 0); 
  if Error &lt;&gt; AVIERR_OK then 
  begin 
    // Clean up and exit 
    AVIFileRelease(pFile); 
    AVIFileExit; 
    Exit; 
  end; 
 
  // Prepares to decompress video frames 
  gapgf := AVIStreamGetFrameOpen(AVIStream, nil); 
  if gapgf = nil then 
  begin 
    AVIStreamRelease(AVIStream); 
    AVIFileRelease(pFile); 
    AVIFileExit; 
    Exit; 
  end; 
 
  // Read current Frame 
  // AVIStreamGetFrame Returns the address of a decompressed video frame 
  lpbi := AVIStreamGetFrame(gapgf, iFrameNumber); 
  if lpbi = nil then 
  begin 
    AVIStreamGetFrameClose(gapgf); 
    AVIStreamRelease(AVIStream); 
    AVIFileRelease(pFile); 
    AVIFileExit; 
    Exit; 
  end; 
 
  // Show number of frames: 
  Form1.Memo1.Lines.Add(Format('Framstart: %d FrameEnd: %d', 
    [AVIStreamStart(AVIStream), AVIStreamEnd(AVIStream)])); 
 
  TmpBmp := TBitmap.Create; 
  try 
    TmpBmp.Height := lpbi.biHeight; 
    TmpBmp.Width  := lpbi.biWidth; 
    bits := Pointer(Integer(lpbi) + SizeOf(TBITMAPINFOHEADER)); 
 
    DC_Handle := CreateDC('Display', nil, nil, nil); 
    try 
      hBmp := CreateDIBitmap(DC_Handle, // handle of device context 
        lpbi^, // address of bitmap size and format data 
        CBM_INIT, // initialization flag 
        bits, // address of initialization data 
        PBITMAPINFO(lpbi)^, // address of bitmap color-format data 
        DIB_RGB_COLORS); // color-data usage 
    finally 
      DeleteDC(DC_Handle); 
    end; 
 
    TmpBmp.Handle := hBmp; 
    AVIStreamGetFrameClose(gapgf); 
    AVIStreamRelease(AVIStream); 
    AVIFileRelease(pfile); 
    AVIFileExit; 
    try 
      TmpBmp.SaveToFile(ToFileName); 
      Result := True; 
    except 
    end; 
  finally 
    TmpBmp.Free; 
  end; 
end; 
 
procedure TForm1.Button1Click(Sender: TObject); 
begin 
  // Extract Frame 3 from AVI file 
  GrabAVIFrame('C:\Test.avi', 3, 'c:\avifram.bmp'); 
end; 
</pre>
<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
