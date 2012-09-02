<h1>Как показать оставшееся время до конца?</h1>
<div class="date">01.01.2007</div>


<pre>
Procedure TForm1.Timer1Timer(Sender: TObject);
Var
 TheLength,Posi,SummaMin,SummaSec: Integer;
begin
  //Progress Bar to check if the track is playing
  if Progress.Max&lt;&gt;0 then Begin
    Progress.Position := Mediaplayer1.Position;
 
     //Gets the length of the selected track
    TheLength := Mediaplayer1.TrackLength[ListBox1.ItemIndex];
 
      //gets the current position of the track
      Posi := Mediaplayer1.Position;
 
      //Caculates Minutes
      SummaMin := ((TheLength - Posi) div 1000) Div 60;
 
      //Calculates Seconds
      SummaSec := ((TheLength - Posi) Div 1000) Mod 60;
 
      //Adds zero if Seconds are less then ten
      If SummaSec &lt; 10 Then
      Label2.Caption := '0' + IntToStr(SummaSec)
      Else
      Label2.Caption := IntToStr(SummaSec);
 
      //Minutes
      Label1.Caption := IntToStr(SummaMin);
 
End;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
