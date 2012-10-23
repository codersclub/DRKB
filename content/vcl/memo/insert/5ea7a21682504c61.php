<h1>Как загрузить юникоды в мемо?</h1>
<div class="date">01.01.2007</div>


<pre>
procedure LoadUnicodeFile(const filename: string; strings: TStrings);
 
  procedure SwapWideChars(p: PWideChar);
  begin
    while p^ &lt;&gt; #0000 do
    begin
      p^ := WideChar(Swap(Word(p^)));
      Inc(p);
    end;
  end;
 
var
  ms: TMemoryStream;
  wc: WideChar;
  pWc: PWideChar;
begin
  ms := TMemoryStream.Create;
  try
    ms.LoadFromFile(filename);
    ms.Seek(0, soFromend);
    wc := #0000;
    ms.Write(wc, sizeof(wc));
    pWC := ms.Memory;
    if pWc^ = #$FEFF then {normal byte order mark}
      Inc(pWc)
    else if pWc^ = #$FFFE then
    begin {byte order is big-endian}
      SwapWideChars(pWc);
      Inc(pWc);
    end
    else
      ; {no byte order mark}
    strings.Text := WideChartoString(pWc);
  finally
    ms.free;
  end;
end;
</pre>


<p>Использовать</p>

<p>LoadUnicodeFile(filename, memo1.lines);</p>
<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
