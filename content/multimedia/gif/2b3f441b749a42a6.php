<h1>Как получить размер GIF-картинки?</h1>
<div class="date">01.01.2007</div>


<pre>
type
   TImageSize = record
     Width: Integer;
     Height: Integer;
   end;
 
 function ReadGIFSize(Stream: TStream): TImageSize;
 type
   TGifHeader = record
     Signature: array [0..5] of Char;
     Width, Height: Word;
   end;
 var
   Header: TGifHeader;
 begin
   FillChar(Header, SizeOf(TGifHeader), #0);
   Result.Width := -1;
   Result.Height := -1;
   with Stream do
   begin
     Seek(0, soFromBeginning);
     ReadBuffer(Header, SizeOf(TGifHeader));
   end;
   if (AnsiUpperCase(Header.Signature) = 'GIF89A') or
     (AnsiUpperCase(Header.Signature) = 'GIF87A') then
   begin
     Result.Width  := Header.Width;
     Result.Height := Header.Height;
   end;
 end;
 
 procedure TForm1.Button1Click(Sender: TObject);
 const
   FileName = 'D:\test.gif';
 var
   fs: TFileStream;
   gifsize: TImageSize;
 begin
   fs := TFileStream.Create(FileName, fmOpenRead or fmShareDenyWrite);
   try
     gifsize := ReadGIFSize(fs);
     ShowMessage(Format('Breite %d Hцhe %d', [gifsize.Width, gifsize.Height]));
   finally
     fs.Free;
   end;
 end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
