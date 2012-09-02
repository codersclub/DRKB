<h1>Копирование файлов</h1>
<div class="date">01.01.2007</div>


<p>Копирование методом Pascal</p>
<pre>
Type
  TCallBack=procedure (Position,Size:Longint); {Для индикации процесса копирования}
 
procedure FastFileCopy(Const InfileName, OutFileName: String; CallBack: TCallBack);
Const BufSize = 3*4*4096; { 48Kbytes дает прекрасный результат }
Type
  PBuffer = ^TBuffer;
  TBuffer = array [1..BufSize] of Byte;
var
  Size             : integer;
  Buffer           : PBuffer;
  infile, outfile  : File;
  SizeDone,SizeFile: Longint;
begin
  if (InFileName &lt;&gt; OutFileName) then
  begin
   buffer := Nil;
   AssignFile(infile, InFileName);
   System.Reset(infile, 1);
   try
     SizeFile := FileSize(infile);
     AssignFile(outfile, OutFileName);
     System.Rewrite(outfile, 1);
     try
       SizeDone := 0; New(Buffer);
       repeat
         BlockRead(infile, Buffer^, BufSize, Size);
         Inc(SizeDone, Size);
         CallBack(SizeDone, SizeFile);
         BlockWrite(outfile,Buffer^, Size)
       until Size &lt; BufSize;
       FileSetDate(TFileRec(outfile).Handle,
         FileGetDate(TFileRec(infile).Handle));
     finally
      if Buffer &lt;&gt; Nil then Dispose(Buffer);
      System.close(outfile)
     end;
   finally
     System.close(infile);
   end;
 end else
  Raise EInOutError.Create('File cannot be copied into itself');
end;
</pre>

<p>Копирование методом потока</p>
<pre>
Procedure FileCopy(Const SourceFileName, TargetFileName: String);
Var
  S,T   : TFileStream;
Begin
 S := TFileStream.Create(sourcefilename, fmOpenRead );
 try
  T := TFileStream.Create(targetfilename, fmOpenWrite or fmCreate);
  try
    T.CopyFrom(S, S.Size ) ;
    FileSetDate(T.Handle, FileGetDate(S.Handle));
  finally
   T.Free;
  end;
 finally
  S.Free;
 end;
end;
</pre>

<p>Копирование методом LZExpand</p>
<pre>
uses LZExpand;
procedure CopyFile(FromFileName, ToFileName  : string);
var
  FromFile, ToFile: File;
begin
  AssignFile(FromFile, FromFileName);
  AssignFile(ToFile, ToFileName);
  Reset(FromFile);
  try
   Rewrite(ToFile);
   try
    if LZCopy(TFileRec(FromFile).Handle, TFileRec(ToFile).Handle)&lt;0 then
     raise Exception.Create('Error using LZCopy')
   finally
    CloseFile(ToFile);
   end;
  finally
   CloseFile(FromFile);
  end;
end;
</pre>

<p>Копирование методами Windows</p>
<pre>
uses ShellApi; // !!! важно
 
function WindowsCopyFile(FromFile, ToDir : string) : boolean;
var F : TShFileOpStruct;
begin
  F.Wnd := 0; F.wFunc := FO_COPY;
  FromFile:=FromFile+#0; F.pFrom:=pchar(FromFile);
  ToDir:=ToDir+#0; F.pTo:=pchar(ToDir);
  F.fFlags := FOF_ALLOWUNDO or FOF_NOCONFIRMATION;
  result:=ShFileOperation(F) = 0;
end;
 // пример копирования
procedure TForm1.Button1Click(Sender: TObject);
begin
 if not WindowsCopyFile('C:\UTIL\ARJ.EXE', GetCurrentDir) then
   ShowMessage('Copy Failed');
end;
</pre>

<p>Источник: <a href="https://dmitry9.nm.ru/info/" target="_blank">https://dmitry9.nm.ru/info/</a></p>

