<h1>How to scale bitmap by percent?</h1>
<div class="date">01.01.2007</div>


<pre>
{ .... }
  private
    function ScalePercentBmp(bitmp: TBitmap; iPercent: Integer): Boolean;
{ .... }
 
function TForm1.ScalePercentBmp(bitmp: TBitmap;
  iPercent: Integer): Boolean;
var
  TmpBmp: TBitmap;
  ARect: TRect;
  h, w: Real;
  hi, wi: Integer;
begin
  Result := False;
  try
    TmpBmp := TBitmap.Create;
    try
      h := bitmp.Height * (iPercent / 100);
      w := bitmp.Width * (iPercent / 100);
      hi := StrToInt(FormatFloat('#', h)) + bitmp.Height;
      wi := StrToInt(FormatFloat('#', w)) + bitmp.Width;
      TmpBmp.Width := wi;
      TmpBmp.Height := hi;
      ARect := Rect(0, 0, wi, hi);
      TmpBmp.Canvas.StretchDraw(ARect, Bitmp);
      bitmp.Assign(TmpBmp);
    finally
      TmpBmp.Free;
    end;
    Result := True;
  except
    Result := False;
  end;
end;
</pre>

<pre>
// Example:
procedure TForm1.Button1Click(Sender: TObject);
begin
  ScalePercentBmp(Image1.Picture.Bitmap, 33);
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
