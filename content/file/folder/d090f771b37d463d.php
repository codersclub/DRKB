<h1>Как скопировать директорию?</h1>
<div class="date">01.01.2007</div>


<p>Использовать ShFileOperation</p>

<pre>
procedure TForm1.Button2Click(Sender: TObject);
var  OpStruc: TSHFileOpStruct;
  frombuf, tobuf: Array [0..128] of Char;
begin  FillChar( frombuf, Sizeof(frombuf), 0 );
  FillChar( tobuf, Sizeof(tobuf), 0 );
  StrPCopy( frombuf, 'd:\brief\*.*' );
  StrPCopy( tobuf, 'd:\temp\brief' );
  with OpStruc do begin
    Wnd := Handle;
    wFunc := FO_COPY;
    pFrom := @frombuf;
    pTo := @tobuf;
    fFlags := FOF_NOCONFIRMATION or FOF_RENAMEONCOLLISION;
    fAnyOperationsAborted := False;
    hNameMappings := Nil;
    lpszProgressTitle := Nil;
  end;
  ShFileOperation( OpStruc );
end;
</pre>

<p>Взято с сайта <a href="https://blackman.wp-club.net/" target="_blank">https://blackman.wp-club.net/</a></p>
