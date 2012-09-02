<h1>Как узнать количество цветов в системной палитре?</h1>
<div class="date">01.01.2007</div>


<pre>
function GetNumColors: LongInt;
var
  BPP: Integer;
  DC: HDC;
begin
  DC := CreateDC('DISPLAY', nil, nil, nil);
  if DC &lt;&gt; 0 then
    begin
      try
        BPP := GetDeviceCaps(DC, BITPIXEL) * GetDeviceCaps(DC, PLANES);
      finally
        DeleteDC(DC);
      end;
      case BPP of
        1: Result := 2;
        4: Result := 16;
        8: Result := 256;
        15: Result := 32768;
        16: Result := 65536;
        24: Result := 16777216;
      end;
    end
  else
    Result := 0;
end;
</pre>

