<h1>Эффект потухания текста</h1>
<div class="date">01.01.2007</div>

Вот небольшой участок кода из купленного мною CD-ROM "How To Book". Файл с именем "HowUtils.Pas" содержит реализацию алгоритма "потухания" текста и обратного ему эффекта на холсте, откуда вы можете почерпнуть необходимую вам информацию.</p>
<pre>function TFadeEffect.FadeInText(Target: TCanvas; X, Y: integer; FText: string):
  TRect;
var
  Pic: TBitmap;
  W, H: integer;
  PicRect, TarRect: TRect;
begin
  Pic := TBitmap.Create;
  Pic.Canvas.Font := Target.Font;
  W := Pic.Canvas.TextWidth(FText);
  H := Pic.Canvas.TextHeight(FText);
  Pic.Width := W;
  Pic.Height := H;
  PicRect := Rect(0, 0, W, H);
  TarRect := Rect(X, Y, X + W, Y + H);
  Pic.Canvas.CopyRect(PicRect, Target, TarRect);
  SetBkMode(Pic.Canvas.Handle, Transparent);
  Pic.Canvas.TextOut(0, 0, FText);
  FadeInto(Target, X, Y, Pic);
  Pic.Free;
  FadeInText := TarRect;
end;
 
procedure TFadeEffect.FadeOutText(Target: TCanvas; TarRect: TRect; Orig:
  TBitmap);
var
  Pic: TBitmap;
  PicRect: TRect;
begin
  Pic := TBitmap.Create;
  Pic.Width := TarRect.Right - TarRect.Left;
  Pic.Height := TarRect.Bottom - TarRect.Top;
  PicRect := Rect(0, 0, Pic.Width, Pic.Height);
  Pic.Canvas.CopyRect(PicRect, Orig.Canvas, TarRect);
  FadeInto(Target, TarRect.Left, TarRect.Top, Pic);
  Pic.Free;
end;
 
 
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

