<h1>Как поместить иконку в окошко подсказки?</h1>
<div class="date">01.01.2007</div>


<p>Следующий код помещает главную иконку приложения в окошки подсказок:</p>
<pre>
unit HintX; 
 
interface 
 
uses 
  Windows, Messages, Controls; 
 
type 
  TIconHintX = class(THintWindow) 
  protected 
    procedure Paint; override; 
  public 
    function CalcHintRect(MaxWidth: Integer; const AHint: string; AData: Pointer): TRect; override; 
  end; 
 
implementation 
 
uses Forms; 
 
{ TIconHintX } 
 
{-Вычисляем новый размер окошка подсказки для помещения в него иконки:-}
function TIconHintX.CalcHintRect(MaxWidth: Integer; const AHint: string; 
  AData: Pointer): TRect; 
begin 
  Result := inherited CalcHintRect(MaxWidth, AHint, AData);       Result.Right := (Length(AHint) * 5) + Application.Icon.Width; 
  Result.Bottom := (Application.Icon.Height) * 2; 
end; 
 
procedure TIconHintX.Paint; 
const 
  MARGIN = 5; 
begin 
  inherited; 
  Canvas.Draw(MARGIN, MARGIN * 5, Application.Icon); 
  SendMessage(Handle, WM_NCPAINT, 0, 0); //рисуем рамку окошка подсказки
end; 
 
initialization 
  //связываем наш новый класс с классом окошка подсказки установленным поумолчанию:
  HintWindowClass := TIconHintX; 
 
end. 
</pre>


<p>Чтобы увидеть это в действии, всё, что надо сделать, это поместить этот юнит список USES Вашего приложения</p>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

