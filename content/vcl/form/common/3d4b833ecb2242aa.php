<h1>Как узнать, форма активна или нет?</h1>
<div class="date">01.01.2007</div>


<pre>
type
   //...
  private
    { Private declarations }
    procedure WMNCACTIVATE(var M: TWMNCACTIVATE); message WM_NCACTIVATE;
  end;
 
 
implementation
 
//...
 
procedure TForm1.WMNCACTIVATE(var M: TWMNCACTIVATE);
begin
  inherited;
  if M.Active then
    caption:='Form active'
  else caption:='Form not active' ;
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
