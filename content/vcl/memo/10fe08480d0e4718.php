<h1>Как узнать количество видимых строчек в TMemo?</h1>
<div class="date">01.01.2007</div>


<pre>
function LinesVisible(Memo: TMemo): integer; 
    Var 
      OldFont : HFont; 
      Hand : THandle; 
      TM : TTextMetric; 
      Rect  : TRect; 
      tempint : integer; 
    begin 
      Hand := GetDC(Memo.Handle); 
      try 
        OldFont := SelectObject(Hand, Memo.Font.Handle); 
        try 
          GetTextMetrics(Hand, TM); 
          Memo.Perform(EM_GETRECT, 0, longint(@Rect)); 
          tempint := (Rect.Bottom - Rect.Top) div 
             (TM.tmHeight + TM.tmExternalLeading); 
        finally 
          SelectObject(Hand, OldFont); 
        end; 
      finally 
        ReleaseDC(Memo.Handle, Hand); 
      end; 
      Result := tempint; 
    end; 
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

